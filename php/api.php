<?php
/**
 * Created by Lunding
 * Date: 06/08/15
 * Time: 11.10
 */

require_once('config.php');
require_once('translation/en.php');
require_once('DB_Functions.php');

$db = new DB_Functions();

if (isset($_POST["tag"]) && $_POST["tag"] != ""){
    $tag = $_POST["tag"];

    $response = array("tag" => $tag, "error" => TRUE);

    switch($tag){
        case "submituser":
            $db->registerNewParticipant($_POST["data"], $response);
            break;
        default:
            $response["error_msg"] = MESSAGE_UNKNOWN_TAG;
            break;
    }
    echo json_encode($response);

}
/**
 * Check for GET request
 */
else if($_GET['tag'] && $_GET['tag'] != ''){
    $tag = $_GET['tag'];
    //Response array
    $response = array("tag" => $tag, "error" => TRUE);

    //check for tag type
    switch($tag){
        case "get_emails":
            break;
        default:
            $response["error_msg"] = MESSAGE_UNKNOWN_TAG;
            break;
    }
    echo json_encode($response);

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = MESSAGE_MISSING_TAG;
    echo json_encode($response);
}