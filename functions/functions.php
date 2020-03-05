<?php


function connexionDatabase(){

    static $monpdo = null;

    $host = "localhost";
    $dbname = "Portfolio";
    $dbusername = "MediaUser";
    $password = "SuperMedia";

    if ($monpdo === null){
        try {
            //code...
            $monpdo = new PDO("mysql:host=$host;dbname=$dbname",$dbusername,$password);
            $monpdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e;
            echo "Impossible de se connecter à la base de données";
        }
    }
    return $monpdo;
}

function addMedia($name, $typeMedia,$idPost){

    try {
        $monpdo = connexionDatabase();

        $sql = "INSERT INTO media (typeMedia,nomMedia,idPost) VALUES ('$typeMedia','$name','$idPost')";

        $monpdo->exec($sql);
    }catch (PDOException $e){
        $e->getMessage();
        echo $e;
    }


}

function addPost($comment){


    try {
        $monpdo = connexionDatabase();

        $sql = "INSERT INTO post (commentaire) VALUES ('$comment')";

        $monpdo->exec($sql);

        $postId = $monpdo->lastInsertId();

        return $monpdo->lastInsertId();
    }catch (PDOException $e){
        $e->getMessage();
    }


}

function getPost(){

    try {
        $monpdo = connexionDatabase();

        $sql = "select commentaire from post";

        $monpdo->exec($sql);
    }
    catch (PDOException $e){
        $e->getMessage();
    }

}

function getImages(){

    try {
        $myMedia = null;
        $monpdo = connexionDatabase();

        $sql = "select idMedia,idPost from media";

        $myMedia = $monpdo->exec($sql);
        return $myMedia;
    }
    catch (PDOException $e){
        $e->getMessage();
    }
}

function DrawMessage(){
    $myPosts = getPost();





}

?>