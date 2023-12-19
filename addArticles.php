<?php
include_once "db.php";
$assurancesQuery = "SELECT * FROM Assurance WHERE SoftDelete = 0";
$assurancesResult = $conn->query($assurancesQuery);

if ($assurancesResult) {
    $assurances = $assurancesResult->fetch_all(MYSQLI_ASSOC);
} else {
    die("Error retrieving assurances");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $assuranceID = $_POST["assurance_id"];

    $insertArticleQuery = "INSERT INTO Article (Name, AssuranceID) VALUES ('$name', $assuranceID)";
    $conn->query($insertArticleQuery);

    header("Location: articles.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Article</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <?php include_once "header.php"; ?>
    <div class="container mx-auto h-[85vh] p-4">
        <h2 class="text-3xl font-bold mb-4">Add Article</h2>
        <form action="addArticles.php" method="POST">
            <label for="name" class="block mb-2">Name:</label>
            <input type="text" id="name" name="name" class="border p-2 mb-4 w-full" required>

            <label for="assurance_id" class="block mb-2">Assurance:</label>
            <select id="assurance_id" name="assurance_id" class="border p-2 mb-4 w-full" required>
                <?php foreach ($assurances as $assurance) : ?>
                    <option value="<?= $assurance['AssuranceID'] ?>"><?= $assurance['Name'] ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md">Add Article</button>
        </form>
    </div>
    <?php include_once "footer.php"; ?>
</body>

</html>
