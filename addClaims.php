<?php
include_once "db.php";
$clientsQuery = "SELECT * FROM Client WHERE SoftDelete = 0";
$clientsResult = $conn->query($clientsQuery);

if ($clientsResult) {
    $clients = $clientsResult->fetch_all(MYSQLI_ASSOC);
} else {
    die("Error retrieving clients");
}

$articlesQuery = "SELECT * FROM Article WHERE SoftDelete = 0";
$articlesResult = $conn->query($articlesQuery);

if ($articlesResult) {
    $articles = $articlesResult->fetch_all(MYSQLI_ASSOC);
} else {
    die("Error retrieving articles");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $clientID = $_POST["client_id"];
    $articleID = $_POST["article_id"];

    $insertClaimQuery = "INSERT INTO Claim (Title, Description, ClientID, ArticleID) VALUES ('$title', '$description', $clientID, $articleID)";
    $conn->query($insertClaimQuery);

    header("Location: claims.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Claim</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <?php include_once "header.php"; ?>
    <div class="container mx-auto h-[85vh] p-4">
        <h2 class="text-3xl font-bold mb-4">Add Claim</h2>
        <form action="addClaims.php" method="POST">
            <label for="title" class="block mb-2">Title:</label>
            <input type="text" id="title" name="title" class="border p-2 mb-4 w-full" required>

            <label for="description" class="block mb-2">Description:</label>
            <textarea id="description" name="description" class="border p-2 mb-4 w-full" required></textarea>

            <label for="client_id" class="block mb-2">Client:</label>
            <select id="client_id" name="client_id" class="border p-2 mb-4 w-full" required>
                <?php foreach ($clients as $client) : ?>
                    <option value="<?= $client['ClientID'] ?>"><?= $client['Name'] ?></option>
                <?php endforeach; ?>
            </select>

            <label for="article_id" class="block mb-2">Article:</label>
            <select id="article_id" name="article_id" class="border p-2 mb-4 w-full" required>
                <?php foreach ($articles as $article) : ?>
                    <option value="<?= $article['ArticleID'] ?>"><?= $article['Name'] ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md">Add Claim</button>
        </form>
    </div>
    <?php include_once "footer.php"; ?>
</body>

</html>
