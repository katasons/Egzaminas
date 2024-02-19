<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_username = $_POST["username"];
    $user_password = $_POST["password"];

    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $user_username);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->execute();

        header("Location: prisijungimasKnygoms.html");
        exit();
    } catch(PDOException $e) {
        echo "Registracija nepavyko: " . $e->getMessage();
    } finally {

        $conn = null;
    }
}
?>
