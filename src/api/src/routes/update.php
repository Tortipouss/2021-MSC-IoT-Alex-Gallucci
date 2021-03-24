<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/*
 * Auteur : Alex Gallucci
 * Version : 1.5
 *
 * Gère toute la partie de l'API
 * pour ce qui en est de la mis à jour
 * des données sur la BD.
 */

/* Met à jout la température et l'humidité */
$app->put('/api/therm/humidTemp/{id}', function (Request $request, Response $response){

    $id = $request->getAttribute('id');

    try {

        // ouverture de la session sur le serveur de bd
        $dbh = conn_db();

        $post = (array)$request->getParsedBody();

        $data = [];

        // Req pour insertion des données
        if(isset($post['temp']) || isset($post['humid'])){

            if(isset($post['temp']) && isset($post['humid'])){
                $sql = "UPDATE tb_tempHumid SET temp_tempHumid = :temp, humid_tempHumid = :humid WHERE $id = pk_tempHumid";
            }

            else if(isset($post['temp'])){
                $sql = "UPDATE tb_tempHumid SET temp_tempHumid = :temp WHERE $id = pk_tempHumid";
            }

            else if(isset($post['humid'])){
                $sql = "UPDATE tb_tempHumid SET humid_tempHumid = :humid WHERE $id = pk_tempHumid";
            }
        }

        // Conversion en date
        $data['temp'] = $post['temp'];
        $data['humid'] = $post['humid'];

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