<?php

//isXMLHTTPRequest() 	or die('Forbidden');
isset($_GET['r'])	or die('Forbidden');

session_start();

$dbhost = '';
$dbname = '';
$dbuser = '';
$dbpass = '';

$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($mysqli->connect_errno) {
  $error=array("error" =>  $mysqli->connect_error);
  echo json_encode($error);
  exit();
}

$mysqli->set_charset("utf8");

$method = $_GET['r'];

switch ($method) {
	case 'addUser':
		echo addUser();
	  break;
	default:
		$error = array("error" =>  "Undefined function.");
    echo json_encode($error);
	  break;
}

$mysqli->close();

function isXMLHTTPRequest() {
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		return true;
	} else {
		return false;
	}
}

function isValidHash($hash) {
  if ($hash != "AuqiDOu0C6DnzbWGFEr0KUWX0zsJoI2qsel5zOqJ") {
    return false;
  } else {
    return true;
  }
}

function addUser() {
	$data = file_get_contents("php://input");
	$objData = json_decode($data);

	if(!isset($objData->data->hash)) {
  	$error = array("error" =>  "No hash value.");
    return json_encode($error);
  }
	if (!isValidHash($objData->data->hash)) {
    $error = array("error" =>  "Incorrect hash value.");
    return json_encode($error);
  }

  $mysqli = $GLOBALS['mysqli'];

  $already = false;
  $id = -1;

  /*$sql = "SELECT `user_id` as id FROM `user` WHERE `name` LIKE '".strip_tags(addslashes($objData->data->user->name))."';";
  if ($result = $mysqli->query($sql)) {
    if ($result->num_rows > 0) {
      $already = true;
      $obj = $result->fetch_object();
      $id = $obj->id;
      $result->close();
    }
  }else {
    $error = array("error" =>  "SELECT user query error.");
    return json_encode($error);
  }*/

  if(!$already) {
    $sql = "INSERT INTO `user`(`name`) VALUES ('".strip_tags(addslashes($objData->data->user->name))."');";
    if ($result = $mysqli->query($sql)) {
      $id = $mysqli->insert_id;
    }else {
      $error = array("error" =>  "INSERT user query error.");
      return json_encode($error);
    }
  }

  if($id != -1) {
    /*$sql = "UPDATE `user` SET `Quiz_Event`='".date("Y-m-d H:i:s")."', newsletter=".strip_tags(addslashes($objData->data->user->newsletter))." WHERE `user_id`=".$id.";";
    if ($result = $mysqli->query($sql)) {

    }else {
      $error = array("error" =>  "UPDATE user query error.");
      return json_encode($error);
    }*/
    $sql = "INSERT INTO `game`(`user_id`, `title`, `answers`, `score`) VALUES ('".$id."','".strip_tags(addslashes($objData->data->game->title))."','".strip_tags(addslashes($objData->data->game->answers))."','".strip_tags(addslashes($objData->data->game->score))."');";
    if ($result = $mysqli->query($sql)) {
      return $id;
    }else {
      $error = array("error" =>  "INSERT INTO game query error.");
      return json_encode($error);
    }
  }else {
    $error = array("error" =>  "No id.");
    return json_encode($error);
  }
}
?>