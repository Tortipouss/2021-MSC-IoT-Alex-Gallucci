<?php
/*
 * Se connecte à la base de donnée
*/
function conn_db()
{
    $user = '0e364_alex';
    $pass = 'Zy65h9rO_tlp';
    $base = '0e364_alex';
    $host = 'host=0e364.myd.infomaniak.com';


    $dsn = 'mysql:' . $host . ';dbname=' . $base . ';charset=UTF8';
    try {
        $dbh = new PDO($dsn, $user, $pass);

        /*** les erreurs sont gérées par des exceptions ***/
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbh;
    } catch (PDOException $e) {
        print "erreur ! :" . $e->getMessage() . "<br/>";
        die();
    }
}


