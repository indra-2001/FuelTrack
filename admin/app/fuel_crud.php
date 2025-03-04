<?php
session_start();
include '../../assets/constant/config.php';
     
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['submit'])) {
        $stmt = $conn->prepare("INSERT INTO `fuel_tbl` (`fuel_category_id`, `openning_stock`, `rate`, `unit_price`, `invoice_number`, `date`) 
                                VALUES (?, ?, ?, ?, ?, ?)");
    
        $stmt->execute([
            htmlspecialchars($_POST['categoryName']),   // `fuel_category_id`
            htmlspecialchars($_POST['openning_stock']),  // `openning_stock`
            htmlspecialchars($_POST['rate']),           // `rate`
            htmlspecialchars($_POST['unit_price']),     // `unit_price`
            htmlspecialchars($_POST['invoiceNumber']),            // `invoice_number`
            htmlspecialchars($_POST['date'])            // `date`
        ]);

        // Get the fuel category ID and the opening stock
        $fuelCategoryId = htmlspecialchars($_POST['categoryName']);
        $newOpeningStock = htmlspecialchars($_POST['openning_stock']);

        // Update the stock volume for the specific fuel category by adding the new opening stock
        $stmtStockUpdate = $conn->prepare("UPDATE `stock` 
                                          SET `volume` = `volume` + ? 
                                          WHERE `fuelType` = ? AND `delete_status` = 0");
        $stmtStockUpdate->execute([$newOpeningStock, $fuelCategoryId]);
    
        $_SESSION['success'] = "success";
    
        header("location:../manage_fuel.php");
    }
    
    if (isset($_POST['update'])) {
    // Fetch the old `openning_stock` before updating
     // Step 1: Fetch the current opening stock and fuel_category_id
     $stmt1 = $conn->prepare("SELECT `openning_stock`, `fuel_category_id` FROM `fuel_tbl` WHERE `id` = ?");
     $stmt1->execute([htmlspecialchars($_POST['id'])]);
     $currentRecord = $stmt1->fetch(PDO::FETCH_ASSOC);

     if ($currentRecord) {
         $currentOpeningStock = $currentRecord['openning_stock'];
         $fuelCategoryId = $currentRecord['fuel_category_id'];

         // Step 2: Update stock volume (subtract current, add updated)
         // Subtract the current opening stock from the stock table
         $stmt2 = $conn->prepare("UPDATE `stock` SET `volume` = `volume` - ? WHERE `fuelType` = ?");
         $stmt2->execute([$currentOpeningStock, $fuelCategoryId]);

         // Add the updated opening stock to the stock table
         $updatedOpeningStock = htmlspecialchars($_POST['openning_stock']);
         $stmt3 = $conn->prepare("UPDATE `stock` SET `volume` = `volume` + ? WHERE `fuelType` = ?");
         $stmt3->execute([$updatedOpeningStock, htmlspecialchars($_POST['fuel_category_id'])]);

         // Step 3: Update the fuel record in `fuel_tbl`
         $stmt4 = $conn->prepare("
             UPDATE `fuel_tbl`
             SET `fuel_category_id` = ?, `openning_stock` = ?, `rate` = ?, `unit_price` = ?, `invoice_number` = ?, `date` = ?
             WHERE `id` = ?
         ");
         $stmt4->execute([
             htmlspecialchars($_POST['fuel_category_id']),
             $updatedOpeningStock,
             htmlspecialchars($_POST['rate']),
             htmlspecialchars($_POST['unit_price']),
             htmlspecialchars($_POST['invoice_number']),
             htmlspecialchars($_POST['date']),
             htmlspecialchars($_POST['id']),
         ]);

         // Commit transaction
         $conn->commit();
         $_SESSION['update'] = "update";
         header("location:../manage_fuel.php");
        }
}

   



    if (isset($_POST['del_id'])) {
        // Step 1: Fetch the current `opening_stock` and `fuel_category_id` for the record to be deleted
        $stmt1 = $conn->prepare("SELECT `openning_stock`, `fuel_category_id` FROM `fuel_tbl` WHERE `id` = ?");
        $stmt1->execute([htmlspecialchars($_POST['del_id'])]);
        $fuelData = $stmt1->fetch(PDO::FETCH_ASSOC);

       
        $openingStock = $fuelData['openning_stock'];
        $fuelCategoryId = $fuelData['fuel_category_id'];

        // Step 2: Subtract `opening_stock` from the `stock` table for the corresponding `fuel_category_id`
        $stmt2 = $conn->prepare("UPDATE `stock` SET `volume` = `volume` - ? WHERE `fuelType` = ?");
        $stmt2->execute([$openingStock, $fuelCategoryId]);

       
        $stmt = $conn->prepare("DELETE FROM `fuel_tbl` WHERE id=?");

        $stmt->execute([htmlspecialchars($_POST['del_id'])]);

        $_SESSION['delete'] = "delete";

        header("location:../manage_fuel.php");
    }
} catch (PDOException $e) {
    echo "Connection failed: " . htmlspecialchars($e->getMessage());
}
     