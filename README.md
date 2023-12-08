# Dreame porszívó magyar hangcsomag és hangcsomag készítő script / The Hungarian voice package for Dreame vacuum cleaner, and the voice package creation script.
## Magyar  
_The English description can be found below._

vettem egy Dreame porszívót és magyar nyelvet csináltam hozzá, mert az jó :)

A Bing TTS-ét használtam, mert ennek a legjobb a magyar hangja.  
Mivel a porszívómat Consuelának hívják ezért nekem a női hang jön be, de elkészítettem a férfi hangcsomagot is.  
A hangcsomagban van: felmosótisztító, AI, ezüst-ion, kamera, porzsák, tiszta/szennyezet/mosószer-tartály hang, de a hangutasítások is.  
Amin mennie kell biztosan: L20 Ultra, L10 Prime, L10 Pro, Z10 Pro, W10, D9, Xiaomi mop 2 pro+

A fájlok mérete az L20 Ultra miatt ekkora, de ahogy tapasztaltam egy elsőgenerációs gép sem panaszkodik érte.  

Mivel a 200.ogg feletti szövegek sehol nem álltak rendelkezésre, ezért az egészet betettem egy hangfelismerő AI-ba és azzal gyűjtöttem ki a szövegeket. Remélem minden stimmel, ha nem akkor jelezd és javítom. :)  

### Hangcsomagok adatai:
- dreame-hu-male (Microsoft TTS - hu-HU-TamasNeural):  
  raw path: https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/dreame-hu-male  
  MD5 hash: 6e60020ed1fff808feecb647a1f526d6  
  Fájlméret: 5851800 byte  
    
- dreame-hu-female (Microsoft TTS - hu-HU-NoemiNeural):  
  raw path: https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/dreame-hu-female  
  MD5 hash: 3cd1615681c6a1f8d9f53ac1e935c7b2  
  Fájlméret: 6518045 byte  

### Telepítés menete:  
1. HomeAssistantból az alábbi módon történik:  
	Futtasd az alábbi parancsot:  
	
	```
	service: dreame_vacuum.vacuum_install_voice_pack
	data:
	url: >-
	    https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/dreame_hu_female
	  lang_id: hu
	  md5: "3cd1615681c6a1f8d9f53ac1e935c7b2"
	  size: 6518045 
	target:
	  entity_id: vacuum.dreamebot_<<<entity_id>>>
	```
  
2. Valetudo  
	Menj a `Robot Settings` -> `Misc Settings` menübe.  
	A `Voice packs` részbe írd be az alábbiakat:  
	URL: https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/dreame_hu_female  
	Language Code: hu  
	Hash: 3cd1615681c6a1f8d9f53ac1e935c7b2  
	File size: 6518045 byte  
	és kattints a `Set Voice Pack` gombra.

