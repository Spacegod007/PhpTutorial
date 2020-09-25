<?php
include 'C:/Users/Jordi van Roij/Documents/PhpstormProjects/PhpTutorial/config/database.php';

try {
    $id = isset($_GET['id']) ? $_GET['id'] : die("ERROR: id not found");

    $query = "DELETE FROM app_user WHERE id = ?";
    $statement = $connection->prepare($query);

    $statement->bindParam(1, $id);

    if ($statement->execute()) {
        header("Location: index.php?action=deleted");
    }
    else
    {
        die("Failed to delete");
    }
}
catch (PDOException $exception){
    die("ERROR: " . $exception->getMessage());
}