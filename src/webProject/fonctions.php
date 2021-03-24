<?php
/*
Auteur : Alex Gallucci
Dernière modification : 23.03.2021

Regroupe les fonctions utilisées par les autres pages
php du site web
*/

/*
 * Extrait des données spécifiques d'un fichier JSON
 * param $url L'URI de l'api
 * param $argument, le nom du groupe de la donnée à éxtraire
 * return les données désirées sous forme d'un arrayList
 */
function getDataArg($uri, $argument)
{
    $arr_final = [];

    $file = file_get_contents($uri);
    $decoded = json_decode($file, true);
    foreach ($decoded as $line){
        array_push($arr_final, $line[$argument]);
    }
    return $arr_final;
}

/*
 * Extrait des données d'un fichier JSON
 * param $uri L'URI de l'api
 * return les données désirées sous forme d'un arrayList
 */
function getData($uri){
    $arr_final = [];

    $file = file_get_contents($uri);
    $decoded = json_decode($file, true);
    foreach ($decoded as $line){
        array_push($arr_final, $line);
    }
    return $arr_final;
}

/*
 * Retourne les données max et min de températures et d'humidité de la journée
 * param $temp l'array list qui contient les données de températures de la journée
 * param $humid l'array list qui contient les données d'humidités de la journée
 */
function getTodayData($temp, $humid){
    $minTemp = 100;
    $maxTemp = 0;
    $minHumid = 100;
    $maxHumid = 0;

    foreach ($temp as $tempH){
        if($minTemp >= $tempH){
            $minTemp = $tempH;
        }

        if($maxTemp <= $tempH){
            $maxTemp = $tempH;
        }
    }

    foreach ($humid as $humidH) {
        if($minHumid >= $humidH){
            $minHumid = $humidH;
        }

        if($maxHumid <= $humidH){
            $maxHumid = $humidH;
        }
    }

    return [$minTemp, $maxTemp, $minHumid, $maxHumid];

}

/*
 * Converti une date du format YYYYMMJJ au format JJ-MM-YYYY
 * param $date la date qui doit être convertie
 * return la date convertie
 */
function convertHardDateToSoft($date){
    return  substr($date, 6, 2) . '.' . substr($date, 4, 2) . '.' . substr($date, 0, 4);
}

/*
 * Effectue une requête DELETE sur l'API donnée
 * param $api l'API sur laquelle la requete sera envoyée
 * return la réponse de la requête
 */
function curl_del($api)
{
    // Initialise l'objet de la requête
    $curl_handle = curl_init();

    // Le configure avec l'url
    curl_setopt($curl_handle, CURLOPT_URL, $api);

    // Configure le header de la requête
    curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    // Configure la méthode en DELETE
    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

    // Execute la requete et stoque la reponse
    $response  = curl_exec($curl_handle);

    // Ferme le curseur
    curl_close($curl_handle);

    return $response;
}

/*
 * Effectue une requête PUT sur l'api donnée
 * param $api l'API sur laquelle la requête sera efféctuée
 * param $temp la température sur laquelle effectuer la requête
 * param $humid l'humidité sur laquelle effectuer la requête
 * return la réponse de la requête
 */
function curl_upd($api, $temp, $humid){

    if(isset($temp) && isset($humid)){
        $data = array("temp" => $temp, "humid" => $humid);
    } else if(isset($temp)){
        $data = array("temp" => $temp);
    } else if(isset($humid)){
        $data = array("humid" => $humid);
    }
    $ch = curl_init($api);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    $response = curl_exec($ch);

    if (!$response)
    {
        return false;
    }

    return $response;
}