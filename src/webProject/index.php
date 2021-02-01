<?php
require 'conn.inc.php';

function getAll(){

    // récupération de tous les enregistrements
    try{
        // insertion des données dans la base de données
        $dbh = conn_db('0e364_alex');

        // modèle de requête
        $sql = " SELECT * FROM tb_tempAndHumid;";

        //préparation de la requête sur le serveur
        $stmt = $dbh->prepare($sql);


        //exécution de la requête
        $stmt->execute();

    }
    catch(PDOException $e){
        echo $e->getMessage();
        die();
    }


    // retourne un tableau d'enregistrement ou le $stmt
    return $stmt;

}

$result = getAll();
$temperature = [];
$humidite = [];
foreach ($result as $row){
       array_push($temperature, $row['temp']);
       array_push($humidite, $row['humid']);
}
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
                        <?php for($i=1; $i < 5 && $i < count($temperature);$i++){
                            echo '<p>' . $temperature[$i] . '</p>';
                        } ?>
                        <a href="#">Voir plus</a>
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
                    <?php for($i=1; $i < 5 && $i < count($humidite);$i++){
                        echo '<p>' . $humidite[$i] . '</p>';
                    } ?>
                    <a href="#">Voir plus</a>
                </div>
            </div>
        </div>

    </div>
</body>
</html>