<?php
require 'fonctions.php';
$columnID = 0;

if(isset($_GET['del'])){
    curl_del('https://gallalle.divtec.me/api/humidTemp/' . $_GET['del']);
}else if (isset($_GET['upd'])){
    curl_upd('https://gallale.divtec.me/api/therm/humidTemp/' . $_GET['upd'], $_GET['temp' . $_GET['upd']], $_GET['humid' . $_GET['upd']]);
}

$tempHumid = getData('https://gallale.divtec.me/api/tempHumid/therm/id/1D3537');
?>

<!--
Auteur : Alex Gallucci
Dernière modification : 23.03.2021

Liste l'historique des données d'un thermomètre

Site web créé à l'occasion de l'atelier Internet Of Things
3ème année du CFC d'informaticien, EMT Porrentruy.
-->
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Historique</title>
    <meta name="author" content="Alex Gallucci">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">

    <!-- Affiche et cache les colonnes -->
    <script>
        function hideColumn(colonne){
            document.getElementById('col' + colonne).style.display = 'none';
        }

        function unHideColumn(colonne){
            document.getElementById('col' + colonne).style.display = 'block';
        }
    </script>
</head>
<body>
<h1 style="margin: 30px 0 30px 50px; width: 1000px; color: white">Historique des relevés de températures et d'humidité
    pour le thérmomètre d'Alex en B1-04</h1>
<div id="divHistorique">
    <table>
        <tr>
            <th>Date</th>
            <th>Humidité</th>
            <th>Température</th>
            <th>Supprimer</th>
            <th>Modifier</th>
        </tr>
        <?php
        foreach ($tempHumid as $singleTempHumid){
            $columnID = $singleTempHumid['pk_tempHumid'];
            echo
            '<tr>
                <td>' . convertHardDateToSoft($singleTempHumid['dateRecep_msg']) . '</td>
                <td> ' . $singleTempHumid['humid_tempHumid'] . '</td>
                <td> ' . $singleTempHumid['temp_tempHumid'] . '</td>
                <td><a href="?del=' . $columnID . '"><img src="img/suppr.png" width="40px" /></a></td>
                <td><img src="img/update.png" width="40px" onclick="unHideColumn(' . $singleTempHumid['pk_tempHumid'] . ')" /></td>
            </tr>
            <tr id="col' . $columnID . '" style="display: none">
            <form method="get"  action="">
                <td> Nouvelles valeurs </td>
                <td> Humidité : <input name="humid' . $columnID . '" type="text" value="' . $singleTempHumid['humid_tempHumid'] . '"></td>
                <td> Température : <input name="temp' . $columnID . '" type="text" value="' . $singleTempHumid['temp_tempHumid'] . '"></td>
                <td><button type="submit" name="Envoyer">Valider</button></td>
                <td><img src="img/hide.png" width="40px" style="margin: 0 20px 0 20px" onclick="hideColumn(' . $columnID . ')"></td>
                <input name="upd" type="hidden" value="' . $columnID . '">
            </form>
            </tr>';
        }
        ?>
    </table>
</div>
</body>
</html>