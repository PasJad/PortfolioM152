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
            $monpdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
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
        return $monpdo->lastInsertId();
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

        $sql = "select idPost,commentaire from post";

        $mesPosts = $monpdo->query($sql)->fetchAll();
        return $mesPosts;
    }
    catch (PDOException $e){
        $e->getMessage();
    }

}

function getMedia(){

    try {
        $myMedia = null;
        $monpdo = connexionDatabase();

        $sql = "select idMedia,idPost,nomMedia,typeMedia from media";


        $myMedia = $monpdo->query($sql)->fetchAll();
        return $myMedia;
    }
    catch (PDOException $e){
        $e->getMessage();
    }
}

function getMediaName($idPost){
    try {
          $media = null;
          $monpdo = connexionDatabase();
          $sql = "SELECT nomMedia FROM media WHERE idPost = " . $idPost;

          $media = $monpdo->query($sql)->fetch(PDO::FETCH_ASSOC);

          return $media;
    }
    catch (PDOException $e){
        $e->getMessage();
    }
}

function DrawMessage(){
    $myPosts = getPost();
    $myMedias = getMedia();

    for ($i = 0;$i < count($myPosts);$i++) {
        echo "<div class='well'>";
        echo "<div class=\"text-center\" style='font-size: 3vh'>" . $myPosts[$i]['commentaire'];
        echo "<br>";
        foreach ($myMedias as $media) {
            if ($media['idPost'] == $myPosts[$i]['idPost']){
                if ($media['typeMedia'] == "webm" ||  $media['typeMedia'] == "mp4" ){
                    echo "<video src='media/" . $media['nomMedia'] . "' height='300px' width='300px' controls autoplay>" . "</video>";
                }
                if ($media['typeMedia'] == "png" ||  $media['typeMedia'] == "jpeg")
                {
                    echo "<img src='media/" . $media['nomMedia'] . "' height='300px' width='300px'/>";
                }
                if ($media['typeMedia'] == "mp3" ||  $media['typeMedia'] == "wav")
                {
                    echo "<audio src='media/" . $media['nomMedia'] . "' height='300px' width='300px' controls/>";
                }
            }

        }
        echo "<a href='removePost.php?id=" . $myPosts[$i]['idPost']  . "'" . "class=\"fa fa-trash\" aria-hidden=\"true\">";
        echo "</a>";
        echo "</div><br>";
        echo "</div>";
    }

    var_dump($myPosts);
    var_dump($myMedias);

}
function RemoveMyPost($myIdPost){
    try {
        $monpdo = connexionDatabase();

        $sql = "DELETE FROM post WHERE idPost = " . $myIdPost;
        echo $sql;

        $remove = $monpdo->exec($sql);
        return $remove;
    }
    catch (PDOException $e){
        $e->getMessage();
    }
}
?>