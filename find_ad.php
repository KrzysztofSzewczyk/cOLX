
<?php

require 'vendor/autoload.php';

$database = new \Filebase\Database([
    'dir' => 'db/'
]);

$e = null;

if(!isset($_GET['name']) && !isset($_GET['location'])) {
    $e = "Nieprawidłowe żądanie. Wypełnij conajmniej jedno pole w formie wyszukiwania.";
    goto end;
}

$results = null;
$amount = 10;
$offset = 0;

if(isset($_GET['amount']) && isset($_GET['offset'])) {
    $amount = $_GET['amount'];
    $offset = $_GET['offset'];
}

if(isset($_GET['location']) && !isset($_GET['name']))
    $results = $database->where('localization','=',$_GET['location'])->limit($amount, $offset)->results();
else if(!isset($_GET['location']) && isset($_GET['name']))
    $results = $database->where('adname','=',$_GET['name'])->limit($amount, $offset)->results();
else if(isset($_GET['location']) && isset($_GET['name']))
    $results = $database->where('adname','=',$_GET['name'])->andWhere('localization','=',$_GET['location'])->limit($amount, $offset)->results();

end:

?>

<!DOCTYPE html>

<html>
    <head>
        <title>cOLX - przeglądrka ogłoszeń</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="index.css">
        <link rel="stylesheet" href="ad.css">
    </head>

    <body>
        <div>
            <h1>cOLX</h1>
            <?php if($e != null || empty($results)): ?>
                <h3> <?php if($e != null) echo $e; else echo "Brak wyników dla " . htmlspecialchars($_GET['name']); ?> </h3>
            <?php else: ?>
                <div class="bottomPadded info">
                    Wyniki wyszukiwania
                    <strong>
                        <?php
                            if(isset($_GET['name']) && !isset($_GET['location']) && $_GET['name'] != "")
                                echo " dla " . strip_tags($_GET['name']);
                            else if(!isset($_GET['name']) && isset($_GET['location']) && $_GET['location'] != "")
                                echo " w " . strip_tags($_GET['location']);
                            else if(isset($_GET['name']) && isset($_GET['location']) && $_GET['name'] != "" && $_GET['location'] != "")
                                echo " dla " . strip_tags($_GET['name']) . " w " . strip_tags($_GET['location']);
                        ?>
                    </strong>
                </div>
            <?php endif; ?>
        </div>
        <?php if($e == null): ?>
            <div>
                <table>
                    <?php
                        foreach($results as &$res)
echo '<tr><td><table class="sml"><tr style="height: 75%;" style="border: 1px solid black;"><td rowspan="32" style="border: 1px solid black; max-height: 128px;"><img src="' . $res['imageurl'] .
'" width="128" height="128" style="display: block; vertical-align: top;"></td><td style="border: 1px solid black;" colspan="2"><h2>' . $res['adname'] .
'</h2></td></tr><tr style="border: 1px solid black;"> <td style="border: 1px solid black;"><h3>' . $res['localization'] .
'</h3></td><td style="border: 1px solid black;"><h3>' . $res['phoneno'] .
'</h3></td></tr><tr style="border: 1px solid black;"><td colspan="3" style="width:100%; border: 1px solid black;">' . $res['description'] .
'</td></tr></table></td></tr>';
                    ?>
                </table>
            </div>
        <?php endif; ?>
        <footer>
            <hr>
            <a href="/">Powrót na stronę główną</a>. Copyright &copy; by Kamila Palaiologos Szewczyk, Apr 2019.
        </footer>
    </body>
</html>
