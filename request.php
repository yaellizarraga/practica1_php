<?php
include "classRequest.php";

$req = new Request;
$url = "https://my-json-server.typicode.com/dp-danielortiz/dptest_jsonplaceholder/items";
$file_name = "data.json";
$req->getRequest($url, $file_name, ['key' => 'color', 'val' => 'green']);
