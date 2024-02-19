<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_username = $_POST["username"];
    $user_password = $_POST["password"];

    try {
       
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

      
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $user_username);
        $stmt->execute();
        header("Location: skaitytojopuslapis.php");

       
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch();
            if (password_verify($user_password, $row['password'])) {
                echo "Prisijungimas sėkmingas!";
              
            } else {
                echo "Neteisingas slaptažodis!";
            }
        } else {
            echo "Vartotojas su tokiu vartotojo vardu nerastas!";
        }
    } catch(PDOException $e) {
        echo "Prisijungti nepavyko: " . $e->getMessage();
    } finally {
    
        $conn = null;
    }
}
?>
