<?php

/**
 *
 */
class Request
{

  public function getRequest($url, $file_to_create) {
    // Hacemos la peticion
    $data = file_get_contents($url);
    // Convertimos la respuesta a json
    $json = json_encode($data, true);
    // Convertimos el json a string para colorcar el resultado en el archivo e imprimirlo
    $file_data = json_decode($json, true);
    // Creamos el archivo y escribimos la respuesta en el
    if(file_exists($file_to_create)) {
      unlink($file_to_create);
    }

    file_put_contents("data.json", $file_data);

    // Seteamos los headers para la descarga del archivo
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename='.basename($file_to_create));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_to_create));
    header('Content-Type: application/json');
    // Hacemos trigger del administrador de archivos del sistema
    readfile($file_to_create);
  }

}
