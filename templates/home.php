<!-- Home Page Template Content -->

<!-- Header with Background Image -->
<header class="business-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="display-3 text-center text-white mt-4">Knowledge Is Power</h1>
            </div>
        </div>
    </div>
</header>

<!-- Page Content -->
<div class="container">

    <div class="row">
        <div class="col-sm-8">
            <h2 class="mt-4">What We Do</h2>
            <p>Knowledge is Power is dedicated to keeping you up-to-date on the Web security and programming information you need to know.</p>
            <p>Our experts are real people with real-world technology experience from around the globe. Microsoft MVPs, IT consultants and many more.</p>
            <p>
                <a class="btn btn-primary btn-lg" href="about.php">Learn more &raquo;</a>
            </p>
        </div>
        <div class="col-sm-4">
            <h2 class="mt-4">Contact Us</h2>
            <address>
                <strong>Knowledge Is Power</strong>
                <br>4 Flanders Ct.
                <br>Moncton, NB E1C 0K6
                <br>
            </address>
            <address>
                <abbr title="Phone">P:</abbr>
                (123) 456-7890
                <br>
                <abbr title="Email">E:</abbr>
                <a href="mailto:#">name@kpower.com</a>
            </address>
        </div>
    </div>
    <!-- /.row -->
    <h2 class="mb-3 mt-4 text-primary">Most Popular Articles</h2>
    <div class="row">   
        <?php
            //test
            $data = $dbh->getPopularList();
            //var_dump($data);
            //check for any errors first
            if($data['error']==false){
                $popItems = $data['items'];
                //var_dump($popItems);
                foreach($popItems as $item){
                    $id = $item['page_id'];
                    $title = $item['title'];
                    $description = $item['description'];
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
            }//end of if data error
        
        ?> 
    </div>
    <!-- /.row -->

</div>
<!-- /.container -->