<?php
include_once "db.php";

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['client_id'])) {
    $clientID = $_GET['client_id'];
    $deleteClientQuery = "UPDATE Client SET SoftDelete = 1 WHERE ClientID = $clientID";
    $conn->query($deleteClientQuery);
    header("Location: clients.php");
    exit();
}

$clientsQuery = "SELECT * FROM Client WHERE SoftDelete = 0";
$clientsResult = $conn->query($clientsQuery);

if ($clientsResult) {
    $clients = [];
    while ($client = $clientsResult->fetch_assoc()) {
        $clients[] = $client;
    }
} else {
    die("Error retrieving clients");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#clientsTable').DataTable();
        });
    </script>
</head>

<body>
    <?php include_once "header.php"; ?>
    <div class="container mx-auto h-[85vh] p-4">
        <h2 class="text-3xl font-bold mb-4">Clients</h2>
        <a href="addClients.php" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md inline-block mb-4">Add Client</a>
        <table id="clientsTable" class="table-auto bg-white shadow-md rounded">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Age</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client) : ?>
                    <tr>
                        <td class="border px-4 py-2"><?= $client['ClientID'] ?></td>
                        <td class="border px-4 py-2"><?= $client['Name'] ?></td>
                        <td class="border px-4 py-2"><?= $client['Age'] ?></td>
                        <td class="border px-4 py-2">
                            <a href="clients.php?action=delete&client_id=<?= $client['ClientID'] ?>" onclick="return confirm('Are you sure you want to delete this client?')" class="text-red-500">Delete</a>
                            <a href="Claims.php?client_id=<?= $client['ClientID'] ?>" class="ml-2 bg-gray-500 hover:bg-gray-600 text-white py-1 px-2 rounded-md">Show Details</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    </div>
    <?php include_once "footer.php"; ?>
</body>

</html>
