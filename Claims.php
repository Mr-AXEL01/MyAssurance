<?php
include_once "db.php";

if (isset($_GET['client_id'])) {
    $clientID = $_GET['client_id'];
    $clientQuery = "SELECT * FROM Client WHERE ClientID = $clientID AND SoftDelete = 0";
    $clientResult = $conn->query($clientQuery);

    if ($clientResult && $clientResult->num_rows > 0) {
        $client = $clientResult->fetch_assoc();
        $claimsQuery = "SELECT * FROM Claim WHERE ClientID = $clientID AND SoftDelete = 0";
        $claimsResult = $conn->query($claimsQuery);

        if ($claimsResult) {
            $claims = $claimsResult->fetch_all(MYSQLI_ASSOC);
        } else {
            die("Error retrieving claims");
        }
    } else {
        die("Client not found");
    }
} else {
    $allClaimsQuery = "SELECT * FROM Claim WHERE SoftDelete = 0";
    $allClaimsResult = $conn->query($allClaimsQuery);

    if ($allClaimsResult) {
        $claims = $allClaimsResult->fetch_all(MYSQLI_ASSOC);
    } else {
        die("Error retrieving claims");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <?php include_once "header.php"; ?>
    <div class="container mx-auto h-[85vh] p-4">
        <h2 class="text-3xl font-bold mb-4">
            <?php
            if (isset($client)) {
                echo "Client Claims - " . $client['Name'];
            } else {
                echo "All Claims";
            }
            ?>
        </h2>
        <a href="addClaims.php" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md inline-block mb-4">Add Claim</a>
        <table id="claimsTable" class="table-auto bg-white shadow-md rounded">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Title</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($claims as $claim) : ?>
                    <tr>
                        <td class="border px-4 py-2"><?= $claim['ClaimID'] ?></td>
                        <td class="border px-4 py-2"><?= $claim['Title'] ?></td>
                        <td class="border px-4 py-2"><?= $claim['Description'] ?></td>
                        <td class="border px-4 py-2">
                            <a href="Claims.php?action=delete&client_id=<?= $claim['ClaimID'] ?>" onclick="return confirm('Are you sure you want to delete this claim?')" class="text-red-500">Delete</a>
                            <a href="Articles.php?claim_id=<?= $claim['ClaimID'] ?>" class="ml-2 bg-gray-500 hover:bg-gray-600 text-white py-1 px-2 rounded-md">Show Details</a>
                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#claimsTable').DataTable();
        });
    </script>
    
    <?php include_once "footer.php"; ?>
</body>

</html>
