<!-- Contact Page Template Content -->
<div class="container">    
    <h1 class="mt-4 mb-3">Contact Us</h1>
    <!-- mwilliams:  breadcrumb navigation -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Contact Us</li>            
    </ol>
    <!-- end breadcrumb -->
    <!-- Content Row -->
    <div class="row">
        <!-- Map Column -->
        <div class="col-lg-8 mb-4">
            <!-- Embedded Google Map -->
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2766.84858493686!2d-64.80253718435692!3d46.09399547911344!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4ca0b8d8f36a576d%3A0x25633576878461ff!2sOulton+College!5e0!3m2!1sen!2sca!4v1475072473149"  frameborder="0" style="border:0;width:100%;height:400px" allowfullscreen=""></iframe>

            <!--<iframe width="100%" height="400px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?hl=en&amp;ie=UTF8&amp;ll=37.0625,-95.677068&amp;spn=56.506174,79.013672&amp;t=m&amp;z=4&amp;output=embed"></iframe>-->
        </div>
        <!-- Contact Details Column -->
        <div class="col-lg-4 mb-4">
            <h3>Contact Details</h3>
            <p>
                <strong>Knowledge Is Power</strong>
                <br>4 Flanders Ct.
                <br>Moncton, NB E1C 0K6
                <br>
            </p>
            <p>
                <abbr title="Phone">P</abbr>: (123) 456-7890
            </p>
            <p>
                <abbr title="Email">E</abbr>:
                <a href="mailto:name@example.com">name@kpower.com
                </a>
            </p>
            <p>
                <abbr title="Hours">H</abbr>: Monday - Friday: 9:00 AM to 5:00 PM
            </p>
        </div>
    </div>
    <!-- /.row -->

    <!-- Contact Form -->
    <!-- In order to set the email address and subject line for the contact form go to the bin/contact_me.php file. -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <h3>Send us a Message</h3>
            <!-- 
            For custom Bootstrap form validation messages, you’ll need to add the novalidate 
            boolean attribute to your <form>. 
            This disables the browser default feedback tooltips, but still provides 
            access to the form validation APIs in JavaScript.
            -->
            <form name="contactForm" id="contactForm" novalidate method="post">
                <div class="control-group form-group">
                    <div class="controls">
                        <label for="fullname">Full Name:</label>
                        <input type="text" class="form-control" 
                               name="fullname" id="fullname" 
                               required data-validation-required-message="Please enter your name.">
                        <p class="form-text"></p>
                    </div>
                </div>
                <div class="control-group form-group">
                    <div class="controls">
                        <label for="phone">Phone Number:</label>
                        <input type="tel" class="form-control" 
                               id="phone" name="phone" 
                               required data-validation-required-message="Please enter your phone number.">
                    </div>
                </div>
                <div class="control-group form-group">
                    <div class="controls">
                        <label for="email">Email Address:</label>
                        <input type="email" class="form-control" 
                               id="email" name="email"
                               required data-validation-required-message="Please enter your email address.">
                    </div>
                </div>
                <div class="control-group form-group">
                    <div class="controls">
                        <label>Message:</label>
                        <textarea rows="10" cols="100" class="form-control" 
                                  id="message" name="message"
                                  required data-validation-required-message="Please enter your message" maxlength="999" style="resize:none"></textarea>
                    </div>
                </div>
                <div id="success"></div>
                <!-- For success/fail messages -->
                <button type="submit" class="btn btn-primary" id="sendMessageButton">Send Message</button>
            </form>
        </div>

    </div>
    <!-- /.row -->
</div>
