<?php

// Check for empty fields
if(empty($_POST)){
    {
    echo "No arguments Provided!";
    return false;
   } 
}//end of empty POST

//Get post parameters
    $type = $_POST['type'];
    $page_id = $_POST['pageid'];
    $user_id = $_POST['userid'];
    
 //var_dump($_POST);
 //exit();
 function __autoload($class) {
    require_once 'classes/' . $class . '.php';
}   

//instantiate the database handler
$dbh = new DbHandler();


//get the type of work (add or delete)
if($type=='add'){
    //add Favorite - call the dbh addFavorite
    $data = $dbh->addFavorite($user_id, $page_id);
    
}else{
    //delete Favorite - call the dbh delFavorite
    $data = $dbh->delFavorite($user_id, $page_id);
}
//Return data
return $data;