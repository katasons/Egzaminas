<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_title = $_POST["book_title"];
    $category_id = $_POST["category_id"];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $isbn = isset($_POST["isbn"]) ? $_POST["isbn"] : 'default_isbn_value';


        $sql = "INSERT INTO books (title, category_id, isbn) VALUES (:title, :category_id, '')";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':title', $book_title);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();

        header("Location: admin.php");
        exit();
    } catch(PDOException $e) {
        echo "Knygos pridėjimas nepavyko: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}
?>
