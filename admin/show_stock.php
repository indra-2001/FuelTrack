<?php
session_start();
include '../assets/constant/config.php';




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
  <div class="row tittle">

    <div class="top col-md-5 align-self-center">
      <h5>Show Stock</h5>
    </div>

    <div class="col-md-7  align-self-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">Show Stock</li>
      </ol>
    </div>
  </div>

  <div class="container-fluid">

    <!-- end page title end breadcrumb -->

    <div class="row">
      <!--   -->
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="btn-group float-left">
              <a href="add_dip.php" class="btn btn-primary mb-3">Add Dip</a>
            </div>

            <div class="table-responsive">

              <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                  <tr>
                    <th>Serial</th>
                    <th>Fuel Name</th>
                    <th>Volume</th>
                    
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Query to fetch data from the stock table and join with the fuel_category table
                  $stmt = $conn->prepare("
            SELECT s.id AS stock_id, fc.name AS fuel_name, s.volume 
            FROM `stock` s 
            JOIN `fuel_category` fc ON s.fuelType = fc.id 
            WHERE s.delete_status = '0'
        ");
                  $stmt->execute();
                  $record = $stmt->fetchAll();
                  $i = 1;

                  // Loop through the records and display the data
                  foreach ($record as $key) { ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $key['fuel_name']; ?></td>
                      <td><?php echo $key['volume']; ?></td>
                      
                    </tr>
                    <?php $i++;
                  } ?>
                </tbody>
              </table>

            </div><!--end /tableresponsive-->
          </div><!--end card-body-->
        </div><!--end card-->
      </div><!--end col-->
    </div><!--end row-->
  </div> <!-- Page content Wrapper -->

</div> <!-- content -->

<?php include('include/footer.php'); ?>


<?php if (!empty($_SESSION['success'])) { ?>
  <script>
    setTimeout(function () {
      swal({
        title: "Congratulaions!",
        text: "Data Added Successfully",
        type: "success",
        confirmButtonText: "Ok"
      }, function () {
        window.location = "manage_dip.php";
      }, 1000);
    });
  </script>
  <p><?php $_SESSION['success'] = '';
} ?></p>


<?php if (!empty($_SESSION['update'])) { ?>
  <script>
    setTimeout(function () {
      swal({
        title: "Congratulaions!",
        text: "Record Updated",
        type: "success",
        confirmButtonText: "Ok"
      }, function () {
        window.location = "manage_dip.php";
      }, 1000);
    });
  </script>
  <p><?php $_SESSION['update'] = '';
} ?></p>

<?php if (!empty($_SESSION['delete'])) { ?>
  <script>
    setTimeout(function () {
      swal({
        title: "Congratulaions!",
        text: "Record Deleted",
        type: "success",
        confirmButtonText: "Ok"
      }, function () {
        window.location = "manage_dip.php";
      }, 1000);
    });
  </script>
  <p><?php $_SESSION['delete'] = '';
} ?></p>