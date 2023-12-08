<?php
if ($argc < 4) {
    echo "Használat: bing_hu_voice.php \"szöveg\" fájlnév gender\n";
    exit;
}

$szoveg = $argv[1];
$mentes = $argv[2];
$gender = $argv[3];

$AccessTokenUri = "https://northeurope.api.cognitive.microsoft.com/sts/v1.0/issueToken";

$apiKey = "!!!!______________API KULCSOT IDE______________!!!!";

$ttsHost = "https://speech.platform.bing.com";

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
    $ttsServiceUri = "https://northeurope.tts.speech.microsoft.com/cognitiveservices/v1";

    $doc = new DOMDocument();
    $root = $doc->createElement("speak");
    $root->setAttribute("version", "1.0");
    $root->setAttribute("xml:lang", "hu-HU");

    $voice = $doc->createElement("voice");
    $voice->setAttribute("xml:lang", "hu-HU");

    // Változók nem alapján
    if ($gender == "male") {
        $voice->setAttribute("xml:gender", "Male");
        $voice->setAttribute("name", "hu-HU-TamasNeural");
        $dir = "male";
    } else {
        $voice->setAttribute("xml:gender", "Female");
        $voice->setAttribute("name", "hu-HU-NoemiNeural");
        $dir = "female";
    }

    $text = $doc->createTextNode($szoveg);
    $voice->appendChild($text);
    $root->appendChild($voice);
    $doc->appendChild($root);
    $data = $doc->saveXML();

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/ssml+xml\r\n" .
                        "X-Microsoft-OutputFormat: riff-24khz-16bit-mono-pcm\r\n" .
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

    if (!is_dir($dir)) {
        mkdir($dir); 
    }

    $result = file_get_contents($ttsServiceUri, false, $context);
    if (!$result) {
        throw new Exception("Problem with $ttsServiceUri, $php_errormsg");
    }
    else{
        $filePath = $dir . "/" . $mentes . ".wav";
        $myfile = fopen($filePath, "w") or die("Unable to open file!");
        fwrite($myfile, $result);
        fclose($myfile);
    }
}
?>
