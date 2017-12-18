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

class DbHandler {

    //private variable to hold the connection
    private $conn;

    //Constructor object - will run automatically when class is instantiated
    function __construct() {
        //Initialize the database 
        require_once dirname(__FILE__ . '/DbConnect.php');
        //Open db Connection
        try {
            $db = new DbConnect();
            $this->conn = $db->connect();
        } catch (Exception $ex) {
            $this::dbConnectError($ex->getCode());
        }
    }

//End of constructor
    //Create a static function called dbConnectError
    //A static function can be called without instantiating the class
    //in other words no need to use the new keyword
    private static function dbConnectError($code) {
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
    }

//End of dbConnectError function

    /**
     * getCategoryList() function
     * Get a list of categories for creating menu
     */
    public function getCategoryList() {
        $sql = "SELECT id, category,Summary.total 
                FROM categories JOIN (SELECT COUNT(*) AS total, 
                                      category_id
                                      FROM pages
                                      GROUP BY category_id) AS Summary
                WHERE categories.id = Summary.category_id
                ORDER BY category";
        try {
            $stmt = $this->conn->query($sql);
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //Create an array to hold success|failure
            //data|message
            $data = array('error' => false,
                'items' => $categories
            );
        } catch (PDOException $ex) {
            $data = array('error' => true,
                'message' => $ex->getMessage()
            );
        }//end of try catch
        //Return data back to calling environment
        return $data;
    }

//end of getCategoryList Method

    /**
     * getPopularList() method
     * Get a list of the 3 most popular articles based on history
     * of pages visited
     * @return array
     */
    public function getPopularList() {
        $sql = "SELECT COUNT(*)AS num, page_id, pages.title, 
                       CONCAT(LEFT(pages.description,30),'...') AS description
              FROM history JOIN pages ON pages.id = history.page_id
              WHERE type = 'page'
              GROUP BY page_id
              ORDER BY 1 DESC
              LIMIT 3";

        try {
            $stmt = $this->conn->query($sql);
            $popular = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //Create an array to hold success|failure
            //data|message
            $data = array('error' => false,
                'items' => $popular
            );
        } catch (PDOException $ex) {
            $data = array('error' => true,
                'message' => $ex->getMessage()
            );
        }//end of try catch
        //Return data back to calling environment
        return $data;
    }

//End of getPopularList

