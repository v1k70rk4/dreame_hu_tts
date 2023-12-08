import tarfile
import hashlib
import os
import subprocess
import sys
import shutil
import glob

# Paraméterek ellenőrzése és kérés, ha szükséges
if len(sys.argv) > 1:
    gender = sys.argv[1].lower()
else:
    gender = input("Kérem adja meg a nemet (male/female): ").lower()

# Ellenőrizzük, hogy a megadott nem helyes-e
if gender not in ["male", "female"]:
    raise ValueError("Érvénytelen nem. Kérem válasszon 'male' vagy 'female' közül.")

current_directory = os.getcwd()
input_folder = os.path.join(current_directory, gender)
output_folder = os.path.join(current_directory, f'{gender}-ogg')
sound_ogg_folder = os.path.join(current_directory, 'sound-ogg')

if not os.path.exists(output_folder):
    os.makedirs(output_folder)

# WAV fájlok feldolgozása
for filename in os.listdir(input_folder):
    if filename.endswith('.wav'):
        wav_file = os.path.join(input_folder, filename)
        tmp_file = os.path.join(output_folder, filename.replace('.wav', '_temp.wav')) 
        ogg_file = os.path.join(output_folder, filename.replace('.wav', '.ogg'))

        subprocess.run([
            "ffmpeg",
            "-i", wav_file,
            "-filter:a", "loudnorm=I=-5:LRA=1:dual_mono=true:tp=-1",
            tmp_file
        ])

        subprocess.run([
            "oggenc",
            tmp_file,
            "--output", ogg_file,
            "--bitrate", "56",
            "--resample", "16000"
        ])

        os.remove(tmp_file)

# sound-ogg tartalmának másolása
for filename in os.listdir(sound_ogg_folder):
    source_file = os.path.join(sound_ogg_folder, filename)
    destination_file = os.path.join(output_folder, filename)
    shutil.copy(source_file, destination_file)

# 's*.ogg' fájlok törlése
for filepath in glob.glob(os.path.join(output_folder, 's*.ogg')):
    os.remove(filepath)

# Tömörítés tar.gz formátumba
tar_gz_filename = os.path.join(current_directory, f'{gender}-ogg.tar.gz')
with tarfile.open(tar_gz_filename, "w:gz") as tar:
    for filename in os.listdir(output_folder):
        tar.add(os.path.join(output_folder, filename), arcname=filename)

# MD5 hash kiszámítása és fájlméret kiírása
hash_md5 = hashlib.md5()
with open(tar_gz_filename, "rb") as f:
    for chunk in iter(lambda: f.read(4096), b""):
        hash_md5.update(chunk)

md5_hash = hash_md5.hexdigest()
file_size = os.path.getsize(tar_gz_filename)

# Írjuk ki az eredményt egy txt fájlba
output_txt_file = tar_gz_filename + '.txt'
with open(output_txt_file, 'w') as f:
    f.write(f"MD5 hash: {md5_hash}\n")
    f.write(f"Fájlméret: {file_size} byte\n")

print("Kész.")
