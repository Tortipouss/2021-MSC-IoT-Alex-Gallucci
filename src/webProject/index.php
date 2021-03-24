<?php
require 'fonctions.php';
// Données par defaut
$temperature = ['noData', 'noData', 'noData','noData','noData','noData'];
$humidite = ['noData','noData','noData','noData','noData','noData'];
$salle = ['salle non enregistrée'];
$user = 'Inconnu';
$pasDonneAuj = true;
//var_dump(getData('http://membmat.divtec.me/iot/api/values'));

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
            $tempHumid = getData('https://amsttho.divtec.me/iot/api/locations/B1-01/values/latest');

            $temperature = [];
            $humidite = [];

            foreach ($tempHumid as $tempH){
                array_push($temperature, $tempH['res_temperature']);
                array_push($humidite, $tempH['res_humidity']);
            }
            $user = 'Thomas';
            $salle = ['B1-01'];
            break;
        CASE 'b1-02':
            $user = 'Nils';
            $salle = ['B1-02'];
            break;
        CASE 'b1-04':
            $pasDonneAuj = false;
            $tempHumid = getData('https://gallale.divtec.me/api/today/tempHumid/therm/id/1D3537');

            $temperature = [];
            $humidite = [];

            foreach ($tempHumid as $tempH){
                array_push($temperature, $tempH['temp_tempHumid']);
                array_push($humidite, $tempH['humid_tempHumid']);
            }

            $salle = getDataArg('https://gallale.divtec.me/api/salles/therm/id/1D3537', 'nom_salle');
            $user = 'Alex';
            break;
        CASE 'b1-05':
            $user = 'Teva';
            $salle = ['B1-05'];
            break;
        CASE 'b1-08':

            // RETOURNE TOUTES LES DONNEES
            $tempHumid = getData('http://chapthe.divtec.me/api/now/mesures/1');

            $temperature = [];
            $humidite = [];

            foreach ($tempHumid as $tempH){
                array_push($temperature, $tempH['temp_msre']);
                array_push($humidite, $tempH['humi_msre']);
            }

            $user = 'Théo';
            $salle = ['B1-08'];
            break;
        CASE 'b1-13':
            $tempHumid = getData('https://spinant.divtec.me/iot/api/message/appareil/18E103');

            $temperature = [];
            $humidite = [];

            foreach ($tempHumid as $tempH){
                array_push($temperature, $tempH['MES_TEMPERATURE']);
                array_push($humidite, $tempH['MES_HUMIDITE']);
            }

            $user = 'Anthony';
            $salle = ['B1-13'];
            break;
        CASE 'b1-15':
            // RETOURNE TOUTES LES DONNEES
            $tempHumid = getData('http://membmat.divtec.me/iot/api/values');

            $temperature = [];
            $humidite = [];

            foreach ($tempHumid as $tempH){
                array_push($temperature, $tempH['temperature_message']);
                array_push($humidite, $tempH['humidite_message']);
            }

            $user = 'Matteo';
            $salle = ['B1-15'];

            break;
        CASE 'b1-21':
            $user = 'Simret';
            $salle = ['B1-21'];
            break;
        CASE 'couloir':
            $user = 'Rayan';
            $salle = ['couloir'];
            break;
        CASE 'bocal':
            $user = 'Steven';
            $salle = ['bocal'];
            break;
        CASE 'bureauJuillerat':

            $tempHumid = getData('https://bovalou.divtec.me/capteur/api/sensors/last');

            $temperature = [];
            $humidite = [];

            foreach ($tempHumid as $tempH){
                array_push($temperature, $tempH['temp_res']);
                array_push($humidite, $tempH['humi_res']);
            }

            $user = 'Louis';
            $salle = ['bureau de M. Juillerat'];
            break;
    }

// Change le titre pricipal
$mainTitle = 'Thermomètre de ' . $user . ' en ' . $salle[0];

}

?>

<!--
Auteur : Alex Gallucci
Dernière modification : 23.03.2021

