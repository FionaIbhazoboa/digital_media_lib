//Javascript

"use strict"  //this line is correct do not modify it


$( document ).ready(function() {  //This line is correct - do not modify it





//datepicker
   $( ".datepicker" ).datepicker({
  dateFormat: "yy-mm-dd"

});
    // Getter
var dateFormat = $( ".datepicker" ).datepicker( "option", "dateFormat" );
// Setter
$( ".datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );


//doesn't work
// $("#login").on('click', function(ev){
//    alert("Login Successful!");
// });

//pop up prompt for detete account
$('a.delete').confirm({
    content: "Are you sure you want to delete your account? Note: All your information will be deleted.",
});
$('a.delete').confirm({
    buttons: {
        hey: function(){
            location.href = this.$target.attr('href');
        }
    }
});
//pop up prompt for detete movie
$('a.deletevid').confirm({
    content: "Are you sure you want to delete this movie? Note: All your information will be removed.",
});
$('a.deletevid').confirm({
    buttons: {
        hey: function(){
            location.href = this.$target.attr('href');
        }
    }
});


//display count
var maxLength = 2500;
$('textarea').keyup(function() {
  var textlen = maxLength - $(this).val().length;
  $('#rchars').text(textlen);
});


// Test for unique username
   let flag = true;

     $("#createaccount #username").on("blur", function(ev)   /* blur is an event used after a textbox has been deselected  */
   {
      //alert("Hi");
      $.get( "checkusername.php", { username: $("#username").val() } )
      .done(function(data) {
      if(data)
      {
         //alert("username alread exist");
         $('#check').remove();
            $("#username").after("<span id= 'check' class= 'error'>Username already exist!</span>");
            flag = true;

          }
        else
        {
          //alert("username is a new one");
          $("#check").remove();
          flag = false;
        }
      })

      .fail(function(jqXHR, textStatus, errorThrown) {
          $("main").prepend("<li style= 'background-color:black'>New</li>");

        });
   });

   // Test for unique username

   $("#editaccount #username").on("blur", function(ev)   /* blur is an event used after a textbox has been deselected  */
{
    //alert("Hi");
    $.get( "checkusername.php", { username: $("#username").val() } )
    .done(function(data) {
    if(data)
    {
      //alert("username alread exist");
      $('#check').remove();
          $("#username").after("<span id= 'check' class= 'error'>Username already exist!</span>");
          flag = true;

        }
     else
     {
        //alert("username is a new one");
        $("#check").remove();
        flag = false;
     }
    })

    .fail(function(jqXHR, textStatus, errorThrown) {
        $("main").prepend("<li style= 'background-color:black'>New</li>");

     });
});





//Email Verification
   var valid = true;
     $("#createaccount [type='submit']").on("click", function(ev){

      var valid = true;
       let $emailerror = $("#email~span:contains('valid')");
      let email = $("#email").val();

    if (!emailIsValid(email))
    {
      $emailerror.removeClass( "noerror" );
      $emailerror.addClass( "error" );
      valid = false;
     }
      else
      {
        $emailerror.removeClass( "error" );
        $emailerror.addClass( "noerror" );

      }




  } );


//checks email on edit.
  $("#editaccount [type='submit']").on("click", function(ev){
     var valid = true;
     let $emailerror = $("#email~span:contains('valid')");
   let email = $("#email").val();

  if (!emailIsValid(email))
  {
   $emailerror.removeClass( "noerror" );
   $emailerror.addClass( "error" );
   valid = false;
  }
   else
   {
     $emailerror.removeClass( "error" );
     $emailerror.addClass( "noerror" );

   }


} );

//if there are error dont add to form 
if(!valid || !flag)
    ev.preventDefault();



























  }); //This line is correct - do not modify it




  //regular expression check for valid email address
   function emailIsValid (email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)
  }
