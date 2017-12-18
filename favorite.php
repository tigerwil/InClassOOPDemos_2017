<?php

// Check for empty fields
if(empty($_POST)){
    {
    echo "No arguments Provided!";
    return false;
   } 
}

//Store params
$type =  $_POST['type'];
$pageid = $_POST['pageid'];
$userid = $_POST['userid'];

    
function __autoload($class) {
    require_once 'classes/' . $class . '.php';
}

//instantiate the database handler
$dbh = new DbHandler();

if ($type=='add'){
  $data = $dbh->addFavorite($userid, $pageid);  
  //var_dump($data);
  //$message = $data['message'];
}else{
   $data = $dbh->delFavorite($userid, $pageid);
   //var_dump($data);
   //$message = $data['message'];
}
//var_dump($data);
return $data;