# Dreame porszívó magyar hangcsomag és hangcsomag készítő script / Hungarian voice package & creation script for Dreame vacuums

## Magyar
_The English description can be found below._

Készítettem 4 hangcsomagot a Microsoft Azure TTS használatával Dreame porszívókhoz. Ebből két hang a **Tamás** és **Noémi** natív magyar hang. **Ryan** és **Jenny** pedig Multilang, de támogatják a magyar nyelvet is. A multilang nyelveknek van egy érdekes bája, de egyáltalán nem rosszak.

**Kompatibilitás és Információk:**
* **Támogatott eszközök:** Valószínűleg minden **Dreame**, valamint a **Mova** és **Truver** robotporszívókon működik. (Megjegyzés: A szövegezés elsősorban a forgó felmosópadokhoz (rotary pads) illeszkedik, így a hengeres (roller) felmosós modelleknél előfordulhatnak apróbb megnevezésbeli pontatlanságok, de a működést ez nem befolyásolja.)
* **Tesztelve:** Dreame X50 Ultra Complete és L10 Prime készüléken.
* **Fordítás:** Mivel az eredeti angol csomag hiányos volt az újabb modellekhez, a hiányzó részek az eredeti kínai hangcsomag hallás alapú AI fordításával készültek. Emiatt apróbb hibák vagy félrefordítások előfordulhatnak, de a funkciók többsége érthető.

### Hangcsomagok adatai (Frissítve):

- **tamas_dreame_hu_voice** (Microsoft TTS - hu-HU-TamasNeural):
  - URL: `https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/tamas_dreame_hu_voice`
  - MD5 hash: `c11b64d9d473d7c0404836822e6f3d74`
  - Fájlméret: `13320907` byte

- **noemi_dreame_hu_voice** (Microsoft TTS - hu-HU-NoemiNeural):
  - URL: `https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/noemi_dreame_hu_voice`
  - MD5 hash: `2f69f5bd66fd7199353169efaf05ed92`
  - Fájlméret: `15148480` byte

- **ryan_dreame_hu_voice** (Microsoft TTS - en-US-RyanMultilingualNeural):
  - URL: `https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/ryan_dreame_hu_voice`
  - MD5 hash: `f7b0b17793f4a50e9cecfd73ca9beaf3`
  - Fájlméret: `13500677` byte

- **jenny_dreame_hu_voice** (Microsoft TTS - en-US-JennyMultilingualV2Neural):
  - URL: `https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/jenny_dreame_hu_voice`
  - MD5 hash: `f2855619fcf421dc08f163d29737e665`
  - Fájlméret: `13528449` byte

### Telepítés menete:

#### 1. HomeAssistant (Dreame Vacuum integráció)
Futtasd az alábbi parancsot a Developer Tools / Services alatt (példa a Noémi hanghoz):

````
service: dreame_vacuum.vacuum_install_voice_pack
data:
  url: >-
    [https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/noemi_dreame_hu_voice](https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/noemi_dreame_hu_voice)
  lang_id: hu
  md5: "2f69f5bd66fd7199353169efaf05ed92"
  size: 15148480
target:
  entity_id: vacuum.dreamebot_<<<entity_id>>>
````

#### 2\. Valetudo

Menj a `Robot Settings` -\> `Misc Settings` menübe.
A `Voice packs` részbe írd be az alábbiakat (példa a Noémi hanghoz):

  * **URL:** `https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/noemi_dreame_hu_voice`
  * **Language Code:** `hu`
  * **Hash:** `2f69f5bd66fd7199353169efaf05ed92`
  * **File size:** `15148480`
    Majd kattints a `Set Voice Pack` gombra.

### Saját TTS hang létrehozása:

Ha valami hang hiányzik a mellékelt CSV-vel, php és python scriptekkel tudsz magadnak készíteni. Erre a részre nincs szükséged, ha neked megfelel az a hang, ami előre el van készítve\!

