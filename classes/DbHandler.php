<?php

/**
 * DbHandler.php
 * Class to handle all database operations
 * This class will have the CRUD methods:
 * C - Create
 * R - Read
 * U - Update
 * D - Delete
 *
 * @author mwilliams
 */
class DbHandler {

    //private connection variable
    private $conn;

    //Constructor class - runs when class is initialized
    function __construct() {
        //initialize database connection when class is instantiated
//        require_once dirname(__FILE__ . '/DbConnect.php');
        require_once dirname(__FILE__) . '/DbConnect.php';
        //Open database
        try {
            $db = new DbConnect();
            $this->conn = $db->connect();
        } catch (Exception $ex) {
            $this::dbConnectError($ex->getCode());
        }
    }

//end of constructor
    //A static function allows to make a calls to it without
    //instantiating the class.  In other words with using the 
    //new keyword, for example
    //$dbh = new DbHandler();
    //$dbh->dbConnectError(1045);
    //Instead we can call it directly like this
    //$this::dbConnectError(1045);
    private static function dbConnectError($code) {
        switch ($code) {
            case 1045:
                echo "A database access error has occured!";
                break;
            case 2002:
                echo "A database server error has occured!";
                break;
            default:
                echo "An server error has occured!";
                break;
        }
    }

//End of DbConnectError 

    /**
     * getCategoryList() function
     * Get a list of categories for creating menu system
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
            $data = array('error' => false,
                'items' => $categories);
        } catch (PDOException $ex) {
            $data = array('error' => true,
                'message' => $ex->getMessage()
            );
        }

        //return the data back to calling environment
        return $data;
    }

    /**
     * getPoularList() function
     * Get a list of 6 most popular article for home page
     */
    public function getPopularList() {
        $sql = "SELECT COUNT(*)AS num, page_id, pages.title, 
                       CONCAT(LEFT(pages.description,30),'...') AS description
                 FROM history JOIN pages ON pages.id = history.page_id
                 WHERE type = 'page'
                 GROUP BY page_id
                 ORDER BY 1 DESC
                 LIMIT 6";
        try {
            $stmt = $this->conn->query($sql);
            $popular = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data = array('error' => false,
                'items' => $popular);
        } catch (PDOException $ex) {
            $data = array('error' => true,
                'message' => $ex->getMessage()
            );
        }

        //return the data back to calling environment
        return $data;
    }

//End of getPopularList method 

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

    /**
     * getArticle
     * Get a single article (page) for corresponding id parameter 
     * passed in
     * @param type $id
     * @return aray
     */
    public function getArticle($id) {
        try {
            //Prepare our sql query
            $stmt = $this->conn->prepare("SELECT title, description, content  
                                         FROM pages 
                                         WHERE id=:id");

            //Bind the query parameters
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            //Execute the query
            $stmt->execute();

            //Fetch the data as associative array
            $page = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //return array of data items
            $data = array(
                'error' => false,
                'items' => $page
            );
        } catch (Exception $ex) {
            $data = array('error' => true,
                'message' => $ex->getMessage()
            );
        }
        //return the data array 
        return $data;
    }

//End of getArticle method  

    /**
     * getArticleList
     * Get a list of article (pages)
     * @return array
     */
    public function getArticleList() {
        //build the sql query
        $sql = "SELECT id, title, description FROM pages ORDER BY title";

        //try to fetch all records
        try {
            $stmt = $this->conn->query($sql);
            $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data = array(
                'error' => false,
                'items' => $articles
            );
        } catch (PDOException $ex) {
            $data = array(
                'error' => true,
                'message' => $ex->getMessage()
            );
        }

        //return the data array 
        return $data;
    }

//End of getArticleList

    /*     * ************************ NEW STUFF ************************************ */

    /**
     * Creating new user
     * @param String $email User login email id
     * @param String $password User login password
     * @param String $first_name User first name
     * @param String $last_name User last name
     */
    public function createUser($email, $password, $first_name, $last_name) {
        // First check if user already existed in db
        if (!$this->isUserExists($email)) {
            // Generating password hash
            $password_hash = PassHash::hash($password);

            // Make activation code
            $active = md5(uniqid(rand(), true));

            $stmt = $this->conn->prepare("INSERT INTO users(email,pass,first_name,last_name,date_expires,active) values(:email, :pass, :fname, :lname, SUBDATE(NOW(), INTERVAL 1 DAY), :active)");

            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':pass', $password_hash, PDO::PARAM_STR);
            $stmt->bindValue(':fname', $first_name, PDO::PARAM_STR);
            $stmt->bindValue(':lname', $last_name, PDO::PARAM_STR);
            $stmt->bindValue(':active', $active, PDO::PARAM_STR);

            $result = $stmt->execute();


            // Check for successful insertion

            if ($result) {
                // User successfully inserted
                $data = array(
                    'error' => false,
                    'message' => 'USER_CREATE_SUCCESS',
                    'active' => $active
                );
            } else {
                // Failed to create user
                $data = array(
                    'error' => true,
                    'message' => 'USER_CREATE_FAIL',
                );
            }
        } else {
            // User with same email already existed in the db
            $data = array(
                'error' => true,
                'message' => 'USER_ALREADY_EXISTS'
            );
        }

        return $data;
    }

