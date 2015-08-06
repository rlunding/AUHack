<?php
/**
 * Created by Lunding
 * Date: 06/08/15
 * Time: 11.10
 */

require_once('config.php');
require_once('translation/en.php');

if (isset($_POST["tag"]) && $_POST["tag"] != ""){
    $tag = $_POST["tag"];

    $response = array("tag" => $tag, "error" => TRUE);

    switch($tag){
        case "submituser":
            //TODO: do something; validate and save in DB
            echo json_encode($_POST["data"]);
            break;
    }
    echo json_encode($response);

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = MESSAGE_MISSING_TAG;
    echo json_encode($response);
}