<!-- Admin Articles Page Template Content -->
<div class="container">
    <h1 class="mt-4 mb-3">Manage Articles</h1>

    <!-- mwilliams:  breadcrumb navigation -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="admin.php">Admin</a></li>
        <li class="breadcrumb-item active">Manage Articles</li>            
    </ol>
    <!-- end breadcrumb -->
    
    <?php
        if($_POST){           
            //get post params
            $category_id=$_POST['category_id'];
            $title=$_POST['title'];
            $description=$_POST['description'];
            $content=$_POST['content'];
            
            $data = $dbh->addArticle($category_id, $title, $description, $content);
            if($data['error']==false){
                 echo '<div class="alert alert-success"><strong>Insert Success</strong>
                        <p>The article page was successfully added!</p></div>';
            } else {
                echo '<div class="alert alert-danger"><strong>Insert Failure</strong>
                        <p>An error has occurRed please try again!</p></div>';
            }
             //finish page:  hide form
            echo '</div>';
            include './includes/footer.php'; //footer
            exit();
        }//End of if POST
        $data = $dbh->getAdminCategories();
        if($data['error']==false){
            $categories = $data['items'];
            
        }
        //var_dump($data);
    ?>
    <form method="post" action="admin-articles.php" class="mb-4" novalidate>
        <div class="form-group">
             <label for="category_id">Category</label>
             <select  class="form-control" id="category_id" name="category_id">
                <?php
                    foreach($categories as $category){
                       echo "<option value='{$category['id']}'>{$category['category']}</option>" ;
                    }    
               ?>
             </select>
        </div>   
        <div class="form-group">
            <div class="form-row">
                <div class="col-md-6">
                    <label for="title">Title</label>
                    <input class="form-control" id="title" name="title"
                           type="text"  
                           oninvalid="this.setCustomValidity('Please enter title')" 
                           oninput="setCustomValidity('')"
                           placeholder="Enter article title" required
                           value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>">
                </div>
                <div class="col-md-6">
                    <label for="description">Description</label>
                    <input class="form-control" id="description" name="description"
                           type="text"  
                           oninvalid="this.setCustomValidity('Please enter description')" 
                           oninput="setCustomValidity('')"
                           placeholder="Enter description" required
                           value="<?php if (isset($_POST['description'])) echo $_POST['description']; ?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Article Content</label>
            <textarea class="form-control" id="content" name="content" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Add</button>

    </form> 
</div>
