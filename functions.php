<?php

//Author - Lea Buchhold
//Prüfen, ob Titel bereits vergeben ist
function check_s_title($s_title, $db){
$check_s_title = $db->query("select s_title from survey where s_title = '".$s_title."';");
$number_of_rows = $check_s_title->num_rows;
if($number_of_rows > 0){
  //Falsch zurückgeben, wenn Titel bereits vergeben ist
  return false;
  }else{
  return true;
  }
}

//Author - Lea Buchhold
//Prüfen, ob Kürzel bereits vergeben ist
function check_s_token($s_token, $db){
$check_s_token = $db->query("select s_token from survey where s_token = '".$s_token."';");
$number_of_rows = $check_s_token->num_rows;
if ($number_of_rows > 0){
  //Falsch zurückgeben, wenn Kürzel bereits vergeben ist
  return false;
  }else{
  return true;
  }
}
?>