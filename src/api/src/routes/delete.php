<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/*
 * Auteur : Alex Gallucci
 * Version : 1.0
 *
 * Gère toute la partie de l'API
 * pour ce qui en est de la suppression
 * de données dans la BD.
 */

$app->delete('/api/humidTemp/{id}', function (Request $request, Response $response){
    $id = $request->getAttribute('id');

    // Requête qui sera executé par la suite
    $sql = "DELETE FROM tb_tempHumid WHERE :id = pk_tempHumid";


    try {
        // Création de l'objet de la BD
        $dbh = conn_db();

        //préparation de la requête sur le serveur
        $stmt = $dbh->prepare($sql);

        // Filtrage des entées afin d'éviter des injections
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

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