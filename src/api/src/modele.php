<?php

/*
 * Retourn l'id du message dans la BD en
 * fournissant le numéro de séquence de celui-ci
 */
function getIdMessBySeqNum($seqMess){

    // Requête qui sera executée par la suite
    $sql = "SELECT pk_msg FROM tb_message WHERE seqNum_msg = :seqMess";

    try {
        // Création de l'objet de la BD
        $dbh = conn_db();

        //préparation de la requête sur le serveur
        $stmt = $dbh->prepare($sql);

        // Filtrage des entées afin d'éviter des injections
        $stmt->bindParam(':seqMess', $seqMess, PDO::PARAM_STR);

        //exécution de la requête
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        return $stmt->fetchAll();

    } catch (PDOException $e) {
        echo $e->getMessage();
        die();
    }
}