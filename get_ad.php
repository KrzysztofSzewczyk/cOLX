
<?php

require 'vendor/autoload.php';

$database = new \Filebase\Database([
    'dir' => 'db/'
]);

$e = null;

if(!isset($_GET['id'])) {
    $e = "Nieprawidłowa kwerenda.";
    goto err;
}

$item = null;

if ($database->has($_GET['id'])) {
    $item = $database->get($_GET['id']);

    // echo $item->imageurl;
    // echo $item->adname;
    // echo $item->description;
    // echo $item->phoneno;
    // echo $item->localization;
    // echo $item->removalid;
} else {
    $e = "Ogłoszenie wygasło.";
    goto err;
}

err:

?>

<!DOCTYPE html>

<html>
    <head>
        <title>cOLX - <?php if($item != null) echo $item->adname; else echo "błąd"; ?></title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="index.css">
        <link rel="stylesheet" href="ad.css">
    </head>

    <body>
        <div>
            <h1>cOLX</h1>
            <?php if($e != null): ?>
                <h3> <?php echo $e; ?> </h3>
            <?php endif; ?>
        </div>
        <?php if($e == null): ?>
            <div>
                <h4 style="padding-bottom: 20px;"><?= "Ogłoszenie #" . $_GET['id'] ?></h4>
                <table class="sml">
                    <tr style="height: 75%;" style="border: 1px solid black;">
                        <td rowspan="32" style="border: 1px solid black; max-height: 128px;">
                            <img src="<?= $item->imageurl ?>" width="128" height="128" style="display: block; vertical-align: top;">
                        </td>
                        <td style="border: 1px solid black;" colspan="2">
                            <h2><?= $item->adname ?></h2>
                        </td>
                    </tr>
                    <tr style="border: 1px solid black;">
                        <td style="border: 1px solid black;">
                            <h3><?= $item->localization ?></h3>
                        </td>
                        <td style="border: 1px solid black;">
                            <h3><?= $item->phoneno ?></h3>
                        </td>
                    </tr>
                    <tr style="border: 1px solid black;">
                        <td colspan="3" style="width:100%; border: 1px solid black;">
                            <?= $item->description ?>
                        </td>
                    </tr>
                </table>
            </div>
        <?php endif; ?>
        <footer>
            <hr>
            <a href="/">Powrót na stronę główną</a>. Copyright &copy; by Kamila Palaiologos Szewczyk, Apr 2019.
        </footer>
    </body>
</html>

