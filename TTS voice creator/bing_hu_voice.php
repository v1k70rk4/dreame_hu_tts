<?php
// Ellenőrizzük, hogy megvan-e a szükséges paraméterszám
if ($argc < 4) {
    echo "Használat: bing_hu_voice.php \"szöveg\" fájlnév hang\n";
    echo "Példa: php bing_hu_voice.php \"Szia világ\" kimenet Tamas\n";
    exit(1);
}

// Bemeneti paraméterek átvétele
$szoveg = $argv[1];
$mentes = $argv[2];
$hang = $argv[3];

// --- ÚJ RÉSZ: Ellenőrzés, hogy létezik-e már a fájl ---
$dir = strtolower($hang); // Mappa neve
$filePath = $dir . "/" . $mentes . ".wav"; // Teljes útvonal

if (file_exists($filePath)) {
    echo "--------------------------------------------------\n";
    echo "A fájl már létezik: $filePath\n";
    echo "TTS generálás és API hívás KIHAGYVA.\n";
    echo "--------------------------------------------------\n";
    exit(0); // Kilépünk, nem csinálunk semmit tovább
}
// -------------------------------------------------------

// --- KONFIGURÁCIÓ ---
// IDE ÍRD BE AZ API KULCSODAT!
$apiKey = "API_KULCS"; 

$AccessTokenUri = "https://northeurope.api.cognitive.microsoft.com/sts/v1.0/issueToken";
$ttsServiceUri = "https://northeurope.tts.speech.microsoft.com/cognitiveservices/v1";

// 1. LÉPÉS: Access Token beszerzése
$options = array(
    'http' => array(
        'header'  => "Ocp-Apim-Subscription-Key: " . $apiKey . "\r\n" .
                     "content-length: 0\r\n",
        'method'  => 'POST',
        'ignore_errors' => true 
    ),
);

$context = stream_context_create($options);

echo "Token lekérése...\n";
$access_token = @file_get_contents($AccessTokenUri, false, $context);

if ($access_token === false) {
    $error = error_get_last();
    throw new Exception("Hiba a Token lekérésekor ($AccessTokenUri): " . ($error['message'] ?? 'Ismeretlen hiba'));
}

// 2. LÉPÉS: SSML XML összeállítása
$doc = new DOMDocument();
$root = $doc->createElement("speak");
$root->setAttribute("version", "1.0");
$root->setAttribute("xml:lang", "hu-HU");

$voice = $doc->createElement("voice");
$voice->setAttribute("xml:lang", "hu-HU");

switch ($hang) {
    case "Tamas":
        $voice->setAttribute("name", "hu-HU-TamasNeural");
        break;
    case "Noemi":
        $voice->setAttribute("name", "hu-HU-NoemiNeural");
        break;
    case "Jenny":
        $voice->setAttribute("name", "en-US-JennyMultilingualV2Neural");
        break;
    case "Ryan":
        $voice->setAttribute("name", "en-US-RyanMultilingualNeural");
        break;
    default:
        throw new Exception("Ismeretlen hang: $hang. (Elérhető: Tamas, Noemi, Jenny, Ryan)");
}

$lang = $doc->createElement("lang");
$lang->setAttribute("xml:lang", "hu-HU");
$text = $doc->createTextNode($szoveg);
$lang->appendChild($text);
$voice->appendChild($lang);

$root->appendChild($voice);
$doc->appendChild($root);
$data = $doc->saveXML();

// 3. LÉPÉS: Hang generálása (TTS kérés)
$options = array(
    'http' => array(
        'header'  => "Content-type: application/ssml+xml\r\n" .
                     "X-Microsoft-OutputFormat: riff-16khz-16bit-mono-pcm\r\n" .
                     "Authorization: Bearer " . $access_token . "\r\n" .
                     "X-Search-AppId: 07D3234E49CE426DAA29772419F436CA\r\n" .
                     "X-Search-ClientID: 1ECFAE91408841A480F00935DC390960\r\n" .
                     "User-Agent: TTSPHP\r\n" .
                     "content-length: " . strlen($data) . "\r\n",
        'method'  => 'POST',
        'content' => $data,
        'ignore_errors' => true
    ),
);

$context = stream_context_create($options);

// Mappa létrehozása, ha nem létezik (Bár fent már kiszámoltuk az útvonalat, a mappa fizikailag lehet, hogy nincs meg)
if (!is_dir($dir)) {
    if (!mkdir($dir, 0777, true)) {
        throw new Exception("Nem sikerült létrehozni a mappát: $dir");
    }
}

echo "Hangfájl letöltése...\n";
$result = @file_get_contents($ttsServiceUri, false, $context);

// 4. LÉPÉS: Eredmény mentése
if ($result === false) {
    $error = error_get_last();
    throw new Exception("Hiba a TTS szolgáltatás hívásakor: " . ($error['message'] ?? 'Ismeretlen hiba'));
} else {
    if (isset($http_response_header[0]) && strpos($http_response_header[0], '200') === false) {
         throw new Exception("A szerver hibát dobott: " . $http_response_header[0]);
    }
    
    // Fájl mentése (a $filePath változót már az elején definiáltuk)
    if (file_put_contents($filePath, $result) === false) {
        throw new Exception("Nem sikerült a fájlt menteni ide: $filePath");
    }
    
    echo "Siker! Új fájl elmentve: $filePath\n";
}
?>