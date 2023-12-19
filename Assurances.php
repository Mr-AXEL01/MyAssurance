<?php
include_once "db.php";

if (isset($_GET['article_id'])) {
    $articleID = $_GET['article_id'];
    $articleQuery = "SELECT * FROM Article WHERE ArticleID = ? AND SoftDelete = 0";
    $stmtArticle = $conn->prepare($articleQuery);
    $stmtArticle->bind_param("i", $articleID);
    $stmtArticle->execute();
    $articleResult = $stmtArticle->get_result();

    if ($articleResult && $articleResult->num_rows > 0) {
        $article = $articleResult->fetch_assoc();
        $assurancesQuery = "SELECT a.AssuranceID, a.Name FROM Assurance a
                            JOIN Article ar ON a.AssuranceID = ar.AssuranceID
                            WHERE ar.ArticleID = ? AND a.SoftDelete = 0";
        $stmt = $conn->prepare($assurancesQuery);
        $stmt->bind_param("i", $articleID);
        $stmt->execute();
        $assurancesResult = $stmt->get_result();

        if ($assurancesResult) {
            $assurances = $assurancesResult->fetch_all(MYSQLI_ASSOC);
        } else {
            die("Error retrieving assurances. Error: " . $stmt->error);
        }
    } else {
        die("Article not found");
    }
} else {
    $allAssurancesQuery = "SELECT * FROM Assurance WHERE SoftDelete = 0";
    $allAssurancesResult = $conn->query($allAssurancesQuery);

    if ($allAssurancesResult) {
        $assurances = $allAssurancesResult->fetch_all(MYSQLI_ASSOC);
    } else {
        die("Error retrieving assurances. Error: " . $conn->error);
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assurances</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#assurancesTable').DataTable();
        });
    </script>
</head>

<body>
    <?php include_once "header.php"; ?>
    <div class="container mx-auto h-[85vh] p-4">
        <h2 class="text-3xl font-bold mb-4">Assurances</h2>
        <a href="addAssurances.php" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md inline-block mb-4">Add Assurance</a>
        <table id="assurancesTable" class="table-auto bg-white shadow-md rounded">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assurances as $assurance) : ?>
                    <tr>
                        <td class="border px-4 py-2"><?= $assurance['AssuranceID'] ?></td>
                        <td class="border px-4 py-2"><?= $assurance['Name'] ?></td>
                        <td class="border px-4 py-2">
                            <a href="assurances.php?action=delete&assurance_id=<?= $assurance['AssuranceID'] ?>" onclick="return confirm('Are you sure you want to delete this assurance?')" class="text-red-500">Delete</a>
                            <a href="client_details.php?client_id=<?= $client['ClientID'] ?>" class="ml-2 bg-gray-500 hover:bg-gray-600 text-white py-1 px-2 rounded-md">Show Details</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include_once "footer.php"; ?>
</body>

</html>
