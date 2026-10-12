<?php
include_once('include/config.php');
session_start();

if (isset($_POST['submit'])) {
    // Account Credentials
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Matches legacy database schema hashing
    
    // Core Identification Details
    $patient_type = $_POST['patient_type'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $middle_name = $_POST['middle_name'];
    $birthdate = $_POST['birthdate'];
    $sex = $_POST['sex'];
    $religion = $_POST['religion'];
    $mothers_name = $_POST['mothers_name']; 

    // Composite Address Structural String assembly
    $region = $_POST['region'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $barangay = $_POST['barangay'];
    $full_address = "$barangay, $city, $province, $region";

    // Secure database storage with Prepared Statements
    $stmt = $con->prepare("INSERT INTO users (username, patient_type, email, password, first_name, last_name, middle_name, birthdate, sex, religion, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $username, $patient_type, $email, $password, $first_name, $last_name, $middle_name, $birthdate, $sex, $religion, $full_address);

    if ($stmt->execute()) {
        echo "<script>alert('Successfully Registered. You can login now'); window.location.href = 'user-login.php';</script>";
    } else {
        echo "<script>alert('Error during registration. Please try again.');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration | CHMSU Clinic Management</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

    <style>
        /* Shared Core Design System Variables */
        :root {
            --primary-color: #1e3a8a;       /* Corporate Blue */
            --primary-hover: #172554;      /* Deep Dark Blue */
            --accent-color: #0ea5e9;       /* Light Medical Accent Blue */
            --bg-body: #f1f5f9;            /* Background Slate Gray Tonal base */
            --text-main: #1e293b;          /* Soft Charcoal Main Body Text */
            --text-muted: #64748b;         /* Captioning Slate */
            --white: #ffffff;
            --shadow-lg: 0 10px 25px -5px rgba(30, 58, 138, 0.1), 0 8px 10px -6px rgba(30, 58, 138, 0.1);
            --border-radius: 12px;
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at top right, #cbd5e1, var(--bg-body));
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 20px;
        }

        /* Scaled and structured Grid Card layout Container */
        .register-box {
            background: var(--white);
            padding: 50px 55px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            width: 100%;
            max-width: 920px; 
            text-align: center;
            border-top: 5px solid var(--primary-color);
            opacity: 0;
            transform: translateY(20px);
            animation: slideUp 0.5s ease-in-out forwards;
        }

        .logo-img {
            max-width: 115px;
            height: auto;
            margin-bottom: 15px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.05));
        }

        .register-box h2 {
            color: var(--primary-color);
            font-weight: 800;
            margin-bottom: 5px;
            font-size: 2.5rem; /* Increased size */
            letter-spacing: -0.5px;
        }

        .text-muted {
            color: var(--text-muted) !important;
            font-size: 1.15rem; /* Increased size */
            margin-bottom: 40px;
        }

        /* Section Split Elements */
        .section-title {
            text-align: left;
            font-size: 1.55rem; /* Increased size */
            font-weight: 600;
            color: var(--primary-color);
            margin: 35px 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 2.5px solid #e2e8f0;
            grid-column: 1 / -1;
        }

        /* Responsive Form Matrix Configuration */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px 28px;
            text-align: left;
        }

        .form-group {
            margin-bottom: 0;
        }

        label {
            font-weight: 500;
            margin-bottom: 10px;
            font-size: 1.2rem; /* Increased size */
            color: var(--text-main);
        }

        .form-control, select {
            width: 100%;
            border-radius: 8px;
            padding: 12px 18px;
            font-size: 1.3rem; /* Increased size */
            border: 1px solid #cbd5e1;
            background-color: #f8fafc;
            color: var(--text-main);
            transition: var(--transition);
            height: 54px; /* Increased height to give clean inner padding */
        }

        .form-control:focus, select:focus {
            border-color: var(--accent-color);
            background-color: var(--white);
            box-shadow: 0 0 0 3.5px rgba(14, 165, 233, 0.15);
            outline: none;
        }

        /* Structural Spanning fixes */
        .span-2 {
            grid-column: span 2;
        }

        /* Buttons & Dynamic interactive visual enhancements */
        .btn-register {
            border-radius: 8px;
            padding: 16px;
            font-size: 1.45rem; /* Increased size */
            font-weight: 500;
            background: var(--primary-color);
            color: var(--white);
            border: none;
            transition: var(--transition);
            width: 100%;
            cursor: pointer;
            margin-top: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            grid-column: span 2;
        }

        .btn-register:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(30, 58, 138, 0.2);
        }

        .register-link {
            margin-top: 35px;
            font-size: 1.25rem; /* Increased size */
            color: var(--text-muted);
            border-top: 1px solid #f1f5f9;
            padding-top: 25px;
        }

        .register-link a {
            color: var(--accent-color);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }

        .register-link a:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        /* Animation Keyframe Layout rules */
        @keyframes slideUp {
            0% {
                transform: translateY(20px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Responsive Breakpoints View adaptions */
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            .span-2 {
                grid-column: span 1;
            }
            .btn-register {
                grid-column: span 1;
            }
            .register-box {
                padding: 40px 25px;
            }
        }
    </style>
</head>

<body>
    <div class="register-box">
        <img src="include/CHMSUWeb.jpg" alt="CHMSU Logo" class="logo-img">
        <h2>Create Clinic Account</h2>
        <p class="text-muted">Fill out the clinical record form profile details to register</p>

        <form method="post" action="" name="registration" onSubmit="return valid();">
            <div class="form-grid">
                
                <div class="section-title">Personal Information</div>

                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" name="first_name" placeholder="John" required>
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" name="last_name" placeholder="Doe" required>
                </div>
                <div class="form-group">
                    <label>Middle Name</label>
                    <input type="text" class="form-control" name="middle_name" placeholder="Mendoza">
                </div>
                <div class="form-group">
                    <label>Birthdate</label>
                    <input type="date" class="form-control" name="birthdate" required>
                </div>
                <div class="form-group">
                    <label for="sex">Sex</label>
                    <select name="sex" id="sex" required>
                        <option value="" disabled selected>Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Religion</label>
                    <input type="text" class="form-control" name="religion" placeholder="e.g. Roman Catholic" required>
                </div>
                <div class="form-group span-2">
                    <label>Mother's Full Name</label>
                    <input type="text" class="form-control" name="mothers_name" placeholder="Mother's Maiden Name" required>
                </div>

                <div class="section-title">Institutional Classification</div>

                <div class="form-group span-2">
                    <label for="patient_type">Type of Patient Class</label>
                    <select name="patient_type" id="patient_type" required>
                        <option value="" disabled selected>Select Institutional Status</option>
                        <option value="student">Student</option>
                        <option value="faculty">Faculty</option>
                        <option value="staff">Staff / Support Team</option>
                    </select>
                </div>

                <div class="section-title">Address Location Information</div>

                <div class="form-group">
                    <label>Region</label>
                    <select id="region" name="region" required>
                        <option value="" disabled selected>Select Region</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Province</label>
                    <select id="province" name="province" required>
                        <option value="" disabled selected>Select Province</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>City / Municipality</label>
                    <select id="city" name="city" required>
                        <option value="" disabled selected>Select City/Municipality</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Barangay</label>
                    <select id="barangay" name="barangay" required>
                        <option value="" disabled selected>Select Barangay</option>
                    </select>
                </div>

                <div class="section-title">Account Security Access Settings</div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username" placeholder="johndoe22" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" class="form-control" name="email" placeholder="johndoe@chmsu.edu.ph" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" placeholder="••••••••" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" name="password_again" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-register" id="submit" name="submit">
                    Complete Account Creation <i class="fa fa-user-plus"></i>
                </button>
            </div>
        </form>

        <div class="register-link">
            <p>Already have a clinical portal account? <a href="user-login.php">Login here</a></p>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        const addressDatabase = {
            "Region VI (Western Visayas)": {
                "Negros Occidental": {
                    "Binalbagan": ["Enclaro", "Paglaum", "San Jose", "Progreso", "Canmoros", "Bagroy", "Santol", "Poblacion Bi-ao", "Poblacion San Pedro"],
                    "Bacolod City": ["Mansilingan", "Villamonte", "Bata", "Alijis", "Singcang-Airport", "Estefania", "Tangub"],
                    "Kabankalan City": ["Talubangi", "Binicuil", "Daan Banua", "Hilamonan", "Salong", "Camugao"],
                    "Himamaylan City": ["Agisan", "Carabalan", "Su-ay", "To-oy", "Mambagaton", "Libacao"]
                },
                "Iloilo": {
                    "Iloilo City": ["Mandurriao", "Jaro", "Molo", "La Paz", "Arevalo"],
                    "Oton": ["Poblacion", "Buray", "Trapiche", "San Antonio"]
                }
            },
            "National Capital Region (NCR)": {
                "Metro Manila": {
                    "Manila City": ["Binondo", "Ermita", "Malate", "Quiapo", "Sampaloc"],
                    "Quezon City": ["Bagong Pag-asa", "Diliman", "Commonwealth", "Cubao"]
                }
            }
        };

        const regionSelect = document.getElementById('region');
        const provinceSelect = document.getElementById('province');
        const citySelect = document.getElementById('city');
        const barangaySelect = document.getElementById('barangay');

        window.addEventListener('DOMContentLoaded', () => {
            for (let region in addressDatabase) {
                let opt = new Option(region, region);
                regionSelect.add(opt);
            }
        });

        regionSelect.addEventListener('change', () => {
            provinceSelect.length = 1; 
            citySelect.length = 1;
            barangaySelect.length = 1;
            
            const provinces = addressDatabase[regionSelect.value];
            for (let province in provinces) {
                provinceSelect.add(new Option(province, province));
            }
        });

        provinceSelect.addEventListener('change', () => {
            citySelect.length = 1;
            barangaySelect.length = 1;
            
            const cities = addressDatabase[regionSelect.value][provinceSelect.value];
            for (let city in cities) {
                citySelect.add(new Option(city, city));
            }
        });

        citySelect.addEventListener('change', () => {
            barangaySelect.length = 1;
            
            const barangays = addressDatabase[regionSelect.value][provinceSelect.value][citySelect.value];
            barangays.forEach(brgy => {
                barangaySelect.add(new Option(brgy, brgy));
            });
        });

        function valid() {
            if (document.registration.password.value != document.registration.password_again.value) {
                alert("Password and Confirm Password Field do not match!");
                document.registration.password_again.focus();
                return false;
            }
            return true;
        }
    </script>
</body>

</html>