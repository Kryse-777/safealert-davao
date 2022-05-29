//Getting value from "ajax.php".
function fill(Value) {

   //Assigning value to "search" div in "index.php" file.
   $('#areasearch').val(Value);

   //Hiding "display" div in "index.php" file.
   $('#areadisplay').hide();

}

$(document).ready(function() {

   //On pressing a key on "Search box" in "index.php" file. This function will be called.
   $("#areasearch").keyup(function() {

       //Assigning search box value to javascript variable named as "areaname".
       var areaname = $('#areasearch').val();

       //Validating, if "name" is empty.
       if (areaname == "") {

           //Assigning empty value to "display" div in "admin.php" file.
           $("#areadisplay").html("");
       }

       //If name is not empty.
       else {

           //AJAX is called.
           $.ajax({

               //AJAX type is "Post".
               type: "POST",

               //Data will be sent to "areasearch.php".
               url: "../areasearch.php",

               //Data, that will be sent to "areasearch.php".
               data: {

                   //Assigning value of "name" into "search" variable.
                   areasearch: areaname
               },

               //If result found, this funtion will be called.
               success: function(html) {

                   //Assigning result to "display" div in "areasearch.php" file.
                   $("#areadisplay").html(html).show();
               }
           });
       }
   });
});