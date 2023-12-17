<?php
if ($argc < 4) {
    echo "Használat: bing_hu_voice.php \"szöveg\" fájlnév hang\n";
    exit;
}

$szoveg = $argv[1];
$mentes = $argv[2];
$hang = $argv[3];

$AccessTokenUri = "https://northeurope.api.cognitive.microsoft.com/sts/v1.0/issueToken";
$apiKey = "!!!!!!!!!API KEY!!!!!!!!!!!!!!!";
$ttsServiceUri = "https://northeurope.tts.speech.microsoft.com/cognitiveservices/v1";

$options = array(
    'http' => array(
        'header'  => "Ocp-Apim-Subscription-Key: ".$apiKey."\r\n" .
        "content-length: 0\r\n",
        'method'  => 'POST',
    ),
);

$context  = stream_context_create($options);
$access_token = file_get_contents($AccessTokenUri, false, $context);

if (!$access_token) {
    throw new Exception("Problem with $AccessTokenUri, $php_errormsg");
}
else{
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
            throw new Exception("Ismeretlen hang: $hang");
    }

    $lang = $doc->createElement("lang");
    $lang->setAttribute("xml:lang", "hu-HU");
    $text = $doc->createTextNode($szoveg);
    $lang->appendChild($text);
    $voice->appendChild($lang);
	
    $root->appendChild($voice);
    $doc->appendChild($root);
    $data = $doc->saveXML();

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/ssml+xml\r\n" .
                        "X-Microsoft-OutputFormat: riff-16khz-16bit-mono-pcm\r\n" .
                        "Authorization: "."Bearer ".$access_token."\r\n" .
                        "X-Search-AppId: 07D3234E49CE426DAA29772419F436CA\r\n" .
                        "X-Search-ClientID: 1ECFAE91408841A480F00935DC390960\r\n" .
                        "User-Agent: TTSPHP\r\n" .
                        "content-length: ".strlen($data)."\r\n",
            'method'  => 'POST',
            'content' => $data,
        ),
    );

    $context  = stream_context_create($options);

    $dir = strtolower($hang); // Mappa neve a hang alapján
    if (!is_dir($dir)) {
        mkdir($dir); 
    }

    $result = file_get_contents($ttsServiceUri, false, $context);
    if (!$result) {
        throw new Exception("Problem with $ttsServiceUri, $php_errormsg");
    }
    else{
        $filePath = $dir . "/" . $mentes . ".wav";
        $myfile = fopen($filePath, "w") or die("Nem sikerült a fájlt megnyitni!");
        fwrite($myfile, $result);
        fclose($myfile);
    }
}
?>
