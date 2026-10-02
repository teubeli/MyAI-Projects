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

**Legende:** 🔧 **ICH** = kann ich direkt umsetzen (Code/Deploy/eingeloggtes GBP-Tool) · 🙋 **DU** = braucht dich (Entscheidung, eigene Worte, fremdes Login, Kontakt zu Dritten)

---

## Prioritätenliste – was bringt am meisten

Sortiert nach geschätztem Ranking-Impact ÷ Aufwand. Wir arbeiten das Stück für Stück ab, nicht alles auf einmal.

1. **🙋 DU – Google-Rezensionen aktiv einholen.** Grösster Einzelhebel für den Maps-Local-Pack bei "physiotherapie wetzikon" – nur 4 Rezensionen aktuell. Konkret: Patienten nach dem Termin direkt um eine Bewertung bitten (mündlich + Link), evtl. QR-Code-Kärtchen am Empfang. *Ich kann dir eine kurze Text-/WhatsApp-Vorlage formulieren, wenn du willst – die Bitte selbst muss aber von dir/der Praxis kommen.*
2. **🔧 ICH – `/behandlungsmethoden/`: interne Verlinkung + Content vertiefen.** Rankt aktuell nur Position 18 trotz gutem Inhalt – reine Struktur-/Textarbeit, kann ich direkt im Theme umsetzen und deployen.
3. **🔧 ICH (mit deiner Freigabe für den Text) – Startseite: Abschnitt zu "Physiotherapie Wetzikon" ausbauen + Maps einbetten.** Technisch kann ich das bauen; den genauen Wortlaut (USPs, Tonalität) sollte Michaela absegnen, bevor er live geht.
4. **🔧 ICH – GBP: Titelbild + Logo hochladen.** Bin als Profil-Admin im Browser eingeloggt und könnte es direkt hochladen. *Brauche von dir: die gewünschten Bilddateien (z. B. ein Praxis-/Aussenfoto als Titelbild, das bestehende Logo) sowie deine Freigabe für den Upload – das ist eine öffentlich sichtbare Änderung, die ich nicht ohne Bestätigung mache.*
5. **🙋 DU – local.ch-Eintrag: Öffnungszeiten ergänzen.** Ich habe dort keinen Zugriff/Login. Braucht dich (oder du gibst mir Zugangsdaten, dann kann ich es via Browser erledigen).
6. **🔧 ICH (mit Terminentscheid von dir) – Blog-Drafts publizieren** (Wellcome Fit, Sturzprävention, Vollzeit-Ankündigung). Technisch fertig, ich kann via WP-CLI + `deploy.sh` live schalten – der Zeitpunkt/die Freigabe liegt bei dir (bei "Vollzeit" bewusst erst nach Öffnungszeiten-Planung, siehe CHANGELOG).
7. **🙋 DU (Vorschlag von mir) – Backlinks/Partner-Links aktiv anfragen**: Wellcome Fit (Partnerschaft besteht schon – Gegenlink auf deren Seite anfragen?), Gewerbeverein/Gemeinde Wetzikon, Zürcher Oberländer (lokale Presse). Ich kann dir pro Kontakt einen fertigen Anfrage-Text (Mail) vorbereiten, senden/verhandeln musst du oder Michaela selbst.
8. **🔧 ICH – GBP-Beiträge regelmässig posten** (bei jedem neuen Blogartikel ein kurzer "Neuigkeit"-Post mit Teaser + Link). Technisch mach ich das gerne laufend – du gibst kurz grünes Licht pro Post, dann ist es in 1 Minute erledigt.
9. **🔧 ICH – Blog-CTAs einbauen**, um die Absprungrate (47 %) zu senken – reine Content-/Template-Änderung.

---

## A. Startseite (`/`)

- [ ] 🔧 Sichtbaren Textabschnitt zu "Physiotherapie Wetzikon" ausbauen (aktuell vermutlich zu knapp für Pos. 17 bei 214 Impressionen) – Standort, Einzugsgebiet (Zürcher Oberland), Leistungsübersicht, was xphysio unterscheidet *(Text vorher mit dir/Michaela abstimmen)*
- [ ] 🔧 Google Maps direkt auf der Startseite einbetten (Trust- und Local-Signal)
- [ ] 🔧 Vollständige NAP-Angaben (Name, Adresse, Telefon) als echten Text im Footer/Kontaktbereich sicherstellen (nicht nur als Bild/Schema) – exakt identisch zu GBP/local.ch/search.ch
- [ ] 🔧 Trust-Elemente ergänzen: Sternebewertung/Rezensions-Snippet sichtbar einbinden (sobald mehr Rezensionen vorhanden sind, siehe Priorität 1)

## B. Behandlungsmethoden (`/behandlungsmethoden/`)

- [ ] 🔧 Interne Verlinkung von der Startseite verstärken: prominenter Link mit Keyword-Ankertext (z. B. "Physiotherapie-Behandlungsmethoden in Wetzikon" statt nur "Behandlungsmethoden")
- [x] 🔧 Pro Methode dezenter Buchungs-Button "Termin für <Methode> buchen" (2026-10-02) ✅
- [ ] 🔧 Inhalt vertiefen: je Methode (Maitland, Neuroathletik, kPNI) einen eigenen, längeren Abschnitt mit konkretem Nutzen für Patient:innen statt Kurzbeschreibung
- [ ] 🔧 Zwischenüberschriften (H2/H3) mit den Suchbegriffen abgleichen, für die die Seite ranken soll ("Neuroathletik Wetzikon", "Maitland Physiotherapie" etc.)

