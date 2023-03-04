<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'CurlService.php';

use App\CurlService;

if (isset($_POST['urlAddress'])) {
// HTTP request to an input url
    $formCurl = new CurlService($_POST['urlAddress']);
    $formCurl->send()
             ->close();
    $jsonResponse = json_encode([
        'raw_text' => $formCurl->getContent(),
    ]);

//HTTP request to the HtmlProcessor.php
    $htmlProcessorUrl = 'http://localhost/projects/projects/Skillbox/skillbox/Module-18/HtmlProcessor.php';
    $processorCurl = new CurlService(
        url: $htmlProcessorUrl,
        contentType: 'application/json',
        method: 'post'
    );
    $processorCurl->setData($jsonResponse)
                  ->send()
                  ->close();

    if ($processorCurl->getStatusCode() === 500) {
        http_response_code($processorCurl->getStatusCode());
        die('<center><h1>Internal Server Error</h1></center>');
    }

    header('Content-Type: application/json');
    echo $processorCurl->getContent();
} else {
    ?>

    <?php require_once __DIR__ . DIRECTORY_SEPARATOR . 'html_entities' . DIRECTORY_SEPARATOR . 'header.html' ?>

        <main class="container min-vh-100 d-flex justify-content-center align-items-center">

            <form class="w-100" method="POST" action="html_import_processor.php">
                <h1 class="h3 mb-3 fw-semibold">Please Enter Your URL address</h1>

                <div class="form-floating mb-3 border-4">
                    <input type="text" class="form-control" name="urlAddress" id="url" placeholder="">
                    <label for="url">URL address</label>
                </div>

                <button class="w-75 rounded-4 btn btn-lg btn-primary" type="submit">Send</button>
            </form>
        </main>

    <?php require_once __DIR__ . DIRECTORY_SEPARATOR . 'html_entities' . DIRECTORY_SEPARATOR . 'footer.html' ?>


    <?php
}
?>
