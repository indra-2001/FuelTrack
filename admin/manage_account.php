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
      <h5>View Employee</h5>
    </div>

    <div class="col-md-7  align-self-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">View Account</li>
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
              <a href="cash_submission.php" class="btn btn-primary mb-3">Cash Submission</a>
            </div>

            <div class="table-responsive">

              <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;" enctype="multipart/form-data">
                <thead>
                  <tr>
                    <th>Serial No</th>
                    <th>Name</th>
                    <th>Fuel Type</th>
                    <th>Opening Rd</th>
                    <th>Closing Rd</th>
                    <th>Fuel Price</th>
                    <th>Acctul Amt</th>
                    <th>Submitted Amt</th>
                    <th>Extra/Short</th>
                    <th>Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  $stmt = $conn->prepare("
                  SELECT 
                      cs.id, 
                      cs.date, 
                      cs.ActualAmount, 
                      cs.AmountSubmitted,
                      cs.AmountSubmitted,
                      cs.opening_read,
                      cs.closing_read,
                      cs.fuelPrice, 
                      cs.ExtraShort, 
                      cs.time, 
                      e.employeeName, 
                      fc.name AS fuelTypeName
                  FROM 
                      cash_submission cs
                  JOIN 
                      employee e ON cs.employeeName = e.id
                  JOIN 
                      fuel_category fc ON cs.fueltype = fc.id
                  WHERE 
                      cs.delete_status = '0'");
                  $stmt->execute();
                  $record = $stmt->fetchAll();
                  $i = 1;
                  foreach ($record as $key) { ?>


                    <tr>

                      <td><?php echo $i; ?></td>
                      <td><?php echo $key['employeeName']; ?></td>
                      <td><?php echo $key['fuelTypeName']; ?></td>
                      <td><?php echo $key['opening_read']; ?></td>
                      <td><?php echo $key['closing_read']; ?></td>
                      <td><?php echo $key['fuelPrice']; ?></td>
                      <td><?php echo $key['ActualAmount']; ?></td>
                      <td><?php echo $key['AmountSubmitted']; ?></td>
                      <td><?php echo $key['ExtraShort']; ?></td>
                      <td><?php echo $key['date']; ?></td>

                      <td>
                        <!-- <a href="#" onclick="editForm(event, <?php // echo $key['id']; ?>,'edit_cash_submission.php')"
                          class="btn btn-primary waves-effect waves-light"><i class="fa fa-edit" aria-hidden="true"></i>

                        </a> -->


                        <a href="#" class="btn btn-danger"
                          onclick="return confirm('Are you sure you want to delete this item?') && delForm(event, <?php echo $key['id']; ?>,'app/cash_crud.php' );"><i
                            class="fa fa-trash-alt" aria-hidden="true"></i></a>



                      </td>
                    </tr>
                    <?php $i++;
                  } ?>
                </tbody>
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
        window.location = "manage_account.php";
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
        window.location = "manage_account.php";
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
        window.location = "manage_account.php";
      }, 1000);
    });
  </script>
  <p><?php $_SESSION['delete'] = '';
} ?></p>