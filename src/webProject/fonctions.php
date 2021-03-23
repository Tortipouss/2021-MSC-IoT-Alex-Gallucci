<?php

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

function getData($uri){
    $arr_final = [];

    $file = file_get_contents($uri);
    $decoded = json_decode($file, true);
    foreach ($decoded as $line){
        array_push($arr_final, $line);
    }
    return $arr_final;
}

function getTodayData($tempHumid){
    $minTemp = 100;
    $maxTemp = 0;
    $minHumid = 100;
    $maxHumid = 0;

    foreach ($tempHumid as $tempH){
        if($minTemp >= $tempH['temp_tempHumid']){
            $minTemp = $tempH['temp_tempHumid'];
        }

        if($maxTemp <= $tempH['temp_tempHumid']){
            $maxTemp = $tempH['temp_tempHumid'];
        }

        if($minHumid >= $tempH['humid_tempHumid']){
            $minHumid = $tempH['humid_tempHumid'];
        }

        if($maxHumid <= $tempH['humid_tempHumid']){
            $maxHumid = $tempH['humid_tempHumid'];
        }
    }

    return [$minTemp, $maxTemp, $minHumid, $maxHumid];

}

function convertHardDateToSoft($date){
    return  substr($date, 6, 2) . '.' . substr($date, 4, 2) . '.' . substr($date, 0, 4);
}

function curl_del($path)
{

    // URL de l'API
    $url = $path;

    // Initialise l'objet de la requête
    $curl_handle = curl_init();

    // Le configure avec l'url
    curl_setopt($curl_handle, CURLOPT_URL, $url);

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

function curl_upd($path, $temp, $humid){

    if(isset($temp) && isset($humid)){
        $data = array("temp" => $temp, "humid" => $humid);
    } else if(isset($temp)){
        $data = array("temp" => $temp);
    } else if(isset($humid)){
        $data = array("humid" => $humid);
    }
    $ch = curl_init($path);
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