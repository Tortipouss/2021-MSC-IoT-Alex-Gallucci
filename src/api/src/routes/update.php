<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/*
 * Auteur : Alex Gallucci
 * Version : 1.0
 *
 * Gère toute la partie de l'API
 * pour ce qui en est de la mis à jour
 * des données sur la BD.
 */

$app->put('/api/therm/humid/{id}', function (Request $request, Response $response){

    $id = $request->getAttribute('id');

    try {

        // ouverture de la session sur le serveur de bd
        $dbh = conn_db();

        $post = (array)$request->getParsedBody();

        $data = [];

        // Conversion en date
        $data['temp'] = $post['temp'];
        $data['humid'] = $post['humid'];

        // Req pour insertion des données
        $sql = "UPDATE tb_tempHumid SET temp_tempHumid = :temp, humid_tempHumid = :humid WHERE $id = pk_tempHumid";

        //préparation de la requête sur le serveur
        $stmt = $dbh->prepare($sql);

        // Filtrage des entées afin d'éviter des injections
        $stmt->bindParam(':temp', $data['temp'], PDO::PARAM_INT);
        $stmt->bindParam(':humid', $data['humid'], PDO::PARAM_INT);

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