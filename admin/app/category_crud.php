<?php
session_start();
include '../../assets/constant/config.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['submit'])) {

        $stmt = $conn->prepare("INSERT INTO `fuel_category`(`name`) VALUES (?)");

        $stmt->execute([htmlspecialchars($_POST['name'])]);
        // Get the ID of the newly inserted fuel category
        $fuelCategoryId = $conn->lastInsertId();

        // Insert an initial entry into the stock table with volume 0
        $stockStmt = $conn->prepare("INSERT INTO `stock`(`fuelType`, `volume`) VALUES (?, 0)");
        $stockStmt->execute([$fuelCategoryId]);

        $_SESSION['success'] = "success";

        header("location:../manage_categories.php");
    }

    if (isset($_POST['update'])) {

        $stmt = $conn->prepare("UPDATE `fuel_category` SET `name`=? WHERE id=?");

        $stmt->execute([htmlspecialchars($_POST['name']), htmlspecialchars($_POST['id'])]);

        $_SESSION['update'] = "update";
        header("location:../manage_categories.php");
    }

    if (isset($_POST['del_id'])) {
        // Delete the corresponding entry from the stock table
        $stockStmt = $conn->prepare("DELETE FROM `stock` WHERE fuelType = ?");
        $stockStmt->execute([htmlspecialchars($_POST['del_id'])]);

        // Delete from the fuel_category table
        $stmt = $conn->prepare("DELETE FROM `fuel_category` WHERE id = ?");
        $stmt->execute([htmlspecialchars($_POST['del_id'])]);

       


        $_SESSION['delete'] = "delete";

        header("location:../manage_categories.php");
    }
} catch (PDOException $e) {
    echo "Connection failed: " . htmlspecialchars($e->getMessage());
}
