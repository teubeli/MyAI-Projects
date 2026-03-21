# CHANGELOG – xphysio WordPress Website

Projektprotokoll für [xphysio.ch](https://xphysio.ch) – Physiotherapie Wetzikon, Michaela Tobler.
Einträge basieren auf Git-History und manuellen Session-Notizen.

---

## Projektübersicht

| | |
|---|---|
| **Website** | https://xphysio.ch |
| **Betreiberin** | Michaela Tobler, Physiotherapeutin BSc, Wetzikon ZH |
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

## Offene Punkte / Bekannte Issues

_(Hier manuell ergänzen nach Sessions)_

- [ ] Blog-Entwurf "Physiotherapie & chronische Krankheiten (BFH-Studie 2024)" noch nicht publiziert
- [ ] GA4 Measurement ID noch einzutragen

---

## Session-Notizen

| Datum | Thema | Notizen |
|-------|-------|---------|
| 2026-03-21 | Projekt-Einlesen | CHANGELOG erstellt aus Git-History |

