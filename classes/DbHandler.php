<?php

/* 
 * DbHandler.php
 * Class to handle all database operations
 * This class will have all the CRUD methods:
 * C - Create
 * R - Read
 * U - Update
 * D - Delete
 */


class DbHandler{
    
    
    
    //private variable to hold the connection
    private $conn;
    
    //Constructor object - will run automatically when class is instantiated
    function __construct() {
        //Initialize the database 
        require_once dirname(__FILE__.'/DbConnect.php');
        //Open db Connection
        try{
            $db = new DbConnect();
            $this->conn = $db->connect();
            
        } catch (Exception $ex) {
            $this::dbConnectError($ex->getCode());
        }
        
    }//End of constructor
    
    //Create a static function called dbConnectError
    //A static function can be called without instantiating the class
    //in other words no need to use the new keyword
    private static function dbConnectError($code){
        switch ($code) {
            case 1045:
                echo "A database access error has occured!";
                break;
            case 2002:
                echo "A database server error has occured!";
                break;            
            default:
                echo "A server error has occured!";
                break;
        }//end of swith        
    }//End of dbConnectError function
    
  
    /**
     * getCategoryList() function
     * Get a list of categories for creating menu
     */
    public function getCategoryList(){
        $sql ="SELECT id, category,Summary.total 
                FROM categories JOIN (SELECT COUNT(*) AS total, 
                                      category_id
                                      FROM pages
                                      GROUP BY category_id) AS Summary
                WHERE categories.id = Summary.category_id
                ORDER BY category";
        try{
            $stmt = $this->conn->query($sql);
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //Create an array to hold success|failure
            //data|message
            $data = array('error'=>false,
                          'items'=>$categories
                         );
            
        } catch (PDOException $ex) {
            $data = array('error'=>true,
                          'message'=>$ex->getMessage()
                         );
        }//end of try catch
        
        //Return data back to calling environment
        return $data;
        
    }//end of getCategoryList Method
    
    /**
     * getPopularList() method
     * Get a list of the 3 most popular articles based on history
     * of pages visited
     * @return array
     */
    public function getPopularList(){
        $sql="SELECT COUNT(*)AS num, page_id, pages.title, 
                       CONCAT(LEFT(pages.description,30),'...') AS description
              FROM history JOIN pages ON pages.id = history.page_id
              WHERE type = 'page'
              GROUP BY page_id
              ORDER BY 1 DESC
              LIMIT 3";
        
        try{
            $stmt = $this->conn->query($sql);
            $popular = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //Create an array to hold success|failure
            //data|message
            $data = array('error'=>false,
                          'items'=>$popular
                         );
            
        } catch (PDOException $ex) {
            $data = array('error'=>true,
                          'message'=>$ex->getMessage()
                         );
        }//end of try catch
        
        //Return data back to calling environment
        return $data;
        
    }//End of getPopularList
    
