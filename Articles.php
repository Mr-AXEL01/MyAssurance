<?php
include_once "db.php";

if (isset($_GET['claim_id'])) {
    $claimID = $_GET['claim_id'];
    $claimQuery = "SELECT * FROM Claim WHERE ClaimID = $claimID AND SoftDelete = 0";
    $claimResult = $conn->query($claimQuery);

    if ($claimResult && $claimResult->num_rows > 0) {
        $claim = $claimResult->fetch_assoc();
        $articlesQuery = "SELECT ArticleID, Name FROM Article WHERE AssuranceID = $claimID AND SoftDelete = 0";
        $articlesResult = $conn->query($articlesQuery);

        if ($articlesResult) {
            $articles = $articlesResult->fetch_all(MYSQLI_ASSOC);
        } else {
            die("Error retrieving articles. Error: " . $conn->error);
        }
    } else {
        die("Claim not found");
    }
} else {
    $allArticlesQuery = "SELECT * FROM Article WHERE SoftDelete = 0";
    $allArticlesResult = $conn->query($allArticlesQuery);
    
    if ($allArticlesResult) {
        $articles = $allArticlesResult->fetch_all(MYSQLI_ASSOC);
    } else {
        die("Error retrieving articles. Error: " . $conn->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#articlesTable').DataTable();
        });
    </script>
</head>

<body>
    <?php include_once "header.php"; ?>
    <div class="container mx-auto h-[85vh] p-4">
        <h2 class="text-3xl font-bold mb-4">
            <?php
            if (isset($claim)) {
                echo "Articles - " . $claim['Title'];
            } else {
                echo "All Articles";
            }
            ?>
        </h2>
        <a href="addArticles.php" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md inline-block mb-4">Add Article</a>
        <table id="articlesTable" class="table-auto bg-white shadow-md rounded">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article) : ?>
                    <tr>
                        <td class="border px-4 py-2"><?= $article['ArticleID'] ?></td>
                        <td class="border px-4 py-2"><?= $article['Name'] ?></td>
                        <td class="border px-4 py-2">
                            <a href="Articles.php?action=delete&article_id=<?= $article['ArticleID'] ?>" onclick="return confirm('Are you sure you want to delete this article?')" class="text-red-500">Delete</a>
                            <a href="Assurances.php?article_id=<?= $article['ArticleID'] ?>" class="ml-2 bg-gray-500 hover:bg-gray-600 text-white py-1 px-2 rounded-md">Show Assurances</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include_once "footer.php"; ?>
</body>

</html>
