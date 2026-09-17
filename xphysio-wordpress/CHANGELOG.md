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
- [x] **GSC: 6 Seiten re-submit** – 2026-09-14: kontakt, angebot, ueber-mich, behandlungsmethoden, blog, anfahrt via "Indexierung beantragen" neu eingereicht; Live-Test bestätigt für alle: kein Redirect-Fehler mehr, 4 von 6 waren bereits wieder indexiert (GSC-Bericht war nur veraltet, Crawl-Stand 20.07.) ✅
- [x] **GSC Seitenindexierung Vollcheck** – 2026-09-14: alle 4 "Nicht indexiert"/"Verbesserung"-Kategorien einzeln geprüft: RSS-Feeds + Such-URL korrekt nicht indexiert, `/was-ist-neuroathletik/` gesund aber (noch) nicht von Google indexiert (Google-Entscheidung, kein Site-Fehler), beide 404-URLs bereits bekannt/unkritisch (s. 2026-07-20) ✅
- [x] **robots.txt Fix: `/online-terminkalender/`** – 2026-09-14: `Disallow: /online-terminkalender/` blockierte Googlebot am Crawlen des eigenen 301-Redirects zu `/online-buchen/` → GSC-Warnung "Indexiert, obwohl durch robots.txt blockiert". Zeile entfernt, committed (`b715f44`), deployed, live verifiziert ✅
- [x] **Krankenkasse-Artikel publiziert** – 2026-07-17, ID 59, Datum 17.07.2026 ✅
- [ ] **⏰ Wellcome Fit-Artikel publizieren** – ID 70, noch draft (auf Prod + Local). Content, SEO-Meta und Beitragsbild sind vollständig und auf beiden Umgebungen identisch (2026-09-17 synchronisiert) – reine Publish-Entscheidung steht noch aus
- [ ] **⏰ Blog-Artikel "Vollzeit ab Dezember"** – ID 162, Kategorie Praxis & Wissen: Vorankündigung, dass Michaela ab 1.12.2026 zu 100% in der Praxis arbeitet. Content + Beitragsbild (helles Farbschema, bewusst) sind fertig (Stand 2026-09-17), bisher nur als Draft auf Local, noch nicht auf Prod deployed. Publizieren erst NACH konkreter Öffnungszeiten-Planung. Folgeartikel mit exakten neuen Zeiten geplant für Mitte November 2026
- [ ] **⏰ Blog-Artikel "Sturzprävention durch Neuroathletik"** – ID 164, Kategorie Neuroathletik: neuer Artikel, Content inkl. Abschnitt zur KVG-Kostenübernahme (situativ, ärztliche Verordnung nötig) und Beitragsbild fertig (Stand 2026-09-17), bisher nur als Draft auf Local, noch nicht auf Prod deployed. Publikationsdatum noch offen
- [x] **GSC Redirect-Fehler behoben** – .htaccess RedirectMatch + 3x 404-Redirects, "Fehlerbehebung überprüfen" geklickt ✅
- [x] **GA4 Conversion Tracking** – cta_termin_klick + kontakt_formular_gesendet via GTM, in DebugView bestätigt ✅
- [x] **GA4 Schlüsselereignisse** – korrekt via GTM definiert, am 17.07.2026 extensiv getestet ✅
- [x] **Medidoc Buchungs-Tracking – abgeschlossen (nicht umsetzbar)** – SoftPlus Support hat 2026-09-14 geantwortet: Wird nicht unterstützt, keine Redirect-URL/Webhook nach Buchung verfügbar. Zuverlässiges `termin_gebucht`-Tracking damit technisch nicht möglich (kein Fix mehr zu erwarten) – Thema geschlossen ✅
- [x] **Medidoc: finale Entscheidung zum Vorgehen** – 2026-09-14 Code-Review von `functions.php:1094-1125` bestätigt: Aktuell laufen live nur noch `kontakt_formular_gesendet` (CF7) und `cta_termin_klick` (Klick auf /online-buchen/-Links). Der frühere Funnel-Code für `medidoc_termin_gewaehlt`/`medidoc_formular_ausgefuellt`/`termin_gebucht` wurde bereits am 17.07. entfernt (Commit `356487f`) – die Events aus dem GA4-Datensatz vom 17.07. waren Test-Artefakte, können heute nicht mehr feuern. Entscheid: **`cta_termin_klick` bleibt bewusst der Proxy für Buchungsabsicht**, echte Buchungsabschlüsse sind nur in Medidoc selbst einsehbar (kein Redirect/API verfügbar). Kein weiterer technischer Aufwand geplant – Alternative (iFrame durch Link/neuer Tab ersetzen) bewusst verworfen (UX-Verschlechterung für schwaches Signal) ✅
- [x] **Medidoc: Live-Buchung als finaler Beweis** – 2026-09-14 Swen hat im Inkognito-Fenster einen echten Testtermin über das Medidoc-iFrame gebucht (Bestätigungsmail von xphysio@hin.physio erhalten: 15.09.2026, 08:00–08:30, Michaela Tobler). GA4 Echtzeit minutenlang beobachtet: **kein einziges neues Event** – auch nicht `cta_termin_klick` (Buchung erfolgte ohne frischen Klick auf einen `/online-buchen/`-Link). Bestätigt endgültig: Buchungsabschluss im Cross-Origin-iFrame ist für die Website-Analytics komplett unsichtbar. ⚠️ Test-Termin (15.09., 08:00–08:30) blockiert einen echten Kalender-Slot – sollte zeitnah storniert werden ✅
- [ ] **⏰ Öffnungszeiten / Kalender** – zusätzliche Öffnungszeiten definieren + auf Website publizieren; Medidoc-Kalender entsprechend freischalten
- [x] **WordPress-Plugins aktualisiert (Local + Prod)** – 2026-09-14: 9 Plugins mit verfügbaren Updates identifiziert, u.a. wp-smushit mit Major-Version-Sprung (3.24→4.3.2). Workflow: erst Local WP aktualisiert (`wp plugin update --all`), verifiziert (keine PHP-/Konsolenfehler, WebP-Bilder laden, Cookie-Banner funktioniert). Dann PageSpeed-Baseline auf Prod erfasst (Mobile 89, Desktop 75/CLS 0.321), UpdraftPlus-Backup via WP-CLI-Hook ausgelöst (`$updraftplus->backup_all()` – kein natives WP-CLI-Kommando vorhanden), danach alle 8 Plugins auf Prod aktualisiert (kein Akismet auf Prod aktiv). Nachher-Test: Mobile 90, **Desktop 99 (CLS 0.321→0)** – der schlechte Desktop-Vorherwert war eine einmalige Messschwankung, kein echtes Problem. Keine Fehler, Cache geleert ✅
- [x] **GSC "Nicht gefunden (404)"-Bericht analysiert** – 2026-07-20: `/anfahrt/` (Redirect ok, Indexierung beantragt), `/agbimpressum/` (Redirect → `/agb/`, dort korrekt robots.txt-blockiert, kein Fix nötig), `/wp-content/*` (False-Positive aus WP Speculative-Loading-JSON, dauerhaft ignorieren) ✅
- [x] **GA4 Auswertung geprüft** – 2026-07-20: Bot-Traffic aus USA (Flint Hill/Phoenix/San Jose, ~68% der "Nutzer") identifiziert; einzige Conversion-Events stammen vom Team-Test vom 17.07. – echte Nutzerdaten liegen noch nicht vor ✅
- [x] **GA4 Vergleich "Schweiz" eingerichtet** – gespeicherter Vergleich (Land = Switzerland) in GA4 erstellt, blendet US-Bot-Traffic (Flint Hill, Phoenix, San Jose) in Berichten aus; über "Vergleich hinzufügen" in jedem Bericht verfügbar ✅
- [x] **GA4 Interner Traffic-Regel erstellt** – IP 178.197.210.50/32 (aktuelle Swisscom-IP, vermutlich dynamisch) als "Team-Testing (Swen/Michaela)" hinterlegt in Internen-Traffic-Regeln; zugehöriger Datenfilter "Internal Traffic" bewusst im Status "Test" belassen (Google-Empfehlung: erst einige Tage beobachten, dann aktivieren – bei dynamischer IP sonst Risiko, später echte Patienten fälschlich auszuschliessen) ✅
- [x] **GA4 Internal-Traffic-IP korrigiert** – 2026-09-14: Regel hatte seit Einrichtung (17.07.) kein einziges Mal gegriffen – über den gesamten Zeitraum (76 Nutzer/94 Sitzungen) zeigte "Name des Testdatenfilters" durchgehend "(not set)". Ursache: dynamische Swisscom-IP hatte sich geändert (alt: 178.197.210.50, aktuell: 178.197.200.13). Regel "Team-Testing (Swen/Michaela)" auf neue IP aktualisiert + gespeichert. Anzumerken: Swen/Michaela waren in den vergangenen ~2 Monaten wohl kaum bis gar nicht aktiv auf der Seite unterwegs – die fehlenden Daten liegen also an geringer Testaktivität UND an der falschen IP ✅
- [ ] **⏰ GA4 Internal-Traffic-Filter aktivieren** – Live-Test 2026-09-14: Swen war nach der IP-Korrektur per Handy im selben WLAN auf der Seite (3 Seiten aufgerufen), in Echtzeit als aktiver Nutzer sichtbar (Standort Bern). Ob die Sitzung korrekt als "internal" getaggt wurde, lässt sich aber erst ab **2026-09-15** prüfen – Standardberichte/Explorationen haben ~24h Verarbeitungsverzögerung, "Name des Testdatenfilters" zeigte am 14.09. für heutige Daten noch "keine Daten vor". Nächster Schritt: ab 15.09. per Exploration (Dimension "Name des Testdatenfilters") prüfen, ob "Team-Testing (Swen/Michaela)" statt "(not set)" erscheint – erst dann Filter in Verwaltung → Datenfilter von "Test" auf "Aktiv" setzen. IP ist vermutlich weiterhin dynamisch – bei erneutem Ausfall Regel unter Datenstream → Google-Tag → Internen Traffic definieren erneut aktualisieren. Wichtig: Verifizierung nur über Geräte im gleichen WLAN wie die hinterlegte IP möglich, nicht über Mobilfunkdaten (andere IP) und nicht über den Browser mit installierter GA-Opt-out-Erweiterung (blockiert Tracking komplett)
- [x] **GA-Opt-out-Erweiterung installiert** – 2026-07-20, im Test-Browser (Mac, Swen), IP-unabhängig ✅
- [x] **GA4 Real-Daten ausgewertet** – 2026-09-14: Exploration 17.07.–12.09. (Schweiz-Filter) zeigt 49 Erstbesucher, 202 page_views, 34 `cta_termin_klick` (21 davon organisch verteilt nach dem 17.07.-Team-Test). Aber: **seit dem Team-Test am 17.07. keine einzige echte `termin_gebucht`- oder `kontakt_formular_gesendet`-Conversion mehr** – trotz 21 echten CTA-Klicks danach. Auslöser für Tracking-Verifizierung (siehe unten) ✅
- [x] **`kontakt_formular_gesendet`-Tracking live verifiziert** – 2026-09-14: Erstversuch über die Browser-Automation zeigte 0 GA4-Requests (auch kein page_view) – zunächst als möglicher Bug vermutet (Consent-Banner-Element `#cmplz-cookiebanner-container` im DOM auf `display:none`, Consent-Objekt leer). Test dann in echtem Inkognito-Fenster (Swen) wiederholt: Cookie-Banner erschien normal, `kontakt_formular_gesendet` wurde korrekt als Ereignis UND Schlüsselereignis in GA4 Echtzeit erfasst. **Kein echter Bug** – die automatisierte Browser-Session war die Ausnahme (vermutlich Erweiterungs-/Automatisierungs-Artefakt). Tracking funktioniert einwandfrei; die 0 Conversions seit 17.07. sind also echt (kein Interessent hat in ~2 Monaten das Formular genutzt oder eine Medidoc-Buchung abgeschlossen) ✅
- [x] **GSC Nachkontrolle robots.txt-Fix + 6 Redirect-Seiten** – 2026-09-15: 5 von 6 Seiten bereits neu indexiert bestätigt, `/anfahrt/` Live-Test grün (nur Google-Crawl-Verzögerung); robots.txt-Fix für `/online-terminkalender/` live korrekt, GSC zeigte nur noch eigenen Cache (bis 24h) ✅
- [x] **Vollständiger Local↔Prod Content-Audit** – 2026-09-17: systematischer Abgleich aller Seiten + Blog-Posts. Gefunden + behoben: fehlende Beitragsbilder (Post 58, 70), Content-Drift auf 3 Seiten (Blog-Übersicht, Kontakt, Online-Buchen), veraltete "Sie"-Anrede + toter Link auf Post 70, SEO-Titel-Drift auf 5 Seiten. Zusätzlich toten Platzhalter-Content auf der Blog-Seite (ID 8) bereinigt (Local + Prod) – Root Cause: `home.php` rendert diese Seite komplett selbst, gespeicherter Content war nie sichtbar. Alle lokalen Blog-Drafts zur einfacheren Vorschau auf Local publiziert (keine Prod-Auswirkung) ✅
- [x] **Neuer Blog-Artikel: Sturzprävention durch Neuroathletik** – 2026-09-16/17 erstellt (ID 164): Content, Beitragsbild, KVG-Kostenübernahme-Abschnitt fertig. Noch nicht auf Prod deployed (siehe offener Punkt oben) ✅

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
| 2026-07-17 | Blog-Artikel Status | Krankenkasse-Artikel (ID 59) via WP-CLI auf publish gesetzt, Datum auf heute; Wellcome Fit (ID 70) bleibt draft |
| 2026-07-17 | GSC Fixes | .htaccess: 301-Redirects für /anfahrt/, /online-terminkalender/, /begriffserlaerung/ + 2-Hop-Fix Hauptseiten (RedirectMatch); GSC "Fehlerbehebung überprüfen" geklickt |
| 2026-07-17 | GA4 Conversion Tracking | GTM: cta_termin_klick + kontakt_formular_gesendet (MutationObserver); GTM sofort auf /kontakt/ laden; beide Events in DebugView bestätigt |
| 2026-07-17 | Medidoc Funnel-Tracking | postMessage nur {"msg":"iframeDocumentReady"} – keine URL, kein Seitentyp → URL-basiertes + Step-Count-Tracking beide unmöglich; SoftPlus Support angefragt re Redirect-URL |
| 2026-07-20 | GSC 404-Bericht Deep-Dive | Live in Search Console (Konto mitoloki@gmail.com) geprüft: `/anfahrt/` Redirect funktioniert, Live-Test grün, Indexierung beantragt; `/agbimpressum/` redirectet auf robots.txt-blockierte `/agb/` (gewollt, kein Fix); `/wp-content/*` als False-Positive aus WordPress Speculative-Loading-JSON identifiziert (Prefetch-Ausschlussmuster, kein echter Link) – wird ignoriert |
| 2026-07-20 | GA4 Auswertung geprüft | Live in GA4 (Property xphysio.ch, Konto mitoloki@gmail.com) geprüft: ~68% der "Nutzer" der letzten 28 Tage sind Bot-Traffic aus US-Städten (Flint Hill, Phoenix, San Jose – 7-9 Sek. Sitzungsdauer, mehr neue als aktive Nutzer); alle Conversion-Events (cta_termin_klick, termin_gebucht, kontakt_formular_gesendet etc.) stammen von einer einzigen Person – erklärt durch Team-Testing der GTM-Events vom 17.07.2026, keine echten Patienten-Conversions bisher messbar; Bot-Filter und interner Traffic-Filter als offene Punkte identifiziert |
| 2026-09-14 | GSC Nachkontrolle + robots.txt Fix | Live in Search Console geprüft: Umleitungsfehler-Validierung vom 17.07. war fehlgeschlagen (6 Seiten), Live-Test aber überall grün → Indexierung für alle 6 neu beantragt. Zusätzlich alle 4 übrigen Nicht-indexiert/Verbesserung-Kategorien einzeln durchgecheckt: einzig `/online-terminkalender/` war ein echter Fund – robots.txt blockierte den eigenen 301-Redirect zu `/online-buchen/`. Fix committed + deployed (`b715f44`), live verifiziert |
| 2026-09-14 | GA4 Internal-Traffic-IP korrigiert | Explorative Datenanalyse mit Dimension "Name des Testdatenfilters" über 17.07.–14.09. zeigte durchgehend "(not set)" (76 Nutzer/94 Sitzungen) – Regel hat seit Einrichtung nie gegriffen. Ursache gefunden: dynamische Swisscom-IP hat sich geändert (178.197.210.50 → 178.197.200.13). Regel in GA4 aktualisiert + gespeichert. Anzumerken: Swen/Michaela waren die letzten ~2 Monate ohnehin kaum aktiv auf der Seite unterwegs – fehlende Daten also Kombination aus falscher IP und geringer Testaktivität. Filter bleibt bewusst auf "Test", bis neue IP sich in den Berichten bestätigt |
| 2026-09-14 | Medidoc Buchungs-Tracking geschlossen | SoftPlus Support hat auf die Anfrage vom 17.07. geantwortet: Redirect-URL/Webhook nach Buchung wird nicht unterstützt. Zuverlässiges `termin_gebucht`-Event-Tracking damit technisch nicht umsetzbar – Thema als nicht weiter verbesserbar geschlossen |
| 2026-09-14 | GA4 Real-Daten Auswertung + Formular-Tracking-Check | Exploration 17.07.–12.09. (Schweiz-Filter): 49 Erstbesucher, 34 cta_termin_klick, aber 0 echte termin_gebucht/kontakt_formular_gesendet seit dem Team-Test vom 17.07. Live-Test des Kontaktformulars (echtes Absenden, Testdaten klar markiert): erster Versuch über Browser-Automation zeigte 0 GA4-Requests – Verdacht auf Tracking-Bug (Cookie-Banner-Element im DOM auf display:none, Consent leer). Zweittest in echtem Inkognito-Fenster (Swen): Banner erschien normal, kontakt_formular_gesendet korrekt als Event + Schlüsselereignis erfasst. Kein Bug – Automatisierungs-Session war die Ausnahme. 0 Conversions seit 17.07. sind damit echt |
| 2026-09-14 | Medidoc: echte Testbuchung | Swen hat im Inkognito-Fenster real über Medidoc gebucht (Bestätigungsmail erhalten, 15.09. 08:00–08:30). GA4 Echtzeit minutenlang beobachtet: kein einziges neues Event, auch kein cta_termin_klick. Endgültige Bestätigung, dass der Buchungsabschluss im iFrame für Website-Analytics unsichtbar ist. Test-Termin danach storniert |
| 2026-09-14 | WordPress-Plugin-Updates | 9 veraltete Plugins identifiziert (Prod-Check via WP-CLI/SSH). Erst auf Local WP aktualisiert + verifiziert (keine Fehler, WebP/Cookie-Banner/Formular funktionieren). PageSpeed-Baseline auf Prod: Mobile 89, Desktop 75 (CLS 0.321 – Ausreisser). UpdraftPlus-Backup auf Prod via `$updraftplus->backup_all()` (WP-CLI eval, da kein natives Backup-Kommando existiert) – erfolgreich, keine Fehler im Log. Danach 8 Plugins auf Prod aktualisiert (inkl. wp-smushit Major-Update 3.x→4.x), Cache geleert. Nachher-Test: Mobile 90, Desktop 99 (CLS 0) – deutliche Verbesserung, keine Regression |
| 2026-09-15 | GSC Nachkontrolle: robots.txt-Fix + 6 Umleitungsfehler-Seiten | Live in Search Console (Konto mitoloki@gmail.com) per URL-Prüfung geprüft: **5 von 6** Umleitungsfehler-Seiten (kontakt, angebot, ueber-mich, behandlungsmethoden, blog) sind laut Google-Index bereits erfolgreich neu indexiert (grün, "Seite ist indexiert"). Bei `/anfahrt/` zeigt der Google-Index-Stand noch den alten Crawl vom 14.09. mit Umleitungsfehler, aber Live-Test von heute bestätigt: kein Redirect-Fehler mehr, Google muss nur noch neu crawlen. Für `/online-terminkalender/` (robots.txt-Fix vom 14.09., Commit `b715f44`): Live-Datei auf dem Server ist korrekt (`curl` mit Browser-/Googlebot-UA bestätigt keine Disallow-Regel mehr, Last-Modified 14.09. 13:56 Uhr – passt zum Fix). GSC Live-Test zeigt aber noch "Durch robots.txt-Datei blockiert" – das liegt am Google-eigenen robots.txt-Cache (bis zu 24h laut Google-Doku, Fix ist erst ~22h alt), kein echter Bug. Sollte sich innert der nächsten Stunden von selbst auflösen, kein weiterer Handlungsbedarf. Nebenbefund: `curl` ohne User-Agent-Header bekommt 403 auf robots.txt (Bot-Schutz-Regel) – Googlebot mit korrektem UA ist davon nicht betroffen |
| 2026-09-16 | Blog-Draft: Sturzprävention durch Neuroathletik | Als Draft in WordPress (Local) angelegt (ID 164, Kategorie "Neuroathletik" – der vom User genannte Kategorie-Name "Blog" existiert auf dieser Seite nicht als eigene Taxonomie, daher inhaltlich passendste bestehende Kategorie gewählt, analog zum bestehenden Artikel "was-ist-neuroathletik"). RankMath-Meta gesetzt (Title, Description, Focus-Keyword "Sturzprävention Neuroathletik"). Inhalt als Gutenberg-Blöcke aus Markdown-Vorlage übernommen, inkl. Quellenverzeichnis (7 Referenzen). Noch nicht auf Prod deployed – Draft existiert bisher nur lokal |
| 2026-09-16 | Beitragsbild Sturzprävention-Artikel | User-Bild aus Downloads (`xphysio_blog_sturzpraevention_bild.svg`, 690×470, mit eingebetteten C2PA-Metadaten) übernommen und für die Website aufbereitet: C2PA/Metadata-Block entfernt (~28KB Rohdaten unnötiger Payload), auf Standard-Canvas 1200×675 zentriert (Seitenverhältnis beibehalten, kein Verzerren/Croppen), Hintergrund auf Marken-Navy `#1e2761` abgestimmt. Daraus PNG (46.9 KB) + WebP (14.8 KB, `cwebp -q 85`) erzeugt – analog zu den bestehenden Blog-Headern (z.B. `blog-header-rueckenschmerzen.*`). Als Featured Image auf Post 164 hochgeladen (Attachment ID 166), WordPress generierte automatisch alle Thumbnail-Grössen (150/300/600/768/930/1024px) als PNG – dafür manuell WebP-Kopien erstellt (Schnellfix-Loop aus CLAUDE.md), da WP diese nicht automatisch erzeugt. Alt-Text gesetzt. Verifiziert via `get_the_post_thumbnail()`: korrektes srcset über alle Grössen, `loading="lazy"`, width/height gesetzt (CLS-sicher) ✅ |
| 2026-09-17 | Recherche + Ergänzung: KVG-Kostenübernahme Sturzprävention | Recherchiert (physioswiss.ch, BFU stoppsturz.ch): Sturzrisikoabklärung/-behandlung wird ab 1.7.2026 neue KVG-Pflichtleistung (Art. 5 KLV), aber nur situativ – gilt nur für Personen ab 65 mit moderatem/hohem Sturzrisiko, nur nach einem von zwei anerkannten Konzepten (StoppSturz/BFU oder Rheumaliga), erfordert ärztliche Verordnung; laut physioswiss "ausschliesslich qualifizierten Physiotherapeut:innen vorbehalten" (Zertifizierungsdetails noch nicht vollständig kommuniziert, Tarifverhandlungen laufen). Wichtig: deckt NICHT generisches Neuroathletik-Training ab, nur die zwei genannten Standardkonzepte. Auf Wunsch neuen Abschnitt "Kostenübernahme durch die Krankenkasse" in den Sturzprävention-Artikel (Post 164, Draft) eingefügt – bewusst zurückhaltend formuliert (situativ, Abklärung mit Arzt + Verordnung nötig), keine pauschale Kassenleistungs-Zusage |
| 2026-09-17 | Local-WP Blog-Bereich synchronisiert + alle Drafts publiziert | Diagnose: Local und Prod hatten unterschiedliche Post-Status/Inhalte im Blog-Bereich, da Artikel bisher teils direkt auf Prod (via SSH/WP-CLI-Skript) statt über Local + deploy.sh finalisiert wurden. Konkret: Post 59 (Krankenkasse-Artikel) war auf Prod seit 17.07. publiziert, auf Local aber noch veralteter Draft; Post 155 (lokaler Draft "Physiotherapie wirkt...") war ein überholter Vorläufer des längst auf Prod publizierten, umbenannten Artikels "Physiotherapie bei chronischen Krankheiten" (ID 158, BFH-Studie). Fix (nur auf Local, keine Prod-Schreibzugriffe): Content, Titel, Slug, Datum, Kategorie und RankMath-Meta von Prod für Post 59 und 155 übernommen, beide auf `publish` gesetzt; fehlendes Beitragsbild `blog-header-krankenkasse-schweiz.svg` von Prod nachgezogen und ins Repo übernommen (`blog-header-chronische-krankheiten.svg` war bereits vorhanden), beide als Featured Image gesetzt. Zusätzlich auf expliziten Wunsch alle übrigen lokalen Drafts (70 Wellcome Fit, 162 Vollzeit-Praxis, 164 Sturzprävention) auf Local ebenfalls auf `publish` gesetzt, damit der Blog-Bereich beim Browsen auf Local vollständig sichtbar ist (betrifft nur die lokale DB – auf Prod bleiben 70/162/164 weiterhin nicht vorhanden bzw. Draft, bis sie regulär über deploy.sh + wp-cli-setup deployed werden) |
| 2026-09-17 | Beitragsbild Vollzeit-Praxis-Artikel | User-Bild aus Downloads (`xphysio_blog_vollzeit_final_v2.svg`, 690×470, mit C2PA-Metadaten) übernommen und optimiert: Metadata-Block entfernt, auf Standard-Canvas 1200×675 zentriert (Seitenverhältnis beibehalten). Bild hat als einziges der Blog-Header ein **helles** Farbschema (#daeaf7, Kalender/Checkbox/Konfetti-Motiv) statt der sonst üblichen Navy-Optik – Rückfrage beim User ergab: bewusst hell belassen (nicht wie bei Sturzprävention auf Navy umgefärbt). PNG (35 KB) + WebP (10.7 KB) erzeugt, als Featured Image auf Post 162 hochgeladen (Attachment ID 174), WP-Thumbnail-Grössen + fehlende WebP-Kopien erstellt, Alt-Text gesetzt. Verifiziert via `get_the_post_thumbnail()`: korrektes srcset, lazy-loading, width/height ✅ |
| 2026-09-17 | Vollständiger Local↔Prod Content-Audit + Fixes | Auf User-Hinweis ("Was ist Neuroathletik" fehlt Bild auf Local) systematischen Abgleich **aller** Seiten und Blog-Posts zwischen Local und Prod durchgeführt (Content-Diff Zeile für Zeile). Gefundene + behobene Lücken (alle Fixes nur auf Local, keine Prod-Schreibzugriffe): (1) **Fehlende Beitragsbilder**: Post 58 (Neuroathletik) und Post 70 (Wellcome Fit) hatten auf Prod ein SVG-Beitragsbild, auf Local keins – beide SVGs lagen bereits im Repo, hochgeladen + als Featured Image gesetzt. (2) **Seiten-Content-Drift**: Blog-Übersichtsseite (ID 8) hatte auf Local noch die ursprünglichen Setup-Planungsnotizen von Projektbeginn statt des aktuellen (wenn auch selbst noch als Platzhalter markierten) Prod-Contents – von Prod übernommen. Kontakt (10) und Online-Buchen (129) fehlte ein (mittlerweile inaktiver, da datumsbasiert per JS ausgeblendeter) Ferienabwesenheits-Hinweis vom April 2026 – von Prod übernommen für exakte Parität. Seitentitel "Online-buchen" wich ab (Local "Termin online buchen" vs. Prod "Online buchen") – angeglichen. (3) **Post-Content-Drift**: Post 70 (Wellcome Fit) hatte auf Local noch alte "Sie"-Anrede + toten Link `/terminbuchung/`, auf Prod bereits korrigiert auf "Du" + `/online-buchen/` – übernommen, inkl. fehlender RankMath-SEO-Meta (Title/Description/Focus-Keyword). (4) **SEO-Titel-Drift**: RankMath-Titel von 5 Seiten (Startseite, Angebot, Behandlungsmethoden, Über-mich, Kontakt) waren auf Prod nachträglich optimiert worden, ohne dass Local nachgezogen wurde – alle 5 Titel angeglichen. Bewusst NICHT verändert: Page 3 (WP-Standard-Privacy-Policy-Entwurf, Domain-Platzhalter ist erwartungsgemäss je Umgebung unterschiedlich) und Page 76 (Cookie-Richtlinie, Complianz-Plugin generiert diesen Block dynamisch je nach Installations-Konfiguration – kein Sync-Fehler). Root Cause aller Lücken: Content wird bei "letzten Handgriffen" häufig direkt auf Prod per SSH/WP-CLI statt über Local + deploy.sh nachgezogen; dieser Weg aktualisiert Local nie automatisch zurück |
| 2026-09-17 | Blog-Seite (ID 8): toter Platzhalter-Content bereinigt | Root-Cause-Check bestätigt: `neve-child-theme/home.php` ist als Template für die Beiträge-Seite (`page_for_posts` = 8) gesetzt und rendert Hero + dynamische Artikel-Liste komplett selbst – `the_content()` der Seite wird nie aufgerufen. Der gespeicherte Content (alte "Blog-Artikel werden bald veröffentlicht"-Meldung, toter Link `/terminbuchung/`, ursprüngliche Setup-Planungsnotizen) war daher seit jeher unsichtbarer Datenbank-Ballast. Auf User-Bestätigung geleert (durch erklärenden HTML-Kommentar ersetzt) – auf **Local und Prod** gleichermassen (Prod-Cache anschliessend geleert). Live-Check nach dem Fix: `/blog/` weiterhin HTTP 200, H1 kommt unverändert aus `home.php` – keine sichtbare Änderung, nur DB-Hygiene. `repo/pages/blog.html` ebenfalls aktualisiert |

