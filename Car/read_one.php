<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Fake car app</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>

<div class="container">

    <div class="page-header">
        <h3>Car</h3>
    </div>

<?php

$action = isset($_GET['action']) ? $_GET['action'] : "";

if ($action == 'deleted') {
    echo "<div class='alert alert-success'>Record deleted</div>";
}

$id = isset($_GET['id']) ? $_GET['id'] : die("ERROR: id not found");
$userId = isset($_GET['userId']) ? $_GET['userId'] : die("ERROR: id not found");
include '../config/database.php';

try {
    $query = "SELECT id, brand, type FROM car WHERE id = ? LIMIT 0,1";
    $statement = $connection->prepare($query);
    $statement->bindParam(1, $id);
    $statement->execute();
    $row = $statement->fetch();

    $id = $row['id'];
    $brand = $row['brand'];
    $type = $row['type'];
}
catch (PDOException $exception) {
    die("ERROR: " . $exception->getMessage());
}

?>

    <table class="table table-hover table-responsive table-bordered">
        <tr>
            <td>id</td>
            <td><?php echo htmlspecialchars($id, ENT_QUOTES); ?></td>
        </tr>
        <tr>
            <td>brand</td>
            <td><?php echo htmlspecialchars($brand, ENT_QUOTES); ?></td>
        </tr>
        <tr>
            <td>type</td>
            <td><?php echo htmlspecialchars($type, ENT_QUOTES); ?></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <a href="../User/read_one.php?<?php echo "id={$userId}" ?>" class="btn btn-danger">Back</a>
            </td>
        </tr>
    </table>

</body>
</html>
