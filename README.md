# Dreame porszívó magyar hangcsomag és hangcsomag készítő script / The Hungarian voice package for Dreame vacuum cleaner, and the voice package creation script.
## Magyar  
_The English description can be found below._

Készítettem 4 hangcsomagot a Bing TTS-ét használva a Dreame porszívókhoz. Ebből két hang a Tamás és Noémi natív magyar hang. Ryan és Jenny pedig Multilang és támogatja a magyar nyelvet is. A multilang nyelveknek van egy érdekes bája :) De nem rosszak.  
  
Tudomásom szerint minden Dreame porszívó hangjfájlait sikerült megtalánom. A hangcsomagban van: felmosótisztító, AI, ezüst-ion, kamera, porzsák, tiszta/szennyezet/mosószer-tartály hang, de a hangutasítások is.  
  
Amin mennie kell biztosan: L20 Ultra, L10 Prime, L10 Pro, Z10 Pro, W10, D9, Xiaomi mop 2 pro+  
  
A fájlok mérete az L20 Ultra miatt ekkora, de ahogy tapasztaltam egy elsőgenerációs gép sem panaszkodik érte.  

Mivel a 200.ogg feletti szövegek sehol nem álltak rendelkezésre, ezért az egészet betettem egy hangfelismerő AI-ba és azzal gyűjtöttem ki a szövegeket. Remélem minden stimmel, ha nem akkor jelezd és javítom. :)  

### Hangcsomagok adatai:
- tamas_dreame_hu_voice (Microsoft TTS - hu-HU-TamasNeural):  
  URL: https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/tamas_dreame_hu_voice  
  MD5 hash: 5f6a880db55abd6eb8044a1ea93ea319  
  Fájlméret: 6264469 byte  
    
- noemi_dreame_hu_voice (Microsoft TTS - hu-HU-NoemiNeural):  
  URL: https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/noemi_dreame_hu_voice  
  MD5 hash: 7abfc9ec9d16204f84ac138338066ec6  
  Fájlméret: 6938480 byte  

- ryan_dreame_hu_voice (Microsoft TTS - en-US-RyanMultilingualNeural):  
  URL: https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/ryan_dreame_hu_voice  
  MD5 hash: 11622301ecc59a90c0e5b2210136ef91  
  Fájlméret: 6306529 byte  
    
- jenny_dreame_hu_voice (Microsoft TTS - en-US-JennyMultilingualV2Neural):   
  URL: https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/jenny_dreame_hu_voice  
  MD5 hash: 267c79b664724b588174f9d3e87a9e45  
  Fájlméret: 6375317 byte  

### Telepítés menete:  
1. HomeAssistantból az alábbi módon történik:  
	Futtasd az alábbi parancsot:  
	
	```
	service: dreame_vacuum.vacuum_install_voice_pack
	data:
	url: >-
	    https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/noemi_dreame_hu_voice 
	  lang_id: hu
	  md5: "7abfc9ec9d16204f84ac138338066ec6"
	  size: 6938480 
	target:
	  entity_id: vacuum.dreamebot_<<<entity_id>>>
	```
  
2. Valetudo  
	Menj a `Robot Settings` -> `Misc Settings` menübe.  
	A `Voice packs` részbe írd be az alábbiakat:  
	URL: https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/noemi_dreame_hu_voice   
	Language Code: hu  
	Hash: 7abfc9ec9d16204f84ac138338066ec6  
	File size: 6938480 byte  
	és kattints a `Set Voice Pack` gombra.

