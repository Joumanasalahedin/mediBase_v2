<?php
include("../connection.php");

session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // Access user-specific information
    $doctor_id = $_SESSION["id"];
    $username = $_SESSION["username"];
}

// Change name on profile to doctor's name
$name_sql = "SELECT name, department FROM doctors WHERE id = $doctor_id";
$name_result = $conn->query($name_sql);

if ($name_result && $name_result->num_rows > 0) {
    $row = $name_result->fetch_assoc();
    $doctor_name = $row["name"];
    $doctor_department = $row["department"];
}

// WIDGET
$widget4_sql = "SELECT COUNT(*) AS count FROM `patients` WHERE doctor_id = $doctor_id;";
$widget4_result = $conn->query($widget4_sql);

if ($widget4_result && $widget4_result->num_rows > 0) {
    $row = $widget4_result->fetch_assoc();
    $patients_registered = $row["count"];
}

// Patients Table
$pat_sql = "SELECT id, first_name, last_name, birthdate, gender, email, mobile_phone
            FROM `patients` WHERE doctor_id = $doctor_id";

$pat_result = mysqli_query($conn, $pat_sql);

// View Patient
if (isset($_POST['view_patient'])) {
    $patient_id = $_POST['patient_id'];

    // Fetch patient information from the database
    $patient_info_query = "SELECT * FROM patients WHERE id = $patient_id";
    $patient_info_result = mysqli_query($conn, $patient_info_query);

    if ($patient_info = mysqli_fetch_assoc($patient_info_result)) {
        // Store patient information in a variable to display in the popup
        $patient_info_data = $patient_info;
        $patient_id = $patient_info_data['id'];
    } else {
        $patient_info_data = null;
    }
}

