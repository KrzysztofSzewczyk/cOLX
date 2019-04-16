
<?php

require 'vendor/autoload.php';

$database = new \Filebase\Database([
    'dir' => 'db/'
]);

$message = null;

if(!isset($_GET['id'])) {
    $message = "Błąd wewnętrzny.";
} else if ($database->has($_GET['id'])) {
    $item = $database->get($_GET['id']);

    if(!isset($_GET['rid'])) {
        $message = "Błąd wewnętrzny.";
        die;
    } else if($item->removalid == $_GET['rid']) {
        $item->delete();
        $message = "Pomyślnie usunięto ogłoszenie.";
    } else {
        $message = "Klucz usunięcia jest nieprawidłowy.";
    }
} else {
    $message = "Ogłoszenie wygasło.";
}

?>

<!DOCTYPE html>

<html>
    <head>
        <title>cOLX - usuwanie ogłoszenia</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="index.css">
    </head>

    <body>
        <div>
            <h1>cOLX</h1>
            <h3><?php echo $message; ?></h3>
        </div>
        <footer>
            <hr>
            <a href="/">Powrót na stronę główną</a>. Copyright &copy; by Kamila Palaiologos Szewczyk, Apr 2019.
        </footer>
    </body>
</html>
