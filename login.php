<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php
    session_start(); 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "mc";

        $conn = new mysqli($host, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $email = $_POST["email"];
        $password = $_POST["password"];

        if ($email === 'adminaa@gmail.com' && $password === '?looneytunesthebest?^-^') {
           
            $_SESSION["authenticated"] = true;
            header("Location: welcome_page.html");
            exit();
        }

       
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            
            if (password_verify($password, $user['password'])) {
                $_SESSION["authenticated"] = true;
                header("Location: file.html");
                exit();
            }
        }

        echo "Invalid email or password";

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
