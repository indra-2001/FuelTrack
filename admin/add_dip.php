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
            <h5><b>Dip</b></h5>
        </div>
        <div class="col-md-7  align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Dip</li>
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
                                <form id="add_dip" method="POST" action="app/dip_crud.php">
                                    <div class="form-group">
                                        <div class="row">
                                            <!--   -->
                                            <label class="col-sm-3 control-label">Date</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" id="date" placeholder="date"
                                                    name="record_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <!--   -->
                                            <label class="col-sm-3 control-label">Fuel Type</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="fuel_type" name="fuel_type">

                                                    <option value="">~~SELECT~~</option>
                                                    <?php
                                                    $stmt = $conn->prepare("SELECT id,name FROM fuel_category WHERE delete_status='0' ");
                                                    $stmt->execute();
                                                    $records = $stmt->fetchAll();
                                                    if (!empty($records)) { // Check if there are records
                                                        foreach ($records as $row) {
                                                            ?>
                                                            <option value="<?php echo $row['id']; ?>">
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
                                                <input type="number" class="form-control" id="dip" placeholder="dip"
                                                    name="dip" step="0.01" min="0" max="99999.99">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <!--   -->
                                            <label class="col-sm-3 control-label">Density</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" id="hydrometer"
                                                    placeholder="hydrometer" name="hydrometer" step="0.01" min="0"
                                                    max="99999.99">
                                                <input type="number" class="form-control" id="temp" placeholder="temp"
                                                    name="temp" step="0.01" min="0" max="99999.99">
                                                <input type="number" class="form-control" id="density"
                                                    placeholder="density" name="density" step="0.01" min="0"
                                                    max="99999.99">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group col-md-12">
                                        <button class="btn btn-primary" onclick="validateDip()" type="submit" name="submit">Submit</button>
                                    </div>
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


<script>
    function validateDip(){

    
   
        // Custom methods
        $.validator.addMethod("noSpacesOnly", function (value, element) {
            return value.trim() !== '';
        }, "Please enter a valid value.");

        // Validation rules
        $("#add_dip").validate({
            rules: {
                record_date: {
                    required: true,
                    date: true
                },
                fuel_type: {
                    required: true
                },
                dip: {
                    required: true,
                    number: true,
                    min: 0,
                    max: 99999.99
                },
                hydrometer: {
                    required: true,
                    number: true,
                    min: 0,
                    max: 99999.99
                },
                temp: {
                    required: true,
                    number: true,
                    min: 0,
                    max: 99999.99
                },
                density: {
                    required: true,
                    number: true,
                    min: 0,
                    max: 99999.99
                }
            },
            messages: {
                record_date: {
                    required: "Please select a date.",
                    date: "Please enter a valid date."
                },
                fuel_type: {
                    required: "Please select a fuel type."
                },
                dip: {
                    required: "Please enter the dip value.",
                    number: "Please enter a valid number.",
                    min: "Value cannot be less than 0.",
                    max: "Value cannot exceed 99999.99."
                },
                hydrometer: {
                    required: "Please enter the hydrometer value.",
                    number: "Please enter a valid number.",
                    min: "Value cannot be less than 0.",
                    max: "Value cannot exceed 99999.99."
                },
                temp: {
                    required: "Please enter the temperature.",
                    number: "Please enter a valid number.",
                    min: "Value cannot be less than 0.",
                    max: "Value cannot exceed 99999.99."
                },
                density: {
                    required: "Please enter the density value.",
                    number: "Please enter a valid number.",
                    min: "Value cannot be less than 0.",
                    max: "Value cannot exceed 99999.99."
                }
            },
            
        });
 
}
</script>

<!-- <script>
    function validateemployee() {
        // Custom method to check if the input contains only spaces
        $.validator.addMethod("noSpacesOnly", function(value, element) {
            return value.trim() !== '';
        }, "Please enter a non-empty value");

        // Custom method to check if the input contains only alphabet characters
        $.validator.addMethod("lettersonly", function(value, element) {
            return /^[a-zA-Z\s]*$/.test(value);
        }, "Please enter alphabet characters only");

        // Custom method to check if the input contains only digits
        $.validator.addMethod("noDigits", function(value, element) {
            return !/\d/.test(value);
        }, "Please enter a value without digits");

        $('#add_employee').validate({
            rules: {
                employeeName: {
                    required: true,
                    noSpacesOnly: true,
                    lettersonly: true
                },
                employeeEmail: {
                    required: true,
                    email: true
                },
                employeePhone: {
                    required: true,
                    noSpacesOnly: true,
                    digits: true,
                    maxlength: 10,
                    minlength: 10
                },
                employeeAccountNo: {
                    required: true,
                    noSpacesOnly: true,
                    digits: true,
                    minlength: 8
                },
                employeeAddress: {
                    required: true,
                    noSpacesOnly: true
                },
                shift: {
                    required: true
                }
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
</script> -->