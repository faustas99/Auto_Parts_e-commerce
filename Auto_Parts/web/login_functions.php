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
            $error=true;
            echo "unwanted characters";
        }

        //validating email
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        {
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
        $sql= "SELECT * FROM users WHERE username= ? OR email = ?;";
        //this is responsible for the prepared statements
        $stmt=mysqli_stmt_init($connect);

        if(!mysqli_stmt_prepare($stmt,$sql))
        {
                ///fail message
            $error=true;
        }
        else
        {
            mysqli_stmt_bind_param($stmt, "ss", $username, $email);
            mysqli_stmt_execute($stmt);

            $result=mysqli_stmt_get_result($stmt);

            while ($row = mysqli_fetch_array($result)) {

                $user[] = $row;
                    
            }
            mysqli_stmt_close($stmt);
        }
        

        if($error==false)
        {
            //this is a prepared statement. Basicaly it says that the querry cannot be anything but this, and the ? will be the only elements that 
            //will be the input from the user. this is to pervent sql injections etc.
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
                $hashed_password= password_hash($password, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "ssss", $fullname, $email, $username, $hashed_password);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                
               
            }
        }
    }
?>