1.  **Microsoft Azure Speech (Bing TTS) API kulcs:** Amit a `bing_hu_voice.php` fájl 12.-ik sorába be kell írni.
      - [Ingyenes kulcs beszerzés](https://azure.microsoft.com/en-us/try/cognitive-services/?api=speech-services)
      - [Fizetős kulcs](https://go.microsoft.com/fwlink/?LinkId=872236)
2.  **Szükséges programok:**
    Ezek Windows-ra vannak, de a linuxosok mindet repóból fel tudják tenni.
      - Opcionális: Choco repo használat: `Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://community.chocolatey.org/install.ps1'))`
      - **[PHP 7/8](https://www.php.net/downloads)** PATH-ba be kell tenni a php.exe elérési útját\! -\> Choco: `choco install php --version=8.5 -y`
      - **[Vorbis-tools Windows](https://github.com/Chocobo1/vorbis-tools_win32-build/releases)** PATH-ba be kell tenni a oggenc.exe elérési útját\!
      - **ffmpeg** -\> Choco: `choco install ffmpeg`
      - **[python 3.11](https://apps.microsoft.com/detail/9NRWMJP3717K?hl=hu-HU&gl=HU)**
3.  **Használat:**
      - **ttscreate.py** *pl: `ttscreate.py HANG --convert`*
        Ez a CSV-ből lévő összes szöveget elkészít először WAV fájlba -\> normalizálja a hangot -\> átkonvertálja OGG kiterjesztésbe -\> bemásolja a sound\_ogg tartalmát az ogg fájlok közé (ezek ugye nem felolvashatóak) -\> kitörli az s\*.ogg fájlokat amik csak helykitöltők a .csv fájlban -\> készít egy .tar.gz archívumot -\> készít md5 kivonatot, amit a fájl méretével együtt egy txt fájlba ír.
        *paraméter nélkül meghívva megkérdezi melyik hangot szeretnéd (Tamas/Noemi/Ryan/Jenny) és megkérdezi, hogy konvertálni szeretnéd-e a fájlokat.*
      - **bing\_hu\_voice.php** *pl.: `php bing_hu_voice.php "szöveg" fájlnév HANG`*
        Ha csak egy szöveget szeretnél javítani elkészíti a megadott szöveget fájlnév.wav formában, a kért hangban (Tamas/Noemi/Ryan/Jenny) és ezután konvertálhatod újból.
      - **convert.py** *pl.: `convert.py HANG`*
        Ha konvertálás nélkül kérted vagy javítottál, ezzel tudod konvertálni külön.

-----

## English

I have created 4 voice packages using Microsoft Azure TTS for Dreame vacuums. Two of these are **Tamás** and **Noémi** (native Hungarian voices), while **Ryan** and **Jenny** are Multilingual voices that also support Hungarian. The multilingual voices have a unique charm, but they are quite good.

**Compatibility and Info:**

  * **Supported Devices:** Likely works on all **Dreame**, as well as **Mova** and **Truver** robot vacuums. (Note: The wording is optimized for rotary mop pads; models with roller mops might have slight terminology discrepancies, but functionality remains unaffected.)
  * **Tested on:** Dreame X50 Ultra Complete and L10 Prime.
  * **Translation:** Since the original English package was incomplete for newer models, the missing parts were translated from the original Chinese voice package using auditory AI translation. Therefore, minor errors may occur, but the functionality remains clear.

### Voice Package Data (Updated):

  - **tamas\_dreame\_hu\_voice** (Microsoft TTS - hu-HU-TamasNeural):

      - URL: `https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/tamas_dreame_hu_voice`
      - MD5 hash: `c11b64d9d473d7c0404836822e6f3d74`
      - File size: `13320907` bytes

  - **noemi\_dreame\_hu\_voice** (Microsoft TTS - hu-HU-NoemiNeural):

      - URL: `https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/noemi_dreame_hu_voice`
      - MD5 hash: `2f69f5bd66fd7199353169efaf05ed92`
      - File size: `15148480` bytes

  - **ryan\_dreame\_hu\_voice** (Microsoft TTS - en-US-RyanMultilingualNeural):

      - URL: `https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/ryan_dreame_hu_voice`
      - MD5 hash: `f7b0b17793f4a50e9cecfd73ca9beaf3`
      - File size: `13500677` bytes

  - **jenny\_dreame\_hu\_voice** (Microsoft TTS - en-US-JennyMultilingualV2Neural):

      - URL: `https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/jenny_dreame_hu_voice`
      - MD5 hash: `f2855619fcf421dc08f163d29737e665`
      - File size: `13528449` bytes

### Installation Guide:

#### 1\. HomeAssistant (Dreame Vacuum Integration)

Run the following command under Developer Tools / Services (example for Noémi voice):

```yaml
service: dreame_vacuum.vacuum_install_voice_pack
data:
  url: >-
    [https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/noemi_dreame_hu_voice](https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/noemi_dreame_hu_voice)
  lang_id: hu
  md5: "2f69f5bd66fd7199353169efaf05ed92"
  size: 15148480
target:
  entity_id: vacuum.dreamebot_<<<entity_id>>>
```

#### 2\. Valetudo

Go to `Robot Settings` -\> `Misc Settings`.
In the `Voice packs` section, enter the following (example for Noémi voice):

  * **URL:** `https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/noemi_dreame_hu_voice`
  * **Language Code:** `hu`
  * **Hash:** `2f69f5bd66fd7199353169efaf05ed92`
  * **File size:** `15148480`
    Then click the `Set Voice Pack` button.

### Creating Your Own TTS Voice:

If any sound is missing, you can create your own using the attached CSV, along with the PHP and Python scripts. You do not need this part if you are satisfied with the pre-made voice packages\!

1.  **API Key:** You need a Microsoft Azure Speech (Bing TTS) API key, which must be entered in line 12 of the `bing_hu_voice.php` file.
2.  **Required Programs:** (Instructions above are for Windows, but Linux users can install via repo).
      * PHP 7/8 (add to PATH)
      * Vorbis-tools (add `oggenc.exe` to PATH)
      * FFmpeg
      * Python 3.11
3.  **Usage:**
      * `ttscreate.py VOICE --convert` : Generates WAVs from CSV -\> Normalizes -\> Converts to OGG -\> Copies non-TTS sounds -\> Cleans up placeholders -\> Creates .tar.gz -\> Generates MD5 and size info.
      * `bing_hu_voice.php "text" filename VOICE` : Generates a single WAV file for corrections.
      * `convert.py VOICE` : Converts WAV to OGG if skipped previously.

<!-- end list -->

```
```
