<?php
session_start();

require_once "config.php";

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
$username = $email= $phone= $password = $confirm_password = "";
$username_err = $email_err= $phone_err= $password_err = $confirm_password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
            }else{
                $sql = "SELECT id FROM users WHERE username = :username";
                if($stmt = $pdo->prepare($sql)){
                    $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
                        $param_username = trim($_POST["username"]);
                            if($stmt->execute()){
                                if($stmt->rowCount() == 1){
                                    $username_err = "This username is already taken.";
                                }else{
                                $username = trim($_POST["username"]);
                                }
                            }else{
                            echo "Oops! Something went wrong. Please try again later.";
                            }
                }
                unset($stmt);
            }
    
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
            }else{
            $sql = "SELECT id FROM users WHERE email = :email";
            if($stmt = $pdo->prepare($sql)){
                $stmt->bindParam(":email", $param_username, PDO::PARAM_STR);
                    $param_email = trim($_POST["email"]);
                        if($stmt->execute()){
                            if($stmt->rowCount() == 1){
                                $email_err = "This email is already taken.";
                            }else{
                            $email = trim($_POST["email"]);
                            }
                        } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
            }
        unset($stmt);
    }




    if(empty(trim($_POST["phone"]))){
        $phone_arr = "Please enter a phone.";
            }else{
            $sql = "SELECT id FROM users WHERE phone = :phone";
            if($stmt = $pdo->prepare($sql)){
                $stmt->bindParam(":phone", $param_phone, PDO::PARAM_STR);
                    $param_phone = trim($_POST["phone"]);
                    if($stmt->execute()){
                        if($stmt->rowCount() == 1){
                            $phone_err = "This phone is already taken.";
                        }else{
                        $phone = trim($_POST["phone"]);
                        }
                    }else{
                    echo "Oops! Something went wrong. Please try again later.";
                    }
            }
        unset($stmt);
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) <= 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    }else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    if(empty($username_err) && empty($email_err) && empty($phone_err) && empty($password_err) && empty($confirm_password_err)){
        
        $sql = "INSERT INTO users (username, email,phone,password) VALUES (:username, :email, :phone, :password)";
         
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":phone", $param_phone, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            
            $param_username = $username;
            $param_email = $email;
            $param_phone = $phone;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            
            if($stmt->execute()){
                header("location: index.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        unset($stmt);
    }
    unset($pdo);
}
?>
 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
</head>
<body>
    <style type="text/css">
        body{ font: 20px sans-serif; }
        .wrapper{ width: 350px; margin:0 auto; margin-top:200px;}
    </style>
    <div  class="container-fluid w-75">
    <?php include "header.php" ?>
        
        <form class = " wrapper w-50 " action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <br />
        <h2><b>Sign Up</b></h2>
        <br />
        <hr />
        <br />
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>  
               <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>email</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>  
              <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                <label>phone</label>
                <input type="number" name="phone" class="form-control" value="<?php echo $phone; ?>">
                <span class="help-block"><?php echo $phone_err; ?></span>
            </div>  
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success" value="Submit">
            </div>
        </form>
        <footer class="bg-primary" style = "margin-top:390px;  height:79px; font-size:30px;">
        <div class="footer-copyright text-center py-3"> <p>© 2018 Copyright</p></div>
        </footer>
    </div>    
    
</body>
</html>