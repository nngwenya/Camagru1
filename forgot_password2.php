<?php
include_once 'config/database.php';
include_once 'config/session.php';
include_once 'utilities.php';
// Was the form submitted?

$email = isset($_POST['email']) ? $_POST['email'] : '';
$headers = isset($_POST['headers']) ? $_POST['headers'] : '';
$ms = isset($_POST['ms']) ? $_POST['ms'] : '';


try {

if (isset($_POST['submit'])) {

    //$email = $_POST['email'];

    // Harvest submitted e-mail addresse
 if (filter_var($email , FILTER_VALIDATE_EMAIL)) {
    //$email = $_POST['email'];

    $result = "<p style='padding: 15px; color: green;'>An email has been sent to you!</p>";
    }else{

        $result = "<p style='padding: 15px; color: red;'>An error occured!</p>";
        //exit;

    }

    $username = $_SESSION['username'];
    // Check to see if a user exists with this e-mail
   
    $query = ('SELECT email FROM users WHERE email = :email');
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email); 
    
    $stmt->execute();
    
    if($userExists = $stmt->fetch(PDO::FETCH_ASSOC))
    {

   // echo "$userExists";
    $email = $_POST['email'];
    
    if ($userExists["email"])

    {

      //generating a random password
         $password = "";
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        
         for($i = 0; $i < 8; $i++)
         {
            $random_int = mt_rand();
             $password .= $chars[$random_int % strlen($chars)];
     
              $pwrurl = "no-reply@camagru.com/forgot_password1.php?q=";
      
       
         }
         
        // Mail them their key

        $to=$email;   
        $subject="www.noreply@camagru.com - RESET PASSWORD";
        $headers .= "MIME-Version: 1.0"."\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
        $headers .= 'From:camagru <gwengwenya@gmail.com>'."\r\n";
                       
        $ms.="<html></body><div><div>Dear ".$username.",</div></br></br>";
        $ms.="<div style='padding-top:8px;'>If this e-mail does not apply to you please ignore it. It appears that you have requested a password reset, Please click the following link For verifying and reset your password,.</div>
        <br>\n\nYour username : ".$username.".\r\n<br>
        \n\nNew password : ".$password.".<br><br>\r\n
        Copy the link:\r\n 
         http://localhost:8080/camagru/forgot_password1.php

       <br>Thank you.<br>
          
            </div>
            </body></html>";
        mail($to,$subject,$ms,$headers);    


    $result = "<p style='padding: 15px; color: green;'>An email has been sent to you!</p>";
    }
    else
    {

    $result =  "<p style='padding: 15px; color: red;'>Opps !Your email does not exist!</p>";
    }
}
}
}

catch(PDOException $ex)

    {
        $result = "<p style='padding: 15px; color: red'>An error occurred: ".$ex->getMessage()." </p>";
    }


?>

                    
                   
<!DOCTYPE html>

<HTML>
    <HEAD>
        <TITLE>login</TITLE>
        <link rel="stylesheet" type="text/css" href="camagru.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </HEAD>
    <BODY class="bgi">

    <i class="material-icons" style="font-size:50px">camera</i>
            <div class="material-icons header"><h1>CAMAGRU</h1></div>

            <center><div class="forgot">
            <?php echo $result ?>
            <div class="head1"><h1>Oops !!</h1></div>
           
            <img src="https://i.pinimg.com/originals/ca/54/e0/ca54e0a12f6bd7dfd467ce59648c17eb.gif"/>
           
               <form method="post" action="">
                <input type="text" name="email" value"email" placeholder="Email Address" required><br>
                <button type="submit" value="Submit" name="submit" >Submit</button><br>
                <p>RESET PASSWORD</p>

     
            </BODY>

</HTML>