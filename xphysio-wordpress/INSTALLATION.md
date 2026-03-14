# xphysio.ch – WordPress Website Installationsanleitung

## Übersicht der erstellten Dateien

```
xphysio-wordpress/
├── neve-child-theme/
│   ├── style.css          → Komplettes Design (Farben, Komponenten, Responsive)
│   └── functions.php      → Schema.org, Matomo, Fonts, Booking-Shortcode
├── htaccess.txt           → Redirects, HTTPS, Security (→ umbenennen in .htaccess)
├── pages/
│   ├── startseite.html    → Startseite (Hero, Trust, Services, FAQ, CTA, Blog)
│   ├── angebot.html       → Leistungen & Preise
│   ├── behandlungsmethoden.html → 6 Methoden mit Schema
│   ├── ueber-mich.html    → Portrait, Timeline, Philosophie
│   ├── terminbuchung.html → Booking-Widget + Kontakt + Öffnungszeiten
│   ├── datenschutz.html   → DSG-konforme Datenschutzerklärung
│   ├── agb.html           → AGB (13 Punkte) + Impressum
│   └── blog.html          → Blog-Archiv + 6 Artikel-Vorschläge
└── INSTALLATION.md        → Diese Anleitung
```

---

## Phase 1: Lokale Entwicklung mit LocalWP

### 1.1 LocalWP installieren
```bash
brew install --cask local
```
Oder Download von: https://localwp.com

### 1.2 Neue Site erstellen
1. LocalWP öffnen → "+" → Neue Site
2. Name: **xphysio**
3. PHP: 8.2, MySQL: 8.0, Web Server: nginx
4. WordPress Admin erstellen
5. Site-URL wird: http://xphysio.local

### 1.3 Neve Theme installieren
WordPress Admin → Design → Themes → Neu hinzufügen → "Neve" suchen → Installieren & Aktivieren

---

## Phase 2: Child Theme aktivieren

### 2.1 Child Theme Ordner erstellen
Im LocalWP-Dateisystem (Finder oder via Terminal):
```
~/Local Sites/xphysio/app/public/wp-content/themes/neve-child/
```

### 2.2 Dateien kopieren
```bash
# Pfad anpassen falls LocalWP anders installiert ist
cp -r neve-child-theme/* ~/Local\ Sites/xphysio/app/public/wp-content/themes/neve-child/
```

### 2.3 Child Theme aktivieren
WordPress Admin → Design → Themes → "Neve Child" → Aktivieren

---

## Phase 3: Plugins installieren

| Plugin | Installation |
|--------|-------------|
| **RankMath SEO** | Plugins → Neu → Suchen → Installieren |
| **WP Rocket** ODER **W3 Total Cache** | WP Rocket (kostenpflichtig, empfohlen) |
| **Smush** oder **ShortPixel** | Plugins → Neu → Suchen |
| **UpdraftPlus** | Plugins → Neu → Suchen |
| **Contact Form 7** | Plugins → Neu → Suchen |
| **Akismet** | Bereits vorinstalliert, API-Key eingeben |
| **All-in-One WP Migration** | Für spätere Migration zu Infomaniak |

---

## Phase 4: Neve Customizer einrichten

Design → Customizer:
- **Header:** Farbe auf `#1e2761` (Navy) setzen
- **Logo:** xphysio-Logo hochladen
- **Primärfarbe:** `#1e2761`
- **Akzentfarbe:** `#7a2048`
- **Navigation:** Sticky Header aktivieren
- **Footer:** Widgets konfigurieren (Adresse, Links, Öffnungszeiten)

---

## Phase 5: Seiten erstellen

Für jede Seite:
1. WordPress Admin → Seiten → Neu hinzufügen
2. Titel setzen (H1 aus Tabelle)
3. Als "Vollbreite / No Sidebar" Template wählen (Neve)
4. HTML aus `pages/SEITENNAME.html` als Custom HTML-Block einfügen
5. ODER: Blöcke manuell in Gutenberg aufbauen (bessere Performance)

| Seite | Titel | Slug |
|-------|-------|------|
| Startseite | Physiotherapie Wetzikon – xphysio | `/` |
| Angebot | Leistungen & Preise | `/angebot/` |
| Behandlungsmethoden | Behandlungsmethoden | `/behandlungsmethoden/` |
| Blog | Blog | `/blog/` |
| Über mich | Über Michaela Tobler | `/ueber-mich/` |
| Terminbuchung | Termin buchen | `/terminbuchung/` |
| Datenschutz | Datenschutzerklärung | `/datenschutzerklaerung/` |
| AGB & Impressum | AGB & Impressum | `/agb/` |

### Startseite & Blog als Frontpage setzen:
Einstellungen → Lesen → Statische Seite:
- Startseite: "Startseite"
- Beitragsseite: "Blog"

---

## Phase 6: Booking-Widget einbinden

