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

<h2>ADMIN LOGIN</h2>

<form action="#" method="post">

  <div class="container">

    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" required>


    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>
        
    <button type="submit">Login</button>
    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
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

        $username= $_POST['username'];
        $password= $_POST['password'];




        
        //this is a prepared statement. Basicaly it says that the querry cannot be anything but this, and the ? will be the only elements that 
        //will be the input from the user. this is to pervent sql injections etc.
        $sql= "SELECT * FROM admins WHERE admin_name = ?;";
        //this is responsible for the prepared statements
        $stmt=mysqli_stmt_init($connect);

        if(!mysqli_stmt_prepare($stmt,$sql))
        {
                ///fail message
            $error=true;
            
        }

            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);


            $result=mysqli_stmt_get_result($stmt);


            if($row = mysqli_fetch_assoc($result))
            {
                $users[]=$row;
                $hashed_pass=$users[0]['admin_password'];
                $check_pass=password_verify($password,$hashed_pass);
                
                if($check_pass===false)
                {
                    echo "username doesnt exsist1";
                }
                else if($check_pass===true)
                {
                    session_start();
                    $_SESSION['admin_id']=$users[0]['admin_id'];
                    $_SESSION['admin_name']=$users[0]['admin_name'];
                    header("location:admin_page.php");
                }
                

            }
            else
            {
              $error=true;
              echo "username doesnt exsist2";
            }
            mysqli_stmt_close($stmt);
            
    }
?>


