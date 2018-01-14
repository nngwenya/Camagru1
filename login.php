<?php
include_once 'config/database.php';
include_once 'config/session.php';
include_once 'utilities.php';


    try
    {
        if (isset($_POST['login']))
        {
            
            if (empty($_POST['email']) || empty($_POST['password']))
            {
                echo "<script type='text/javascript'>alert('Username or Password empty or invalid');</script>";
            }
            else
            {
                $email = htmlEntities($_POST['email']);
                $password = htmlEntities($_POST["password"]);

                $query = "SELECT * FROM users WHERE email = :email";
                $stmt = $conn->prepare($query);
                $stmt->execute(array(':email' => $email));
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    $mail = $row['email'];
                    $hashedPassword = $row['password'];
                    if (password_verify($password,  $hashedPassword))
                    {
                        $_SESSION["username"] = $row['username'];
                        $_SESSION["password"] =  $hashedPassword;
                        header("location: home.php");
                    
                }else if(password_verify($password,  $hashedPassword)){
                    $result = "<p style='padding: 20px; color: red; border: 1px solid gray'>Account has not be activated</p>";
                }
                    else
                    {
                        $result = "<p style='padding: 20px; color: red;'>Invalid email or password</p>";
                        echo "<script type='text/javascript'>alert('Please verify data');</script>";
                    }
                }
            }
            
        }
    }
    catch (PDOException $e) 
    {
        echo $database.'<br>'.$e->getMessage();
    }
?>




<!DOCTYPE html>

<HTML>
    <HEAD>
        <TITLE>login</TITLE>
        <link rel="stylesheet" type="text/css" href="camagru.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </HEAD>
    <BODY class="bgi">

    <i class="material-icons" style="font-size:50px">camera</i>
            <div class="material-icons header"><h1>CAMAGRU</h1></div>
          
            <center><div class="container">
            
                <div class="head1"><h1>LOGIN</h1></div>
                <div class="head2"><p>with Email</p></div>
                <?php if(isset($result)) echo $result ?>
            <form method="post" action="login.php">
                <input type="email" name="email" value="" placeholder="Email Address" required><br>
                <input type="password" name="password" value="" placeholder="Password" required><br><br>
                <button type="submit" name="login"  value="Submit" >Submit</button><br>
                <button type="signup" value="Submit"  onclick="window.location.href='signup.php'">SignUp</button>
                <div><a href="http://localhost:8080/camagru/forgot_password2.php">forgot my password ?</a></div>
            </form>
            </div>
            
    </BODY>

</HTML>