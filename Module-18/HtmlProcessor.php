<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // receiving a data and unpacking it from json format
    $jsonData = file_get_contents('php://input');
    $arrayData = json_decode($jsonData, true);
    $rawText = $arrayData['raw_text'];
    // if empty an input data then setting response code 500
    if (empty($rawText)) {
        http_response_code(500);
    } else {
    // removing the a tag from given text without content of that tag and give it back
        header('Content-Type: application/json');
        $formattedText = preg_replace('%<a.*?>(.*?)</a>%i', '$1', $rawText);
        $response = json_encode([
            'formatted_text' => $formattedText,
        ]);

        echo $response;
    }
}
