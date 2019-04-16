
<?php

require 'vendor/autoload.php';

$database = new \Filebase\Database([
    'dir' => 'db/'
]);

$creationForm = false;

if(!isset($_POST['name']) && 
   !isset($_POST['desc']) &&
   !isset($_POST['phone']) &&
   !isset($_POST['imageurl']) &&
   !isset($_POST['localization'])) {
    $creationForm = true;
    goto end;
}

$id = bin2hex(random_bytes(10));
$item = $database->get($id);

$item->imageurl = $_POST['imageurl'];
$item->adname = $_POST['name'];
$item->description = $_POST['desc'];
$item->phoneno = $_POST['phone'];
$item->localization = $_POST['localization'];
$item->removalid = bin2hex(random_bytes(10));
$item->id = $id;

// echo "ID: " . $id;
// echo "RID: " . $item->removalid;

$item->save();

end:

?>

<!DOCTYPE html>

<html>
    <head>
        <title>cOLX - nowe ogłoszenie</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="index.css">
    </head>

    <body>
        <div>
            <h1>cOLX</h1>
            <?php if($creationForm == false): ?>
                <h4> ID ogłoszenia: <?php echo $id; ?> </h4>
                <h4> <a href="<?= "/del_ad.php?rid=" . $item->removalid . "&id=" . $id ?>">Link usunięcia</a> </h4>
            <?php endif; ?>
        </div>
        <?php if($creationForm == true): ?>
            <div>
                <table>
                    <tr>
                        <td>
                            <h4>Lokalizacja</h4>
                        </td>
                        <td>
                            <input type="text" name="localization" form="post">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h4>Tytuł</h4>
                        </td>
                        <td>
                            <input type="text" name="name" form="post">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h4>Treść</h4>
                        </td>
                        <td>
                            <input type="text" name="desc" form="post">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h4>Kontakt (nr. tel)</h4>
                        </td>
                        <td>
                            <input type="text" name="phone" form="post">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h4>URL zdjęcia (opcjonalne)</h4>
                        </td>
                        <td>
                            <input type="text" name="imageurl" form="post">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <form action="/new_ad.php" id="post" method="POST">
                                <input type="submit" value="Zamieść">
                            </form>
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
