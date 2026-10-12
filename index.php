<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHMSU Binalbagan Clinic Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Ropa+Sans&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* CSS Variables for Clean Themes */
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

        .image-flipper {
            max-width: 1200px;
            margin: 30px auto;
            overflow: hidden;
            position: relative;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            height: 400px; /
        }

        .flipper-wrapper {
            display: flex;
            width: 300%;
            height: 100%;
            animation: flipper 15s infinite ease-in-out;
        }

        .flipper-wrapper img {
            width: 33.3333%;
            height: 100%;
            object-fit: cover;
            flex-shrink: 0;
        }

        @keyframes flipper {
            0%, 28% { transform: translateX(0); }
            33%, 61% { transform: translateX(-33.3333%); }
            66%, 94% { transform: translateX(-66.6666%); }
            100% { transform: translateX(0); }
        }

        main {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }

        .card {
            background: var(--white);
            padding: 25px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            border-top: 4px solid var(--accent-color);
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .card h3 {
            margin-top: 0;
            color: var(--primary-color);
        }

        footer {
            background-color: var(--primary-color);
            color: rgba(255, 255, 255, 0.8);
            text-align: center;
            padding: 25px 10px;
            margin-top: 50px;
            font-size: 0.9em;
            border-top: 3px solid var(--accent-color);
        }

        @media (max-width: 768px) {
            .wrap {
                flex-direction: column;
                text-align: center;
            }
            .brand-container {
                flex-direction: column;
                gap: 10px;
            }
            .top-nav ul {
                flex-direction: column;
                width: 100%;
            }
            .top-nav ul li {
                width: 100%;
            }
            .dropdown-content {
                position: relative;
                top: 0;
                width: 100%;
                opacity: 1;
                pointer-events: auto;
                transform: none;
                box-shadow: none;
                display: none;
                background-color: rgba(255, 255, 255, 0.05);
            }
            .dropdown:hover .dropdown-content {
                display: block;
            }
            .dropdown-content a {
                color: var(--white) !important;
            }
            .image-flipper {
                height: 250px;
                margin: 15px;
            }
        }
    </style>
</head>
<body>

    <!-- header section -->
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

    <!-- image flipper banner -->
    <div class="image-flipper">
        <div class="flipper-wrapper">
            <img src="images/clinic1.jpg" alt="Clinic Treatment Room">
            <img src="images/clinic2.jpg" alt="Modern Medical Equipment">
            <img src="images/clinic3.jpg" alt="Friendly Clinic Reception">
        </div>
    </div>

    <!-- Main Content Grid -->
    <main>
        <section class="features-grid">
            <div class="card">
                <h3>📅 Easy Scheduling</h3>
                <p>Book, reschedule, or cancel your clinic appointments easily through our web portal without waiting in long queues.</p>
            </div>
            <div class="card">
                <h3>🩺 Expert Consultations</h3>
                <p>Connect instantly with dedicated university physicians and nurses ready to support your health and well-being.</p>
            </div>
            <div class="card">
                <h3>🔒 Secure Health Records</h3>
                <p>Your medical histories and prescription logs are safely stored and easily managed with top-tier data privacy guidelines.</p>
            </div>
        </section>
    </main>

    <!-- footer Section -->
    <footer>
        <div class="wrap" style="justify-content: center;">
            © 2026 CHMSU Binalbagan Clinic Management System. All Rights Reserved.
        </div>
    </footer>

</body>
</html>