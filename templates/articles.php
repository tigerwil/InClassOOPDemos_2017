<!-- Articles Page Template Content -->
<div class="container">
    <h1 class="mt-4 mb-3">All Articles</h1>
    <!-- mwilliams:  breadcrumb navigation -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Articles</li>            
    </ol>
    <!-- end breadcrumb --> 
    <?php
        $data = $dbh->getArticles();
        //var_dump($data);
        if($data['error']==false){
            //no errors - get the data items
            $articles = $data['items'];
            //var_dump($articles);
            
            //start the table
            echo '    
                <table class="table table-striped table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">View</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach($articles as $article){
                $id = $article['id'];
                $title = $article['title'];
                $description = $article['description'];
                
                //create a tr for each record
                echo "<tr>
                        <th scope='row'>$title</th>
                        <td>$description</td>
                        <td><a href='article.php?id=$id'>Read Article</a>  
                             <i class='fa fa-eye' aria-hidden='true'></i>
                        </td>
                     </tr>";
                
            }//end of foreach
            
            //end the table
            echo '</tbody>
                </table>';
        }//end of if data error
        
    ?>
</div>

