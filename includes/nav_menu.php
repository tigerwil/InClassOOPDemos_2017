<ul class="navbar-nav ml-auto">
    <?php
    //Convert above static menu to a dynamic menu using a multi-dimensinoal array of 
    //labels, links and icons
    //to allow us to dynamically set the active menu item based on the current page 
    //the user is currently visiting
    $links = array(
        'Home'=>array('link'=>SITE_URI,'icon'=>'home'),
        'About' => array('link'=>SITE_URI.'about.php','icon'=>'question-circle'),
        //'Services' => array('link'=>'/InClassOOPDemos_2017/services.php','icon'=>'th-large'),
        'Contact' => array('link'=>SITE_URI.'contact.php','icon'=>'envelope')
    );
    
    //var_dump($links);
//    foreach($links as $page=>$link){
//        echo $page."<br>";
//        echo($link['link'])."<br>";
//        echo($link['icon'])."<br>";//        
//    }
   

    //Find out which page user is viewing
    $this_page = $_SERVER['REQUEST_URI'];
    // =========== test =================//
    //echo $this_page;
    //exit();
    // ========= end test ===============//   

    //loop the array and check if array page matches $this_page
    foreach($links as $page=>$link){
        echo '<li class="nav-item';
        if ($this_page == $link['link']) {
            echo ' active">';
        } else {
            echo '">';
        }
     echo "<a class='nav-link' href='{$link['link']}'>
                <i class='fa fa-{$link['icon']}' aria-hidden='true'></i> $page</a></li>";
       
    }  
    ?>
    <!-- Articles dropdown -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="articlesdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-list" aria-hidden="true"></i> Articles
        </a>
        <div class="dropdown-menu" aria-labelledby="articlesdropdown">
            <a class="dropdown-item" href="articles.php"><i class="fa fa-list" aria-hidden="true"></i> All Articles</a>
            <a class="dropdown-item" href="articlesbycategory.php?id=1"><span class="badge badge-pill badge-light">2</span> Database Security</a>
            <a class="dropdown-item" href="articlesbycategory.php?id=7"><span class="badge badge-pill badge-light">3</span> General Web Security</a>
            <a class="dropdown-item" href="articlesbycategory.php?id=4"><span class="badge badge-pill badge-light">2</span> HTML 5</a>
        </div>
    </li>
    <!-- Account dropdown -->
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="accountdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-user" aria-hidden="true"></i> Account
        </a>
        <div class="dropdown-menu" aria-labelledby="accountdropdown">            
            <!-- Non-authenticated user -->
            <a class="dropdown-item" href="register.php"><i class="fa fa-user" aria-hidden="true"></i> Register</a>
            <a class="dropdown-item" href="login.php"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a>
            <!-- Registered user only -->
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="account.php"><i class="fa fa-user-secret" aria-hidden="true"></i> My Account </a>
            <a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout </a>
            <!-- Admin user only -->
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="admin.php"><i class="fa fa-user-secret" aria-hidden="true"></i> Admin </a>
            <a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout </a>
        </div>
    </li>
</ul>