## C. Internes Verlinken (generell)

- [x] 🔧 Blog → Behandlungsmethoden verlinkt (2026-10-02): 9 kontextuelle Links mit Methoden-Ankertext in 4 Artikeln (Rücken 3, Neuroathletik 2, Krankenkasse 2 + Satz zu /angebot/, Chronische Krankheiten 2), Sprungziele #manuelle-therapie/#mtt/#neuroathletik/#schwindeltherapie ✅
- [ ] 🔧 Blog-Artikel "Physiotherapie & Krankenkasse" (Pos. 11,7, 235 Impr. – zweithöchstes Volumen nach der Startseite!) prominenter von Startseite/Angebot aus verlinken
- [ ] 🔧 Footer-Navigation prüfen: verlinkt sie alle Hauptseiten mit sprechenden Ankertexten (kein reines "mehr")?

## D. Blog / Content

- [x] 🔧 Absprungrate im Blog (47,4 %) senken: CTA-Box ("Termin online buchen" + "Kontakt aufnehmen") am Ende jedes Artikels – live seit 2026-10-02 (via `xphysio_blog_post_wrap()` in functions.php, gilt automatisch für alle künftigen Artikel). Wirkung in GA4 nach 4–6 Wochen prüfen ✅
- [ ] 🔧🙋 Bestehende Blog-Drafts fertig auf Prod deployen (Wellcome Fit ID 70, Sturzprävention ID 164, Vollzeit-Ankündigung ID 162) – technisch bereit, **Publikationsentscheid/-datum liegt bei dir**
- [ ] 🔧 Neue Artikel konsequent auf Long-Tail-Varianten der Money-Keywords ausrichten (z. B. "Sportphysiotherapie Wetzikon", "Lymphdrainage Wetzikon" – aktuell Pos. 22 bzw. 15,5)

## E. Google Business Profile ("x-physio M. Tobler") – Audit-Ergebnis

Geprüft am 2026-09-29 (eingeloggt als Profil-Admin). Eintrag ist verifiziert und grundsätzlich korrekt (Name, Adresse Breitistrasse 25, 8623 Wetzikon, Telefon, Kategorie "Physiotherapeut", Öffnungszeiten, Beschreibungstext vorhanden), aber deutlich ausbaufähig:

- [x] 🔧🙋 **Titelbild fehlt komplett** – erledigt 2026-10-02: Porträt Michaela als Titelbild hochgeladen (Prüfung durch Google ausstehend) ✅
- [x] 🔧🙋 **Kein Logo hinterlegt** – am 2026-10-02 geprüft: Pfeil-Logo ist bereits im Profil hinterlegt ✅
- [x] 🔧🙋 **Nur 4 Fotos insgesamt** – 2026-10-02: 4 neue Fotos hochgeladen (Empfang mit Michaela, 3× Behandlungsraum), jetzt 8 Fotos + Titelbild (Prüfung durch Google ausstehend). Upload-Dateien liegen unter `marketing/gbp-fotos/` ✅
- [ ] 🙋 **Nur 4 Google-Rezensionen** (4,3 ★) – siehe Priorität 1, reine Patientenansprache
- [ ] 🔧🙋 **GBP-Beiträge** – erster Beitrag (Krankenkasse-Artikel) am 2026-10-02 veröffentlicht. Rhythmus: alle 1–2 Wochen ein bestehender Artikel (nächste: Rückenschmerzen, Neuroathletik, chronische Krankheiten) + bei jedem neuen Artikel. Vorlagen/Bilder unter `marketing/gbp-beitraege/`, Links mit UTM (`utm_source=google&utm_medium=gbp_post&utm_campaign=<thema>`)
- [ ] 🔧 Zweitkategorie prüfen (z. B. "Sportphysiotherapeut" falls von Google angeboten) – kann ich direkt im Profil setzen
- [ ] 🔧 Dienstleistungen/Leistungen-Liste im Profil vervollständigen (Abgleich mit `/angebot/`) – kann ich direkt eintragen
- [ ] 🙋 **local.ch-Eintrag ohne Öffnungszeiten** – kein Zugriff meinerseits, **braucht dich** (oder Zugangsdaten für mich)

## F. Monitoring

- [ ] 🔧 Nach Abarbeiten von A–D: Positionsentwicklung für die 5 Kern-Keywords (physiotherapie wetzikon, physio wetzikon, physiotherapie wetzikon zh, neuroathletik, behandlungsmethoden-Seite) alle paar Wochen in GSC prüfen
- [ ] 🔧 Nach GBP-Fixes (Abschnitt E): Sichtbarkeit im Maps-Local-Pack für "physiotherapie wetzikon" stichprobenartig prüfen (Inkognito-Suche)

---

*Hinweis: Diese Liste ergänzt die separate, bereits im CHANGELOG dokumentierte GSC-Fehleranalyse (Umleitungsfehler, 404, Indexierung) vom 2026-09-29 – dort ging es um technische Fehler, hier um inhaltliche/strukturelle Rankingfaktoren.*
