<?php

require_once __DIR__ . '/dao.php';
require_once __DIR__ . '/Service.php';

if($_POST['site'] == 'ml'){

    $service = new Service();
    $json = [];

    $token = $service->getToken();
    $auth = 'Authorization: Bearer ' . $token;
    $url = 'https://api.mercadolibre.com/sites/MLB/search';
    $categories = ['tv' => 'MLB1002', 'geladeira' =>'MLB181294', 'celular' => 'MLB1055'];
    $urlSearch = $url . '?q=' .$_POST['key'] . '&category='. $categories[$_POST['category']];
    
    $searchFromDatabase = $service->getProductsFromDatabase( $_POST['key'], $categories[$_POST['category']] );

    if(!empty( $searchFromDatabase ) ) {
        $response = ['results' => $searchFromDatabase];

        $json = $service->generateJson($response['results']);
    }
    else {
        $service->setUrl($urlSearch);
        $service->setPost(false);
        $service->setPostFields([]);
        $service->setHttpHeaders([$auth]);
        $response = $service->search();

        if(array_key_exists('message', $response) && $response['message'] == 'Invalid token') {
            $token = $service->refreshToken();
            $auth = 'Authorization: Bearer ' . $token;
            $service->setHttpHeaders([$auth]);
            $response = $service->search();
        }

        $json = $service->generateJson($response['results']);
        
        $dao = new Dao();
        $dao->connect();
        $dao->insertSeach($json);
        $dao = null;
    }
    
    $service = null;
    
    echo json_encode($json);

}

