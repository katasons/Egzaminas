<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = $_POST["category_name"];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO categories (name) VALUES (:name)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $category_name);
        $stmt->execute();

        header("Location: admin.php");
        exit();
    } catch(PDOException $e) {
        echo "Kategorijos pridėjimas nepavyko: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}
?>
