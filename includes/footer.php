<!-- Footer -->
<footer class="py-5 bg-primary">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Knowledge Is Power 
            <?php echo date("Y") ?>            
        </p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<?php
    //Include jQuery Bootstrap Validation for contact form
    if ($this_page == '/InClassOOPDemos_2017/contact.php') {
?>
    <!-- Contact form JavaScript -->
    <!-- Do not edit these files! In order to set the email address and subject line 
         for the contact form go to the mail/contact_me.php file. --> 
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>
    <?php
}
?>
</body>
</html>