<?php
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "mc";

   
    $conn = mysqli_connect($host, $username, $password, $database);

    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

   
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    
    $stmt = mysqli_prepare($conn, "INSERT INTO users (email, password) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $email, $hashedPassword);

    
    if ($email === 'admina@gmail.com' && $password === '?looneytunesthebest?^-^') {
       
        header("Location: welcome_page.html");
        exit();
    } else {
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Registration successful!";
           
            header("Location: file.html");
            exit();
        } else {
            echo "Error: Registration failed";
           
        }
    }

   
    mysqli_stmt_close($stmt);
    
   
    mysqli_close($conn);
}
?>
