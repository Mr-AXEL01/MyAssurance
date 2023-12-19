<?php
include_once "db.php";

$sql = "CREATE TABLE IF NOT EXISTS Client (
    ClientID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255) NOT NULL,
    Age INT NOT NULL,
    SoftDelete BOOLEAN DEFAULT 0
)";
$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS Assurance (
    AssuranceID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255) NOT NULL,
    SoftDelete BOOLEAN DEFAULT 0
)";
$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS Article (
    ArticleID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255) NOT NULL,
    AssuranceID INT,
    FOREIGN KEY (AssuranceID) REFERENCES Assurance(AssuranceID) ON DELETE CASCADE,
    SoftDelete BOOLEAN DEFAULT 0
)";
$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS Claim (
    ClaimID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(255) NOT NULL,
    Description VARCHAR(355),
    ClientID INT,
    ArticleID INT,
    FOREIGN KEY (ClientID) REFERENCES Client(ClientID) ON DELETE CASCADE,
    FOREIGN KEY (ArticleID) REFERENCES Article(ArticleID) ON DELETE CASCADE,
    SoftDelete BOOLEAN DEFAULT 0
)";
$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS ClientAssurance (
    ClientID INT,
    AssuranceID INT,
    FOREIGN KEY (ClientID) REFERENCES Client(ClientID) ON DELETE CASCADE,
    FOREIGN KEY (AssuranceID) REFERENCES Assurance(AssuranceID) ON DELETE CASCADE,
    PRIMARY KEY (ClientID, AssuranceID)
)";
$conn->query($sql);

echo "Tables created successfully";
?>
