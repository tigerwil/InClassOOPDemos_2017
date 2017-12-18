$(function(){//DOM Ready
   //alert('dom ready'); 
   
    //Add Favorite Click Event
    $(document).on("click", ".addfav", function(e){
        e.preventDefault();//Stop from linking
        
        //console.log('Add Favorite click');
        
        //Retrieve data values
        var pageid = $(this).data('id');
        var userid = $(this).data('userid');
        var type = 'add'; //for add

        //console.log(type);
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
            //console.log('success');
          // Success message
          $("#success").html('<div class="alert alert-success alert-dismissible fade show" role="alert">'+
            '<strong>Favorite successfully added!</strong> You should check in on some of those fields below.'+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
              '<span aria-hidden="true">&times;</span>'+
            '</button>'+
          '</div>');          
         },
        error: function() {
            //console.log('fail');
          // Fail message
            $("#success").html('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
            '<strong>Sorry, but an error has occurred!</strong>'+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
              '<span aria-hidden="true">&times;</span>'+
            '</button>'+
            '</div>');
        },
        complete: function() {
            //alert('complete')
          setTimeout(function() {
            document.location = "http://localhost:8888/InClassOOPDemos_2017/article.php?id="+pageid;
            document.location.reload(); 
          }, 2000);
        }

      });//End of Ajax call

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
            $("#success").html('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
            '<strong>Favorite successfully deleted!</strong>'+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
              '<span aria-hidden="true">&times;</span>'+
            '</button>'+
          '</div>');

          
        },
        error: function() {
          // Fail message
            $("#success").html('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
            '<strong>Sorry, but an error has occurred!</strong>'+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
              '<span aria-hidden="true">&times;</span>'+
            '</button>'+
            '</div>');
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
