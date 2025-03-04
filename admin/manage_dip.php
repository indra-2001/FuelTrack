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
      <h5>View DIP</h5>
    </div>

    <div class="col-md-7  align-self-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">View Dip</li>
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
                style="border-collapse: collapse; border-spacing: 0; width: 100%;" enctype="multipart/form-data">
                <thead>
                  <tr>
                    <th>Serial</th>
                    <th>Date</th>
                    <th>Fuel Type</th>
                    <th>Dip</th>
                    <th>Density_hydro</th>
                    <th>Density_temp</th>
                    <th>Density_value</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $stmt = $conn->prepare("
    SELECT dd.*, fc.name AS fuel_type_name 
    FROM `dip_density` dd 
    JOIN `fuel_category` fc ON dd.fuel_type = fc.id 
    WHERE dd.delete_status='0'
");
                  $stmt->execute();
                  $record = $stmt->fetchAll();
                  $i = 1;
                  foreach ($record as $key) { ?>

                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $key['record_date']; ?></td>
                      <td><?php echo $key['fuel_type_name']; ?></td> <!-- Updated to show the fuel type name -->
                      <td><?php echo $key['dip']; ?></td>
                      <td><?php echo $key['density_hydro']; ?></td>
                      <td><?php echo $key['density_temp']; ?></td>
                      <td><?php echo $key['density_value']; ?></td>

                      <td>
                        <a href="#" onclick="editForm(event, 
             <?php echo $key['id']; ?>,'edit_dip.php')" class="btn btn-primary waves-effect waves-light">
                          <i class="fa fa-edit" aria-hidden="true"></i>
                        </a>

                        <a href="#" class="btn btn-danger"
                          onclick="return confirm('Are you sure you want to delete this item?') && delForm(event, <?php echo $key['id']; ?>,'app/dip_crud.php');">
                          <i class="fa fa-trash-alt" aria-hidden="true"></i>
                        </a>
                      </td>
                    </tr>
                    <?php $i++;
                  } ?>


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