<!-- Articles By Categogy Page Template Content -->
<div class="container">

        <?php
        //1. Retrieve the id parameter from the url querystring
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            //id url param was passed in - store in variable 
            $id = $_GET['id'];

            $data = $dbh-> getArticlesByCategory($id);
            //var_dump($data);
            //exit();
            if ($data['error'] == false) {
                //good to go - get the items
                $articles = $data['items'];
                if(empty($articles)){
                    //no record was found with that id
                    //build breadcrumb nav
                    echo '<ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="articles.php">Articles</a></li>  
                        </ol>';
                   
                    //display warning message
                    echo '<div class="alert alert-warning" role="alert">
                            No articles was found!
                          </div>';
                }else{
                     //we found a record- display it
                    //var_dump($articles);
                    //exit();
                    //var_dump($articles[0]['category']);
                    //get single array items - for category
                    $category = $articles[0]['category'];
                    echo "<h1 class='mt-4 mb-3'>$category</h1>";
                    echo "<ol class='breadcrumb'>
                            <li class='breadcrumb-item'><a href='index.php'>Home</a></li>
                            <li class='breadcrumb-item'><a href='articles.php'>Articles</a></li> 
                            <li class='breadcrumb-item active'>$category</li>
                           </ol>";
                    echo   '<div class="row">';//start row
                    foreach($articles as $article){
                        $id = $article['id'];
                        $title = $article['title'];
                        $description = $article['description'];
                        echo "<div class='col-md-4 mb-4'>
                                <div class='card h-100'>
                                    <div class='card-body'>
                                        <h2 class='card-title'>$title</h2>
                                        <p class='card-text'>$description</p>
                                    </div>
                                    <div class='card-footer'>
                                        <a href='article.php?id=$id' class='btn btn-primary'>More Info</a>
                                    </div>
                                </div>
                            </div>";
                    }//end of foreach
                    echo '</div>'; //end of row
                }
            }
        }
        ?> 

</div>
