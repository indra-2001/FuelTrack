<?php
session_start();
include '../../assets/constant/config.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    if (isset($_POST['submit'])) {
        // Sanitize and validate form data
        $record_date = htmlspecialchars($_POST['record_date'], ENT_QUOTES, 'UTF-8');
        $fuel_type = htmlspecialchars($_POST['fuel_type'], ENT_QUOTES, 'UTF-8');
        $dip = htmlspecialchars($_POST['dip'], ENT_QUOTES, 'UTF-8');
        $density_hydro = htmlspecialchars($_POST['hydrometer'], ENT_QUOTES, 'UTF-8');
        $density_temp = htmlspecialchars($_POST['temp'], ENT_QUOTES, 'UTF-8');
        $density_value = htmlspecialchars($_POST['density'], ENT_QUOTES, 'UTF-8');
        
        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO `dip_density` (`record_date`, `fuel_type`, `dip`, `density_hydro`, `density_temp`, `density_value`) VALUES (?, ?, ?, ?, ?, ?)");
        
        // Bind parameters and execute
        $stmt->execute([$record_date, $fuel_type, $dip, $density_hydro, $density_temp, $density_value]);
    
        
        $_SESSION['success'] = "success";

        header("location:../manage_dip.php");
    }

    if (isset($_POST['update'])) {

        $stmt = $conn->prepare("UPDATE `dip_density` SET `record_date`=?, `fuel_type`=?, `dip`=?,`density_hydro`=?, `density_temp`=?, `density_value`=? WHERE id=? ");

       
        $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
        $record_date = htmlspecialchars($_POST['record_date'], ENT_QUOTES, 'UTF-8');
        $fuel_type = htmlspecialchars($_POST['fuel_type'], ENT_QUOTES, 'UTF-8');
        $dip = htmlspecialchars($_POST['dip'], ENT_QUOTES, 'UTF-8');
        $density_hydro = htmlspecialchars($_POST['hydrometer'], ENT_QUOTES, 'UTF-8');
        $density_temp = htmlspecialchars($_POST['temp'], ENT_QUOTES, 'UTF-8');
        $density_value = htmlspecialchars($_POST['density'], ENT_QUOTES, 'UTF-8');
        
        
        $stmt->execute([$record_date, $fuel_type, $dip, $density_hydro, $density_temp, $density_value,$id]);
        $_SESSION['update'] = "update";
        header("location:../manage_dip.php");
    }

    if (isset($_POST['del_id'])) {

        $stmt = $conn->prepare("UPDATE `dip_density` SET delete_status='1' WHERE id=? ");

        // Apply htmlspecialchars to user inputs
        $del_id = htmlspecialchars($_POST['del_id'], ENT_QUOTES, 'UTF-8');

        $stmt->execute([$del_id]);

        $_SESSION['delete'] = "delete";

        header("location:../manage_dip.php");
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
