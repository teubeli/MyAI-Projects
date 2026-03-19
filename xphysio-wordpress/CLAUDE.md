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

## Performance-Regeln (PageSpeed Mobile Ziel: ≥ 90)
- Neue Bilder: WebP mit `cwebp -q 85`, mehrere Grössen für srcset
- Hero/LCP-Bild: `loading="eager"` + `fetchpriority="high"` + `<link rel="preload">`
- Kein render-blocking JS: neue Scripts mit `defer` oder `async`
- Complianz CSS NICHT async laden (verursacht LCP-Regression)
- CLS = 0 beibehalten: immer `width` + `height` auf Bilder

## Fokus (nie torpedieren)
Mobile First | UX | SEO | PageSpeed
