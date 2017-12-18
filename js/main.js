$(function(){//DOM Ready
   //alert('dom ready'); 
   
    //Add Favorite Click Event
    $(document).on("click", ".addfav", function(e){
        e.preventDefault();//Stop from linking
        
        //Retrieve data values
        var pageid = $(this).data('id');
        var userid = $(this).data('userid');
        var type = 'add'; //for add

        //Make ajax call to favorite.php
        $.ajax({
            url: "favorite.php",
            type: "POST",
            data: {
              userid: userid,
              pageid: pageid,
              type:type
            },
        cache: false,
        success: function() {
          // Success message
          $('#success').html("<div class='alert alert-success'>");
          $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            .append("</button>");
          $('#success > .alert-success')
            .append("<strong>Favorite successfully added!. </strong>");
          $('#success > .alert-success')
            .append('</div>');

          
        },
        error: function() {
          // Fail message
          $('#success').html("<div class='alert alert-danger'>");
          $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            .append("</button>");
          $('#success > .alert-danger').append($("<strong>").text("Sorry, but an error has occured!"));
          $('#success > .alert-danger').append('</div>');
        },
        complete: function() {
          setTimeout(function() {
            document.location = "http://localhost:8888/InClassOOPDemos_2017/article.php?id="+pageid;
            document.location.reload(); 
          }, 2000);
        }

      });

    });//End ADD Favorite click
    
    //Delete Favorite Click Event
    $(document).on("click", ".delfav", function(e){
        e.preventDefault();//Stop from linking
        
        //Retrieve data values
        var pageid = $(this).data('id');
        var userid = $(this).data('userid');
        var type = 'delete'; //for delete
        
        //Make ajax call to favorite.php
        $.ajax({
            url: "favorite.php",
            type: "POST",
            data: {
              userid: userid,
              pageid: pageid,
              type:type
            },
        cache: false,
        success: function() {
          // Success message
          $('#success').html("<div class='alert alert-success'>");
          $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            .append("</button>");
          $('#success > .alert-success')
            .append("<strong>Favorite successfully deleted!. </strong>");
          $('#success > .alert-success')
            .append('</div>');

          
        },
        error: function() {
          // Fail message
          $('#success').html("<div class='alert alert-danger'>");
          $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            .append("</button>");
          $('#success > .alert-danger').append($("<strong>").text("Sorry, but an error has occured!"));
          $('#success > .alert-danger').append('</div>');
        },
        complete: function() {
          setTimeout(function() {
            document.location = "http://localhost:8888/InClassOOPDemos_2017/article.php?id="+pageid;
            document.location.reload(); 
          }, 2000);
        }

      });
    }); //End DELETE Favorite click   
    
});
