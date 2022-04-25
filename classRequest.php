<?php

class Request
{

  public function getRequest($url, $file_to_create, $query) {
    // Hacemos la peticion
    $data = file_get_contents($url);
    // Filtramos los datos
    $filtered = $this->filter($data, $query);
    // Convertimos la respuesta a json
    $json = json_encode($filtered);
    // Convertimos el json a string para colorcar el resultado en el archivo e imprimirlo
    $file_data = json_encode($json, true);
    // Creamos el archivo y escribimos la respuesta en el
    if(file_exists($file_to_create)) {
      unlink($file_to_create);
    }

    // Creamos el archivo con los datos
    file_put_contents("data.json", json_decode($file_data, true));

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

  public function filter($data, $query) {
    /**
    * En esta funcion se intenta hacer un poco dinamico, se recibe por parametro un array de clave valor para decididir dinamicamente
    * con cual propiedad filtramos
    **/
    $key = $query['key'];
    $val = $query['val'];
    $json = json_decode($data, true);
    $shoes = array();
    $shoes_filtered = array_filter($json, function ($var) use ($key, $val) {
        return ($var[$key] == $val);
    });
    // Aqui solamente "eliminamos" por asi decirlo el array generado por array_filter
    foreach ($shoes_filtered as $shoe) {
      $shoes[] = $shoe;
    }
    return $shoes;
  }

}
