<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="The best photo downloader in your neighborhood">
    <title>Photo Downloader</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="/css/styles.css" rel="stylesheet">
  </head>
  <body class="text-center">

    <main class="form-send w-100 m-auto">
      <form method="POST" action="send_photo.php" enctype="multipart/form-data">

        <div class="mb-3">
          <label for="form-file" class="form-label">Select your favorite photo (jpg, png)</label>
          <input class="form-control" type="file" name="photo" id="form-file">
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Send</button>
      </form>

<?php
// You should set in the php.ini upload_max_filesize or post_max_size, so
// the $_FILES will contain an array of a file with 'error'=>1 if the file exceed the limit size
const IMG_DIR_NAME = 'images';
const MB = 1024 * 1024;
const MAX_IMAGE_SIZE = 2 * MB;
const MAX_UPLOAD_TIMES = 1;

//var_dump($_FILES);

// To make it more neat I'm using set_exception_handler. Now every error that was intended to an user
// Will be formatted the same
$exceptionHandler = function (Throwable $ex) {
    echo '<p class="bg-warning mt-2 rounded-2 p-2">' . $ex->getMessage() . '</p>';
};

set_exception_handler($exceptionHandler);
// Starting session and setting 'uploadedCount'
session_start();
if (!isset($_SESSION['uploadedCount'])) {
    $_SESSION['uploadedCount'] = 0;
}
// Checking sessions here in order to prevent any execution below
// But I'm not sure if a Teacher wanted use 'greater than operator ">"' It will let user download 2 times
// But If we use 'greater than equal or operator ">="' we would prevent second downloading
if ($_SESSION['uploadedCount'] >= MAX_UPLOAD_TIMES) {
    throw new \Exception("You can not upload now. You've exceeded your limit for a day");
}

if (isset($_FILES['photo']) && strtolower($_SERVER["REQUEST_METHOD"]) === "post") {
    $photo = $_FILES['photo'];
    // Of course I could just check only if it is an array and throw an exception.
    // For the sake of skills I will make myself a mini challange
    if (is_array($photo['error']) && count($photo['error']) > 1 ) {
        throw new \Exception("Morpheus and Neo are already searching for you. You are needed in The Matrix, so choose your pill.");
    }
    // If $photo will contain an array of an array with one value. flattening it just in case
    $photo = array_map(fn($item) => is_array($item) ? $item[0] : $item, $photo);

    // This "if" block is dedicated to every error from $_FILES that I did't want to handle(not because I'm lazy)
    if ($photo['error'] > UPLOAD_ERR_INI_SIZE) {
        throw new \Exception('Something went wrong...');
    }
    // Checking if image size exceeding MAX_IMAGE_SIZE and if it exceeding our default size in php.ini
    if ($photo['size'] > MAX_IMAGE_SIZE || $photo['error'] === UPLOAD_ERR_INI_SIZE) {
        throw new \Exception("A file can't be bigger than 2 megabytes(MB)");
    }
    // Here you can easily add new extensions that you need. Give it a try
    // We could use $ext = pathinfo($name, PATHINFO_EXTENSION). But I'm fine with this result
    switch ($photo['type']) {
        case 'image/jpg':
            $ext = 'jpg';
            break;
        case 'image/png':
            $ext = 'png';
            break;
        default:
            throw new \Exception("You can only upload files with 'jpg' or 'png' extensions");
    }
    try {
        // Checking if a directory for images exists if not then create one
        $imgDirName = IMG_DIR_NAME;
        $imgDirPath = __DIR__ . '/' . $imgDirName;
        if (!is_dir($imgDirPath)) {
            mkdir($imgDirPath);
        }

        // Check if a file name already exists if it does then generate new one
        $fileName = "image.{$ext}";
        $prefix = 0;
        while (file_exists("{$imgDirPath}/{$fileName}")) {
            $fileName = "image_{$prefix}.{$ext}";
            $prefix++;
        }

        // If everything OK a photo will be save in an image directory
        move_uploaded_file($photo['tmp_name'], "{$imgDirPath}/{$fileName}");
        $_SESSION['uploadedCount']++;
        // Using Error class in order exception_handler don't catch it but we'll save it for you of course
    } catch (\Error $e) {
        $errorMsg = "[{$e->getCode()}]:{$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}";
        file_put_contents('errors.log', $errorMsg, FILE_APPEND);
        // Instead of a series error we will give an exception
        throw new \Exception("Movers're having lunch. Please, come in an hour and they will upload your file.");
    }
    // If something went wrong we still need to check existence of the file (i.e WARNING)
    if (file_exists("{$imgDirPath}/{$fileName}")) {
        header("Location: http://localhost:5555/{$imgDirName}/{$fileName}"); // Change location here
    } else {
        throw new \Exception("Please, don't tell any hackers about problems on the website ;(");
    }
}

?>
    </main>
  </body>
</html>
