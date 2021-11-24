<?php 
session_start();
require("./requete.php");

$edit = $_SESSION["edit"] ?? false;
$id = $_SESSION["id"] ?? "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles.css">
</head>
<body class="container">
    <header>
        <h1 class="title">
            To Do List 
        </h1>
    </header>
    <section class="formContainer">
        <form class="todoForm" action="./index.php" method="POST">
            <input class="inputForm" type="text" name="todo" placeholder="A faire:">
            <button class="buttonForm" type="submit" name="todoSubmit">Ajouter à la liste</button>
        </form>
        //* AFFICHAGE
            <?php
                $stmt = $pdo->query("SELECT * from todoapp");
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    if ($row["is_check"] == 1) {
                        $class = "line";
                    } else {
                        $class = "";
                    }
                    if($row["id"] === $id && $edit) {
                        echo '<form class="todoForm" method="POST">
                        <input type ="text" name="todo_name" value="' . $row["todo"] . '">
                        <input type ="hidden" name="todo_id" value="' . $row["id"] . '">
                        <button class="buttonForm" type="submit" name="modify">Modifier</button>
                        </form>';
                    } else {
                        echo '<p class=' . $class . '>' . $row["todo"] . '</p><form class="todoForm" method="POST">
                            <input type ="hidden" name="todo_id" value="' . $row["id"] . 
                            '">
                            <button class="buttonForm editButton" type="submit" name="editSubmit">Editer la tâche</button>
                            <button class="buttonDelete" type="submit" name="deleteSubmit">Supprimer la tâche</button>
                            </form>';
                        if($row["is_check"] == 0) {
                            echo '<form class="todoForm" method="POST">
                            <input type ="hidden" name="todo_id" value="' . $row["id"] . '">
                            <button class="checkButton" type="submit" name="checkSubmit"><i class="fas fa-check"></i></button>
                            </form>';
                        } elseif($row["is_check"] == 1) {
                            echo '<form class="todoForm" method="POST">
                            <input type ="hidden" name="todo_id" value="' . $row["id"] . '">
                            <button class="uncheckButton" type="submit" name="uncheckSubmit"><i class="fas fa-check"></i></button>
                            </form>';
                        }
                    }
                }
            ?>
            <form class="todoForm" method="POST">
                <button class="buttonDelete" type="submit" name="deleteAllSubmit">Vider la liste</button>
            </form>
    </section>
</body>
</html>