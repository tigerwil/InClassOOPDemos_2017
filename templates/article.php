    <!-- Article Page Template Content -->
<div class="container">
    <h1 class="mt-4 mb-3">Article</h1>
    <?php
    
        //ONLY AUTHORIZED USER CAN VIEW ARTICLE
        if(isset($_SESSION['user_id']) && isset($_SESSION['user_not_expired'])){
            //we found a user who is logged in - store their id in variable
            $userid = $_SESSION['user_id'];
            
        }else{
            $userid = null;
        }
        
        //var_dump($userid);//null when not logged in
        
        if(!empty($userid)){
            //user is logged in - continue
         //1. Retrieve the id parameter from the url querystring
        if (  isset($_GET['id']) && is_numeric($_GET['id'])     ){
            //id url param was passed in - store in variable 
            $id = $_GET['id'];
            
            $data = $dbh->getArticle($id);
            //var_dump($data);
            if($data['error']==false){
                //good to go - get the items
                $article = $data['items'];
                //var_dump($article);
                
                if(empty($article)){
                    //no record was found with that id
                    //build breadcrumb nav
                    echo '<ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="articles.php">Articles</a></li>  
                        </ol>';
                   
                    //display warning message
                    echo '<div class="alert alert-warning" role="alert">
                            No article was found!
                          </div>';
                }else{
                    //we found a record- display it
                    //var_dump($article);
                    //exit();
                    foreach($article as $item){
                        $title = $item['title'];
                        $description = $item['description'];
                        $content = $item['content'];
                      
                        echo "<ol class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='index.php'>Home</a></li>
                            <li class='breadcrumb-item'><a href='articles.php'>Articles</a></li>  
                            <li class='breadcrumb-item active'>$title</li> 
                        </ol>";
                        
                        echo "<h2 class='mt-3 mb-3'>$title</h2>";
                        echo $content;
                        
                    }//end of foreach
                    
                }//end of if else empty
                
            }//end of if data error
            
            
        }else{
            //id url param was missing or not numeric - show error message
            echo '<div class="alert alert-danger" role="alert">
                    This page was accessed in error!
                  </div>';
            //show footer and kill the script 
            echo '</div>';
            include './includes/footer.php';
            exit();
        }//end of if get id      
    
        }else{
            //user is not logged in - show message
            echo '<div class="alert alert-warning" role="alert">
                    <strong>Members Only</strong>
                    <p>You must be logged in as a registered user to view this article!</p>
                  </div>';
        }//end of if not empty
        ?>
</div>