Site web créé à l'occasion de l'atelier Internet Of Things
3ème année du CFC d'informaticien, EMT Porrentruy.
-->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Alex Gallucci">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thermomètre IOT</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Exposition des données du thermomètre séléctionné -->
<h3 id="dernMAJ">Dernière mise à jour : <?php echo date('d-m-y'); ?></h3>
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
            <?php
            if(!$pasDonneAuj){
                echo '<div class="content">
                <p><strong>Aujourd\'hui :</strong></p>
                <p>Temp. min : ' . getTodayData($temperature, $humidite)[0] . '</p>
                <p>Temp. max : ' . getTodayData($temperature, $humidite)[1] . '</p>
                <a href="historique.php">Voir l\'historique</a>
            </div>';
            }else {
                echo '<div class="content">
                <p><strong>Impossible d\'afficher les données spécifique de la journée</strong></p>
                <p>Seul le thermomètre situé en salle B1-04 le peut.</p>
            </div>';
            }
            ?>

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
            <?php
            if(!$pasDonneAuj){
                echo '<div class="content">
                <p><strong>Aujourd\'hui :</strong></p>
                <p>Humid. min : ' . getTodayData($temperature, $humidite)[2] . '</p>
                <p>Humid. max : ' . getTodayData($temperature, $humidite)[3] . '</p>
                <a href="historique.php">Voir l\'historique</a>
            </div>';
            }else{
                echo '<div class="content">
                <p><strong>Impossible d\'afficher les données spécifique de la journée</strong></p>
                <p>Seul le thermomètre situé en salle B1-04 le peut.</p>
            </div>';
            }
            ?>
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
                <?php /* href="?salle=b1-02" */ ?> alt="B102" style="cursor: not-allowed"/>

        <area shape="rect" coords="240, 85, 320, 173"
              href="?salle=b1-04" alt="B104" />

        <area shape="rect" coords="192, 133, 238, 173"
                <?php /* href="?salle=bocal" */?> alt="bocal" style="cursor: not-allowed" />

        <area shape="rect" coords="320, 85, 445, 173"
                <?php /* href="?salle=b1-05" */ ?> alt="B105" style="cursor: not-allowed"/>

        <area shape="rect" coords="448, 85, 535, 173"
              href="?salle=b1-08" alt="B108" />

        <area shape="rect" coords="107, 48, 535, 85"
                <?php /* href="?salle=couloir" */ ?> alt="couloir" style="cursor: not-allowed" />

        <area shape="rect" coords="620, 85, 685, 177"
              alt="B112" style="cursor: not-allowed"/>

        <area shape="rect" coords="685, 85, 770, 177"
              href="?salle=b1-13" alt="B113" />

        <area shape="rect" coords="810, 85, 920, 177"
              href="?salle=b1-15" alt="B115" />

        <area shape="rect" coords="790, 0, 833, 50"
                <?php /* href="?salle=b1-21" */ ?> alt="B121" style="cursor: not-allowed" />

        <area shape="rect" coords="488, 303, 615, 230"
              href="?salle=bureauJuillerat" alt="Bureau de M. Juillerat" />

    </map>

    <!-- Liste déroulante des salles des thermomètres -->
    <form>
        <label for="salle">Séléction listée:</label>
        <select name="salle" id="salle">
            <option value="b1-01">Salle B1-01</option>
            <option disabled="disabled" value="b1-02">Salle B1-02</option>
            <option value="b1-04" selected="selected">Salle B1-04</option>
            <option disabled="disabled" value="b1-05">Salle B1-05</option>
            <option value="b1-08">Salle B1-08</option>
            <option value="b1-13">Salle B1-13</option>
            <option value="b1-15">Salle B1-15</option>
            <option disabled="disabled" value="b1-15">Salle B1-21</option>
            <option disabled="disabled" value="couloir">Couloir</option>
            <option disabled="disabled" value="bocal">Salle bocal</option>
            <option value="bureauJuillerat">Bureau de M. Juillerat</option>
        </select>
        <input type="submit" value="OK">
    </form>
</div>
</body>
</html>