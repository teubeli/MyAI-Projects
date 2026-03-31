#!/usr/bin/env python3
"""
Generiert personalisierte .eml-Dateien für jeden Patienten mit 'x' in Spalte A.
Verwendung: python3 generate_emails.py
"""

import base64
import openpyxl
import os
import re

EXCEL_FILE = "2026_03 Export Patienten Email.xlsx"
TEMPLATE_EML = "Vorlage-Patienten-Mail.eml"
OUTPUT_DIR = "Versand"

# EML laden und HTML-Body extrahieren
with open(TEMPLATE_EML, "r", encoding="utf-8") as f:
    template_raw = f.read()

# Base64-Block extrahieren und HTML dekodieren
parts = template_raw.split("Content-Transfer-Encoding: base64")
header = parts[0] + "Content-Transfer-Encoding: base64"
b64_block = parts[1]
b64_data = b64_block.split("--===============")[0].strip()
html_template = base64.b64decode(b64_data).decode("utf-8")

# Boundary ermitteln
boundary_match = re.search(r'boundary="([^"]+)"', template_raw)
boundary = boundary_match.group(1)

# Alles nach dem b64-Block (Footer/Boundary)
footer_start = parts[1].find("--===============")
footer = parts[1][footer_start:]

# Output-Ordner erstellen
os.makedirs(OUTPUT_DIR, exist_ok=True)

# Excel laden
wb = openpyxl.load_workbook(EXCEL_FILE)
ws = wb.active

count = 0
skipped = 0

for row in ws.iter_rows(min_row=2, values_only=True):
    marker, anrede, nachname, vorname, email = row[0], row[1], row[2], row[3], row[4]

    # Nur Zeilen mit 'x' in Spalte A und vorhandener E-Mail
    if str(marker).strip().lower() != "x":
        skipped += 1
        continue

    if not email or "@" not in str(email):
        print(f"  ⚠️  Übersprungen (keine E-Mail): {vorname} {nachname}")
        skipped += 1
        continue

    vorname = str(vorname).strip()
    nachname = str(nachname).strip()
    email = str(email).strip()

    # HTML personalisieren
    html_personalized = html_template.replace("[VORNAME]", vorname)

    # HTML re-enkodieren
    html_b64 = base64.encodebytes(html_personalized.encode("utf-8")).decode("ascii")

    # EML zusammenbauen
    eml_content = (
        header
        + "\n\n"
        + html_b64
        + footer
    )

    # To-Header setzen
    eml_content = re.sub(
        r"^To:.*$",
        f"To: {vorname} {nachname} <{email}>",
        eml_content,
        flags=re.MULTILINE,
    )

    # Dateiname: sicher für Dateisystem
    safe_name = re.sub(r"[^\w\-]", "_", f"{nachname}_{vorname}")
    filename = os.path.join(OUTPUT_DIR, f"{safe_name}.eml")

    with open(filename, "w", encoding="utf-8") as f:
        f.write(eml_content)

    print(f"  ✅  {vorname} {nachname} <{email}>")
    count += 1

print(f"\n✅ Fertig: {count} EML-Dateien erstellt in '{OUTPUT_DIR}/'")
print(f"   Übersprungen: {skipped} (kein 'x' oder keine E-Mail)")
