# CLAUDE.md – Dev Rules für xphysio-wordpress

## Prinzip: Was auf Local läuft, kommt auf Prod
- Local WP ist die Entwicklungsumgebung und Source of Truth für Dateien
- GitHub ist Source of Truth für Code-History
- Prod wird ausschliesslich via `bash deploy.sh` aktualisiert

## Workflow (Pflicht bei jeder Änderung)
1. Dateien im Repo editieren (`neve-child-theme/`, `pages/`, etc.)
2. Local WP reflektiert Änderungen sofort (Symlink: `neve-child → neve-child-theme/`)
3. Im Browser auf Local WP testen
4. `git add` + `git commit` + `git push`
5. `bash deploy.sh` → Prod

## neve-child-theme/ – Symlink
`/Local Sites/xphysio/.../themes/neve-child` → `/MyAI-Projects/xphysio-wordpress/neve-child-theme`
Neue Dateien im Theme-Ordner werden automatisch auf Local sichtbar und per deploy.sh auf Prod deployed.

## deploy.sh – Was wird deployed
| Schritt | Inhalt | Flag |
|---------|--------|------|
| 1 | neve-child-theme/ komplett (inkl. neue Dateien, --delete) | default + --theme-only |
| 2 | wp-content/uploads/ (neu/geändert, kein delete) | default + --theme-only |
| 3 | Seiteninhalte via wpdb->update() (SVG-sicher) | default + --db-only |
| 4 | WP-CLI Setup-Scripts (Optionen, Footer, Menus) | default + --db-only |

## Pflicht bei JEDEM Bild
- Format: WebP (mit PNG Fallback via `<picture>`)
- `loading="lazy"` auf allen `<img>` ausser LCP-Hero
- `width` + `height` Attribute immer setzen (CLS = 0 beibehalten)
- `srcset` + `sizes` für Responsive Images

## Performance-Architektur (Stand 2026-03-21, Score Mobile: ~84, CLS=0)

### deploy.sh – Wichtig
- Leert automatisch WP Super Cache nach jedem Deploy (Schritt 5)
- ⚠️ WP Super Cache war Ursache für viele scheinbare "opcache"-Probleme: altes HTML wurde gecacht

### Logo
- **Header + Footer**: weisses Logo (`Logo-und-Schrift-weiss-auf-transparent-1024x282.png/.webp`)
- Beide Hintergründe sind Navy (#1e2761) → weisses Logo überall korrekt
- WP-Attachment ID 157 (lokal + Prod): `custom_logo` + `neve_logo_footer`
- Logo-sizes: 120px (= tatsächliche Display-Grösse via --maxwidth)

### CSS-Strategie (functions.php)
- **Critical CSS inline** (`xphysio_critical_css_inline`, priority 2): Alles bis `.xp-services{` + Mobile-@media-Blöcke die Hero/Trust betreffen → kein render-blocking, kein CLS
- **neve-parent-style** (style.css, 1.2 KiB, kein CSS-Inhalt): async → spart 570ms render-blocking
- **Child CSS async** (`xphysio_defer_noncritical_css`): `neve-child-style`, `rank-math`, `cmplz-general` via `media="print" onload="this.media='all'"`
- **Neve Main CSS (neve-style)**: render-blocking (nötig!), aber preloaded → `<link rel="preload" as="style">`
- **Complianz banner-1-optin.css**: via JS geladen, kein WP-Handle → nicht kontrollierbar
- ⚠️ Complianz CSS NICHT auf andere Weise async laden (verursacht LCP-Regression)
- ⚠️ neve-style NICHT deferren: verursacht CLS ≥0.6 (zu viele Above-fold Abhängigkeiten: Container, Row, Logo, Header). Mehrfach getestet 2026-03-21, jedes Mal CLS. Endgültig verworfen.

### Neue CSS-Klassen hinzufügen?
Wenn neue **Above-fold Elemente** (sichtbar ohne Scrollen) hinzukommen:
→ Selektor in `$above_fold`-Array in `xphysio_critical_css_inline()` ergänzen
→ Sonst erscheinen sie im deferred CSS → CLS auf Mobile

### Neue Plugin installiert?
→ Prüfen ob es CSS lädt: Network Tab → CSS Filter → render-blocking?
→ Handle via `style_loader_tag` zu `xphysio_defer_noncritical_css()` hinzufügen

### Neue Bilder
- Format: WebP mit `cwebp -q 85` + PNG Fallback via `<picture>`
- `loading="lazy"` auf allen `<img>` ausser LCP-Hero
- `width` + `height` Attribute immer setzen (CLS = 0)
- `srcset` + `sizes` für Responsive Images
- Neue WebP-Dateien lokal erstellen: `cwebp -q 85 input.png -o output.webp`

### LCP-Hero
- `loading="eager"` + `fetchpriority="high"` + `<link rel="preload">` in `xphysio_font_preconnect()`
- URL hardcoded auf `xphysio.ch` → lokal gibt es einen 404-Preload-Fehler, das ist normal

### Kein render-blocking JS
- Neve Scripts: `defer` via `xphysio_defer_neve_scripts()`
- GTM: lazy nach Interaktion oder 2s via `xphysio_gtm_head()`
- CF7: nur auf /kontakt/ laden via `xphysio_dequeue_cf7_selectively()`
- Neue Scripts: immer `defer` oder `async` Attribut setzen

## Fokus (nie torpedieren)
Mobile First | UX | SEO | PageSpeed
