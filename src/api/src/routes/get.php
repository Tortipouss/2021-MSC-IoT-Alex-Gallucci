<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


/* Retourne TOUTES les valeurs d'humidités dans la BD */

// Evenements se déclanchants lors de l'appel de l'uri suivante : index.php/api/humidites
$app->get('/api/humidites', function (Request $request, Response $response) {

    // Requête qui sera executé par la suite
    $sql = "SELECT humid_tempHumid FROM tb_tempHumid";

    try {
        // insertion des données dans la base de données
        $dbh = conn_db();

        //préparation de la requête sur le serveur
        $stmt = $dbh->prepare($sql);

        // exécution de la requête
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

    } catch (PDOException $e) {
        echo $e->getMessage();
        die();
    }


    // retourne un tableau des données au format JSON
    echo json_encode($stmt->fetchAll());
});


/* Retourne les valeurs d'humidités d'un thermometre précis dans la BD */
$app->get('/api/humidites/therm/id/{therID}', function (Request $request, Response $response) {

    $idTherm = $request->getAttribute('therID');

    // Requête qui sera executé par la suite
    $sql = "SELECT humid_tempHumid FROM tb_tempHumid, tb_thermometre WHERE tb_thermometre.pk_therm LIKE :idTherm";


    try {
        // insertion des données dans la base de données
        $dbh = conn_db();

        //préparation de la requête sur le serveur
        $stmt = $dbh->prepare($sql);

        // Filtrage des entées afin d'éviter des injections
        $stmt->bindParam(':idTherm', $idTherm, PDO::PARAM_STR);

        //exécution de la requête
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

    } catch (PDOException $e) {
        echo $e->getMessage();
        die();
    }


    // Affiche les données trouvées
    echo json_encode($stmt->fetchAll());
});