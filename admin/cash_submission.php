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
            <h5>Daily Cash Submission</h5>
        </div>
        <div class="col-md-7  align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Cash Submission</li>
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
                                <form id="cash_submission" method="POST" action="app/cash_crud.php">
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Select Date:</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" id="submissionDate"
                                                    name="submissionDate">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Fuel Type</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="fueltype" name="fueltype">
                                                    <option value="">~~SELECT~~</option>
                                                    <?php
                                                    $stmt = $conn->prepare("Select * from fuel_category where delete_status='0'");
                                                    $stmt->execute();
                                                    $result = $stmt->fetchAll();
                                                    foreach ($result as $key) {
                                                        ?>
                                                        <option value="<?php echo $key['id'] ?>"><?php echo $key['name'] ?>
                                                        </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Employee</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="employeeName" name="employeeName">
                                                    <option value="">~~SELECT~~</option>
                                                    <?php
                                                    $stmt = $conn->prepare("Select * from employee where delete_status='0'");
                                                    $stmt->execute();
                                                    $result = $stmt->fetchAll();
                                                    foreach ($result as $key) {
                                                        ?>
                                                        <option value="<?php echo $key['id'] ?>">
                                                            <?php echo $key['employeeName'] ?>
                                                        </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Opening Rd.</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="opening_read"
                                                    placeholder="Opening Reading" name="opening_read">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Closing Rd.</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="closing_read"
                                                    placeholder="Closing Reading" name="closing_read">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Price</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="fuelPrice"
                                                    placeholder="Fuel Price" name="fuelPrice">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Cash Submitted</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="CashSubmitted"
                                                    placeholder="Cash Submitted" name="CashSubmitted">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- New fields -->
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Online Amount</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="OnlineAmount"
                                                    placeholder="Online Amount" name="OnlineAmount">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Coin</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="Coin" placeholder="Coin"
                                                    name="Coin">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Testing Density (in Amt)</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="TestingDensity"
                                                    placeholder="Testing Density (in Amt)" name="TestingDensity">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Actual Amount (Read-Only) -->
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Actual Amount (Rs)</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="ActualAmount"
                                                    name="ActualAmount" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Amount Submitted (Read-Only) -->
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Amount Submitted (Rs)</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="AmountSubmitted"
                                                    name="AmountSubmitted" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Extra/Short Amount -->
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Extra/Short</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="ExtraShort"
                                                    name="ExtraShort" readonly>
                                                <span id="extraShortText" style="margin-left: 10px;"></span>
                                                <!-- Text to show extra or short -->
                                            </div>
                                        </div>
                                    </div>

                                    <!-- End of new fields -->

                                    <div class="form-group col-md-12">
                                        <button type="button" class="btn btn-secondary"
                                            onclick="calculateAmounts()">Calculate</button>
                                        <button class="btn btn-primary" type="submit" name="submit"
                                            onclick="validateSubmission(),calculateAmounts()">Submit</button>
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

<!-- JavaScript for Calculate Function -->
<script>
    function calculateAmounts() {
        // Get values from the form fields
        const openingRd = parseFloat(document.getElementById("opening_read").value) || 0;
        const closingRd = parseFloat(document.getElementById("closing_read").value) || 0;
        const fuelPrice = parseFloat(document.getElementById("fuelPrice").value) || 0;
        const testingDensity = parseFloat(document.getElementById("TestingDensity").value) || 0;

        const cashSubmitted = parseFloat(document.getElementById("CashSubmitted").value) || 0;
        const onlineAmount = parseFloat(document.getElementById("OnlineAmount").value) || 0;
        const coin = parseFloat(document.getElementById("Coin").value) || 0;

        // Calculate Actual Amount and Amount Submitted
        const actualAmount = ((closingRd - openingRd) * fuelPrice) - testingDensity;
        const amountSubmitted = cashSubmitted + onlineAmount + coin;

        // Set calculated values in the read-only fields
        document.getElementById("ActualAmount").value = actualAmount.toFixed(2);
        document.getElementById("AmountSubmitted").value = amountSubmitted.toFixed(2);

        // Calculate the difference (extra/short)
        const difference = amountSubmitted - actualAmount;

        // Get the Extra/Short field
        const extraShortField = document.getElementById("ExtraShort");
        const extraShortText = document.getElementById("extraShortText");

        // Check if the difference is extra or short, and apply the appropriate style and text
        if (difference > 0) {
            extraShortField.value = `+${difference.toFixed(2)}`;
            extraShortField.style.border = '2px solid green';
            extraShortField.style.color = 'green';
            extraShortText.textContent = 'Extra'; // Display "Extra" next to the input
            extraShortText.style.color = 'green';
        } else if (difference < 0) {
            extraShortField.value = `${difference.toFixed(2)}`;
            extraShortField.style.border = '2px solid red';
            extraShortField.style.color = 'red';
            extraShortText.textContent = 'Short'; // Display "Short" next to the input
            extraShortText.style.color = 'red';
        } else {
            extraShortField.value = '0.00';
            extraShortField.style.border = 'none';
            extraShortField.style.color = 'black';
            extraShortText.textContent = 'No Difference'; // Display "No Difference" if amounts match
            extraShortText.style.color = 'black';
        }
    }
</script>
<script>
    function validateSubmission() {
        
        // Custom method to check if the input contains only spaces
        $.validator.addMethod("noSpacesOnly", function (value, element) {
            return value.trim() !== '';
        }, "Please enter a non-empty value");

        // Custom method to check if the input contains only digits or decimal values
        $.validator.addMethod("digitsOrDecimal", function (value, element) {
            return this.optional(element) || /^\d+(\.\d+)?$/.test(value); // Matches integer or decimal values
        }, "Please enter a valid number or decimal");
        $.validator.addMethod("positiveValue", function (value, element) {
            return this.optional(element) || parseFloat(value) > 0; // Ensures value is greater than 0
        }, "Please enter a positive value");

        $('#cash_submission').validate({
            rules: {
                submissionDate: {
                    required: true
                },
                fueltype: {
                    required: true
                },
                employeeName: {
                    required: true,
                },
                opening_read: {
                    required: true,
                    digitsOrDecimal: true,
                    noSpacesOnly: true
                },
                closing_read: {
                    required: true,
                    digitsOrDecimal: true,
                    noSpacesOnly: true
                },
                fuelPrice: {
                    required: true,
                    number: true,
                    noSpacesOnly: true
                    positiveValue: true
                },
                CashSubmitted: {
                    required: true,
                    number: true,
                    noSpacesOnly: true
                    positiveValue: true
                },
                OnlineAmount: {
                    required: true,
                    number: true,
                    noSpacesOnly: true
                    positiveValue: true
                },
                Coin: {
                    required: true,
                    number: true,
                    noSpacesOnly: true
                    positiveValue: true
                },
                TestingDensity: {
                    required: true,
                    number: true,
                    noSpacesOnly: true
                    positiveValue: true
                }
            },
            messages: {
                submissionDate: {
                    required: "Please select a date"
                    
                },
                fueltype: {
                    required: "Please select a fuel type"
                },
                employeeName: {
                    required: "Please select an employee"
                },
                opening_read: {
                    required: "Please enter the opening reading",
                    digitsOrDecimal: "Only numeric values are allowed"
                },
                closing_read: {
                    required: "Please enter the closing reading",
                    digitsOrDecimal: "Only numeric values are allowed"
                },
                fuelPrice: {
                    required: "Please enter the fuel price",
                    number: "Only numeric values are allowed"
                    positiveValue: "The value must be positive"
                },
                CashSubmitted: {
                    required: "Please enter the cash submitted amount",
                    number: "Only numeric values are allowed"
                    positiveValue: "The value must be positive"
                },
                OnlineAmount: {
                    required: "Please enter the online amount",
                    number: "Only numeric values are allowed"
                    positiveValue: "The value must be positive"
                },
                Coin: {
                    required: "Please enter the coin amount",
                    number: "Only numeric values are allowed"
                    positiveValue: "The value must be positive"
                },
                TestingDensity: {
                    required: "Please enter the testing density amount",
                    number: "Only numeric values are allowed"
                    positiveValue: "The value must be positive"
                }
            }
        });
        
    }
</script>
