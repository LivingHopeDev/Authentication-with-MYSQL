<?php

require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $country, $gender){
    $conn = db();

    // Checking if the email is already in the database
    $select = mysqli_query($conn, "SELECT * FROM students WHERE email = '".$_POST['email']."'");


   if(mysqli_num_rows($select) > 0) {
         echo '<script>alert("This email address already exist!");
                                     window.location="../forms/register.html";
                                  </script>';
    }else{
        // continue with the registration if email is not in the database

          $sql = "INSERT INTO students (`full_names`, `email`,`password`,`country`,`gender`)
            VALUES ('$fullnames', '$email','$password','$country', '$gender');";
            if(mysqli_query($conn,$sql)){
                echo "You have successfully registered";
            }else{
            //    echo mysqli_error($conn);
                echo "Something went wrong, check your details";
            }
       }

}


//login users
function loginUser($email, $password){
    $conn = db();
    session_start();
    $sql = "SELECT * FROM students WHERE email = '".$_POST['email']."' && password = '".$_POST['password']."'";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);
            // print_r($row);
                    $_SESSION['username'] = $row['full_names'];
            if($row['email'] === $_POST['email'] && $row['password'] === $_POST['password']){
                     header("location: ../dashboard.php");
            }
    }else{
             echo '<script>alert("incorrect email or password");
                                     window.location="../forms/login.html";
                                  </script>';
                                }
}


function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    // echo "<h1 style='color: red'>RESET YOUR PASSWORD (IMPLEMENT ME)</h1>";
    //open connection to the database and check if username exist in the database
    //if it does, replace the password with $password given
     $sql =  "SELECT email FROM students WHERE email = '".$_POST['email']."'";
     $result = mysqli_query($conn,$sql);
                    //  print_r($result);
    if(mysqli_num_rows($result) == 1){
        $select = "UPDATE students SET `password` = '$password' WHERE `email` = '$email'" ;
             $result = mysqli_query($conn,$select);

         echo "password updated successfully";
 
     } else{
        echo "User doesn't exist";
    }
}

function getusers(){
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_assoc($result)){
            //show data
            echo "<tr style='height: 30px'>".
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] . 
                "</td> <td style='width: 150px'>" . $data['country'] . 
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                 "value=" . $data['id'] . ">".
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>".
                "</input> </form> </tr>";
        }
        echo "</table></table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

 function deleteaccount($id){
     $conn = db();
     //delete user with the given id from the database
     $sql = "DELETE FROM students WHERE id = '".$_POST['id']."'";
         $result = mysqli_query($conn,$sql);
        //  print_r($result);
          echo '<script>alert("User removed successfully");
                                     window.location="../dashboard.php";
                                  </script>';
    
 }
?>