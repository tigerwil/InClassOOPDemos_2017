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
    
     
}//End of Class