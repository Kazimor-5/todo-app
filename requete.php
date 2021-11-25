<?php
require_once("connexion.php");
if(isset($_POST["todoSubmit"])){
    $_SESSION['flash'] = 'Tâche ajoutée';
    $sql = "INSERT INTO todoapp(todo) VALUES (:todo)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "todo" => $_POST["todo"]
    ]);
    header("location: index.php");
    return;
}

if(isset($_POST["checkSubmit"])) {
    $sql = "UPDATE todoapp SET is_check = :is_check WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "id" => $_POST["todo_id"],
        "is_check" => 1
    ]);
    header("location: index.php");
    return;
}

if (isset($_POST["uncheckSubmit"])) {
    $sql = "UPDATE todoapp SET is_check = :is_check WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "id" => $_POST["todo_id"],
        "is_check" => 0
    ]);
    header("location: index.php");
    return;
}

if(isset($_POST["modify"]) && isset($_POST["todo_name"])) {
    $_SESSION['flash'] = 'Tâche modifiée';
    $sql = "UPDATE todoapp SET todo = :todo WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "id" => $_POST["todo_id"],
        "todo" => $_POST["todo_name"]
    ]);
    $_SESSION["edit"] = false;
    header("location: index.php");
    return;
}

if(isset($_POST["deleteSubmit"]) && isset($_POST["todo_id"])) {
    $_SESSION['flash'] = 'Tâche supprimée';
    $sql = "DELETE FROM todoapp WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "id" => $_POST["todo_id"]
    ]);
    header("location: index.php");
    return;
}

if(isset($_POST["deleteAllSubmit"])) {
    $_SESSION['flash'] = 'Liste supprimée';
    $sql = "TRUNCATE TABLE todoapp ";
    $stmt = $pdo->query($sql);
    header("location: index.php");
    return;
}

if(isset($_POST["editSubmit"])) {
    $_SESSION["edit"] = true;
    $_SESSION["id"] = $_POST["todo_id"];
    header("location:index.php");
}