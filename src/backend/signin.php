<?php

    include('../../config/database.php');
    session_start();

    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $passw = $_POST['password'];
        $enc_pass = sha1($passw);

        $sql = "
            SELECT 
                id, firstName, lastName
            FROM 
                users
            WHERE
                email = '$email' AND
                password = '$enc_pass'
            LIMIT 1
        ";

        $res = pg_query($conn, $sql);

        if ($res && pg_num_rows($res) > 0) {
            $row = pg_fetch_assoc($res);
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['firstName'] . ' ' . $row['lastName'];
            header('Location: home.php');
            exit();
        } else {
            echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href='login.html';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Por favor complete todos los campos'); window.location.href='login.html';</script>";
        exit();
    }
?>