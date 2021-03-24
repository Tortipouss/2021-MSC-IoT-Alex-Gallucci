<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/*
 * Auteur : Alex Gallucci
 * Version : 1.2
 *
 * Gère toute la partie de l'API
 * pour ce qui en est de l'insertion dans la BD.
 */

/* Insere un message dans la BD avec la température et l'humidité*/
$app->post('/api/sigFoxMKRFOX1200', function (Request $request, Response $response) {

    // Insère le message dans la BD
    try {

        // ouverture de la session sur le serveur de bd
        $dbh = conn_db();

        $post = (array)$request->getParsedBody();

        $data = [];

        $data['seqNum'] = $post['seqNum'];

        // Conversion en date
        $data['dateMsg'] = date('Ymd', $post['dateMsg']);

        // Req pour insertion des données
        $sql = "INSERT INTO tb_message (dateRecep_msg, seqNum_msg) VALUES (:dateMsg, :seqNum);";

        //préparation de la requête sur le serveur
        $stmt = $dbh->prepare($sql);

        // Filtrage des entées afin d'éviter des injections
        $stmt->bindParam(':seqNum', $data['seqNum'], PDO::PARAM_INT);
        $stmt->bindParam(':dateMsg', $data['dateMsg'], PDO::PARAM_INT);

        //exécution de la requête
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        //exécution de la requête
        $stmt->execute($data);

        //fermeture de la requête préparée
        $stmt = null;

        $data = [];

        $idMess = getIdMessBySeqNum($post['seqNum']);

        // Conversion en date
        $data['temp'] = $post['temp'];
        $data['humid'] = $post['humid'];
        $data['therm'] = $post['therm'];
        $msg = $idMess[0]['pk_msg'];

        var_dump($idMess[0]['pk_msg']);

        $sql = "INSERT INTO tb_tempHumid (temp_tempHumid, humid_tempHumid, fk_pk_therm, fk_pk_mess) VALUES (:temp, :humid, :therm, $msg);";

        //préparation de la requête sur le serveur
        $stmt = $dbh->prepare($sql);

        // Filtrage des entées afin d'éviter des injections
        $stmt->bindParam(':temp', $data['temp'], PDO::PARAM_INT);
        $stmt->bindParam(':humid', $data['humid'], PDO::PARAM_INT);
        $stmt->bindParam(':therm', $data['therm'], PDO::PARAM_INT);

        //exécution de la requête
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        //exécution de la requête
        $stmt->execute($data);

        //fermeture de la requête préparée
        $stmt = null;

        http_response_code(200);
        header('Content-Type: text/html; charset=utf-8');
        echo json_encode($data);

    } catch (PDOException $e) {
        http_response_code(403);
        die($e->getMessage());
    }


//fermeture de la connexion si elle existe
    if ($dbh)
        $dbh = null;
});