### Saját TTS hang létrehozása:
Ha valami hang hiányzik a mellékelt CSV-vel, php és python scriptekkel tudsz magadnak készíteni. Erre a részre nincs szükséged, ha neked megfelel az a hang, ami előre el van készítve!
1. A Bing TTS használatához szükséges API kulcs!  **Amit a bing_hu_voice.php fájl 13.-ik sorába be kell írni.**  
	- [Ingyenes kulcs beszerzés](https://azure.microsoft.com/en-us/try/cognitive-services/?api=speech-services)  
	- [Fizetős kulcs](https://go.microsoft.com/fwlink/?LinkId=872236)  
2. Szükséges programok:  
   Ezek Windows-ra vannak, de a linuxosok mindet repóból fel tudják tenni.  
	- **[PHP 7/8](https://www.php.net/downloads)** PATH-ba be kell tenni a php.exe elérési útját!
	- **[Vorbis-tools Windows](https://github.com/Chocobo1/vorbis-tools_win32-build/releases)** PATH-ba be kell tenni a oggenc.exe elérési útját! 
	- **ffmpeg** -> Windows 10/11 alatt rendszergazdaként `choco install ffmpeg`
	- **[python 3.11](https://apps.microsoft.com/detail/9NRWMJP3717K?hl=hu-HU&gl=HU)**
4. Használat:
   	- **ttscreate.py**  _pl: ttscreate.py gender --convert_  
   	  Ez a CSV-ből lévő összes szöveget elkészít először WAV fájlba -> átkonvertálja OGG kiterjesztésbe -> bemásolja a sound_ogg tartalmát az ogg fájlok közé (ezek ugye nem felolvashatóak) ->
   	  kitörli az s*.ogg fájlokat amik csak helykitöltők a .csv fájlban -> készít egy .tar.gz archívumot -> készít md5 kivonatot, amit a fájl méretével együtt egy txt fájlba ír.  
  	  _paraméter nélkül meghívva bekéri a nemet (male/female) és megkérdezi, hogy konvertálni szeretnéd-e a fájlokat._  
   	- **bing_hu_voice.php** _pl.: php bing_hu_voice.php "szöveg" fájlnév gender_  
   	   Ha csak egy szöveget szeretnél javítani elkészíti a megadott szöveget fájlnév.wav formában, a kért nemben (male/female) és ezután konvertálhatod újból.  
   	- **convert.py** _pl.: convert.py gender_  
   	  Ha konvertálás nélkül kérted vagy javítottál, ezzel tudod konvertálni külön.  

     
   
## English

I used Bing TTS because it has the best Hungarian voice.  
Since my vacuum cleaner is named Consuela, I prefer the female voice, but I also made a male voice pack.  
The voice pack includes: mop cleaner, AI, silver-ion, camera, dust bag, clean/dirty/detergent tank voice, and also voice commands.  
It should definitely work on: L20 Ultra, L10 Prime, L10 Pro, Z10 Pro, W10, D9, Xiaomi mop 2 pro+  

The file size is this large due to the L20 Ultra, but as I observed, even a first-generation machine does not complain about it.  

Since the texts for the files above 200.ogg were not available anywhere, I put the whole thing into a speech recognition AI and used it to collect the texts. I hope everything is correct, but if not, please let me know and I'll fix it. :)  

### Voice Pack Details  
- dreame-hu-male (Microsoft TTS - hu-HU-TamasNeural):   
  raw path: https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/dreame-hu-female  
  MD5 hash: 6e60020ed1fff808feecb647a1f526d6  
  File size: 5851800 bytes  
    
- dreame-hu-female (Microsoft TTS - hu-HU-NoemiNeural):  
  raw path: https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/dreame-hu-female  
  MD5 hash: 3cd1615681c6a1f8d9f53ac1e935c7b2  
  File size: 6518045 bytes  

### Installation Process:  
1. From HomeAssistant as follows:  
   Run the following command:  
   
   ```
   service: dreame_vacuum.vacuum_install_voice_pack
   data:
   url: >-
       https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/dreame-hu-female
     lang_id: hu
     md5: "3cd1615681c6a1f8d9f53ac1e935c7b2"
     size: 6518045 
   target:
     entity_id: vacuum.dreamebot_<<<entity_id>>>
   ```
  
2. Valetudo  
   Go to `Robot Settings` -> `Misc Settings`.  
   In the `Voice packs` section, enter the following:  
   URL: https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/dreame-hu-female
   Language Code: hu  
   Hash: 3cd1615681c6a1f8d9f53ac1e935c7b2  
   File size: 6518045 bytes  
   and click the `Set Voice Pack` button.

### Creating Your Own TTS Voice:
If you're missing any sound, you can create your own using the provided CSV, PHP, and Python scripts. You don't need this part if you're satisfied with the pre-made sounds!
1. API key required for Bing TTS! **Write it in the 13th line of the bing_hu_voice.php file.**  
   - [Free key acquisition](https://azure.microsoft.com/en-us/try/cognitive-services/?api=speech-services)  
   - [Paid key](https://go.microsoft.com/fwlink/?LinkId=872236)  
2. Required programs:  
   These are for Windows, but Linux users can install them from repositories.  
   - **[PHP 7/8](https://www.php.net/downloads)** Add the php.exe path to PATH!
   - **[Vorbis-tools Windows](https://github.com/Chocobo1/vorbis-tools_win32-build/releases)** Add oggenc.exe path to PATH! 
   - **ffmpeg** -> For Windows 10/11, install as administrator with `choco install ffmpeg`
   - **[python 3.11](https://apps.microsoft.com/detail/9NRWMJP3717K?hl=hu-HU&gl=HU)**
3. Usage:
    - **ttscreate.py** _e.g., ttscreate.py gender --convert_  
      This creates all texts from the CSV first in WAV file -> converts to OGG extension -> copies the content of sound_ogg into the ogg files (which are not readable) ->
      deletes the s*.ogg files which are just placeholders in the .csv file -> creates a .tar.gz archive -> creates an MD5 extract, which along with the file size is written into a txt file.  
      _Called without parameters, it asks for the gender (male/female) and whether you'd like to convert the files._  
    - **bing_hu_voice.php** _e.g., php bing_hu_voice.php "text" filename gender_  
       If you want to correct just one text, it creates the specified text in filename.wav format, in the requested gender (male/female), and then you can convert it again.  
    - **convert.py** _e.g., convert.py gender_  
      If you requested without conversion or corrected something, you can use this for separate conversion.  
