<?php

 require_once __DIR__ . '/dao.php';

Class Service {

    private $url;
    private $post;
    private $postfields;
    private $httpheaders;

    public function setUrl($value) {
        $this->url = $value;
    }

    public function setPost($value) {
        $this->post = $value;
    }

    public function setPostFields($value) {
        $this->postfields = $value;
    }

    public function setHttpHeaders($value) {
        $this->httpheaders = $value;
    }

    public function search() 
    {
        $response = $this->http($this->url, $this->post, $this->postfields, $this->httpheaders);
        return $response;
    }

    public function refreshToken()
    {
        $APP_ID =  '3451965851253310';
        $CLIENT_SECRET =  'C9g7dHiMkyh892OWIVbPSAjyQl2tI2ID';
        $dao = new Dao();
        $dao->connect();
    
        $url = 'https://api.mercadolibre.com/oauth/token?grant_type=refresh_token&client_id='. $APP_ID .'&client_secret='.$CLIENT_SECRET.'&refresh_token='.$dao->getRefreshToken();
        $response = $this->http($url, false, [], []);

        $dao->updateRefreshToken($response['refresh_token']);
        $dao->updateToken($response['access_token']);

        return $response['access_token'];
    }

    public function getToken()
    {
        $dao = new Dao();
        $dao->connect();
        $token = $dao->getToken();
        return $token;
    }

    public function getProductsFromDatabase($text, $category)
    {
        $dao = new Dao();
        $dao->connect();
        $token = $dao->getProducts($text, $category);
        return $token;
    }

    public function http($url, $post, $postfields, $httpheaders)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $post);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheaders);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        return json_decode($response, true);
    }

    public function generateJson($data) {
        $json = [];

        foreach ($data as $item) {

            $values = [
                'title' => $item['title'],
                'price' => $item['price'],
                'category' => $item['category_id'],
                'permalink' => $item['permalink'],
                'thumbnail' => $item['thumbnail']
            ];
            
            array_push($json, $values);
        
        }

        return $json;
    }
}