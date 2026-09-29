# SEO-Optimierungen – To-do-Liste

Erstellt: 2026-09-29, Basis: GSC-Analyse (3 Monate) + GA4-Analyse (90 Tage) + GBP-Audit.

**Scope dieser Liste:** Nur Anpassungen, die wir **selbst** umsetzen (Website-Content, Struktur, internes Linking, Google Business Profile). Backlink-/PR-Aufbau bei Dritten (Presse, Verbände, Partner) ist bewusst **nicht** hier drin – das ist eine eigene Baustelle mit anderem Vorgehen.

**Ausgangslage:**
- Durchschnittliche Google-Position (3 Mt.): **11** – Grenze Seite 1/2
- Wichtigstes lokales Keyword "physiotherapie wetzikon" (214 Impressionen): Position **17** (Seite 2)
- "physio wetzikon" (104 Impr.): Position 10, "neuroathletik" (66 Impr.): Position 11, "sportphysiotherapie wetzikon" (39 Impr.): Position 22
- `/behandlungsmethoden/` (Kernseite für Leistungen): Position 18, trotz gutem Content
- GA4: Homepage-Absprungrate 43,6 %, Blog-Absprungrate 47,4 % (90 Tage)
- Nur 4 Google-Rezensionen, GBP-Profil ohne Titelbild/Logo (Details unten)

---

## A. Startseite (`/`)

- [ ] Sichtbaren Textabschnitt zu "Physiotherapie Wetzikon" ausbauen (aktuell vermutlich zu knapp für Pos. 17 bei 214 Impressionen) – Standort, Einzugsgebiet (Zürcher Oberland), Leistungsübersicht, was xphysio unterscheidet
- [ ] Google Maps direkt auf der Startseite einbetten (Trust- und Local-Signal)
- [ ] Vollständige NAP-Angaben (Name, Adresse, Telefon) als echten Text im Footer/Kontaktbereich sicherstellen (nicht nur als Bild/Schema) – exakt identisch zu GBP/local.ch/search.ch
- [ ] Trust-Elemente ergänzen: Sternebewertung/Rezensions-Snippet sichtbar einbinden (sobald mehr Rezensionen vorhanden sind, siehe Abschnitt E)

## B. Behandlungsmethoden (`/behandlungsmethoden/`)

- [ ] Interne Verlinkung von der Startseite verstärken: prominenter Link mit Keyword-Ankertext (z. B. "Physiotherapie-Behandlungsmethoden in Wetzikon" statt nur "Behandlungsmethoden")
- [ ] Inhalt vertiefen: je Methode (Maitland, Neuroathletik, kPNI) einen eigenen, längeren Abschnitt mit konkretem Nutzen für Patient:innen statt Kurzbeschreibung
- [ ] Zwischenüberschriften (H2/H3) mit den Suchbegriffen abgleichen, für die die Seite ranken soll ("Neuroathletik Wetzikon", "Maitland Physiotherapie" etc.)

## C. Internes Verlinken (generell)

- [ ] Blog-Artikel "Was ist Neuroathletik" (Pos. 11, 59 Impr.) stärker mit `/behandlungsmethoden/` und `/angebot/` verlinken (Linkkraft weiterreichen)
- [ ] Blog-Artikel "Physiotherapie & Krankenkasse" (Pos. 11,7, 235 Impr. – zweithöchstes Volumen nach der Startseite!) prominenter von Startseite/Angebot aus verlinken
- [ ] Footer-Navigation prüfen: verlinkt sie alle Hauptseiten mit sprechenden Ankertexten (kein reines "mehr")?

## D. Blog / Content

