import csv
import os
import subprocess
import sys

# CSV fájl elérési útjának beállítása
csv_path = "all_dreame_hu.csv"

# Hang paraméterének beállítása
voice_options = ["Tamas", "Noemi", "Jenny", "Ryan"]
voice = sys.argv[1] if len(sys.argv) > 1 else input(f"Kérlek válassz egy hangot ({'/'.join(voice_options)}): ").capitalize()

# Automatikus konverzió, ha a második paraméter --convert
run_conversion = 'igen' if len(sys.argv) > 2 and sys.argv[2] == '--convert' else input("Futtassuk a konvertálást a feldolgozás végén? (igen/nem): ")

# Ellenőrizzük, hogy létezik-e a CSV fájl
if not os.path.exists(csv_path):
    print(f"A fájl nem található: {csv_path}")
    sys.exit()

# Ellenőrizzük, hogy a hang paraméter helyes-e
if voice not in voice_options:
    voice = input(f"Kérlek válassz egy hangot ({'/'.join(voice_options)}): ").capitalize()

# CSV fájl beolvasása és feldolgozása
with open(csv_path, newline='', encoding='utf-8') as csvfile:
    csvreader = csv.DictReader(csvfile, delimiter=';')
    for row in csvreader:
        print(f"{row['Text']}", end='')
        # A bing_hu_voice.php szkript futtatása a szöveggel és a hanggal
        php_command = f'php bing_hu_voice.php "{row["Text"]}" "{row["Code"]}" {voice}'
        subprocess.run(php_command, shell=True)
        print(" ... done!")

# Konverzió
if run_conversion.lower() == 'igen':
    py_command = f"python convert.py {voice}"
    subprocess.run(py_command, shell=True)