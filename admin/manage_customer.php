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
      <h5>View Customer</h5>
    </div>

    <div class="col-md-7  align-self-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">View Customer</li>
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
              <a href="add_customer.php" class="btn btn-primary mb-3">Add Customer</a>
            </div>

            <div class="table-responsive">

              <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" enctype="multipart/form-data">
                <thead>
                  <tr>
                    <th>Serial</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  $stmt = $conn->prepare("SELECT * FROM `customer` WHERE delete_status='0' ");
                  $stmt->execute();
                  $record = $stmt->fetchAll();
                  $i = 1;
                  foreach ($record as $key) { ?>


                    <tr>

                      <td><?php echo $i; ?></td>
                      <td><?php echo $key['brandName']; ?></td>
                      <td><?php echo $key['customerEmail']; ?></td>
                      <td><?php echo $key['customerPhone']; ?></td>
                      <td><?php echo $key['customerAddress']; ?></td>
                      <td><?php echo $key['brandStatus']; ?></td>

                      <td>
                        <a href="#" onclick="editForm(event, <?php echo $key['id']; ?>,'edit_customer.php')" class="btn btn-primary waves-effect waves-light"><i class="fa fa-edit" aria-hidden="true"></i>

                        </a>


                        <a href="#" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?') && delForm(event, <?php echo $key['id']; ?>,'app/customer_crud.php' );"><i class="fa fa-trash-alt" aria-hidden="true"></i></a>



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
    setTimeout(function() {
      swal({
        title: "Congratulaions!",
        text: "Data Added Successfully",
        type: "success",
        confirmButtonText: "Ok"
      }, function() {
        window.location = "manage_customer.php";
      }, 1000);
    });
  </script>
  <p><?php $_SESSION['success'] = '';
    } ?></p>


  <?php if (!empty($_SESSION['update'])) { ?>
    <script>
      setTimeout(function() {
        swal({
          title: "Congratulaions!",
          text: "Record Updated",
          type: "success",
          confirmButtonText: "Ok"
        }, function() {
          window.location = "manage_customer.php";
        }, 1000);
      });
    </script>
    <p><?php $_SESSION['update'] = '';
      } ?></p>

    <?php if (!empty($_SESSION['delete'])) { ?>
      <script>
        setTimeout(function() {
          swal({
            title: "Congratulaions!",
            text: "Record Deleted",
            type: "success",
            confirmButtonText: "Ok"
          }, function() {
            window.location = "manage_customer.php";
          }, 1000);
        });
      </script>
      <p><?php $_SESSION['delete'] = '';
        } ?></p>