- [ ] Absprungrate im Blog (47,4 %) senken: am Ende jedes Artikels klare CTA einbauen ("Jetzt Termin buchen" / Link zu passender Behandlungsmethode)
- [ ] Bestehende Blog-Drafts fertig auf Prod deployen (siehe CHANGELOG "Offene Punkte"): Wellcome Fit (ID 70), Sturzprävention (ID 164), Vollzeit-Ankündigung (ID 162) – jeder neue, gut verlinkte Artikel stärkt Themenrelevanz für "Physiotherapie Wetzikon"
- [ ] Neue Artikel konsequent auf Long-Tail-Varianten der Money-Keywords ausrichten (z. B. "Sportphysiotherapie Wetzikon", "Lymphdrainage Wetzikon" – aktuell Pos. 22 bzw. 15,5)

## E. Google Business Profile ("x-physio M. Tobler") – Audit-Ergebnis

Geprüft am 2026-09-29 (eingeloggt als Profil-Admin). Eintrag ist verifiziert und grundsätzlich korrekt (Name, Adresse Breitistrasse 25, 8623 Wetzikon, Telefon, Kategorie "Physiotherapeut", Öffnungszeiten, Beschreibungstext vorhanden), aber deutlich ausbaufähig:

- [ ] **Titelbild fehlt komplett** – Google zeigt aktuell keinen Cover-Header für das Profil
- [ ] **Kein Logo hinterlegt** – Platzhalter aktiv, sollte gesetzt werden
- [ ] **Nur 4 Fotos insgesamt** (Eingang + 3 Behandlungsraum-Bilder). Diese 4 Fotos haben aber bereits 109–206 Aufrufe je Bild → Fotos werden gesehen, lohnt sich auszubauen. Empfehlung: Porträtfoto von Michaela (Vertrauen), weitere Praxis-/Team-Bilder, ggf. kurzes Video
- [ ] **Nur 4 Google-Rezensionen** (4,3 ★) – zu wenig für starke Local-Pack-Sichtbarkeit bei "physiotherapie wetzikon". Aktiv weiter Rezensionen einholen (Patienten-Mail-Kampagne aus dem CHANGELOG fortführen, evtl. QR-Code/Kärtchen in der Praxis)
- [ ] **Keine GBP-Beiträge ("Neuigkeiten") vorhanden** – Feld ist leer, "Neuigkeit hinzufügen" wird von Google aktiv vorgeschlagen. Bereits als Backlog-Punkt im CHANGELOG erfasst – regelmässig (z. B. bei jedem neuen Blog-Artikel) einen kurzen GBP-Post mit Teaser + Link erstellen
- [ ] **Zweitkategorie prüfen** – aktuell nur "Physiotherapeut" gesetzt; passende Zusatzkategorien (z. B. "Sportphysiotherapeut", falls verfügbar) könnten zusätzliche Sichtbarkeit bringen
- [ ] Dienstleistungen/Leistungen-Liste im Profil vervollständigen (Abgleich mit `/angebot/` – Google zeigte im Audit die "Dienstleistungen bearbeiten"-Sektion als unvollständig markiert)
- [ ] **Externe Verzeichnis-Konsistenz:** local.ch-Eintrag hat aktuell **keine Öffnungszeiten hinterlegt** ("Zu diesem Geschäft sind leider keine Öffnungszeiten eingetragen") – dort ergänzen, damit NAP-Daten überall konsistent sind

## F. Monitoring

- [ ] Nach Abarbeiten von A–D: Positionsentwicklung für die 5 Kern-Keywords (physiotherapie wetzikon, physio wetzikon, physiotherapie wetzikon zh, neuroathletik, behandlungsmethoden-Seite) alle paar Wochen in GSC prüfen
- [ ] Nach GBP-Fixes (Abschnitt E): Sichtbarkeit im Maps-Local-Pack für "physiotherapie wetzikon" stichprobenartig prüfen (Inkognito-Suche)

---

*Hinweis: Diese Liste ergänzt die separate, bereits im CHANGELOG dokumentierte GSC-Fehleranalyse (Umleitungsfehler, 404, Indexierung) vom 2026-09-29 – dort ging es um technische Fehler, hier um inhaltliche/strukturelle Rankingfaktoren.*
