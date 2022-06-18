<?php
session_start();

logout();

function logout(){
    /*
Check if the existing user has a session
if it does
destroy the session and redirect to login page
*/

    if(isset($_POST["logout"])){
   // destroy the session
    unset($_SESSION["username"]);
    session_destroy();
    
    //redirect to the login page
      echo '<script>alert("You have successfully logged out");
          window.location="../forms/login.html";
            </script>';
     
        }
}

