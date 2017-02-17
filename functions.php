<?php
//functions that are pretty damn useful. ^_^
function convert_timestamp($ugly){
  $date = new DateTime($ugly);
  //echo $date->format('l, F, jS, Y');
  //if echo was not present, it would not be spit out
  return $date->format('l, F, jS, Y');
}

//clean any inputstring
function clean_string($dirtydata){ //feed it in the field to dump it into the function itself :)
  global $db;
  return mysqli_real_escape_string($db, filter_var($dirtydata, FILTER_SANITIZE_STRING));
}
function clean_integer($dirtydata){
  global $db;
  return mysqli_real_escape_string($db, filter_var($dirtydata, FILTER_SANITIZE_NUMBER_INT));
}
function clean_email($dirtydata){
  global $db;
  return mysqli_real_escape_string($db, filter_var($dirtydata, FILTER_SANITIZE_EMAIL));
}
function clean_url($dirtydata){
  global $db;
  return mysqli_real_escape_string($db, filter_var($dirtydata, FILTER_SANITIZE_URL));
}
//no close ze PHP! >:D
