<?php

require "config.php";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Prisijungimas sėkmingas";
} catch(PDOException $e) {
    echo "Prisijungti nepavyko: " . $e->getMessage();
}

if(isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM books WHERE title LIKE '%$search%'";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skaitytojo puslapis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        h3 {
            margin-top: 20px;
            color: #007bff;
        }

        input[type="text"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Skaitytojo puslapis</h2>

        <form action="" method="get">
            <input type="text" name="search" placeholder="Paieška...">
            <input type="submit" value="Ieškoti">
        </form>

        <h3>Rasti rezultatai</h3>
        <?php
        if(isset($result) && $result->rowCount() > 0) {
            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "Knygos pavadinimas: " . $row["title"]. "<br>";
                echo '<a href="?reserve='.$row["id"].'">Rezervuoti</a><br><br>';
            }
        } else {
            echo "Nėra rezultatų arba neatlikote paieškos.";
        }
        ?>

        <h3>Rezervuoti knygą</h3>
        <?php
        if(isset($_GET['reserve'])){
            $book_id = $_GET['reserve'];
            echo "Jūs sėkmingai rezervavote knygą su ID: $book_id";
        }
        ?>
        <form action="" method="get">
            <input type="hidden" name="reserve" value="123">
            <input type="submit" value="Rezervuoti">
        </form>

        <h3>Mėgstamų knygų sąrašas</h3>
    </div>
</body>
</html>
