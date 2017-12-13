<?php
//include header
include 'includes/header.php';
?>
<div class="container">
    <h1 class="mt-4 mb-3">Account Activation</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Account Activation</li>            
    </ol>
    <?php
    //Check if url querystring parameters are present (x and y)
    if(isset($_GET['x']) && isset($_GET['y'])){
        //Good to go
        //validate our parameters
        $errors = array();
        
        //retrieve parameters and store in variables
        $email = $_GET['x'];
        $active = $_GET['y'];

        
        
        //1.validate the email (which is in param: x)
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            //invalid email format passed in url
            $errors['email'] = 'Invalid email address!';
        }
        //2. validate the activation code - should 32 long (which is in param y)
        if(strlen($active)!=32){
           //invalid code passed in url
           $errors['active'] = 'Invalid activation code!';
        }
        
        //Only if $errors array is empty - proceed to database
        if(empty($errors)){
            //OK to proceed
            $data = $dbh->activateUser($email,$active);
            if($data['error']){
                //Activation failed
                echo '<div class="alert alert-danger" role="alert">
                        Account activation has failed!
                      </div>';
            }else{
                //Activation success
               echo '<div class="alert alert-success" role="alert">
                     Your account is now active! <br>  
                     You can proceed to the <a href="login.php">login</a> page.
                  </div>'; 
            }
            
        }else{
            //Validation errors are present - show them
            echo '<div class="alert alert-danger" role="alert">';
            echo '<strong>Activation Failed</strong><ul>';
            //loop the error array
            foreach($errors as $error){
                echo "<li>$error</li>";
            }
            echo '</ul>';            
            echo '</div>';
        }
        
        
    }else{
        //params are missing - show alert
        echo '<div class="alert alert-danger" role="alert">
                <strong>Activation Failed</strong><br>
                This page has been accessed in error!
            </div>';
    }
    
    ?>
    
</div>
<?php
include 'includes/footer.php';

