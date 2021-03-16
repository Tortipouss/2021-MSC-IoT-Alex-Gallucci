<?php

/*
 * Extrait des données spécifiques d'un fichier JSON
 * param $url L'URI de l'api
 * param $argument, le nom du groupe de la donnée à éxtraire
 * return les données désirées sous forme d'un arrayList
 */
function getData($uri, $argument)
{
    $arr_final = [];

    $file = file_get_contents($uri);
    $decoded = json_decode($file, true);
    foreach ($decoded as $line){
        array_push($arr_final, $line[$argument]);
    }
    return $arr_final;
}

// Données par defaut
$temperature = ['noData', 'noData', 'noData','noData','noData','noData'];
$humidite = ['noData','noData','noData','noData','noData','noData'];
$salle = ['salle non enregistrée'];
$user = 'Inconnu';

// Si aucune salle n'est déjà selectionnée
if (!isset($_GET['salle'])) {

    // Change le contenu du titre pricipale
    $mainTitle = 'Veuillez séléctionner une salle sur le plan';

    ?>
    <!-- Cache les cartes indicatrices de température et d'humidité -->
    <style>
        .card {
            display: none !important;
        }
    </style>

<?php
} else { // Affiche les données des autres thermomètres selon la salle
    switch ($_GET['salle']){
        CASE 'b1-01':
            $user = 'Thomas';
            break;
        CASE 'b1-02':
            $user = 'Nils';
            break;
        CASE 'b1-04':
            $temperature = getData('https://gallale.divtec.me/api/temperatures/therm/id/1D3537', 'temp_tempHumid');
            $humidite = getData('https://gallale.divtec.me/api/humidites/therm/id/1D3537', 'humid_tempHumid');
            $salle = getData('https://gallale.divtec.me/api/salles/therm/id/1D3537', 'nom_salle');
            $user = 'Alex';
            break;
        CASE 'b1-05':
            $user = 'Teva';
            break;
        CASE 'b1-08':
            $user = 'Théo';
            break;
        CASE 'b1-13':
            $user = 'Anthony';
            break;
        CASE 'b1-15':
            $user = 'Matteo';
            break;
        CASE 'b1-21':
            $user = 'Simret';
            break;
        CASE 'couloir':
            $user = 'Rayan';
            break;
        CASE 'bocal':
            $user = 'Steven';
            break;
        CASE 'bureauJuillerat':
            $user = 'Louis';
            break;
    }

// Change le titre pricipal
$mainTitle = 'Thermomètre de ' . $user . ' en ' . $salle[0];

}

?>

<!--
Auteur : Alex Gallucci
Dernière modification : 16.03.2021

Site web créé à l'occasion de l'atelier Internet Of Things
3ème année du CFC d'informaticien, EMT Porrentruy.
-->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thermomètre IOT</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Exposition des données du thermomètre séléctionné -->
<div class="container">
    <h2 id="mainTitle"><?php echo $mainTitle?></h2>
    <div class="card">
        <div class="face face1">
            <div class="content">
                <div class="imgValue">

                    <!-- Icon du thermomètre -->
                    <img alt="thermomètre" class="img1" src="img/thermometre.png">

                    <!-- Affiche en grand dans une carte la dernière température reçue -->
                    <p class="value"><?php echo(end($temperature) . ' °C') ?></p>
                </div>
                <h3>Température</h3>
            </div>
        </div>
        <div class="face face2">
            <div class="content">
                <p><strong>Historique</strong></p>
                <br>

                <!-- Affiche un petit historique des 6 dernières températures -->
                <?php for ($i = sizeof($temperature) - 2; $i > sizeof($temperature) - 6 ; $i--) {
                    echo '<p>' . $temperature[$i] . ' °C' . '</p>';
                } ?>
                <a href="#">Voir + / modifier</a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="face face1">
            <div class="content">
                <div class="imgValue">
                    <img alt="goutte d'eau humidité" class="img2" src="img/humidite.png">

                    <!-- Affiche en grand la dernière humidité reçue -->
                    <p class="value"><?php echo(end($humidite) . ' %') ?></p>
                </div>
                <h3>Humidité</h3>
            </div>
        </div>
        <div class="face face2">
            <div class="content">
                <p><strong>Historique</strong></p>
                <br>

                <!-- Affiche un petit historique des 6 dernières températures -->
                <?php for ($i = sizeof($humidite) - 2; $i > sizeof($humidite) - 6; $i--) {
                    echo '<p>' . $humidite[$i] . ' %' . '</p>';
                } ?>
                <a href="#">Voir + / modifier</a>
            </div>
        </div>
    </div>
</div>

<!-- Carte des salles -->
<div class="map">
    <h1 style="text-align: center">Carte des thermomètres</h1>
    <p style="padding-left: 20px">Cliquer sur une salle :</p>
    <img
            src="img/salles.png"
            width="900px"
            alt="Plan des salles"
            style="padding-left: 20px;margin-bottom: 2em;"
            usemap="#salles"
    />

    <!-- Mapping de l'image afin de la rendre caliquable à des endroits précis -->
    <map name="salles">

        <!-- Format des coordonnées ; position gauche, bas, droit, haut -->
        <area shape="rect" coords="20, 30, 110, 173"
              href="?salle=b1-01" alt="B101" />

        <area shape="rect" coords="107, 85, 194, 173"
              href="?salle=b1-02" alt="B102" />

        <area shape="rect" coords="240, 85, 320, 173"
              href="?salle=b1-04" alt="B104" />

        <area shape="rect" coords="192, 133, 238, 173"
              href="?salle=bocal" alt="bocal" />

        <area shape="rect" coords="320, 85, 445, 173"
              href="?salle=b1-05" alt="B105" />

        <area shape="rect" coords="448, 85, 535, 173"
              href="?salle=b1-08" alt="B108" />

        <area shape="rect" coords="107, 48, 535, 85"
              href="?salle=couloir" alt="couloir" />

        <area shape="rect" coords="620, 85, 685, 177"
              href="" alt="B112" />

        <area shape="rect" coords="685, 85, 770, 177"
              href="?salle=b1-13" alt="B113" />

        <area shape="rect" coords="810, 85, 920, 177"
              href="?salle=b1-15" alt="B115" />

        <area shape="rect" coords="790, 0, 833, 50"
              href="?salle=b1-21" alt="B121" />

        <area shape="rect" coords="488, 303, 615, 230"
              href="?salle=bureauJuillerat" alt="Bureau de M. Juillerat" />

    </map>

    <!-- Liste déroulante des salles des thermomètres -->
    <form>
        <label for="salle">Séléction listée:</label>
        <select name="salle" id="salle">
            <option value="b1-01">Salle B1-01</option>
            <option value="b1-02">Salle B1-02</option>
            <option value="b1-04" selected="selected">Salle B1-04</option>
            <option value="b1-05">Salle B1-05</option>
            <option value="b1-08">Salle B1-08</option>
            <option value="b1-13">Salle B1-13</option>
            <option value="b1-15">Salle B1-15</option>
            <option value="b1-15">Salle B1-21</option>
            <option value="couloir">Couloir</option>
            <option value="bocal">Salle bocal</option>
            <option value="bureauJuillerat">Bureau de M. Juillerat</option>
        </select>
        <input type="submit" value="OK">
    </form>
</div>
</body>
</html>