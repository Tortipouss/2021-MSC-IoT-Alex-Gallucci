<?php
function conn_db($base)
{
    $user = '0e364_alex';
    $pass = 'Zy65h9rO_tlp';
    //$base = '0e364_alex';


    $dsn = 'mysql:host=0e364.myd.infomaniak.com;dbname=' . $base . ';charset=UTF8';
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


