# CLAUDE.md – Dev Rules für xphysio-wordpress

## Pflicht bei JEDEM Bild
- Format: WebP (mit JPEG/PNG Fallback via <picture>)
- `loading="lazy"` auf allen <img> ausser LCP-Hero
- `width` + `height` Attribute immer setzen (CLS vermeiden)
- `srcset` für Responsive Images

## Pflicht bei JEDEM Commit
- Reihenfolge: Local testen → Repo pushen → Prod deployen
- Kein direktes Pushen auf Prod ohne Local-Test

## Fokus (nie torpedieren)
Mobile First | UX | SEO | PageSpeed

## Sync-Check
- WP Local = Dev-Umgebung
- GitHub = Source of Truth
- Prod = nur via Git deployen
