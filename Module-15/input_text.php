<?php
require_once 'autoload.php';

// Local Classes
use entities\TelegraphText;
use entities\FileStorage;
// Imported Classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$response = [];

// Handling Exception errors
$exception_handler = function (Throwable $e) {
    $response = <<<REPLY
    <!doctype html>
    <html lang="ru">
      <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Telegraph</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link href="styles.css" rel="stylesheet">
      </head>
      <body class="text-center">
        <main class="form-telegraph w-100 m-auto">
          <div class="form-floating exception">{$e->getMessage()}</div>
          <a href="./input_text.php"><button class="w-100 btn btn-lg btn-send">Попробовать снова</button></a>
        </main>
      </body>
    </html>
    REPLY;
    echo $response;
};

set_exception_handler($exception_handler);

// Check if the form was submitted
if (isset($_POST['author'])) {
    // Assign POST variables
    $author = htmlspecialchars($_POST['author'], ENT_QUOTES);
    $message = htmlspecialchars($_POST['message'], ENT_QUOTES);
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES);

    // Create Telegraph object and store text
    $telegraph = new TelegraphText($author, 'user-message');
    $telegraph->text = $message;
    // Create FileStorage object and store object in json
    $fileStorage = new FileStorage();
    $fileStorage->create($telegraph);

    // Sending the mail thanks to PHPMailer Class
    if (!empty($email)) {
        // Create $mail object
        $mail = new PHPMailer(true);
        try {
            // Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = 'ssl://smtp.mail.ru';
            $mail->CharSet = 'UTF-8';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'SSL';
            $mail->Port = 465;
            $mail->Username = 'user@mail.ru';
            $mail->Password = 'secret';
            $mail->setLanguage('ru');

            // Recipients
            $mail->setFrom('from@mail.ru', 'Telegraph');
            $mail->addAddress($email, $author);

            // Content
            $mail->Subject = 'Ваше сообщение из Telegraph';
            $mail->msgHTML($message);

            // Sending the mail
            $mail->send();
            $response['message'] = 'Сообщение отправленно!';
            $response['class'] = 'success';

            // Catching exceptions
        } catch (Exception $e) {
            $response['message'] = "Сообщенее не может быть отправленно. {$e->getMessage()}.";
            $response['class'] = 'mail-error';
        }
    }
}

?>


<!doctype html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Telegraph</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="styles.css" rel="stylesheet">
  </head>
  <body class="text-center">

    <main class="form-telegraph w-100 m-auto">
      <?php if ($response) : ?>
        <div class="box-status <?php echo $response['class']; ?>">
          <p><?php echo $response['message']; ?></p>
        </div>
      <?php endif; ?>
      <form method="POST" action="input_text.php">

        <div class="form-floating">
          <input type="text" class="form-control" id="author" name="author" placeholder="Введите своё имя">
          <label for="author">Автор</label>
        </div>
        <div class="form-floating">
          <input type="email" class="form-control" id="email" name="email" placeholder="Введите свой email">
          <label for="email">Email</label>
        </div>
        <div class="form-floating">
          <textarea id="message" class="form-control" name="message" placeholder="Введите своё сообщение"></textarea>
          <label for="message">Сообщение</label>
        </div>

        <button class="w-100 btn btn-lg btn-send" type="submit">Отправить</button>
      </form>
    </main>

  </body>
</html>
