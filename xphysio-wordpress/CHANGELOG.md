# CHANGELOG – xphysio WordPress Website

Projektprotokoll für [xphysio.ch](https://xphysio.ch) – Physiotherapie Wetzikon, Michaela Tobler.
Einträge basieren auf Git-History und manuellen Session-Notizen.

---

## Projektübersicht

| | |
|---|---|
| **Website** | https://xphysio.ch |
| **Betreiberin** | Michaela Tobler, Physiotherapeutin, Wetzikon ZH |
| **Technologie** | WordPress, Neve Child Theme, WP-CLI, deploy.sh |
| **Repo** | teubeli/MyAI-Projects → `xphysio-wordpress/` |
| **Entwicklungsumgebung** | Local WP (Symlink zu neve-child-theme/) |
| **Deployment** | `bash deploy.sh` → Prod |

---

## Phasen-Übersicht

### Phase 1 – Initiales Setup & Theme-Aufbau
> Commits: `ba35170` – `1e83463`

- WordPress Child Theme (Neve) erstellt mit kompletten Seiten: Startseite, Angebot, Behandlungsmethoden, Über mich, Terminbuchung, Blog, AGB, Datenschutz
- Setup-Skript für Local WP Einrichtung
- Logo eingebunden (320px skaliert)
- Praxis- und Portrait-Fotos integriert
- Kontaktformular (CF7) + dezente Telefon-Darstellung
- Schriftart: Lora (Titel), nach Wechsel von Playfair Display
- Nav-Farben Header korrigiert (Neve Selektoren)

---

### Phase 2 – Icons, Footer, Mobile-Grundlage
> Commits: `7ca408f` – `a3df3e1`

- Emoji-Icons durch professionelle SVG-Icons ersetzt (einheitlicher Ringstil)
- Method-Tags mit SVG-Icons ausgestattet
- 3-Spalten Footer: Logo, Navigation, Kontaktinfo
- Footer-Widgets via WP-CLI eingerichtet
- FAQ-Hover-Fix (Neve navy Background Override)
- Barrierefreiheit, SEO & UX – vollständiges Audit-Fixing
- Mobile-Layout: Inline-Grids durch responsive CSS-Klassen ersetzt
- Hamburger-Menü auf iPhone SE + Mobile Nav Fixes (weisse Links, Schliessen-X)

---

### Phase 3 – Inhalte & SEO-Grundlagen
> Commits: `077f5f4` – `bf1c4e0`

- SEO Meta-Tags vollständig implementiert
- Blog-Setup: 3 SEO-Artikel + 6 Kategorien
- Preisangaben konsolidiert und konsistent gemacht
- Kassenleistungen (KVG) klar von Privatleistungen getrennt
- Behandlungsmethoden: Kassenleistungen priorisiert
- Personal Training als Behandlungsmethode hinzugefügt
- Blog: Zurück-Link, Kategorie, Lesezeit auf Artikelseiten
- Alt-Texte Bilder korrigiert (SEO)
- E-Mail geändert auf `xphysio@hin.physio`
- Terminabsagen: nur noch per E-Mail

---

### Phase 4 – Wellcome Fit & Inhaltserweiterungen
> Commits: `52c664f` – `4484460`

- Wellcome Fit Partnerschaft: MTT-Seite + Blog-Post
- Anreise ÖV korrekt beschrieben (Bus 850 Kempten Ochsen)
- Mitgliedschaften: nur physioswiss
- OKP → KVG korrigiert, BSc aus Texten entfernt
- Timeline Ausbildung korrigiert
- Complianz GDPR: Cookie-Richtlinie im Footer + einzeilige Copyright-Leiste
- `.gitignore` für Credentials und Backups eingerichtet
- Lymphdrainage als Behandlungsmethode hinzugefügt

---

### Phase 5 – Online-Buchen, CTA-Button, Nav-Fixes
> Commits: `cbf25be` – `6f6d08a`

- Terminbuchung auf eigene Seite `/online-buchen/` ausgelagert
- CTA-Button im Header eingebaut
- iFrame-Höhe für Terminbuchung optimiert (900px → 1100px → 1600px)
- Nav-Fixes: CTA-Button-Selektor, Doppel-Titel, Kontakt-Seite
- Favicon: Kreuz-Logo als Browser-Favicon gesetzt
- Tab-Titel vereinheitlicht auf `xphysio Physiotherapie in Wetzikon`
- Schema JSON-LD BSc-Abkürzung entfernt

---

### Phase 6 – Angebot & Ausbildungen überarbeitet
> Commits: `4b6a44d` – `bf1c4e0`

- Angebot: Hero und Intro-Text überarbeitet
- Absagegebühr CHF 65 bei KVG-Leistungen als Fussnote
- Angebot-Tabelle: Stern bei Spalte Abrechnung
- Ausbildungs-Cards Redesign: Navy-Header, Icons, Checkmarks
- CrossFit L1 aus Ausbildungen entfernt
- Reihenfolge Credentials + Methoden-Tags angeglichen (Kassen zuerst)

---

### Phase 7 – Analytics & Tracking
> Commits: `321dfca` – `0c7e259`

- Matomo entfernt
- Google Tag Manager eingebunden (GTM-PTL8GNJS)
- GA4-Tracking vorbereitet
- Schema.org: physioswiss.ch als `sameAs`-Link ergänzt
- Instagram aus `sameAs` entfernt (kein Account)
- search.ch + local.ch als `sameAs` ergänzt
- RankMath übernimmt alle Meta-Tags
- BreadcrumbList-Fehler (Google Search Console) behoben

---

### Phase 8 – Performance & PageSpeed Mobile ≥ 90
> Commits: `ff73117` – `fa373c5`

- **PageSpeed Mobile: 67 → 90** (Best Practices 96, CLS 0)
- Logo WebP für Header + Footer
- `.htaccess` WebP-Auto-Serve + Browser-Cache
- Google Fonts async laden
- Hero-Bild WebP + Preload (LCP-Optimierung)
- WordPress Emoji-Support deaktiviert
- CF7-Scripts nur auf Kontaktseite laden
- Complianz CSS: async laden → **Rückgängig gemacht** (verursachte LCP-Regression)
- GTM lazy load rückgängig gemacht
- Preload-Hints für kritische CSS
- RankMath übernimmt SEO Meta-Tags (eigene Funktion entfernt)
- Neuroathletik-Artikel auf 606 Wörter erweitert (SEO)
- Article-Schema, 404-Seite, aria-current Navigation

---

### Phase 9 – Sie → Du Umstellung (Markenbotschaft)
> Commits: `0cc84c4` – `c61af38`

- Startseite, Angebot, Behandlungsmethoden, Über mich, Online-Buchen auf **Du-Ansprache** umgestellt
- Kontakt-Seite Du-Ansprache vervollständigt
- Öffnungszeiten überall korrigiert: Di 08:00–12:00 / 13:00–16:30, Do 14:00–17:00
- CHF 65 Pauschale in FAQ-Antworten korrekt kommuniziert
- Neue Markenbotschaft im Hero der Startseite
- Persönliches Zitat von Michaela auf Über-mich-Seite
- Footer-Tagline + Meta-Description auf neue Markenbotschaft
- physioswiss Mitglied-Logo auf Über-mich-Seite und im Footer

---

### Phase 10 – Deployment-Workflow & CLAUDE.md
> Commits: `628af8c` – `b757a84`

- `CLAUDE.md` mit Dev-Constraints und Regeln erstellt
- Symlink-Workflow dokumentiert und stabilisiert
- `deploy.sh` erweitert: Theme + Uploads vollständig, mit `--delete`
- `deploy.sh` Fix: `wpdb->update()` statt `wp post update` (SVG kses-Fix)
- Blog-Entwurf: Physiotherapie und chronische Krankheiten (BFH-Studie 2024)
- PageSpeed Mobile Regression behoben: 90 → 78 → 90 (render-blocking Resources entfernt)
- Complianz async CSS + neve/style.css preload Revert (LCP-Regression)

---

### Phase 11 – Google Sichtbarkeit & PageSpeed ≥90
> Commits: `4ed84fe` – `0709438`

- **Patienten-Email** erstellt: HTML Newsletter-Template (`marketing/email-patienten-v1.html`) + `.eml` Vorlage für Mac Mail
- **PageSpeed-Architektur** dokumentiert in CLAUDE.md (neve-style blocking, neve-parent-style deferred)
- **Claude Code Settings**: `bypassPermissions` + `ask` für `bash deploy.sh`

---

### Phase 13 – Hero Mobile Layout + PageSpeed 90
> Commits: `38d9c26` – aktuell

- **Hero Mobile**: 3-Grid-Struktur (`hero-text-top` / `hero-image` / `hero-actions`) → Bild erscheint auf Mobile zwischen Titel und Badges/CTA
- **CSS**: `grid-template-areas` für Desktop (Bild rechts, 2 Zeilen) + Mobile-Reihenfolge via `grid-template-areas`
- **Logo WebP**: WP hatte `-1-1` Thumbnails ohne WebP → WebP-Kopien manuell erstellt → `.htaccess` Auto-Serve greift jetzt
- **PageSpeed Mobile: 86 → 90** (CLS=0, TBT 50ms)
- **Bild-Checkliste** in CLAUDE.md dokumentiert (WebP-Pflicht, srcset, WP-Thumbnail-WebP-Problem)

---

### Phase 12 – Cleanup, Logo-Fix, PageSpeed-Debugging
> Commits: `fbe66a6` – `7961ccc`

- **Root-Cause PageSpeed**: WP Super Cache cachte alte HTML-Seiten → deploy.sh leert jetzt automatisch Cache nach jedem Deploy
- **neve-style deferral endgültig verworfen**: CLS ≥0.6 unvermeidbar (39KB, zu viele Above-fold Styles). Stabile Baseline: neve-style render-blocking + preloaded, Score ~84, CLS=0
- **neve-parent-style deferred**: style.css (1.2 KiB, kein CSS-Inhalt) → 570ms render-blocking gespart, Score 77→84
- **Logo weiss auf transparent** erstellt (`assets/logos/Logo-und-Schrift-weiss-auf-transparent-1024x282.png/.webp`)
  - Header + Footer nutzen jetzt weisses Logo auf Navy-Hintergrund (sauber, kein CSS-Trick mehr)
  - WP: custom_logo + neve_logo_footer auf ID 157 (lokal + Prod)
- **Logo sizes-Attribut**: 300px → 120px (entspricht tatsächlicher Display-Grösse)
- **Sie→Du**: Behandlungsmethoden-Seite ("Ihren Therapieerfolg" → "deinen", "Ihrer Physiotherapie" → "deiner")

---

## Offene Punkte / Bekannte Issues

- [x] Blog-Entwurf "Physiotherapie & chronische Krankheiten (BFH-Studie 2024)" publiziert (2026-03-31)
- [x] GA4 Measurement ID – aktiv via GTM (G-HLWWRL2T94), Tracking bestätigt 2026-03-22
- [x] Ärzte-Anschreiben erstellt (`marketing/aerzte-anschreiben-v2.txt`)
- [x] **Patienten-Mail gesendet** – 2026-03-30, inkl. Newsletter + Bitte um Google-Rezension
- [x] **⏰ Ärzte-Anschreiben senden** – `marketing/aerzte-anschreiben-v2.txt` – versandbereit (nach Ferienrückkehr ~16.04.2026)
- [x] Featured Images gesetzt – alle 5 Artikel ✅
- [x] RankMath Meta-Descriptions + Focus-Keywords gesetzt – alle 5 Artikel ✅
- [x] Google Rich Results Test: grün ✅
- [ ] **Backlog: Google Business Profile (GBP) Beiträge** – neue Blog-Artikel manuell als GBP-Post publizieren (Teaser + Link)
- [x] **GBP Sonderöffnungszeiten** – 02.04.–20.04.2026 als "Geschlossen" eingetragen ✅
- [x] Search Console: noindex-Tag auf unbekannte Seite geprüft → AGB (ID 12) + Datenschutz (ID 11) = korrekt gewollt ✅
- [x] Search Console: `/author/mitoloki/` + `/category/neuroathletik/` auf noindex gesetzt (via RankMath term/user meta) ✅
- [x] **Rückenschmerzen-Artikel publiziert** – 2026-04-29, post_date 2026-04-22, ID 57 ✅
- [x] **FAQPage JSON-LD Schema** für Blog-Posts implementiert (functions.php + _xphysio_faq_items post meta) ✅
- [x] **Search Console Fixes deployed** – 2026-04-30 ✅
- [ ] **⏰ GSC: 5 Seiten re-submit** – kontakt, ueber-mich, blog, angebot, behandlungsmethoden manuell in Search Console erneut zur Überprüfung einreichen (Seiten antworten 200 OK – nur GSC-Cache veraltet)
- [x] **Krankenkasse-Artikel publiziert** – 2026-07-17, ID 59 ✅
- [ ] **⏰ Wellcome Fit-Artikel publizieren** – ID 70, noch draft

---

## Session-Notizen

| Datum | Thema | Notizen |
|-------|-------|---------|
| 2026-03-21 | Projekt-Einlesen | CHANGELOG erstellt aus Git-History |
| 2026-03-21 | Email + PageSpeed | Patienten-Email erstellt, neve-style deferred, Logo-CLS-Fix |
| 2026-03-21 | Cleanup & Logo | WP Super Cache-Bug gefunden, weisses Logo erstellt, neve-style revertiert, Sie→Du fix |
| 2026-03-21 | Hero Mobile + Score 90 | Hero 3-spaltig restrukturiert (Bild zwischen Titel und Badges), Logo WebP-Thumbnails auf Prod ergänzt → Score 90, CLS=0 |
| 2026-03-22 | BSc entfernt, Ärzte-Anschreiben | BSc-Kürzel aus allen Dateien entfernt, Ärzte-Anschreiben v1+v2 erstellt, Versandplan festgelegt |
| 2026-03-31 | Search Console + Rich Results | SEO-Redirects (.htaccess), Article-Schema erweitert, BFH-Studie publiziert |
| 2026-03-31 | Alt-Texte + Blog-Header | Alt-Texte für alle Medien via WP-CLI gesetzt (inkl. BSc entfernt), Blog-Header SVGs für alle 5 Artikel |
| 2026-03-31 | RankMath + Rich Results | Meta-Descriptions + Focus-Keywords für alle 5 Artikel gesetzt, Rich Results grün ✅ |
| 2026-04-01 | Search Console noindex | /author/mitoloki/ + /category/neuroathletik/ auf noindex via RankMath; AGB+Datenschutz noindex bestätigt (korrekt) |
| 2026-04-29 | Rückenschmerzen-Artikel + FAQPage-Schema | Artikel ID 57 publiziert (post_date 22.04.), Du-Ansprache, Featured Image 1200×675 PNG, FAQPage JSON-LD Schema in functions.php |
| 2026-04-30 | Search Console Fixes | robots.txt (Disallow Regeln), .htaccess (301 /agbimpressum/→/agb/), deploy.sh (.htaccess+robots.txt Deploy-Schritt 0), RankMath Breadcrumbs aktiviert |
| 2026-07-17 | Blog-Artikel Status | Krankenkasse-Artikel (ID 59) via WP-CLI auf publish gesetzt; Wellcome Fit (ID 70) bleibt draft |

