<?php

    require_once "connectdb.php";
    $admin_name="";
    $admin_password="";


    $sql= "INSERT INTO admins (admin_name,admin_password) VALUES (?, ?);";
            //this is responsible for the prepared statements
            $stmt=mysqli_stmt_init($connect);

            if(!mysqli_stmt_prepare($stmt,$sql))
            {
                ///fail message
                $error=true;
            }

            else
            {
                $hashed_password= password_hash($admin_password, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "ss", $admin_name, $hashed_password);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                
               
            }

?>