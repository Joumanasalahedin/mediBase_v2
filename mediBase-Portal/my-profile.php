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

$doc_sql = "SELECT * FROM `doctors` WHERE id = $doctor_id";
$doc_result = mysqli_query($conn, $doc_sql);

if ($doctor_info = mysqli_fetch_assoc($doc_result)) {
    $doctor_info = $doctor_info;
}

// Edit Doctor Info
if (isset($_POST['update_doctor_profile'])) {
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
    $gender = filter_input(INPUT_POST, "gender", FILTER_SANITIZE_SPECIAL_CHARS);
    $nationality = filter_input(INPUT_POST, "nationality", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $mobile_phone = filter_input(INPUT_POST, "mobile_phone", FILTER_SANITIZE_NUMBER_INT);
    $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS);
    $license_no = filter_input(INPUT_POST, "license_no", FILTER_SANITIZE_SPECIAL_CHARS);
    $department = filter_input(INPUT_POST, "department", FILTER_SANITIZE_SPECIAL_CHARS);
    $position = filter_input(INPUT_POST, "position", FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);

    $update_sql = "UPDATE `doctors` SET `name` = '$name',
                  `gender` = '$gender',
                  `nationality` = '$nationality',
                  `email` = '$email',
                  `mobile_phone` = '$mobile_phone',
                  `address` = '$address',
                  `license_no` = '$license_no',
                  `department` = '$department',
                  `position` = '$position',
                  `username` = '$username' WHERE `doctors`.`id` = $doctor_id";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: my-profile.php");
        exit();
    };
};

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>mediBase Portal - My Profile</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="mediBase, EHR, Healthcare" name="keywords">
    <meta content="mediBase is a project on Information Systems in Healthcare by Jouhanzasom" name="description">

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
                    <a href="patients.php" class="nav-item nav-link"><i class="fa fa-hospital-user me-2"></i>My Patients</a>
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
                            <a href="my_profile.php" class="dropdown-item openPopupBtn" data-popup-target="doctorInfoPopup"><i class="fa fa-user-doctor me-3"></i>My Profile</a>
                            <a href="#" class="dropdown-item openPopupBtn" data-popup-target="settingsPopup"><i class="fa fa-gear me-3"></i>Settings</a>
                            <a href="signin.php" class="dropdown-item"><i class="fa fa-right-from-bracket me-3"></i>Log Out</a>
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

            <!-- Doctor Information -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <h2 class="mb-4">Your Profile Details</h2>
                    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                        <p><strong>Name: </strong><input type="text" name="name" class="doctor-editable-field" value="<?php echo htmlspecialchars($doctor_info['name']); ?>"></p>
                        <p><strong>Birthdate: </strong><span name="birth_date"><?php
                                                                                $dateObject = new DateTime($doctor_info['birth_date']);
                                                                                $formattedDate = $dateObject->format('d-m-Y');
                                                                                echo htmlspecialchars($formattedDate); ?></span></p></span></p>
                        <p><strong>Gender: </strong><input type="text" name="gender" class="doctor-editable-field" value="<?php echo htmlspecialchars($doctor_info['gender']); ?>"></p>
                        <p><strong>Nationality: </strong><input type="text" name="nationality" class="doctor-editable-field" value="<?php echo htmlspecialchars($doctor_info['nationality']); ?>"></p>
                        <p><strong>Email Address: </strong><input type="email" name="email" class="doctor-editable-field" value="<?php echo htmlspecialchars($doctor_info['email']); ?>" style=" width: 22%;"></p>
                        <p><strong>Phone No.:: </strong><input type="tel" name="mobile_phone" class="doctor-editable-field" value=" <?php echo htmlspecialchars($doctor_info['mobile_phone']); ?>"></p>
                        <p><strong>Address: </strong><input type="text" name="address" class="doctor-editable-field" value="<?php echo htmlspecialchars($doctor_info['address']); ?>"></span></p>
                        <p><strong>License No.: </strong><input type="text" name="license_no" class="doctor-editable-field" value="<?php echo htmlspecialchars($doctor_info['license_no']); ?>"></p>
                        <p><strong>Department: </strong><input type="text" name="department" class="doctor-editable-field" value="<?php echo htmlspecialchars($doctor_info['department']); ?>"></p>
                        <p><strong>Position: </strong><input type="text" name="position" class="doctor-editable-field" value="<?php echo htmlspecialchars($doctor_info['position']); ?>"></p>
                        <p><strong>Username: </strong><input type="text" name="username" class="doctor-editable-field" value="<?php echo htmlspecialchars($doctor_info['username']); ?>"></p>
                        <button type="submit" class="btn btn-sm btn-primary" id="updateDoctorProfile" name="update_doctor_profile"><i class="fa fa-save me-2"></i>Save Changes</button>
                    </form>
                </div>
            </div>
            <!-- Doctor Information End -->

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">mediBase</a>, All Rights Reserved.
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed by <a href="https://github.com/so-mb/mediBase">Jouhanzasom&reg;</a>
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

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
