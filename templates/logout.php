<!-- Logout Page Template Content -->
<div class="container">
    <h1 class="mt-4 mb-3">Logout</h1>

    <!-- mwilliams:  breadcrumb navigation -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Logout</li>            
    </ol>
    <!-- end breadcrumb -->
    <?php
    // Unset all of the session variables.
    $_SESSION = array();

    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
        );
    }

    // Finally, destroy the session.
    session_destroy();
    ?>
    <div class="alert alert-success" role="alert">
        Thank you for visiting.  You are now logged out! <br>
        Please come back soon!
    </div>
    
    <script>
        var delay = 5;
        var url = 'logout.php';
        function countdown() {
            setTimeout(countdown, 500);
            //$('#count').html(delay);
            delay--;
            if (delay < 0) {
                window.location = url;
                delay = 0;
            }
        }
        countdown();
    </script>
</div>
<!-- /.container -->