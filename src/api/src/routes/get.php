<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/*
 * Auteur : Alex Gallucci
 * Version : 1.1
 *
 * Gère toute la partie de l'API
 * pour ce qui en est de la selection
 * des données depuis la BD
 */

/* --------- HUMIDITÉ ------------- */
/* Retourne TOUTES les valeurs d'humidités dans la BD */
$app->get('/api/humidites', function (Request $request, Response $response) {

    // Requête qui sera executé par la suite
    $sql = "SELECT humid_tempHumid FROM tb_tempHumid";

    try {
        // Création de l'objet de la BD
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
    return json_encode($stmt->fetchAll());
});

/* Retourne les valeurs d'humidités en fonction de l'id du thermometre */
$app->get('/api/humidites/therm/id/{therID}', function (Request $request, Response $response) {

    $idTherm = $request->getAttribute('therID');

    // Requête qui sera executé par la suite
    $sql = "SELECT humid_tempHumid FROM tb_tempHumid, tb_thermometre WHERE tb_thermometre.pk_therm LIKE :idTherm";


    try {
        // Création de l'objet de la BD
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

/* Retourne les valeurs d'humidités en fonction du PAC d'un thermomètre */
$app->get('/api/humidites/therm/pac/{therPAC}', function (Request $request, Response $respsone) {

    $pacTherm = $request->getAttribute('therPAC');

    // Requête qui sera executé par la suite
    $sql = "SELECT humid_tempHumid FROM tb_tempHumid, tb_thermometre WHERE tb_thermometre.pac_therm LIKE :pacTherm";


    try {
        // Création de l'objet de la BD
        $dbh = conn_db();

        //préparation de la requête sur le serveur
        $stmt = $dbh->prepare($sql);

        // Filtrage des entées afin d'éviter des injections
        $stmt->bindParam(':pacTherm', $pacTherm, PDO::PARAM_STR);

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

/* Retourne les valeurs d'humidités en fonction du nom du thermometre */
$app->get('/api/humidites/therm/nom/{therNom}', function (Request $request, Response $response) {

    $nomTherm = $request->getAttribute('therNom');

    // Requête qui sera executé par la suite
    $sql = "SELECT humid_tempHumid FROM tb_tempHumid, tb_thermometre WHERE tb_thermometre.nom_therm LIKE :nomTherm";

    try {
        // Création de l'objet de la BD
        $dbh = conn_db();

        //préparation de la requête sur le serveur
        $stmt = $dbh->prepare($sql);

        // Filtrage des entées afin d'éviter des injections
        $stmt->bindParam(':nomTherm', $nomTherm, PDO::PARAM_STR);

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


/* --------- TEMPERATURE ------------- */
/* Retourne TOUTES les valeurs de températures dans la BD */
$app->get('/api/temperatures', function (Request $request, Response $response) {

    // Requête qui sera executé par la suite
    $sql = "SELECT temp_tempHumid FROM tb_tempHumid";

    try {
        // Création de l'objet de la BD
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

/* Retourne les valeurs de températures en fonction de l'id du thermometre */
$app->get('/api/temperatures/therm/id/{therID}', function (Request $request, Response $response) {

    $idTherm = $request->getAttribute('therID');

    // Requête qui sera executé par la suite
    $sql = "SELECT temp_tempHumid FROM tb_tempHumid, tb_thermometre WHERE tb_thermometre.pk_therm LIKE :idTherm";


    try {
        // Création de l'objet de la BD
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

/* Retourne les valeurs de températures en fonction du nom du thermometre */
$app->get('/api/temperatures/therm/nom/{therNom}', function (Request $request, Response $response) {

    $nomTherm = $request->getAttribute('therNom');

    // Requête qui sera executé par la suite
    $sql = "SELECT temp_tempHumid FROM tb_tempHumid, tb_thermometre WHERE tb_thermometre.nom_therm LIKE :nomTherm";


    try {
        // Création de l'objet de la BD
        $dbh = conn_db();

        //préparation de la requête sur le serveur
        $stmt = $dbh->prepare($sql);

        // Filtrage des entées afin d'éviter des injections
        $stmt->bindParam(':nomTherm', $nomTherm, PDO::PARAM_STR);

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

/* Retourne les valeurs de températures d'un thermometre précis dans la BD */
$app->get('/api/temperatures/therm/pac/{therPAC}', function (Request $request, Response $response) {

    $pacTherm = $request->getAttribute('therPAC');

    // Requête qui sera executé par la suite
    $sql = "SELECT temp_tempHumid FROM tb_tempHumid, tb_thermometre WHERE tb_thermometre.pac_therm LIKE :pacTherm";


    try {
        // Création de l'objet de la BD
        $dbh = conn_db();

        //préparation de la requête sur le serveur
        $stmt = $dbh->prepare($sql);

        // Filtrage des entées afin d'éviter des injections
        $stmt->bindParam(':pacTherm', $pacTherm, PDO::PARAM_STR);

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

/* Salle */
/* Retourne les valeurs de températures en fonction de l'id du thermometre */
$app->get('/api/salles/therm/id/{therID}', function (Request $request, Response $response) {

    $salle = $request->getAttribute('therID');

    // Requête qui sera executé par la suite
    $sql = "SELECT nom_salle FROM tb_salle, tb_thermometre WHERE tb_thermometre.fk_pk_salle = :salle";


    try {
        // Création de l'objet de la BD
        $dbh = conn_db();

        //préparation de la requête sur le serveur
        $stmt = $dbh->prepare($sql);

        // Filtrage des entées afin d'éviter des injections
        $stmt->bindParam(':salle', $salle, PDO::PARAM_STR);

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