Auf der Seite "Terminbuchung":
1. Custom HTML-Block hinzufügen
2. Shortcode einfügen:
```
[xphysio_booking]
```
Das Widget wird automatisch responsiv gerendert.

Alternativ direkt als Custom HTML-Block:
```html
<div class="booking-widget-wrapper">
  <iframe
    src="https://onlinecalendar.medidoc.ch/BookAppointment?cgid=iRbKTRhcMUCaJqT_hUccRg&ssid=mQn5AH47dEij__eiQCnICQ"
    width="1150" height="1000" allow="fullscreen" scrolling="no"
    title="Online-Terminbuchung xphysio" loading="lazy">
  </iframe>
</div>
```

---

## Phase 7: RankMath SEO konfigurieren

1. RankMath Setup-Wizard durchführen
2. Schema-Typ für Website: MedicalBusiness
3. Lokales Geschäft: Adresse eingeben
4. Sitemap aktivieren (XML-Sitemap)
5. Pro-Seite: Focus Keyword + Meta Description setzen
6. Jede Seite auf "Grüner RankMath-Score" bringen

---

## Phase 8: Bilder hochladen

Benötigte Bilder (von Michaela zu liefern):
- `michaela-tobler-physiotherapeutin-wetzikon.jpg` (Hero, 1200×600)
- `michaela-tobler-portrait.jpg` (Über mich, 800×960)
- `praxis-xphysio.jpg` (Praxisfotos)
- `logo-xphysio.png` (transparent, weiß für Header)
- Blog-Bilder für die ersten Artikel

---

## Phase 9: Matomo einrichten (nach Go-Live)

1. Self-hosted Matomo auf Infomaniak installieren (separates Subdomain: matomo.xphysio.ch)
2. `functions.php` anpassen:
   - URL: `var u = "https://matomo.xphysio.ch/";`
   - Site-ID: nach erster Einrichtung anpassen
3. Matomo konfigurieren: IP-Anonymisierung + cookieless

---

## Phase 10: Migration zu Infomaniak

### 10.1 Lokal: Export
1. All-in-One WP Migration → Export → Datei (`.wpress`)
2. Datei herunterladen (kann mehrere GB gross sein)

### 10.2 Infomaniak: WordPress vorbereiten
1. Infomaniak Manager → Mein Hosting → WordPress installieren
2. WordPress-Admin aufrufen
3. All-in-One WP Migration Plugin installieren

### 10.3 Import + URL-Anpassung
1. All-in-One WP Migration → Import → `.wpress` Datei hochladen
2. URLs werden automatisch angepasst (local → xphysio.ch)
3. `.htaccess` aus `htaccess.txt` hochladen (umbenennen!)

### 10.4 DNS & Go-Live
1. DNS: A-Record xphysio.ch → Infomaniak IP
2. DNS: A-Record x-physio.ch → gleiche IP (dann .htaccess Redirect greift)
3. SSL-Zertifikat bei Infomaniak aktivieren (Let's Encrypt, kostenlos)
4. HTTPS-Redirect testen

---

## Verifikations-Checkliste (nach Go-Live)

- [ ] Schema.org: https://search.google.com/test/rich-results (alle 6 Seiten testen)
- [ ] Booking-Widget: Testbuchung durchführen
- [ ] Mobile: Chrome DevTools → iPhone Test
- [ ] Desktop: Chrome DevTools
- [ ] PageSpeed Insights: > 80 mobil, > 90 Desktop
- [ ] 301-Redirect: x-physio.ch → xphysio.ch prüfen
- [ ] 301-Redirect: www.xphysio.ch → xphysio.ch prüfen
- [ ] HTTPS: http://xphysio.ch → https://xphysio.ch prüfen
- [ ] Matomo: Echtzeit-Traffic beobachten
- [ ] Kontaktformular: Test-E-Mail senden
- [ ] RankMath: Alle Seiten grün
- [ ] UpdraftPlus: Automatisches Backup aktiviert

---

## Farben (Design Tokens)

| Variable | Hex | Verwendung |
|----------|-----|------------|
| `--color-navy` | `#1e2761` | Header, Hero, Footer, CTA-Banner |
| `--color-hellblau` | `#dff2ff` | Sektions-Hintergründe |
| `--color-bordeaux` | `#7a2048` | Buttons, Preise, Highlights |
| `--color-gruen` | `#77b978` | Kassen-Badges, Bestätigungen |

---

## Offene Punkte (von Michaela zu liefern)

1. **Bilder**: Portrait + Praxisfotos (professionell, JPG/WebP, min. 1200px breit)
2. **Persönlicher Text**: Über-mich-Seite (1–2 persönliche Absätze)
3. **Öffnungszeiten**: Aktuelle Zeiten bestätigen (aktuell Mo–Fr 07:30–20:00)
4. **Ausbildungs-Jahreszahlen**: Für Timeline bestätigen
5. **Instagram-Link**: Handle/@username für Footer
6. **Infomaniak-Zugangsdaten**: FTP/SFTP + WP-Admin für Migration
