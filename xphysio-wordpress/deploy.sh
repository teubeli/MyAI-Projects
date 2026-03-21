#!/usr/bin/env bash
# ============================================================
# xphysio.ch – Deployment Script
# Verwendung: bash deploy.sh [--dry-run] [--theme-only] [--db-only]
#
# Prinzip: Was auf Local läuft, kommt auf Prod.
# neve-child-theme/ ist via Symlink direkt mit Local WP verknüpft.
#
# Flags:
#   --dry-run      Zeigt was gemacht würde, ändert nichts
#   --theme-only   Nur Theme + Uploads (keine DB-Änderungen)
#   --db-only      Nur DB-Inhalte (Seiten, Optionen, Menus)
# ============================================================

set -euo pipefail

# ── Konfiguration ─────────────────────────────────────────────
SSH_HOST="xphysio-prod"
REMOTE_HOME="/home/clients/dcefc60f649f88bc5fc4453361e13451"
REMOTE_WP="${REMOTE_HOME}/sites/xphysio.ch"
REMOTE_THEME="${REMOTE_WP}/wp-content/themes/neve-child"
REMOTE_WP_CLI="${REMOTE_HOME}/wp-cli.phar"
WP="php ${REMOTE_WP_CLI} --path=${REMOTE_WP} --allow-root"

LOCAL_THEME="$(dirname "$0")/neve-child-theme"
LOCAL_UPLOADS="/Users/swentobler/Local Sites/xphysio/app/public/wp-content/uploads"
LOCAL_PAGES="$(dirname "$0")/pages"
LOCAL_WP_CLI="$(dirname "$0")/wp-cli-setup"

DRY_RUN=false
THEME_ONLY=false
DB_ONLY=false

for arg in "$@"; do
  case $arg in
    --dry-run)    DRY_RUN=true ;;
    --theme-only) THEME_ONLY=true ;;
    --db-only)    DB_ONLY=true ;;
  esac
done

RSYNC_BASE="-avz --checksum --exclude=.DS_Store --exclude='*.log' --exclude=Thumbs.db"
if $DRY_RUN; then
  RSYNC_BASE="$RSYNC_BASE --dry-run"
  echo "🔍 DRY-RUN Modus – keine Änderungen werden gespeichert"
fi

echo ""
echo "╔══════════════════════════════════════════╗"
echo "║   xphysio.ch Deployment → Production     ║"
echo "╚══════════════════════════════════════════╝"
echo ""

# ── 1. Theme-Dateien (komplettes Verzeichnis) ─────────────────
# --delete: Dateien die lokal gelöscht wurden, auch auf Prod entfernen
if ! $DB_ONLY; then
  echo "▶ [1/4] Theme synchronisieren (komplett)..."
  rsync $RSYNC_BASE --delete \
    "${LOCAL_THEME}/" \
    "${SSH_HOST}:${REMOTE_THEME}/"
  echo "  ✓ neve-child-theme/ (alle Dateien, inkl. neue)"
fi

# ── 2. Uploads (neu/geändert, kein Delete – Prod kann eigene haben) ──
if ! $DB_ONLY; then
  echo ""
  echo "▶ [2/4] Uploads synchronisieren (neu/geändert)..."
  rsync $RSYNC_BASE \
    "${LOCAL_UPLOADS}/" \
    "${SSH_HOST}:${REMOTE_WP}/wp-content/uploads/"
  echo "  ✓ wp-content/uploads/ (neue und geänderte Dateien)"
fi

# ── 3. Seiten-Content ─────────────────────────────────────────
if ! $THEME_ONLY; then
  echo ""
  echo "▶ [3/4] Seiten-Content aktualisieren..."

  # Mapping: "slug:lokale-datei" (kompatibel mit bash 3.2)
  PAGE_MAPPINGS=(
    "startseite:${LOCAL_PAGES}/startseite.html"
    "angebot:${LOCAL_PAGES}/angebot.html"
    "behandlungsmethoden:${LOCAL_PAGES}/behandlungsmethoden.html"
    "ueber-mich:${LOCAL_PAGES}/ueber-mich.html"
    "kontakt:${LOCAL_PAGES}/terminbuchung.html"
    "online-buchen:${LOCAL_PAGES}/online-buchen.html"
    "agb:${LOCAL_PAGES}/agb.html"
    "datenschutzerklaerung:${LOCAL_PAGES}/datenschutz.html"
  )

  for entry in "${PAGE_MAPPINGS[@]}"; do
    slug="${entry%%:*}"
    local_file="${entry#*:}"
    if [ ! -f "$local_file" ]; then
      echo "  ⚠ Datei nicht gefunden: $local_file – übersprungen"
      continue
    fi

    # Post-ID via WP-CLI ermitteln
    post_id=$(ssh "$SSH_HOST" "${WP} post list --post_type=page --post_status=any --name=${slug} --field=ID 2>/dev/null" 2>/dev/null | tr -d '[:space:]')

    if [ -z "$post_id" ]; then
      echo "  ⚠ Seite '${slug}' nicht gefunden auf Prod – übersprungen"
      continue
    fi

    if $DRY_RUN; then
      echo "  ~ (dry-run) Würde Seite '${slug}' (ID ${post_id}) aktualisieren"
    else
      # Direkt via $wpdb->update() um kses-Filter zu umgehen (SVG-Tags würden sonst gestripped)
      scp -q "$local_file" "${SSH_HOST}:/tmp/deploy_page_${post_id}.html"
      ssh "$SSH_HOST" "php -r \"
        define('ABSPATH','${REMOTE_WP}/');
        \\\$_SERVER['HTTP_HOST']='xphysio.ch';
        \\\$_SERVER['REQUEST_URI']='/';
        require_once ABSPATH.'wp-load.php';
        global \\\$wpdb;
        \\\$content=file_get_contents('/tmp/deploy_page_${post_id}.html');
        \\\$wpdb->update(\\\$wpdb->posts,['post_content'=>\\\$content],['ID'=>${post_id}]);
        clean_post_cache(${post_id});
        unlink('/tmp/deploy_page_${post_id}.html');
      \"" 2>/dev/null
      echo "  ✓ ${slug} (ID ${post_id})"
    fi
  done
fi

# ── 4. WordPress-Optionen & Theme-Mods ────────────────────────
if ! $THEME_ONLY; then
  echo ""
  echo "▶ [4/4] WP-CLI Setup-Scripts ausführen..."

  for script in "${LOCAL_WP_CLI}"/*.php; do
    script_name=$(basename "$script")
    if $DRY_RUN; then
      echo "  ~ (dry-run) Würde ${script_name} ausführen"
    else
      scp -q "$script" "${SSH_HOST}:/tmp/${script_name}"
      ssh "$SSH_HOST" "${WP} eval-file /tmp/${script_name} 2>&1 && rm /tmp/${script_name}" 2>/dev/null
      echo "  ✓ ${script_name}"
    fi
  done
fi

# ── Cache leeren (immer, ausser dry-run) ──────────────────────
if ! $DRY_RUN; then
  echo ""
  echo "▶ Cache leeren..."
  ssh "$SSH_HOST" "${WP} cache flush 2>/dev/null && rm -rf ${REMOTE_WP}/wp-content/cache/supercache 2>/dev/null; echo '  ✓ WP Cache + Super Cache geleert'" 2>/dev/null || echo "  ⚠ Cache flush fehlgeschlagen (nicht kritisch)"
fi

echo ""
echo "✅ Deployment abgeschlossen!"
echo ""
if ! $DRY_RUN; then
  echo "→ https://xphysio.ch"
fi