    /**
     * checkLogin
     * Check user login
     * @param type $email
     * @param type $password
     * @return boolean
     */
    public function checkLogin($email, $password) {
        // fetching user by email
        //var_dump($email);
        //var_dump($password);
        //var_dump(PassHash::hash($password));
        //exit();
        //1. Check if email exists

        $stmt = $this->conn->prepare("SELECT COUNT(*) from users WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $num_rows = $stmt->fetchColumn();
        //var_dump($num_rows);
        //exit();
        if ($num_rows > 0) {
            //2. Actual query
            $stmt = $this->conn->prepare("SELECT pass from users WHERE email = :email");
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_OBJ);

            if (PassHash::check_password($row->pass, $password)) {
                // User password is correct
                return TRUE;
            } else {
                // user password is incorrect
                return FALSE;
            }
        } else {
            // user not existed with the email
            return FALSE;
        }
    }

    /**
     * getUserByEmail
     * @param type $email
     * @return type
     */
    public function getUserByEmail($email) {
        try {
            $stmt = $this->conn->prepare("SELECT id, type, email, first_name, last_name, 
                                         IF(date_expires>=NOW(),true,false) as notexpired,
                                         IF(type='admin',true,false)as admin
                                         FROM users WHERE email = :email");
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
                //return $user;
                $data = array('error' => false,
                    'items' => $user);
                return $data;
            } else {
                return NULL;
            }
        } catch (PDOException $e) {
            return NULL;
        }
    }

//End getUserByEmail

    /**
     * activateUser
     * This method will active the user account.
     * @param type $email
     * @param type $active
     * @return boolean
     */
    public function activateUser($email, $active) {
        if ($this->isUserExists($email)) {
            //User exists in database - update table (date_expires and active)      
            $stmt = $this->conn->prepare("UPDATE users SET active=NULL, 
                                         date_expires=ADDDATE(date_expires, INTERVAL 1 YEAR)
                                         WHERE email=:email AND active = :active");

            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':active', $active, PDO::PARAM_STR);


            $result = $stmt->execute();
            $count = $stmt->rowCount();

            //Check for successfull update
            if ($count > 0) {
                //User successfully activated
                $data = array('error' => false,
                    'message' => 'USER_ACTIVE_SUCCESS');
            } else {
                //Failed to activate user
                $data = array('error' => true,
                    'message' => 'USER_ACTIVE_FAIL');
            }
        } else {
            //Account does not exist in database
            $data = array('error' => true,
                'message' => 'USER_ACTIVE_FAIL');
        }
        return $data;
    }

//End activateUser

    /**
     * getSearch
     * Wildcard search for article page by title or description
     * @param type $s
     * @return array
     */
    public function getSearch($s) {
        $sql = "SELECT id, title, description
                FROM pages
                WHERE title LIKE '%$s%' OR description LIKE '%$s%'  ";

        try {
            $stmt = $this->conn->query($sql);
            $search = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data = array(
                            'error' => false,
                            'items' => $search
                         );
        } catch (PDOException $e) {
            $data = array(
                            'error' => true,
                            'message' => $e->getMessage()
                    );
        }
        return $data;
    }

    /**
     * Checking for duplicate user by email address
     * @param String $email email to check in db
     * @return boolean
     */
    private function isUserExists($email) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) from users WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $num_rows = $stmt->fetchColumn();

        return $num_rows > 0;
    }

//end isUserExists
}

//end of class
