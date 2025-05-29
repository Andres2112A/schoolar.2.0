<?php

    include('../../config/database.php');
   
    $firstName  = $_POST['firstname'];
    $lastName  = $_POST['lastname'];
    $email  = $_POST['email'];
    $password = $_POST['password'];

    //$enc_pass = md5($password);
    $enc_pass = sha1($password);
    
    $sql_email_exist = "
        SELECT 
            COUNT(email) as total 
        FROM 
            users 
        WHERE 
            email = '$email' 
            LIMIT 1 
    ";
    $res = pg_query($conn, $sql_email_exist);

    if($res){
        $row = pg_fetch_assoc($res);
        if($row['total'] > 0){
            echo "Email already exists";
        }else{
            $sql = "INSERT INTO users (firstName, lastName, email, password)
                VALUES('$firstName','$lastName','$email','$enc_pass')
            ";

            $res = pg_query($conn, $sql);

            if ($res){
                echo "User has been created succesfully";
                echo "<script>alert('User has been created. Go to login!')</script>";
                header('Refresh: 0; URL=http://localhost/schoolar.2.0/src/login.html');
            }else{
                echo "Error";
            }
        }
    }
?>