### Saját TTS hang létrehozása:
Ha valami hang hiányzik a mellékelt CSV-vel, php és python scriptekkel tudsz magadnak készíteni. Erre a részre nincs szükséged, ha neked megfelel az a hang, ami előre el van készítve!
1. A Bing TTS használatához szükséges API kulcs!  **Amit a bing_hu_voice.php fájl 12.-ik sorába be kell írni.**  
	- [Ingyenes kulcs beszerzés](https://azure.microsoft.com/en-us/try/cognitive-services/?api=speech-services)  
	- [Fizetős kulcs](https://go.microsoft.com/fwlink/?LinkId=872236)  
2. Szükséges programok:  
   Ezek Windows-ra vannak, de a linuxosok mindet repóból fel tudják tenni.  
	- **[PHP 7/8](https://www.php.net/downloads)** PATH-ba be kell tenni a php.exe elérési útját!
	- **[Vorbis-tools Windows](https://github.com/Chocobo1/vorbis-tools_win32-build/releases)** PATH-ba be kell tenni a oggenc.exe elérési útját! 
	- **ffmpeg** -> Windows 10/11 alatt rendszergazdaként `choco install ffmpeg`
	- **[python 3.11](https://apps.microsoft.com/detail/9NRWMJP3717K?hl=hu-HU&gl=HU)**
4. Használat:
   	- **ttscreate.py**  _pl: ttscreate.py HANG --convert_  
   	  Ez a CSV-ből lévő összes szöveget elkészít először WAV fájlba -> normalizálja a hangot -> átkonvertálja OGG kiterjesztésbe -> bemásolja a sound_ogg tartalmát az ogg fájlok közé (ezek ugye nem felolvashatóak) ->
   	  kitörli az s*.ogg fájlokat amik csak helykitöltők a .csv fájlban -> készít egy .tar.gz archívumot -> készít md5 kivonatot, amit a fájl méretével együtt egy txt fájlba ír.  
  	  _paraméter nélkül meghívva megkérdezi melyik hangot szeretnéd (Tamas/Noemi/Ryan/Jenny) és megkérdezi, hogy konvertálni szeretnéd-e a fájlokat._  
   	- **bing_hu_voice.php** _pl.: php bing_hu_voice.php "szöveg" fájlnév HANG_  
   	   Ha csak egy szöveget szeretnél javítani elkészíti a megadott szöveget fájlnév.wav formában, a kért hangban (Tamas/Noemi/Ryan/Jenny) és ezután konvertálhatod újból.  
   	- **convert.py** _pl.: convert.py HANG_  
   	  Ha konvertálás nélkül kérted vagy javítottál, ezzel tudod konvertálni külön.  

     
   
## English

I have created 4 voice packs using Bing TTS for Dreame vacuum cleaners. Two of these voices are Tamás and Noémi, native Hungarian voices. Ryan and Jenny are Multilang and also support Hungarian. The Multilang languages have an interesting charm :) But they are not bad.  
  
To my knowledge, I have managed to find the voice files for every Dreame vacuum cleaner. The voice pack includes: mop cleaner, AI, silver ion, camera, dust bag, clean/dirty/detergent tank sound, as well as voice commands.   
  
It should definitely work on: L20 Ultra, L10 Prime, L10 Pro, Z10 Pro, W10, D9, Xiaomi mop 2 pro+  
  
The file size is this large due to the L20 Ultra, but as I observed, even a first-generation machine does not complain about it.  
  
Since the texts for the files above 200.ogg were not available anywhere, I put the whole thing into a speech recognition AI and used it to collect the texts. I hope everything is correct, but if not, please let me know and I'll fix it. :)  

### Voice Pack Details  
- tamas_dreame_hu_voice (Microsoft TTS - hu-HU-TamasNeural):  
  URL: https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/tamas_dreame_hu_voice  
  MD5 hash: 5f6a880db55abd6eb8044a1ea93ea319   
  File size: 6264469 byte  

- noemi_dreame_hu_voice (Microsoft TTS - hu-HU-NoemiNeural):  
  URL: https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/noemi_dreame_hu_voice   
  MD5 hash: 7abfc9ec9d16204f84ac138338066ec6   
  File size: 6938480 byte   

- ryan_dreame_hu_voice (Microsoft TTS - en-US-RyanMultilingualNeural):  
  URL: https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/ryan_dreame_hu_voice  
  MD5 hash: 11622301ecc59a90c0e5b2210136ef91  
  File size: 6306529 byte  
    
- jenny_dreame_hu_voice (Microsoft TTS - en-US-JennyMultilingualV2Neural):  
  URL: https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/jenny_dreame_hu_voice  
  MD5 hash: 267c79b664724b588174f9d3e87a9e45  
  File size: 6375317 byte  

### Installation Process:  
1. From HomeAssistant as follows:  
   Run the following command:  
   
   ```
   service: dreame_vacuum.vacuum_install_voice_pack
   data:
   url: >-
       https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/dreame-hu-female
     lang_id: hu
     md5: "7abfc9ec9d16204f84ac138338066ec6"
     size: 6938480 
   target:
     entity_id: vacuum.dreamebot_<<<entity_id>>>
   ```
  
2. Valetudo  
   Go to `Robot Settings` -> `Misc Settings`.  
   In the `Voice packs` section, enter the following:  
   URL: https://raw.githubusercontent.com/v1k70rk4/dreame_hu_tts/main/dreame_voicepack_hu/dreame-hu-female
   Language Code: hu  
   Hash: 7abfc9ec9d16204f84ac138338066ec6  
   File size: 6938480 bytes  
   and click the `Set Voice Pack` button.

### Creating Your Own TTS Voice:
If you're missing any sound, you can create your own using the provided CSV, PHP, and Python scripts. You don't need this part if you're satisfied with the pre-made sounds!
1. API key required for Bing TTS! **Write it in the 12th line of the bing_hu_voice.php file.**  
   - [Free key acquisition](https://azure.microsoft.com/en-us/try/cognitive-services/?api=speech-services)  
   - [Paid key](https://go.microsoft.com/fwlink/?LinkId=872236)  
2. Required programs:  
   These are for Windows, but Linux users can install them from repositories.  
   - **[PHP 7/8](https://www.php.net/downloads)** Add the php.exe path to PATH!
   - **[Vorbis-tools Windows](https://github.com/Chocobo1/vorbis-tools_win32-build/releases)** Add oggenc.exe path to PATH! 
   - **ffmpeg** -> For Windows 10/11, install as administrator with `choco install ffmpeg`
   - **[python 3.11](https://apps.microsoft.com/detail/9NRWMJP3717K?hl=hu-HU&gl=HU)**
3. Usage:
	- **ttscreate.py** _example: ttscreate.py VOICE --convert_  
	  This script first processes all the text from the CSV into a WAV file -> normalizes the sound -> converts it into OGG format -> copies the content into the sound_ogg folder among the ogg files (which are not readable) ->
	  deletes the s*.ogg files which are just placeholders in the .csv file -> creates a .tar.gz archive -> generates an md5 summary, which is written into a txt file along with the file size.  
	  _When called without parameters, it asks which voice you would like to use (Tamas/Noemi/Ryan/Jenny) and whether you would like to convert the files._

	- **bing_hu_voice.php** _example: php bing_hu_voice.php "text" filename VOICE_  
	  If you want to correct just one piece of text, it creates the specified text in filename.wav format in the requested voice (Tamas/Noemi/Ryan/Jenny) and then you can convert it again.

	- **convert.py** _example: convert.py VOICE_  
	  If you requested or corrected without conversion, this script can be used to perform the conversion separately.