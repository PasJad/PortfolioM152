<?php
require_once('functions/functions.php');
$myPostId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
if (connexionDatabase()) {
    connexionDatabase()->beginTransaction();
    $media = getMediaName($myPostId);

    $remove = RemoveMyPost($myPostId);
    if ($remove) {
        if (!empty($media)) {
            foreach ($media as $m) {
                echo $m;
                unlink("media/" . $m);
            }
        }
        echo "le post" . $myPostId . "a bien été supprimé";
        connexionDatabase()->commit();
    } else {
        connexionDatabase()->rollBack();
    echo "Erreur lors de la suppression du post";
    echo $myPostId;
}
}


?>