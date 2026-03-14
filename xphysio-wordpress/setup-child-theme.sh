#!/bin/bash
# ══════════════════════════════════════════════════════════════════════════════
# xphysio Child Theme Setup Script
# Führt dieses Skript aus, NACHDEM die WordPress-Site in LocalWP erstellt wurde.
#
# Verwendung:
#   chmod +x setup-child-theme.sh
#   ./setup-child-theme.sh
#
# Das Skript:
#   1. Findet die LocalWP-WordPress-Installation automatisch
#   2. Kopiert das Child Theme in das richtige Verzeichnis
#   3. Aktiviert das Child Theme via WP-CLI
#   4. Installiert Neve (Parent Theme) falls noch nicht vorhanden
# ══════════════════════════════════════════════════════════════════════════════

set -e

# ── Farben für Ausgabe ────────────────────────────────────────────────────────
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo ""
echo "════════════════════════════════════════════════════"
echo "  xphysio Child Theme Setup"
echo "════════════════════════════════════════════════════"
echo ""

# ── 1. LocalWP Pfad ermitteln ─────────────────────────────────────────────────
LOCAL_SITES="$HOME/Local Sites"
SITE_NAME="xphysio"
WP_PATH="$LOCAL_SITES/$SITE_NAME/app/public"

echo "Suche WordPress-Installation..."

if [ ! -d "$WP_PATH" ]; then
    echo -e "${RED}FEHLER: WordPress-Site nicht gefunden unter:${NC}"
    echo "  $WP_PATH"
    echo ""
    echo "Bitte zuerst in LocalWP eine neue Site namens 'xphysio' erstellen:"
    echo "  1. LocalWP öffnen"
    echo "  2. '+' → Neue Site erstellen"
    echo "  3. Name: xphysio"
    echo "  4. Site starten"
    echo "  5. Dann dieses Skript erneut ausführen"
    exit 1
fi

echo -e "${GREEN}✓ WordPress gefunden: $WP_PATH${NC}"

# ── 2. WP-CLI prüfen (LocalWP hat eigenes WP-CLI) ────────────────────────────
WPCLI="$LOCAL_SITES/$SITE_NAME/app/public"
# LocalWP WP-CLI Pfad
WP_CLI_CMD=""

# Prüfe ob globales wp-cli verfügbar
if command -v wp &> /dev/null; then
    WP_CLI_CMD="wp"
    echo -e "${GREEN}✓ WP-CLI gefunden: $(which wp)${NC}"
else
    echo -e "${YELLOW}⚠ Kein globales WP-CLI gefunden. Installiere via Homebrew...${NC}"
    brew install wp-cli
    WP_CLI_CMD="wp"
fi

# ── 3. Child Theme Ordner erstellen ──────────────────────────────────────────
THEMES_DIR="$WP_PATH/wp-content/themes"
CHILD_THEME_DIR="$THEMES_DIR/neve-child"
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
SOURCE_DIR="$SCRIPT_DIR/neve-child-theme"

echo ""
echo "Kopiere Child Theme..."

mkdir -p "$CHILD_THEME_DIR"

if [ ! -d "$SOURCE_DIR" ]; then
    echo -e "${RED}FEHLER: Source-Ordner nicht gefunden: $SOURCE_DIR${NC}"
    echo "Bitte Skript aus dem xphysio-wordpress/ Ordner ausführen."
    exit 1
fi

cp "$SOURCE_DIR/style.css"    "$CHILD_THEME_DIR/style.css"
cp "$SOURCE_DIR/functions.php" "$CHILD_THEME_DIR/functions.php"

echo -e "${GREEN}✓ Child Theme Dateien kopiert nach:${NC}"
echo "   $CHILD_THEME_DIR"

# ── 4. Screenshot Platzhalter erstellen ───────────────────────────────────────
# WordPress zeigt ohne screenshot.png eine Warnung im Theme-Menü
if [ ! -f "$CHILD_THEME_DIR/screenshot.png" ]; then
    # Minimales 1x1 transparentes PNG (Base64)
    echo "iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==" | base64 -d > "$CHILD_THEME_DIR/screenshot.png" 2>/dev/null || true
fi

# ── 5. Neve Parent Theme installieren ────────────────────────────────────────
echo ""
echo "Prüfe Neve Parent Theme..."

# WP-CLI braucht --path und --allow-root
WP_CMD="$WP_CLI_CMD --path=$WP_PATH --allow-root"

if $WP_CMD theme is-installed neve 2>/dev/null; then
    echo -e "${GREEN}✓ Neve ist bereits installiert${NC}"
else
    echo "Installiere Neve Theme..."
    $WP_CMD theme install neve
    echo -e "${GREEN}✓ Neve installiert${NC}"
fi

# ── 6. Child Theme aktivieren ─────────────────────────────────────────────────
echo ""
echo "Aktiviere Neve Child Theme..."
$WP_CMD theme activate neve-child
echo -e "${GREEN}✓ Neve Child Theme aktiviert${NC}"

# ── 7. Empfohlene Plugins installieren ───────────────────────────────────────
echo ""
read -p "Empfohlene Plugins installieren? (RankMath, UpdraftPlus, CF7, Akismet, All-in-One Migration) [j/N] " INSTALL_PLUGINS

if [[ "$INSTALL_PLUGINS" =~ ^[jJ]$ ]]; then
    echo "Installiere Plugins..."

    PLUGINS=(
        "seo-by-rank-math"
        "updraftplus"
        "contact-form-7"
        "akismet"
        "all-in-one-wp-migration"
        "smush"
    )

    for PLUGIN in "${PLUGINS[@]}"; do
        echo -n "  → $PLUGIN ... "
        if $WP_CMD plugin install "$PLUGIN" --activate 2>/dev/null; then
            echo -e "${GREEN}✓${NC}"
        else
            echo -e "${YELLOW}⚠ Fehler (manuell installieren)${NC}"
        fi
    done
fi

# ── 8. WordPress Grundeinstellungen ──────────────────────────────────────────
echo ""
read -p "WordPress Grundeinstellungen setzen (Permalink-Struktur, Sprache)? [j/N] " SETUP_WP

if [[ "$SETUP_WP" =~ ^[jJ]$ ]]; then
    # Permalinks auf /beitragsname/ setzen (wichtig für SEO)
    $WP_CMD rewrite structure '/%postname%/'
    $WP_CMD rewrite flush

    # Zeitzone Schweiz
    $WP_CMD option update timezone_string 'Europe/Zurich'

    # Sprache Deutsch Schweiz (falls verfügbar)
    $WP_CMD language core install de_CH 2>/dev/null || true

    # Blog-Beschreibung
    $WP_CMD option update blogdescription 'Physiotherapie Wetzikon – xphysio'

    echo -e "${GREEN}✓ Grundeinstellungen gesetzt${NC}"
fi

# ── Fertig ────────────────────────────────────────────────────────────────────
echo ""
echo "════════════════════════════════════════════════════"
echo -e "${GREEN}  ✓ Setup abgeschlossen!${NC}"
echo "════════════════════════════════════════════════════"
echo ""
echo "Nächste Schritte:"
echo "  1. http://xphysio.local/wp-admin/ öffnen"
echo "  2. Design → Customizer → Header auf Navy (#1e2761) setzen"
echo "  3. Seiten aus pages/*.html in WordPress einfügen"
echo "  4. RankMath konfigurieren"
echo ""
echo "WordPress Admin: http://xphysio.local/wp-admin/"
echo ""