// Edit Patient
if (isset($_POST['update_patient_profile'])) {
    $first_name = filter_input(INPUT_POST, "first_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $last_name = filter_input(INPUT_POST, "last_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $nationality = filter_input(INPUT_POST, "nationality", FILTER_SANITIZE_SPECIAL_CHARS);
    $health_insurance = filter_input(INPUT_POST, "health_insurance", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $mobile_phone = filter_input(INPUT_POST, "mobile_phone", FILTER_SANITIZE_NUMBER_INT);
    $emergency_name = filter_input(INPUT_POST, "emergency_contact_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $emergency_no = filter_input(INPUT_POST, "emergency_contact_no", FILTER_SANITIZE_NUMBER_INT);
    $height = filter_input(INPUT_POST, "height", FILTER_SANITIZE_NUMBER_INT);
    $weight = filter_input(INPUT_POST, "weight", FILTER_SANITIZE_NUMBER_INT);
    $blood_group = filter_input(INPUT_POST, "blood_group", FILTER_SANITIZE_SPECIAL_CHARS);
    $allergies = filter_input(INPUT_POST, "allergies", FILTER_SANITIZE_SPECIAL_CHARS);
    $chronic_diseases = filter_input(INPUT_POST, "chronic_diseases", FILTER_SANITIZE_SPECIAL_CHARS);
    $disabilities = filter_input(INPUT_POST, "disabilities", FILTER_SANITIZE_SPECIAL_CHARS);
    $vaccines = filter_input(INPUT_POST, "vaccines", FILTER_SANITIZE_SPECIAL_CHARS);
    $medications = filter_input(INPUT_POST, "medications", FILTER_SANITIZE_SPECIAL_CHARS);
    $patient_id = $_POST['patient_id'];

    $update_sql = "UPDATE `patients` SET `first_name` = '$first_name',
                  `last_name` = '$last_name',
                  `nationality` = '$nationality',
                  `health_insurance_no` = '$health_insurance',
                  `email` = '$email',
                  `mobile_phone` = '$mobile_phone',
                  `emergency_contact_name` = '$emergency_name',
                  `emergency_contact_no` = '$emergency_no',
                  `height` = '$height',
                  `weight` = '$weight',
                  `blood_group` = '$blood_group',
                  `allergies` = '$allergies',
                  `chronic_diseases` = '$chronic_diseases',
                  `disabilities` = '$disabilities',
                  `vaccines` = '$vaccines',
                  `medications` = '$medications' WHERE `patients`.`id` = $patient_id";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: patients.php");
        exit();
    };
};

// Delete Patient
if (isset($_POST['delete_patient'])) {
    $patient_id = $_POST['patient_id'];

    // Fetch patient information from the database
    $patient_info_query = "SELECT * FROM patients WHERE id = $patient_id";
    $patient_info_result = mysqli_query($conn, $patient_info_query);

    if ($patient_info = mysqli_fetch_assoc($patient_info_result)) {
        // Store patient information in a variable to display in the popup
        $patient_info_data = $patient_info;
        $patient_id = $patient_info_data['id'];

        $delete_sql = "DELETE FROM `patients` WHERE `patients`.`id` = $patient_id";

        if (mysqli_query($conn, $delete_sql)) {
            header("Location: patients.php");
            exit();
        } else {
            $patient_info_data = null;
        }
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>mediBase Portal - My Patients</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.php" class="navbar-brand mx-4 mb-3">
                    <img src="img/logo.png" alt="mediBase logo" style="margin-left: -5%;">
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?php echo $doctor_name; ?></h6>
                        <span><?php echo $doctor_department; ?></span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.php" class="nav-item nav-link"><i class="fa fa-house me-2"></i>Home</a>
                    <a href="patients.php" class="nav-item nav-link active" data-bs-toggle="dropdown"><i class="fa fa-hospital-user me-2"></i>My Patients</a>
                    <a href="patient-registration.php" class="nav-item nav-link"><i class="fa fa-user-plus me-2"></i>Register Patient</a>
                    <a href="signin.php" class="nav-item nav-link"><i class="fa fa-right-from-bracket me-2"></i>Log out</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="index.php" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control bg-dark border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex"><?php echo $doctor_name; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="my-profile.php" class="dropdown-item openPopupBtn" data-popup-target="doctorInfoPopup"><i class="fa fa-user-doctor me-3"></i>My Profile</a>
                            <a href="#" class="dropdown-item openPopupBtn" data-popup-target="settingsPopup"><i class="fa fa-gear me-3"></i>Settings</a>
                            <a href="signin.php?" class="dropdown-item"><i class="fa fa-right-from-bracket me-3"></i>Log Out</a>
                        </div>
                        <!-- Settings Message Popup -->
                        <div id="settingsPopup" class="popup">
                            <div class="popup-content">
                                <span class="close">&times;</span>
                                <p>For settings changes, please contact the Admin.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Overview Tile Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded h-100 p-4">
                    <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                        <i class="fa fa-people-group fa-3x text-primary"></i>
                        <div class="ms-3">
                            <p class="mb-2">Total No. of Patients Registered With You</p>
                            <h6 class="mb-0"><?php echo $patients_registered; ?></h6>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Overview Tile End -->

            <!-- Table Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded h-100 p-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="mb-4">Patients Registered With You</h6>
                        <a class="mb-4" href="patient-registration.php">Register New</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">First Name</th>
                                    <th scope="col">Last Name</th>
                                    <th scope="col">Birthdate</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Contact Number</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($pat_result && mysqli_num_rows($pat_result) > 0) {
                                    // Fetch each row of appointment data
                                    while ($row = mysqli_fetch_assoc($pat_result)) {
                                        $dateObject = new DateTime($row['birthdate']);
                                        $formattedDate = $dateObject->format('d-m-Y');
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($formattedDate) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['mobile_phone']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                        echo "<form method='POST' action=''>";
                                        echo "<input type='hidden' name='patient_id' value='" . htmlspecialchars($row['id']) . "'>";
                                        echo "<td><button type='submit' name='view_patient' class='btn btn-sm btn-primary'><i class='fa fa-address-card me-2'></i>View</button></td>";
                                        echo "</form>";
                                        echo "<form method='POST' action=''>";
                                        echo "<input type='hidden' name='patient_id' value='" . htmlspecialchars($row['id']) . "'>";
                                        echo "<td><button type='submit' name='delete_patient' class='btn btn-sm btn-primary'><i class='fa fa-address-card me-2'></i>Delete</button></td>";
                                        echo "</form>";
                                    }
                                } else {
                                    echo "<tr><td colspan='8'>No patients found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Patient Info Popup -->
                    <!-- Patient Info Form -->
                    <div id="patientInfoPopup" class="popup" style="<?php echo isset($patient_info_data) ? 'display: block;' : 'display: none;'; ?>">
                        <div class="popup-content">
                            <span class="close">&times;</span>
                            <h2>Patient Profile Information</h2>
                            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                                <!-- Display patient information if available -->
                                <?php if ($patient_info_data) : ?>
                                    <div>
                                        <p style="display: inline-block; margin-right: 15px;"><strong>First Name: </strong><input type="text" name="first_name" value="<?php echo htmlspecialchars($patient_info_data['first_name']); ?>"></p>
                                        <p style="display: inline-block; margin-right: 15px;"><strong>Last Name: </strong><input type="text" name="last_name" value="<?php echo htmlspecialchars($patient_info_data['last_name']); ?>"></p>
                                    </div>
                                    <div>
                                        <p style="display: inline-block; margin-right: 15px;"><strong>Date of Birth: </strong><span><?php
                                                                                                                                    $dateObject = new DateTime($patient_info_data['birthdate']);
                                                                                                                                    $formattedDate = $dateObject->format('d-m-Y');
                                                                                                                                    echo htmlspecialchars($formattedDate); ?></span></p>
                                        <p style="display: inline-block; margin-right: 15px;"><strong>Gender: </strong><span><?php echo htmlspecialchars($patient_info_data['gender']); ?></span></p>
                                    </div>
                                    <div>
                                        <p style="display: inline-block; margin-right: 15px;"><strong>Nationality: </strong><input type="text" name="nationality" value="<?php echo htmlspecialchars($patient_info_data['nationality']); ?>"></p>
                                        <p style="display: inline-block; margin-right: 15px;"><strong>Health Insurance No.: </strong><input type="text" name="health_insurance" value="<?php echo htmlspecialchars($patient_info_data['health_insurance_no']); ?>" disabled></p>
                                    </div>
                                    <div>
                                        <p style="display: inline-block; margin-right: 15px;"><strong>Email Address: </strong><input type="email" name="email" value="<?php echo htmlspecialchars($patient_info_data['email']); ?>" style="width: 70%;" disabled></p>
                                        <p style="display: inline-block; margin-right: 15px;"><strong>Phone No.: </strong><input type="tel" name="mobile_phone" value="<?php echo htmlspecialchars($patient_info_data['mobile_phone']); ?>" disabled></p>
                                    </div>
                                    <div>
                                        <p style="display: inline-block; margin-right: 15px;"><strong>Emergency Contact Name: </strong><input type="text" name="emergency_contact_name" value="<?php echo htmlspecialchars($patient_info_data['emergency_contact_name']); ?>" disabled></p>
                                        <p style="display: inline-block; margin-right: 15px;"><strong>Emergency Contact No.: </strong><input type="tel" name="emergency_contact_no" value="<?php echo htmlspecialchars($patient_info_data['emergency_contact_no']); ?>" disabled></p>
                                    </div>
                                    <div>
                                        <p style="display: inline-block; margin-right: 15px;"><strong>Height: </strong><input type="number" name="height" value="<?php echo htmlspecialchars($patient_info_data['height']); ?>" disabled> cm</p>
                                        <p style="display: inline-block; margin-right: 15px;"><strong>Weight: </strong><input type="number" name="weight" value="<?php echo htmlspecialchars($patient_info_data['weight']); ?>" disabled> kg</p>
                                    </div>
                                    <p><strong>Blood Group: </strong><input type="text" name="blood_group" value="<?php echo htmlspecialchars($patient_info_data['blood_group']); ?>" disabled></p>
                                    <p><strong>Allergies: </strong><textarea name="allergies" disabled><?php echo htmlspecialchars($patient_info_data['allergies']); ?></textarea></p>
                                    <p><strong>Chronic Diseases: </strong><textarea name="chronic_diseases" disabled><?php echo htmlspecialchars($patient_info_data['chronic_diseases']); ?></textarea></p>
                                    <p><strong>Disabilities: </strong><textarea name="disabilities" disabled><?php echo htmlspecialchars($patient_info_data['disabilities']); ?></textarea></p>
                                    <p><strong>Vaccines: </strong><textarea name="vaccines" disabled><?php echo htmlspecialchars($patient_info_data['vaccines']); ?></textarea></p>
                                    <p><strong>Medications: </strong><textarea name="medications" disabled><?php echo htmlspecialchars($patient_info_data['medications']); ?></textarea></p>
                                    <input type="hidden" name="patient_id" value="<?php echo htmlspecialchars($patient_info_data['id']); ?>">
                                    <button type="button" class="btn btn-sm btn-primary" id="editPatientInfoBtn" name="editPatientInfoBtn"><i class="fa fa-user-pen me-2"></i>Edit Info</button>
                                    <button type="submit" class="btn btn-sm btn-primary" id="updatePatientProfile" name="update_patient_profile" style="display: none; margin: 25px 0px 0px"><i class="fa fa-save me-2"></i>Save Changes</button>
                                <?php else : ?>
                                    <p>No patient information available.</p>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Table End -->

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">mediBase</a>, All Rights Reserved.
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed by <a href="https://github.com/Joumanasalahedin/mediBase">Jouhanzasom&reg;</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Main Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
