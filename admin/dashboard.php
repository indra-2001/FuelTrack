<?php
session_start();
include "../assets/constant/config.php";



try {
   $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
   echo "Connection failed: " . $e->getMessage();
}
?>
<?php include('include/sidebar.php'); ?>
<!-- Top Bar End -->
<?php include('include/header.php'); ?>
<div class="page-content-wrapper ">
   <div class="container-fluid">
      <div class="row">
         <!--   -->
         <div class="col-sm-12">
            <div class="page-title-box">
               <div class="btn-group float-right">
                  <ol class="breadcrumb hide-phone p-0 m-0">
                     <li class="breadcrumb-item active"></li>
                  </ol>
               </div>
               <h4 class="page-title">Dashboard</h4>
            </div>
         </div>
         <div class="clearfix"></div>
      </div>
      <!-- end page title end breadcrumb -->
      <div class="row dashboard">
         <div class="col-md-6">
            <div class="card bg-success">
               <div class="card-body py-4">
                  <div class="d-flex flex-row p-3">
                     <div class="col-3 align-self-center">
                        <div class="round">
                           <i class="fas fa-gas-pump"></i>
                        </div>
                     </div>
                     <div class="col-9 align-self-center text-right">
                        <div class="m-l-10">
                           <h3 class="mt-0 text-white">
                              <?php
                              $stmt = $conn->prepare("SELECT count(*) as cnt_name from fuel_tbl WHERE delete_status='0' ");
                              $stmt->execute();
                              $record = $stmt->fetch(PDO::FETCH_ASSOC); ?>
                              <?PHP echo $record['cnt_name'];
                              $name = $record['cnt_name']; ?>
                           </h3>
                           <p class="mb-0 text-white">Total Fuels</p>
                        </div>
                     </div>
                  </div>
               </div>



               <!--end card-body-->
            </div>
            <!--end card-->
         </div>


         <div class="col-md-6">
            <div class="card bg-primary">
               <div class="card-body py-4">
                  <div class="d-flex flex-row p-3">
                     <div class="col-3 align-self-center">
                        <div class="round">
                           <i class="fas fa-gas-pump"></i>
                        </div>
                     </div>
                     <div class="col-9 align-self-center text-right">
                        <div class="m-l-10">
                           <h3 class="mt-0 text-white">
                              <?php
                              // Get today's date
                              $todayDate = date('Y-m-d');

                              // Fetch total cash submission for the day (all shifts, all fuel types)
                              $stmt = $conn->prepare("
                                SELECT SUM(AmountSubmitted) AS total_cash 
                                FROM cash_submission 
                                WHERE date = ? AND delete_status='0'
                            ");
                              $stmt->execute([$todayDate]);
                              $record = $stmt->fetch(PDO::FETCH_ASSOC);

                              // Display the total cash or default to 0 if no data
                              echo number_format($record['total_cash'] ?? 0, 2);
                              ?>
                           </h3>
                           <p class="mb-0 text-white">Total Sales of the Day</p>
                        </div>
                     </div>
                  </div>
               </div>
               <!--end card-body-->
            </div>
            <!--end card-->
         </div>


         <div class="col-md-6">
            <div class="card bg-danger">
               <div class="card-body py-4">
                  <div class="d-flex flex-row p-3">
                     <div class="col-3 align-self-center">
                        <div class="round">
                           <i class=" fa fa-file"></i>
                        </div>
                     </div>
                     <div class="col-9 align-self-center text-right">
                        <div class="m-l-10">
                           <h3 class="mt-0 text-white">
                              <?php
                              $stmt = $conn->prepare("SELECT count(*) as emp from employee WHERE delete_status='0' ");
                              $stmt->execute();
                              $record = $stmt->fetch(PDO::FETCH_ASSOC); ?>
                              <?PHP echo $record['emp'];
                              $name = $record['emp']; ?>
                           </h3>
                           <p class="mb-0 text-white">Total Employees</p>
                        </div>
                     </div>
                  </div>
               </div>



               <!--end card-body-->
            </div>
            <!--end card-->
         </div>


         <div class="col-md-6">
    <div class="card bg-warning">
        <div class="card-body py-4">
            <div class="d-flex flex-row p-3">
                <div class="col-3 align-self-center">
                    <div class="round">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
                <div class="col-9 align-self-center text-right">
                    <div class="m-l-10">
                        <h3 class="mt-0 text-white">
                            <?php
                            // Get today's date
                            $todayDate = date('Y-m-d');

                            // Query to calculate the total extra/short from the ExtraShort column
                            $stmt = $conn->prepare("
                                SELECT SUM(ExtraShort) AS total_extra_short 
                                FROM cash_submission 
                                WHERE date = ? AND delete_status = '0'
                            ");
                            $stmt->execute([$todayDate]);
                            $record = $stmt->fetch(PDO::FETCH_ASSOC);

                            // Get the total extra/short value
                            $total_extra_short = $record['total_extra_short'] ?? 0;

                            // Check if the total is negative (short) or positive (extra)
                            if ($total_extra_short < 0) {
                                echo "Short: " . number_format(abs($total_extra_short), 2);
                            } else {
                                echo "Extra: " . number_format($total_extra_short, 2);
                            }
                            ?>
                        </h3>
                        <p class="mb-0 text-white">Total Extra/Short for the Day</p>
                    </div>
                </div>
            </div>
        </div>
        <!--end card-body-->
    </div>
    <!--end card-->
</div>

         <!--end card-body-->
      </div>
      <!--end card-->
   </div>
</div>
<!--end row-->


<div class="card">
   <div class="card-body">
      <h3>Today's Sale</h3>
      <br>
      <div class="table-responsive" style="max-height: 400px; overflow-y: auto; border: 1px solid #ddd;">
         <table class="table table-striped table-bordered"
            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
               <tr>
                  <th>#</th>
                  <th>Fuel Type</th>
                  <th>Units Sold</th>
                  <th>Price Per Unit</th>
                  <th>Total Amount</th>
                  <th>Amount Submitted</th>
                  <th>Extra/Short</th>
               </tr>
            </thead>
            <tbody>
               <?php
               // Get today's date
               $todayDate = date('Y-m-d');

               // Fetch all fuel categories
               $fuelQuery = "SELECT id, name FROM fuel_category WHERE delete_status='0'";
               $fuelStmt = $conn->prepare($fuelQuery);
               $fuelStmt->execute();
               $fuelCategories = $fuelStmt->fetchAll(PDO::FETCH_ASSOC);

               $i = 1;

               foreach ($fuelCategories as $fuel) {
                  // Get cash submission data for the specific fuel type
                  $cashQuery = "SELECT 
                                    SUM(closing_read - opening_read) AS total_units,
                                    AVG(fuelPrice) AS price_per_unit,
                                    SUM(AmountSubmitted) AS total_submitted ,
                                    ExtraShort
                                FROM cash_submission 
                                WHERE fueltype = ? AND `date` = ?";
                  $cashStmt = $conn->prepare($cashQuery);
                  $cashStmt->execute([$fuel['id'], $todayDate]);
                  $cashData = $cashStmt->fetch(PDO::FETCH_ASSOC);

                  // Default values if no submission exists
                  $totalUnits = $cashData['total_units'] ?? 0;
                  $pricePerUnit = $cashData['price_per_unit'] ?? 0;
                  $totalSubmitted = $cashData['total_submitted'] ?? 0;
                  $ExtraShort = $cashData['ExtraShort'] ?? 0;

                  // Calculate total amount and extra/short
                  $totalAmount = $totalUnits * $pricePerUnit;
                 
                  ?>
                  <tr>
                     <td><?= $i; ?></td>
                     <td><?= htmlspecialchars($fuel['name']); ?></td>
                     <td><?= number_format($totalUnits, 2); ?></td>
                     <td><?= number_format($pricePerUnit, 2); ?></td>
                     <td><?= number_format($totalAmount, 2); ?></td>
                     <td><?= number_format($totalSubmitted, 2); ?></td>
                     <td><?= number_format($ExtraShort, 2); ?></td>
                  </tr>
                  <?php
                  $i++;
               }
               ?>
            </tbody>
         </table>
      </div><!-- End table-responsive -->
   </div><!-- End card-body -->
</div><!-- End card -->








</div>
<!-- Page content Wrapper -->
</div>
<!-- content -->
<?php include('include/footer.php'); ?>