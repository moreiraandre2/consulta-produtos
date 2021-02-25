<?php

Class Dao {

    private $conn;

    public function connect()
    {
        try {
            $this->conn = new PDO("mysql:host=localhost;dbname=id14814123_lexartlab", "id14814123_root", "o!IB*t{~2abnt=kO");
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
          }
    }

    public function updateRefreshToken($refreshToken)
    {
        try{
            $sql = "UPDATE refresh_token SET refresh_token = '$refreshToken' WHERE id = 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
        }
        catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
       
    }

    public function getRefreshToken()
    {
        try{
            $stmt = $this->conn->prepare("SELECT refresh_token FROM refresh_token LIMIT 1");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll()[0]['refresh_token'];
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function updateToken($token)
    {
        try{
            $sql = "UPDATE refresh_token SET token = '$token' WHERE id = 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
        }
        catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
       
    }

    public function getToken()
    {
        try{
            $stmt = $this->conn->prepare("SELECT token FROM refresh_token LIMIT 1");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll()[0]['token'];
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function insertSeach($data)
    {
        try{
            $this->conn->beginTransaction();

            foreach ( $data as $value ) {
                $this->conn->exec("INSERT INTO searches(title,price,category_id,permalink,thumbnail)
                VALUES ('".$value['title']."', '".$value['price']."', '".$value['category']."', '".$value['permalink']."', '".$value['thumbnail']."')");
            }

            $this->conn->commit();

        }catch(PDOException $e) {
            $this->conn->rollback();
            echo "Error: " . $e->getMessage();
        }
    }

    public function getProducts($text, $category)
    {
        try{

            $stmt = $this->conn->prepare("SELECT * FROM searches WHERE category_id = '$category' 
            AND title LIKE '%$text%'");

            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();

        }catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}