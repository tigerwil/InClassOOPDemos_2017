<!-- Login Page Template Content -->
<div class="container">
    <h1 class="mt-4 mb-3">Login</h1>

    <!-- mwilliams:  breadcrumb navigation -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Login</li>            
    </ol>
    <!-- end breadcrumb -->
    <?php
    //check for post
    if ($_POST) {
        //FORM HAS BEEN POSTED - CHECK LOGIN CREDENTIALS
        //FOR TESTING: FICTIONAL USER
        //$_SESSION['user_id'] = 1; //pretend user 1 is logged in
        //$_SESSION['user_not_expired'] = true; //pretend user account is not expired
        //$_SESSION['admin'] = true;  //pretend user is an admin
        //END TESTING
        
         //get post params
        $email = $_POST['email'];
        $password = $_POST['password'];
        //Attempt login 
        $data = $dbh->checkLogin($email, $password);
        //var_dump($data);
        
        if($data){//true: login success or false: login failed
            //login success - get the user by email
            $data = $dbh->getUserByEmail($email);
            //var_dump($data);
            if ($data['error'] == false) {
                $userItems = $data['items'];
                //var_dump($userItems); 
                foreach ($userItems as $item) {
                    $userid = $item['id'];
                    $firstname = $item['first_name'];
                    $lastname = $item['last_name'];
                    $fullname = $firstname . ' ' . $lastname;
                    $admin = $item['admin'];
                    $expired = $item['expired'];
                }
                //store data in session
                $_SESSION['user_id'] = $userid;
                $_SESSION['fullname'] = $fullname;
                $_SESSION['expired'] = $expired;
                $_SESSION['admin'] = $admin;
            //show success and redirect user to home page (countdown)
            echo '<div class="alert alert-success">                      
                  <p><strong>Welcome</strong></p>
                  <p>You have successfully signed in!  
                  You will be automatically redirected to the home page in <span id="count"></span> seconds...</p></div>';
            echo "<script>
                var delay = 5;
                var url = 'index.php';
                function countdown() {
                        setTimeout(countdown, 1000) ;
                        $('#count').html(delay);
                        delay --;
                        if (delay < 0 ) {
                                window.location = url ;
                                delay = 0 ;
                        }
                }
                countdown() ;   
              </script>";    
        }
       
        //finish page:  hide form
        echo '</div>
              </div>';
        include './includes/footer.php'; //footer
        exit();
        }else{
           //login failed- show message
            echo '<div class="alert alert-danger"><strong>Login Failed</strong>
                    <p>Invalid credentials entered.  Please try again!</p>
                  </div>'; 
        }
    }//end of if POST
    ?>


    <form method="post" action="login.php" novalidate>
        <div class="form-group">
            <label for="email">Email address</label>
            <input class="form-control" id="email" name="email" 
                   type="email" aria-describedby="emailHelp" placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input class="form-control" id="password" name="password"
                   type="password" placeholder="Password">
        </div>
        <div class="form-group">
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox"> Remember Password</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
    <div class="text-center">
        <a class="d-block small mt-3" href="register.php">Register an Account</a>
        <a class="d-block small" href="forgot-password.php">Forgot Password?</a>
    </div>
</div>  