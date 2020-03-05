<?php
session_start();
require('functions.php');
$commentaire = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
$submitted = filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_STRING);
$target_dir = "../media/";
$willUploadFile = false;

$uploadOk = 1;

if ($submitted) {
    if (connexionDatabase()) {
        connexionDatabase()->BeginTransaction();
        if ($_FILES["fileToUpload"]['name'][0] != "") {
            $willUploadFile = true;
        }


        if ($willUploadFile == true){
            // Allow certain file formats
            for ($i = 0; $i < count($_FILES["fileToUpload"]["name"]); $i++) {
                $myFileType = mime_content_type($_FILES["fileToUpload"]["tmp_name"][$i]);
                echo $myFileType;
                echo strpos($myFileType, "image/");
                if (strpos($myFileType, "image/") === 0 or strpos($myFileType, "video/") === 0 or strpos($myFileType, "audio/") === 0) {
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            }
        }
// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 1) {
            $post = addPost($commentaire);
            echo "<br>" . $post . "<br>";
            if ($post != null) {
                if ($willUploadFile == true){
                    for ($i = 0; $i < count($_FILES["fileToUpload"]["name"]); $i++) {
                        echo $_FILES['fileToUpload']["name"][$i];
                        $target_name = basename(uniqid('',true) . '_' . $_FILES["fileToUpload"]["name"][$i]);
                        $target_file = $target_dir . $target_name;
                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                            echo $target_name;
                            $lastidMedia = addMedia($target_name, $imageFileType, $post);
                            echo $lastidMedia;
                            echo 'Your files has been uploaded';

                            echo $_FILES["fileToUpload"]["name"][$i];

                        } else {
                            echo "Une image n'as pas pu être ajouter";
                            connexionDatabase()->rollBack();
                        }
                    }
                }
                connexionDatabase()->commit();
            }

        } else {
            echo "Votre Upload n'as pas pu être effectué";
            connexionDatabase()->rollBack();
        }
    }

}

?>