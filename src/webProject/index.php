<?php

function getData($url, $argument)
{
    $arr_final = [];

    $file = file_get_contents($url);
    $decoded = json_decode($file, true);
    foreach ($decoded as $line){
        array_push($arr_final, $line[$argument]);
    }
    return $arr_final;
}


$temperature = [12,32,34,53,12];
$humidite = [12,32,14,35,23];
$salle = ['B1-04'];

/*
$temperature = getData('https://gallale.divtec.me/api/temperatures', 'temp_tempHumid');
$humidite = getData('https://gallale.divtec.me/api/humidites', 'humid_tempHumid');
$salle = getData('https://gallale.divtec.me/api/salles/therm/id/1D3537', 'nom_salle');
*/

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Card Hover Effects</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2 style="width: 700px;text-align: center;font-size: 2em;color: #cccccc">Thermomètre d'Alex en <?php echo $salle[0] ?></h2>
    <div class="card">
        <div class="face face1">
            <div class="content">
                <div class="imgValue">
                    <img class="img1" src="img/thermometre.png">
                    <p class="value"><?php echo(end($temperature) . ' °C') ?></p>
                </div>
                <h3>Température</h3>
            </div>
        </div>
        <div class="face face2">
            <div class="content">
                <p><strong>Historique</strong></p>
                <br>
                <?php for ($i = sizeof($temperature) - 2; $i > sizeof($temperature) - 6; $i--) {
                    echo '<p>' . $temperature[$i] . '</p>';
                } ?>
                <a href="#">Voir + / modifier</a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="face face1">
            <div class="content">
                <div class="imgValue">
                    <img class="img2" src="img/humidite.png">
                    <p class="value"><?php echo(end($humidite) . ' %') ?></p>
                </div>
                <h3>Humidité</h3>
            </div>
        </div>
        <div class="face face2">
            <div class="content">
                <p><strong>Historique</strong></p>
                <br>
                <?php for ($i = sizeof($humidite) - 2; $i > sizeof($humidite) - 6; $i--) {
                    echo '<p>' . $humidite[$i] . '</p>';
                } ?>
                <a href="#">Voir + / modifier</a>
            </div>
        </div>
    </div>
</div>
<div class="map">
    <h1 style="text-align: center">Carte des thermomètres</h1>
    <form>
        <label for="salle">Choisir une salle:</label>
        <select name="salle" id="salle">
            <option value="b1-01">B1-01</option>
            <option value="b1-03">B1-03</option>
            <option value="b1-04" selected="selected">B1-04</option>
            <option value="b1-05">B1-05</option>
            <option value="b1-08">B1-08</option>
            <option value="b1-13">B1-13</option>
            <option value="b1-15">B1-15</option>
            <option value="b1-21">B1-21</option>
            <option value="couloir">Couloir</option>
            <option value="bocal">Bocal</option>
        </select>
        <input type="submit" value="OK">
    </form>
</div>
</body>
</html>