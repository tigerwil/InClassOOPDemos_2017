<!-- Admin Edit Category Page Template Content -->
<div class="container">
    <h1 class="mt-4 mb-3">Edit Category</h1>

    <!-- mwilliams:  breadcrumb navigation -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="admin.php">Admin</a></li>
        <li class="breadcrumb-item"><a href="admin-categories.php">Manage Categories</a></li>
        <li class="breadcrumb-item active">Edit Category</li>            
    </ol>
    <!-- end breadcrumb -->
    <?php
    //1.  Must retrieve a url parameter called id
    //var_dump($_GET);
    //exit();
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        //For GET
        //if we get here, we found our id parameter and it's numeric
        //store it in variable for later use
        $id = $_GET['id'];
    } elseif (isset($_POST['id']) && is_numeric($_POST['id'])) {
        //FOR POST
        //if we get to this area, the user has posted -
        //need to retrieve the id from hidden post field
        $id = $_POST['id'];
    } else {
        //Parameter is missing - kill the script
        //and show error message
        echo '<div class="alert alert-danger" role="alert">
                    <i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i> 
                    This page has been accessed in error!                    
                 </div>';
        //complete proper closing html
        echo '</div>';
        include './includes/footer.php';
        exit();
    }

    //1.  Check if form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      //END OF POST PROCESSING  $category = trim( filter_var($_POST['category'],FILTER_SANITIZE_STRING));
            //Test if user actually entered something
            if(!empty($category)){   
                
            }else{
              //no value entered by user - show message
                echo "<p class='text-danger'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Category name is required!</p>";  
            }//end if not empty    
        
    }//END OF POST PROCESSING
    ?>
    <form class="form-inline" method="post" action="admin-editCategory.php">
        <div class="form-group mx-sm-3">
            <label for="category" class="sr-only">Category:</label>
            <input type="text" class="form-control" 
                   id="category" name="category"                    
                   value="General Web Security">
        </div>
        <input type="hidden" name="id" id="id" value="1">
        <button type="submit" class="btn btn-primary">Edit Category</button>
    </form>
</div>