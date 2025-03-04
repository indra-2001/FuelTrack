<?php
session_start();
include '../../assets/constant/config.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['submit'])) {

        // Prepare the SQL statement for inserting data into the cash_submission table
        $stmt = $conn->prepare("INSERT INTO `cash_submission` 
            (`date`, `fueltype`, `employeeName`, `opening_read`, `closing_read`, `fuelPrice`, 
             `ActualAmount`, `AmountSubmitted`, `ExtraShort`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Apply htmlspecialchars to sanitize user inputs
        $submissionDate = htmlspecialchars($_POST['submissionDate'], ENT_QUOTES, 'UTF-8');
        $fueltype = htmlspecialchars($_POST['fueltype'], ENT_QUOTES, 'UTF-8');
        $employeeName = htmlspecialchars($_POST['employeeName'], ENT_QUOTES, 'UTF-8');
        $opening_read = htmlspecialchars($_POST['opening_read'], ENT_QUOTES, 'UTF-8');
        $closing_read = htmlspecialchars($_POST['closing_read'], ENT_QUOTES, 'UTF-8');
        $fuelPrice = htmlspecialchars($_POST['fuelPrice'], ENT_QUOTES, 'UTF-8');
        $CashSubmitted = htmlspecialchars($_POST['CashSubmitted'], ENT_QUOTES, 'UTF-8');
        $OnlineAmount = htmlspecialchars($_POST['OnlineAmount'], ENT_QUOTES, 'UTF-8');
        $Coin = htmlspecialchars($_POST['Coin'], ENT_QUOTES, 'UTF-8');
        $TestingDensity = htmlspecialchars($_POST['TestingDensity'], ENT_QUOTES, 'UTF-8');
        $ActualAmount = htmlspecialchars($_POST['ActualAmount'], ENT_QUOTES, 'UTF-8');
        $AmountSubmitted = htmlspecialchars($_POST['AmountSubmitted'], ENT_QUOTES, 'UTF-8');
        $ExtraShort = htmlspecialchars($_POST['ExtraShort'], ENT_QUOTES, 'UTF-8');
    
        // Execute the statement with sanitized values
        $stmt->execute([
            $submissionDate,$fueltype, $employeeName, $opening_read, $closing_read, $fuelPrice, 
            $ActualAmount,$AmountSubmitted, $ExtraShort
        ]);
    
        // Redirect after successful insertion
        $_SESSION['success'] = "Data successfully submitted";
        header("location:../manage_account.php");
    }
    
    
    if (isset($_POST['del_id'])) {

        $stmt = $conn->prepare("UPDATE `cash_submission` SET delete_status='1' WHERE id=? ");

        // Apply htmlspecialchars to user inputs
        $del_id = htmlspecialchars($_POST['del_id'], ENT_QUOTES, 'UTF-8');

        $stmt->execute([$del_id]);

        $_SESSION['delete'] = "delete";

        header("location:../manage_account.php");
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
