<?php
require 'vendor/autoload.php';
$client = new \GuzzleHttp\Client();
$response = $client->request('GET', 'https://api.github.com/repos/guzzle/guzzle');

echo $response->getStatusCode(); // 200
echo $response->getHeaderLine('content-type'); // 'application/json; charset=utf8'
echo $response->getBody(); // '{"id": 1420053, "name": "guzzle", ...}'

// Send an asynchronous request.
$request = new \GuzzleHttp\Psr7\Request('GET', 'http://httpbin.org');
$promise = $client->sendAsync($request)->then(function ($response) {
    echo 'I completed! ' . $response->getBody();
});

$promise->wait();

/*
$url = "http://www.movistarplus.es/programacion-tv/".date("Y-m-d", time() )."?v=json";

$content = json_decode(file_get_contents($url));

//var_dump(json_decode($content));
$directos = "";
$deportes = [];
foreach($content->data as $cadena){
	$directos .= "en la {$cadena->DATOS_CADENA->NOMBRE} veo";
	foreach($cadena->PROGRAMAS as $programa){		
		if(date("H:i", time()) > $programa->HORA_INICIO && date("H:i", time()) < $programa->HORA_FIN){
			$directos .= " {$programa->TITULO} <br>";			
		}
		if($programa->GENERO == "Deportes"){
            $deporte = 'deporte';
            if(strpos($programa->TITULO,"Liga Endesa")){
                $deporte = 'basket';
            }
            if(strpos($programa->TITULO,"Serie A")){
                $deporte = 'liga italiana';
            }
            if(strpos($programa->TITULO,"NBA")){
                $deporte = 'NBA';
            }
            if(strpos($programa->TITULO,"Bundesliga ")){
                $deporte = 'liga alemana';
            }
            if(strpos($programa->TITULO,"Ligue 1 ")){
                $deporte = 'liga francesa';
            }
            if(strpos($programa->TITULO,"LaLiga Santander ")){
                $deporte = 'Liga 1 div';
            }
            if(strpos($programa->TITULO,"LaLiga SmartBank ")){
                $deporte = 'Liga 2 div';
            }
            if(strpos($programa->TITULO,"UEFA Champions League ")){
                $deporte = 'Champions';
            }
            if(strpos($programa->TITULO,"UEFA Europa League ")){
                $deporte = 'Europa League';
            }
            $deportes[$deporte][] = ['cadena'=> $cadena, 'programa'=>$programa];

			//var_dump($programa);
		}
	}
}
//var_dump($deportes['Liga 1 div']);
foreach ($deportes as $liga => $contenido) {
    if ($liga != 'deporte') {
        foreach ($contenido as $item) {
            echo "en {$item['cadena']->DATOS_CADENA->NOMBRE} ponen un partido de la $liga a las {$item['programa']->HORA_INICIO} -> {$item['programa']->TITULO} <br>";
        }
    }
}
*/


