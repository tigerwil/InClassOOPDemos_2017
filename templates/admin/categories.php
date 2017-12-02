<!-- Admin Categories Page Template Content -->
<div class="container">
    <h1 class="mt-4 mb-3">Manage Categories</h1>

    <!-- mwilliams:  breadcrumb navigation -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="admin.php">Admin</a></li>
        <li class="breadcrumb-item active">Manage Categories</li>            
    </ol>
    <!-- end breadcrumb -->

    <div class="row">
        <div class="col-lg-6">
            <h2>Edit Category</h2>
            <table class='table table-bordered table-striped'>
                <thead class='thead-dark'>
                    <tr>
                        <th>Category</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>General Web Security</td>
                        <td>                        
                            <a href='admin-editCategory.php?id=1'  title='Edit General Web Security'>
                                <i class='fa fa-pencil-square-o fa-2x'></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Common Attacks</td>
                        <td>                        
                            <a href='admin-editCategory.php?id=3'  title='Edit General Common Attacks'>
                                <i class='fa fa-pencil-square-o fa-2x'></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>JavaScript Security</td>
                        <td>                        
                            <a href='admin-editCategory.php?id=4'  title='Edit JavaScript Security'>
                                <i class='fa fa-pencil-square-o fa-2x'></i>
                            </a>
                        </td>
                    </tr>            
                </tbody>
            </table> 
        </div>
        <div class="col-lg-6">
            <?php
            // handle post
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $category = trim(filter_var($_POST['category'], FILTER_SANITIZE_STRING));
                //Test if user actually entered something
                if (!empty($category)) {
                    
                } else {
                    //no value entered by user - show message
                    echo "<p class='text-danger'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Category name is required!</p>";
                }//end if not empty  
            }//END OF POST PROCESSING
            ?>
            <h2>Add Category</h2>
            <form class="form-inline" method="post" action="admin-categories.php">
                <div class="form-group mx-sm-3">
                    <label for="category" class="sr-only">Category:</label>
                    <input type="text" class="form-control" 
                           id="category" name="category"                    
                           placeholder="Enter the category">
                </div>
                <button type="submit" class="btn btn-primary">Add Category</button>
            </form>
        </div>
    </div>
</div>
