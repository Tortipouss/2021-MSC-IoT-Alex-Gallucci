<?php

function getIdMessBySeqNum($seqMess){

    // Requête qui sera executé par la suite
    $sql = "SELECT pk_msg FROM tb_message WHERE seqNum_msg LIKE :seqMess";


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

    } catch (PDOException $e) {
        echo $e->getMessage();
        die();
    }
}