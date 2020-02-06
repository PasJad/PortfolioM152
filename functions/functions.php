<?php

function connexionDatabase(){

    static $monpdo = null;

    $host = "localhost";
    $dbname = "Portfolio";
    $dbusername = "MediaUser";
    $password = "SuperMedia";
    
    try {
        //code...
        $monpdo = new PDO("mysql:host=$host;dbname=$dbname",$dbusername,$password);
        $monpdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo $e;
    }
    
}

function addMedia($name, $typeMedia){


    $host = "localhost";
    $dbname = "Portfolio";
    $dbusername = "MediaUser";
    $password = "SuperMedia";

    try {
        $monpdo = new PDO("mysql:host=$host;dbname=$dbname",$dbusername,$password);

        $monpdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO media (typeMedia,nomMedia) VALUES ('$typeMedia','$name')";

        $monpdo->exec($sql);
    }catch (PDOException $e){
        $e->getMessage();
        echo $e;
    }


}

function addPost($comment){
    $host = "localhost";
    $dbname = "Portfolio";
    $dbusername = "MediaUser";
    $password = "SuperMedia";

    try {
        $monpdo = new PDO("mysql:host=$host;dbname=$dbname",$dbusername,$password);

        $monpdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO post (commentaire) VALUES ('$comment')";

        $monpdo->exec($sql);
    }catch (PDOException $e){
        $e->getMessage();
    }


}

?>