    /**
     * getArticle() method
     * Return a single article
     * @param type $id
     * @return array
     */
    public function getArticle($id) {
        try {
            //Prepare our sql query with $id param coming from 
            //outside environment
            $stmt = $this->conn->prepare("SELECT title,description,content
                                        FROM pages 
                                        WHERE id=:id");
            //Bind our parameter
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            //Execute the query
            $stmt->execute();

            //Fetch the data as an associative array
            $page = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //Return array of data items
            $data = array(
                'error' => false,
                'items' => $page
            );
        } catch (PDOException $ex) {
            $data = array('error' => true,
                'message' => $ex->getMessage()
            );
        }//end of try catch
        //Return final data array
        return $data;
    }

//end of getArticle

    /**
     * getArticles() method
     * Return all articles
     * @return array
     */
    public function getArticles() {

        //build our sql query
        $sql = "SELECT id, title, description FROM pages ORDER BY title";

        try {
            $stmt = $this->conn->query($sql);
            $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //Return array of data items
            $data = array(
                'error' => false,
                'items' => $articles
            );
        } catch (PDOException $ex) {
            $data = array('error' => true,
                'message' => $ex->getMessage()
            );
        }//end of try catch
        //Return final data array
        return $data;
    }

//end of getArticles

    /**
     * getArticleByCategory
     * Get all articles for a particular category id
     * @param type $id
     * @return array
     */
    public function getArticlesByCategory($id) {
        try {
            $stmt = $this->conn->prepare("SELECT category, pages.id, title,description 
                                            FROM pages JOIN categories 
                                            ON category_id = categories.id
                                            WHERE category_id=:id
                                            ORDER BY date_created DESC");
            //Bind the parameters
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            //Execute the query
            $stmt->execute();
            //Fetch as associative array
            $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //Pass it to array
            $data = array('error' => false,
                'items' => $pages);
        } catch (Exception $ex) {
            $data = array('error' => true,
                'message' => $ex->getMessage()
            );
        }
        //return the data array back to calling environment
        return $data;
    }
// End of getArticlesByCategory method

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
    public function createUser($email, $password, $first_name, $last_name) {
        //First check if user already exists in table
        if (!$this->isUserExists($email)) {
            //User does not exist - continue
            //Generate password hash'
            $password_hash = PassHash::hash($password);

            //Generate random activation code
            $active = md5(uniqid(rand(), true));

            //Insert a new user to the database
            //Note: set the date_expires to yesterday (until they activate account)
            $stmt = $this->conn->prepare("INSERT INTO users (email,pass,first_name,last_name,date_expires,active)
                                        VALUES(:email,:pass,:fname,:lname,SUBDATE(NOW(),INTERVAL 1 DAY),:active)");
            //Bind Parameters
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':pass', $password_hash, PDO::PARAM_STR);
            $stmt->bindValue(':fname', $first_name, PDO::PARAM_STR);
            $stmt->bindValue(':lname', $last_name, PDO::PARAM_STR);
            $stmt->bindValue(':active', $active, PDO::PARAM_STR);

            //Execute the statement
            $result = $stmt->execute();

            //Prepare array of result
            if ($result) {
                //success - build success message 
                $data = array(
                    'error' => false,
                    'message' => 'USER_CREATE_SUCCESS',
                    'active' => $active
                );
            } else {
                //fail - build fail message
                $data = array(
                    'error' => true,
                    'message' => 'USER_CREATE_FAIL'
                );
            }
        } else {
            //User already exists - return error and message
            $data = array('error' => true,
                'message' => 'USER_ALREADY_EXISTS'
            );
        }

        //Return one final data array
        return $data;
    }

//End of createUser

    /**
     * activateUser() method
     * Activate a newly registered user account
     * @param type $email
     * @param type $active
     * @return array
     */
    public function activateUser($email, $active) {

        //Prepare update statement
        $stmt = $this->conn->prepare("UPDATE users 
                                    SET active=NULL,
                                        date_expires=ADDDATE(date_expires, INTERVAL 1 YEAR)
                                    WHERE email=:email AND active=:active 
                                    LIMIT 1");
        //Bind our statement parameters
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':active', $active, PDO::PARAM_STR);

        //Execute the statement
        $stmt->execute();

        //Retrieve the RowCount to find out if records were affected
        if ($stmt->rowCount() > 0) {
            //success
            $data = array(
                'error' => false,
                'message' => 'USER_ACTIVATE_SUCCESS'
            );
        } else {
            //not successful
            $data = array(
                'error' => true,
                'message' => 'USER_ACTIVATE_FAIL'
            );
        }
        //Return a final data array
        return $data;
    }

//End of activateUser

    /**
     * isUserExists() method
     * Check if user already exists in the database
     * @param type $email
     * @return boolean
     */
    private function isUserExists($email) {
        $stmt = $this->conn->prepare("SELECT COUNT(*)
                                    FROM users 
                                    WHERE email=:email");

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $num_rows = $stmt->fetchColumn();

        //return true or false
        return $num_rows > 0;
    }

//end of isUserExists 
    //=================== end Registration ===================//
    //================== User login ==========================//
    /**
     * checkLogin method
     * Check user email and password for login
     * @param type $email
     * @param type $password
     * @return boolean
     */
    public function checkLogin($email, $password) {
        //1. Check if email is in the database
        if ($this->isUserExists($email)) {
            //email exists - now check the email-password combination
            $stmt = $this->conn->prepare("SELECT pass from users 
                                        WHERE email =:email");

            //Bind statement parameter
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);

            //Execute the statement
            $stmt->execute();

            //Fetch the record as an PDO object
            $row = $stmt->fetch(PDO::FETCH_OBJ);

            //Check the hash against form password
            if (PassHash::check_password($row->pass, $password)) {
                //User password is a match
                return true;
            } else {
                //No match
                return false;
            }
        } else {
            //email was not found 
            return false;
        }
    }

//End of checkLogin 

    public function getUserByEmail($email) {
        try {
            //Prepare our query
            $stmt = $this->conn->prepare("SELECT id,type, email, 
                                          first_name, last_name,
                                          IF(date_expires<=NOW(),true,false) as expired,
                                          IF(type='admin',true,false) as admin
                                        FROM users
                                        WHERE email=:email");
            //Bind our parameter
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $data = array(
                    'error' => false,
                    'items' => $user
                );
                return $data;
            } else {
                return null;
            }
        } catch (PDOException $ex) {
            return null;
        }
    }

//End getUserByEmail
    //====================end login ==========================//
    //========================== USER FAVORITES ==============//
    public function addFavorite($user_id, $page_id) {
        /* REPLACE INTO Statement
         * This works exactly like an INSERT, except that if an old row
         * in the table has the exact same value(s) as a new row for a PK or 
         * UQ index, the old row is deleted before the new row is inserted.
         * Note:  This statement may return more than one row affected when
         * it deletes + inserts
         */

        try {
            //Prepare the SQL
            $stmt = $this->conn->prepare("REPLACE INTO user_favorites
                                                 (user_id,page_id)
                                        VALUES (:user_id,:page_id)");
            //Bind the params
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);

            //Execute the statement
            $stmt->execute();

            //Get the rowcount
            $count = $stmt->rowCount();

            //Check for success|failure
            if ($count > 0) {
                //success
                return true;
            } else {
                //fail
                return false;
            }
        } catch (PDOException $ex) {
            return false;
        }
    }

//End of addFavorite

    public function delFavorite($user_id, $page_id) {

        try {
            //Prepare the SQL
            $stmt = $this->conn->prepare("DELETE FROM user_favorites
                                        WHERE user_id = :user_id
                                        AND page_id = :page_id");
            //Bind the params
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);

            //Execute the statement
            $stmt->execute();

            //Get the rowcount
            $count = $stmt->rowCount();

            //Check for success|failure
            if ($count > 0) {
                //success
                return true;
            } else {
                //fail
                return false;
            }
        } catch (PDOException $ex) {
            return false;
        }
    }

//End of delFavorite 
    /**
     * getFavorite() method
     * Return a single record for user favorite
     * @param type $user_id
     * @param type $page_id
     */

    public function getFavorite($user, $page) {
        try {
            //Build prepared statement
            $stmt = $this->conn->prepare("SELECT user_id, page_id
                                       FROM user_favorites
                                       WHERE user_id = :user_id AND page_id = :page_id");
            //Bind params
            $stmt->bindValue(':user_id', $user, PDO::PARAM_INT);
            $stmt->bindValue(':page_id', $page, PDO::PARAM_INT);

            //Execute the statement
            $stmt->execute();

            //Fetch all records
            $favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //Build an array of results           
            $data = array(
                'error' => false,
                'items' => $favorites
            );
        } catch (PDOException $ex) {
            $data = array(
                'error' => true,
                'message' => $ex->getMessage()
            );
        }
        //return the data
        return $data;
    }

//End of getFavorite
    //========================== USER FAVORITES ==============// 
    //============================= ADMIN ONLY =======================//
    public function getAdminCategories() {
        $sql = "SELECT id, category
               FROM categories
               ORDER BY category";
        try {
            $stmt = $this->conn->query($sql);
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //Create an array to hold success|failure
            //data|message
            $data = array('error' => false,
                'items' => $categories
            );
        } catch (PDOException $ex) {
            $data = array('error' => true,
                'message' => $ex->getMessage()
            );
        }//end of try catch
        //Return data back to calling environment
        return $data;
    }

//end of getAdminCategories Method

    public function addArticle($category_id, $title, $description, $content) {
        $stmt = $this->conn->prepare("INSERT INTO pages (category_id,title,description,content)
                                      VALUES(:category_id,:title,:description,:content)");
        //Bind Parameters
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
         $stmt->bindValue(':content', $content, PDO::PARAM_STR);

        //Execute the statement
        $result = $stmt->execute();

        //Prepare array of result
        if ($result) {
            //success - build success message 
            $data = array(
                'error' => false,
                'message' => 'PAGE_CREATE_SUCCESS'
            );
        } else {
            //fail - build fail message
            $data = array(
                'error' => true,
                'message' => 'PAGE_CREATE_FAIL'
            );
        }
        return $data;
    }

    //============================ END ADMIN ONLY ====================//
}

//End of Class
