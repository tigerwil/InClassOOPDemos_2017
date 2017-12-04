<?php
// ************************** CONSTANTS **************************/
define('SITE_URI', '/InClassOOPDemos_2017/');
// **************************** SESSION **************************/
//start the session
session_start();

/* ************************************************************** */
/* Autoloading Classes
 * Whenever your code tries to create a new instance of a class
 * that PHP doesn't know about, PHP automatically calls your 
 * __autoload() function, passing in the name of the class it's
 * looking for. Your function's job is to locate and include the 
 * class file, thereby loading the class. 
 */

//var_dump($_SESSION);

function __autoload($class) {
    require_once 'classes/' . $class . '.php';
}

//instantiate the database handler
$dbh = new DbHandler();
//print_r($dbh);
//exit();  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Knowledge Is Power</title>
    
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fontawesome CSS -->
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    
    
    <!-- Custom styles for this template -->
    <link href="css/business-frontpage.css" rel="stylesheet">
  </head>
  <body>
<!-- Navigation -->
<!--    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
      <div class="container">
        <a class="navbar-brand" href="/InClassOOPDemos_2017/"><i class="fa fa-plug text-warning" aria-hidden="true"></i> Knowledge Is Power</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <?php include 'includes/nav_menu.php';?>
        </div>
      </div>
    </nav>