<?php

/**
 * Description of DbConnect
 *
 * @author mwilliams
 */
class DbConnect {

    //create private variables
    private $conn;

    function __construct() {
        //empty constructor
    }

/**
 * Establish database connection to the local database server
 * @return database connection handler
 */
    function connect() {
        //1.  Get the connection info
        require_once dirname($_SERVER['DOCUMENT_ROOT']).'/dbconn/2017_oop_connect.php';

       //2. make the connection (using the PDO - PHP data objects driver)
       $this->conn = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);

       //3. set error reporting - make it throw exceptions
       $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       //4. return connection resource back to calling environment
       return $this->conn;
   }//end of connect method

}//End of class