    /**
     * getArticle() method
     * Return a single article
     * @param type $id
     * @return array
     */
    public function getArticle($id){
        try{
            //Prepare our sql query with $id param coming from 
            //outside environment
            $stmt=$this->conn->prepare("SELECT title,description,content
                                        FROM pages 
                                        WHERE id=:id");
            //Bind our parameter
            $stmt->bindValue(':id',$id,PDO::PARAM_INT);
            
            //Execute the query
            $stmt->execute();
            
            //Fetch the data as an associative array
            $page = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            //Return array of data items
            $data = array(
                'error' =>false,
                'items'=>$page
            );
            
        } catch (PDOException $ex) {
                $data = array('error'=>true,
                              'message'=>$ex->getMessage()
                             );
        }//end of try catch
        
        //Return final data array
        return $data;
        
    }//end of getArticle
    
    /**
     * getArticles() method
     * Return all articles
     * @return array
     */
     public function getArticles(){
  
            //build our sql query
            $sql = "SELECT id, title, description FROM pages ORDER BY title";

            try{
                $stmt=$this->conn->query($sql);
                $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                //Return array of data items
                $data = array(
                    'error' =>false,
                    'items'=>$articles
                );               
                
            } catch (PDOException $ex) {
                $data = array('error'=>true,
                              'message'=>$ex->getMessage()
                             );
            }//end of try catch
        
        //Return final data array
        return $data;
        
    }//end of getArticles
    
    
    //====================== User Registration =========================//
    /**
     * createUser() method
     * Add a new application user
     * @param type $email
     * @param type $password
     * @param type $first_name
     * @param type $last_name
     * @return array
     */
    public function createUser($email,$password,$first_name,$last_name){
        //First check if user already exists in table
        if(!$this->isUserExists($email)){
            //User does not exist - continue
            //Generate password hash'
            $password_hash = PassHash::hash($password);
            
            //Generate random activation code
            $active = md5(uniqid(rand(),true));
            
            //Insert a new user to the database
            //Note: set the date_expires to yesterday (until they activate account)
            $stmt=$this->conn->prepare("INSERT INTO users (email,pass,first_name,last_name,date_expires,active)
                                        VALUES(:email,:pass,:fname,:lname,SUBDATE(NOW(),INTERVAL 1 DAY),:active)");
            //Bind Parameters
            $stmt->bindValue(':email',$email,PDO::PARAM_STR);
            $stmt->bindValue(':pass',$password_hash,PDO::PARAM_STR); 
            $stmt->bindValue(':fname',$first_name,PDO::PARAM_STR); 
            $stmt->bindValue(':lname',$last_name,PDO::PARAM_STR);
            $stmt->bindValue(':active',$active,PDO::PARAM_STR);
            
            //Execute the statement
            $result = $stmt->execute();
            
            //Prepare array of result
            if($result){
                //success - build success message 
                $data = array(
                    'error'=>false,
                    'message'=>'USER_CREATE_SUCCESS',
                    'active'=>$active                    
                );
            }else{
                //fail - build fail message
                $data = array(
                    'error'=>true,
                    'message'=>'USER_CREATE_FAIL'       
                );
            }
            
            
        }else{
            //User already exists - return error and message
            $data=array('error'=>true,                
                        'message'=>'USER_ALREADY_EXISTS'
            );
            
        }
        
        //Return one final data array
        return $data;
    }//End of createUser
    
    /**
     * activateUser() method
     * Activate a newly registered user account
     * @param type $email
     * @param type $active
     * @return array
     */
    public function activateUser($email,$active){
        
        //Prepare update statement
        $stmt=$this->conn->prepare("UPDATE users 
                                    SET active=NULL,
                                        date_expires=ADDDATE(date_expires, INTERVAL 1 YEAR)
                                    WHERE email=:email AND active=:active 
                                    LIMIT 1");
        //Bind our statement parameters
        $stmt->bindValue(':email',$email,PDO::PARAM_STR);
        $stmt->bindValue(':active',$active,PDO::PARAM_STR);
        
        //Execute the statement
        $stmt->execute();
        
        //Retrieve the RowCount to find out if records were affected
        if($stmt->rowCount()>0){
            //success
            $data = array(
                'error'=>false,
                'message'=>'USER_ACTIVATE_SUCCESS'                
            );
        }else{
            //not successful
            $data = array(
                'error'=>true,
                'message'=>'USER_ACTIVATE_FAIL'                
            );
        }
        //Return a final data array
        return $data;
    }//End of activateUser
    
    /**
     * isUserExists() method
     * Check if user already exists in the database
     * @param type $email
     * @return boolean
     */
    private function isUserExists($email){
        $stmt=$this->conn->prepare("SELECT COUNT(*)
                                    FROM users 
                                    WHERE email=:email");
        
        $stmt->bindValue(':email',$email,PDO::PARAM_STR);
        $stmt->execute();
        $num_rows = $stmt->fetchColumn();
        
        //return true or false
        return $num_rows>0;
        
    }//end of isUserExists 
    //=================== end Registration ===================//
    
    //================== User login ==========================//
    
    
    //====================end login ==========================//

     
}//End of Class
