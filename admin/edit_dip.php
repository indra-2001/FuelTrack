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
            <h5>Edit Dip</h5>
        </div>

        <div class="col-md-7  align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Edit Dip</li>
            </ol>
        </div>
    </div>



    <div class="container-fluid">
        <div class="row">
            <!--   -->
            <div class="col-lg-8" style="margin-left: 10%;">
                <div class="card">
                    <div class="card-body">

                        <div class="tab-content">

                            <div class="tab-pane active p-3" id="home" role="tabpanel">


                                <form id="add_employee" method="POST" action="app/dip_crud.php">
                                    <?php
                                    $stmt = $conn->prepare("SELECT * FROM `dip_density` WHERE id='" . $_POST['id'] . "' ");

                                    $stmt->execute();
                                    $record = $stmt->fetchAll();

                                    foreach ($record as $key) {

                                        ?>

                                        <input class="form-control" type="hidden" name="id"
                                            value="<?php echo $key['id']; ?>">
                                        <div class="form-group">
                                            <div class="row">
                                                <!--   -->
                                                <label class="col-sm-3 control-label">Date</label>
                                                <div class="col-sm-9">
                                                    <input type="date" class="form-control" id="date" placeholder="date"
                                                        value="<?php echo $key['record_date'] ?>" name="record_date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <!--   -->
                                                <label class="col-sm-3 control-label">Fuel Type</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="fuel_type" name="fuel_type">
                                                        <option value="">SELECT</option>
                                                        <?php
                                                        $stmt = $conn->prepare("SELECT id, name FROM fuel_category WHERE delete_status='0'");
                                                        $stmt->execute();
                                                        $records = $stmt->fetchAll();

                                                        if (!empty($records)) { // Check if there are records
                                                            foreach ($records as $row) {
                                                                // Check if this option should be selected
                                                                $selected = ($row['id'] == $key['fuel_type']) ? 'selected="selected"' : '';
                                                                ?>
                                                                <option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>>
                                                                    <?php echo $row['name']; ?>
                                                                </option>
                                                                <?php
                                                            }
                                                        } else { // If no records are found
                                                            echo "<option value=''>No options available</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <!--   -->
                                                <label class="col-sm-3 control-label">Dip</label>
                                                <div class="col-sm-9">
                                                    <input type="digit" class="form-control" id="dip" placeholder="Dip"
                                                        value="<?php echo $key['dip'] ?>" name="dip">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <!--   -->
                                                <label class="col-sm-3 control-label">Density</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" id="hydrometer"
                                                        placeholder="hydrometer"
                                                        value="<?php echo $key['density_hydro'] ?>"
                                                        name="hydrometer">
                                                    <input type="number" class="form-control" id="temp"
                                                        placeholder="temp"
                                                        value="<?php echo $key['density_temp'] ?>"
                                                        name="temp">
                                                    <input type="number" class="form-control" id="density"
                                                        placeholder="density"
                                                        value="<?php echo $key['density_value'] ?>"
                                                        name="density">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <button class="btn btn-primary" type="submit" name="update" onclick="validateDip()">Submit</button>
                                        </div>

                                    <?php } ?>
                                </form>


                            </div>
                        </div>

                    </div>
                </div><!--end card-->
            </div><!--end col-->
        </div><!--end row-->
    </div> <!-- Page content Wrapper -->
</div> <!-- content -->

<?php include('include/footer.php'); ?>


<p id="message"></p>
<script>
    function validateDip() {
        const selectedOption = document.getElementById("fuel_type").value;
    if (selectedOption === "") {
      event.preventDefault(); // Prevent form submission
     
     alert(" Please select an option.");
    } else {
      document.getElementById("message").innerText = "";
      // proceed with form submission
    }

        // Custom method to check if the input contains only spaces
        $.validator.addMethod("noSpacesOnly", function (value, element) {
            return value.trim() !== '';
        }, "Please enter a non-empty value");

        // Custom method to check if the input contains only alphabet characters
        $.validator.addMethod("lettersonly", function (value, element) {
            return /^[a-zA-Z\s]*$/.test(value);
        }, "Please enter alphabet characters only");

        // Custom method to check if the input contains only digits
        $.validator.addMethod("noDigits", function (value, element) {
            return !/\d/.test(value);
        }, "Please enter a value without digits");

        $('#add_dip').validate({
            rules: {
                record_date: {
                    required: true,
                    noSpacesOnly: true,
                },
                fuel_type: {
                    required: true,
                    digit: true
                },
                dip: {
                    required: true,
                    noSpacesOnly: true,
                    digits: true,
                    maxlength: 40,
                    minlength: 0
                },
                density_hydro: {
                    required: true,
                    noSpacesOnly: true,
                    digits: true,
                    minlength: 0
                },
                density_temp: {
                    required: true,
                    noSpacesOnly: true,
                    digits: true,
                    minlength: 0
                },
                density_value: {
                    required: true,
                    noSpacesOnly: true,
                    digits: true,
                    minlength: 0
                },
            },
            messages: {
                employeeName: {
                    required: "Please enter a Employee name",
                    lettersonly: "Only alphabet characters are allowed"
                },
                employeeEmail: {
                    required: "Please enter a Employee email",
                    email: "Please enter a valid email address"
                },
                employeePhone: {
                    required: "Please enter a Employee phone number",
                    noDigits: "Employee phone number should not contain digits"
                },
                employeeAccountNo: {
                    required: "Please enter a Employee Account number",
                    noDigits: "Employee Account number should not contain digits"
                },
                employeeAddress: {
                    required: "Please enter a Employee address"
                },
                shift: {
                    required: "Please select a Employee shift"
                }
            }
        });
    }
</script>