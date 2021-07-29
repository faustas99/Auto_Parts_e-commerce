<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
form {border: 3px solid #f1f1f1;}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

img.avatar {
  width: 40%;
  border-radius: 50%;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
</style>
</head>
<body>

<h2>Sign Up Form</h2>

<form action="#" method="post">

  <div class="container">
    <label for="uname"><b>Full Name</b></label>
    <input type="text" placeholder="Enter Full Name" name="fullname" required>

    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" required>

    <label for="uname"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>

    <label for="psw"><b>Repeat Password</b></label>
    <input type="password" placeholder="Enter Password" name="reppassword" required>
        
    <button type="submit">Sign Up</button>
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="cancelbtn">Cancel</button>
    <span class="psw">Forgot <a href="#">password?</a></span>
  </div>
</form>

</body>
</html>
<?php



    $error=false;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        require_once "connectdb.php";

        $fullname= $_POST['fullname'];
        $username= $_POST['username'];
        $email= $_POST['email'];
        $password= $_POST['password'];
        $reppassword= $_POST['reppassword'];

        //checking if there are empty fields
        if(empty($username) || empty($username) || empty($username) || empty($username) || empty($username))
        {
            $error=true;
        }
        
        //validating username
        if(!preg_match("/^[a-zA-Z0-9]*$/", $username))
        {
          //if() check wheter the the charakters in the username field only includes
          //the alphabet, both lower and upper case and numbers from 0-9 
            $error=true;
            echo "unwanted characters";
        }

        //validating email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            //checks if the email is a valid email, has valid domain name aka @
            $error=true;
            echo "invalid email";
        }

        //validating password
        if($password !== $reppassword)
        {
            $error=true;
            //header("location: ../login_functions.php?error=password");
            echo "password dun't mech";
        }

        
        //this is a prepared statement. Basicaly it says that the querry cannot be anything but this, and the ? will be the only elements that 
        //will be the input from the user. this is to pervent sql injections etc.
        $sql= "SELECT * FROM users WHERE username = ? OR email = ?;";
        //this is responsible for the prepared statements
        $stmt=mysqli_stmt_init($connect);

        if(!mysqli_stmt_prepare($stmt,$sql))
        {
                ///fail message
            $error=true;

        }

            mysqli_stmt_bind_param($stmt, "ss", $username, $email);
            mysqli_stmt_execute($stmt);

            $result=mysqli_stmt_get_result($stmt);

            if(!($row = mysqli_fetch_assoc($result)))
            {
              $aaa=$row;
              print_r($aaa);
            }
            else
            {
              $error=true;
              echo "already exsists";
            }
            mysqli_stmt_close($stmt);

        

        if($error==false)
        {
            //this is a prepared statement. Basicaly it says that the querry cannot be anything but this, and the ? will be the
            //only elements that will be the input from the user. this is to pervent sql injections etc.
            $sql= "INSERT INTO users (name,email,username,password) VALUES (?, ?, ?, ?);";
            //this is responsible for the prepared statements
            $stmt=mysqli_stmt_init($connect);

            if(!mysqli_stmt_prepare($stmt,$sql))
            {
                ///fail message
                $error=true;
            }


            else
            {
                // hasing the password. PASSWORD_DEFAULT automaticaly updates hashing method.
                $hashed_password= password_hash($password, PASSWORD_DEFAULT);
                //prepares the information for the SQL query. the count of ss means how many strings i am passing
                mysqli_stmt_bind_param($stmt, "ssss", $fullname, $email, $username, $hashed_password);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                
               
            }
        }
        
    }
?>


