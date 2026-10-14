<?php
include_once('hms/include/config.php');
if (isset($_POST['submit'])) {
    $name = $_POST['fullname'];
    $email = $_POST['emailid'];
    $mobileno = $_POST['mobileno'];
    $dscrption = $_POST['description'];
    
    // Secure SQL execution using Prepared Statements
    $stmt = $con->prepare("INSERT INTO tblcontactus(fullname, email, contactno, message) VALUES(?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $mobileno, $dscrption);
    
    if($stmt->execute()) {
        echo "<script>alert('Your information successfully submitted');</script>";
        echo "<script>window.location.href ='contact.php'</script>";
    } else {
        echo "<script>alert('An error occurred. Please try again.');</script>";
    }
    $stmt->close();
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHMSU | Contact Us</title>
    <link href="https://fonts.googleapis.com/css2?family=Ropa+Sans&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* CSS Variables matching Home Page styling */
        :root {
            --primary-color: #1e3a8a;       
            --primary-hover: #172554;      
            --accent-color: #0ea5e9;
            --bg-body: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --white: #ffffff;
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
            --border-radius: 8px;
            --transition: all 0.3s ease;
        }

        /* body */
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            line-height: 1.6;
        }
        
        .header {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 15px 0;
            box-shadow: var(--shadow-sm);
        }

        .wrap {
            max-width: 1200px;
            margin: auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .brand-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo img {
            height: 65px;
            width: auto;
            display: block;
        }

        .title-area h1 {
            margin: 0;
            font-family: 'Ropa Sans', sans-serif;
            font-size: 1.6rem;
            letter-spacing: 0.5px;
        }

        .title-area p {
            margin: 3px 0 0 0;
            font-size: 0.9rem;
            color: var(--accent-color);
            font-weight: 500;
        }

        .top-nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .top-nav ul li {
            position: relative;
        }

        .top-nav ul li a {
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            padding: 10px 18px;
            border-radius: var(--border-radius);
            transition: var(--transition);
            display: block;
        }

        .top-nav ul li a:hover, 
        .top-nav ul li.dropdown:hover > .dropbtn {
            background-color: rgba(255, 255, 255, 0.15);
            color: var(--white);
        }

        .dropdown-content {
            display: block;
            position: absolute;
            top: 110%;
            right: 0;
            background-color: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            min-width: 200px;
            overflow: hidden;
            z-index: 100;
            opacity: 0;
            pointer-events: none;
            transform: translateY(10px);
            transition: var(--transition);
            border: 1px solid #e2e8f0;
        }

        .dropdown-content a {
            color: var(--text-main) !important; 
            padding: 12px 20px;
            display: block;
            text-decoration: none;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .dropdown-content a:hover {
            background-color: #f1f5f9; 
            color: var(--primary-color) !important;
            padding-left: 25px;
        }

        .dropdown:hover .dropdown-content {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
        }

        /* contact layout */
        .contact-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .contact-container h2 {
            font-family: 'Ropa Sans', sans-serif;
            color: var(--primary-color);
            font-size: 2.2rem;
            margin-bottom: 25px;
            border-bottom: 3px solid var(--accent-color);
            display: inline-block;
            padding-bottom: 5px;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 30px;
            align-items: start;
        }

        /* card styling */
        .company_address {
            background: var(--white);
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            border-left: 4px solid var(--primary-color);
        }

        .company_address h3 {
            margin-top: 0;
            color: var(--primary-color);
            font-size: 1.3rem;
            margin-bottom: 20px;
        }

        .company_address p {
            margin: 12px 0;
            color: var(--text-main);
            font-size: 0.95rem;
        }

        .company_address span {
            color: var(--accent-color);
            font-weight: 500;
        }

        /* contact */
        .contact-form {
            background: var(--white);
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            border-top: 4px solid var(--accent-color);
        }

        .contact-form label {
            display: block;
            margin-top: 15px;
            font-weight: 500;
            color: var(--text-main);
            font-size: 0.9rem;
        }

        .contact-form label:first-of-type {
            margin-top: 0;
        }

        .contact-form input[type="text"],
        .contact-form input[type="email"],
        .contact-form textarea {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            box-sizing: border-box;
            border: 1px solid #cbd5e1;
            border-radius: var(--border-radius);
            font-size: 0.95rem;
            background-color: #f8fafc;
            transition: var(--transition);
            font-family: 'Roboto', sans-serif;
        }

        .contact-form input[type="text"]:focus,
        .contact-form input[type="email"]:focus,
        .contact-form textarea:focus {
            outline: none;
            border-color: var(--accent-color);
            background-color: var(--white);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
        }

        .contact-form textarea {
            resize: vertical;
            min-height: 120px;
        }

        .contact-form input[type="submit"] {
            margin-top: 20px;
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 12px 28px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .contact-form input[type="submit"]:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        /* footer */
        footer {
            background-color: var(--primary-color);
            color: rgba(255, 255, 255, 0.8);
            text-align: center;
            padding: 30px 10px;
            margin-top: 60px;
            border-top: 3px solid var(--accent-color);
        }

        footer ul {
            list-style: none;
            padding: 0;
            margin: 0 0 15px 0;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        footer ul li a {
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        footer ul li a:hover {
            color: var(--accent-color);
        }

        footer p {
            margin: 0;
            font-size: 0.9rem;
        }

        /* full responsiveness */
        @media (max-width: 768px) {
            .wrap {
                flex-direction: column;
                text-align: center;
            }
            .brand-container {
                flex-direction: column;
                gap: 10px;
            }
            .contact-grid {
                grid-template-columns: 1fr;
            }
            .top-nav ul {
                padding-top: 5px;
            }
        }
    </style>
</head>
<body>

    <header class="header">
        <div class="wrap">
            <div class="brand-container">
                <div class="logo">
                    <img src="images/CHMSUWeb.png" alt="CHMSU Logo">
                </div>
                <div class="title-area">
                    <h1>CHMSU Binalbagan Clinic Management System</h1>
                    <p>Efficient Scheduling & Healthcare Management</p>
                </div>
            </div>
           <nav class="top-nav">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropbtn">Log In ▼</a>
                        <div class="dropdown-content">
                            <a href="hms/user-login.php">Patient Login</a>
                            <a href="hms/doctor/">Doctor Login</a>
                            <a href="hms/admin">Admin Login</a>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="contact-container">
        <h2>Contact Us</h2>
        
        <div class="contact-grid">
            <section class="company_address">
                <h3>Campus Clinic Directory</h3>
                <p><strong>📍 Address:</strong> Carlos Hilado Memorial State University</p>
                <p style="padding-left: 20px; margin-top: -10px;">Binalbagan Campus, Enclaro,</p>
                <p style="padding-left: 20px; margin-top: -10px;">Binalbagan, Negros Occidental, Philippines</p>
                <p><strong>📞 Phone:</strong> +63 (034) 388-8421</p>
                <p><strong>📠 Fax:</strong> +63 (034) 388-8422</p>
                <p><strong>✉️ Email:</strong> <span>clinic.binalbagan@chmsu.edu.ph</span></p>
            </section>

            <section class="contact-form">
                <form name="contactus" method="post">
                    * <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" placeholder="John Doe" required>
                    
                    * <label for="emailid">E-mail Address</label>
                    <input type="email" id="emailid" name="emailid" placeholder="johndoe@example.com" required>
                    
                    * <label for="mobileno">Mobile Number</label>
                    <input type="text" id="mobileno" name="mobileno" placeholder="09123456789" required>
                    
                    * <label for="description">Message Description</label>
                    <textarea id="description" name="description" placeholder="How can our clinical staff assist you today?" required></textarea>
                    
                    <input type="submit" name="submit" value="Send Message">
                </form>
            </section>
        </div>
    </main>

    <footer>
        <div class="footer-wrap">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
            <p>© 2026 CHMSU Patient System and Scheduling. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>
