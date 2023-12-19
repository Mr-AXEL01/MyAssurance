<?php
include_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $age = $_POST["age"];

    $insertClientQuery = "INSERT INTO Client (Name, Age) VALUES ('$name', $age)";
    $conn->query($insertClientQuery);

    header("Location: clients.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Client</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <?php include_once "header.php"; ?>
    <div class="container mx-auto h-[85vh] p-4">
        <h2 class="text-3xl font-bold mb-4">Add Client</h2>
        <form action="addClients.php" method="POST">
            <label for="name" class="block mb-2">Name:</label>
            <input type="text" id="name" name="name" class="border p-2 mb-4 w-full" required>

            <label for="age" class="block mb-2">Age:</label>
            <input type="number" id="age" name="age" class="border p-2 mb-4 w-full" required>

            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md">Add Client</button>
        </form>
    </div>
    <?php include_once "footer.php"; ?>
</body>

</html>
