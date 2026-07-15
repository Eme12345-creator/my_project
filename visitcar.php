<?php
session_start();

// Redirect to login page if user is not logged in
if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();
}

// Logout handling
if(isset($_POST['logout'])){
    session_destroy();
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Visit Car | Car Rental System</title>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    display:flex;
    background:#f4f6f9;
}

/* ===== ENHANCED SIDEBAR ===== */
.sidebar{
    width:290px;
    height:100vh;
    background:linear-gradient(180deg,#0f0f23 0%, #1a1a2e 50%, #16213e 100%);
    color:white;
    position:fixed;
    transition:all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    z-index:10;
    box-shadow: 8px 0 40px rgba(0,0,0,0.5);
    border-right:1px solid rgba(255,255,255,0.05);
    overflow:hidden;
}

.sidebar.collapsed{
    width:85px;
}

.sidebar-header{
    display:flex;
    align-items:center;
    padding:30px 25px;
    font-size:22px;
    font-weight:800;
    border-bottom:1px solid rgba(255,255,255,0.08);
    background:linear-gradient(135deg, rgba(59,130,246,0.15), rgba(99,102,241,0.15));
    position:relative;
    backdrop-filter: blur(20px);
}

.sidebar-header::after{
    content:'';
    position:absolute;
    bottom:-10px;
    left:0;
    right:0;
    height:1px;
    background:linear-gradient(90deg, transparent, rgba(59,130,246,0.3), transparent);
}

.toggle-btn{
    font-size:26px;
    cursor:pointer;
    margin-right:18px;
    padding:12px;
    border-radius:16px;
    transition:all 0.3s ease;
    background:rgba(255,255,255,0.08);
    backdrop-filter: blur(10px);
    border:1px solid rgba(255,255,255,0.1);
}

.toggle-btn:hover{
    background:linear-gradient(135deg, rgba(59,130,246,0.3), rgba(99,102,241,0.3));
    transform:rotate(180deg) scale(1.05);
    box-shadow:0 8px 25px rgba(59,130,246,0.3);
}

.sidebar.collapsed .sidebar-title,
.sidebar.collapsed .logo-icon{
    display:none;
}

.sidebar-title{
    letter-spacing:2px;
    background:linear-gradient(135deg, #60a5fa, #a78bfa);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    background-clip:text;
}

.logo-icon{
    font-size:32px;
    margin-right:12px;
    background:linear-gradient(135deg, #3b82f6, #8b5cf6);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    background-clip:text;
    animation: pulseGlow 2s ease-in-out infinite alternate;
}

@keyframes pulseGlow{
    0%{ filter: drop-shadow(0 0 5px rgba(59,130,246,0.5)); }
    100%{ filter: drop-shadow(0 0 15px rgba(139,92,246,0.8)); }
}

.menu{
    list-style:none;
    margin-top:40px;
    padding:0 15px;
    padding-bottom:30px;
}

.menu li{
    padding:20px 25px;
    display:flex;
    align-items:center;
    cursor:pointer;
    transition:all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    color:#d1d5db;
    margin-bottom:12px;
    border-radius:20px;
    position:relative;
    overflow:hidden;
    font-weight:500;
    letter-spacing:0.5px;
    backdrop-filter: blur(10px);
    border:1px solid rgba(255,255,255,0.05);
}

.menu li::before{
    content:'';
    position:absolute;
    left:0;
    top:0;
    height:100%;
    width:0;
    background:linear-gradient(135deg,#3b82f6,#6366f1,#8b5cf6);
    transition:all 0.4s ease;
    z-index:-1;
    border-radius:20px;
}

.menu li:hover::before{
    width:100%;
}

.menu li:hover{
    background:rgba(255,255,255,0.12);
    color:white;
    transform:translateX(12px) scale(1.02);
    box-shadow:0 12px 35px rgba(59,130,246,0.3);
    border-color:rgba(59,130,246,0.3);
}

.menu li.active{
    background:linear-gradient(135deg,#3b82f6,#6366f1,#8b5cf6);
    color:white;
    box-shadow:0 15px 40px rgba(59,130,246,0.4);
    border-color:rgba(59,130,246,0.4);
    transform:translateX(8px);
}

.menu li.active::before{
    width:0;
}

.menu li i{
    width:35px;
    text-align:center;
    margin-right:20px;
    font-size:20px;
    background:linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.1));
    border-radius:12px;
    padding:8px;
    transition:0.3s ease;
}

.menu li:hover i,
.menu li.active i{
    background:linear-gradient(135deg, rgba(255,255,255,0.4), rgba(255,255,255,0.3));
    transform:scale(1.1);
}

.sidebar.collapsed .menu li span{
    display:none;
}

.sidebar.collapsed .menu li i{
    margin-right:0;
    width:45px;
}

.logout-section{
    position:absolute;
    bottom:30px;
    left:25px;
    right:25px;
}

.logout-menu-item{
    padding:22px 28px;
    display:flex;
    align-items:center;
    cursor:pointer;
    transition:all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    color:#d1d5db;
    border-radius:24px;
    position:relative;
    overflow:hidden;
    background:rgba(255,255,255,0.05);
    backdrop-filter: blur(20px);
    border:1px solid rgba(255,255,255,0.08);
    font-weight:600;
    letter-spacing:0.5px;
    width:100%;
}

.logout-menu-item::before{
    content:'';
    position:absolute;
    left:0;
    top:0;
    height:100%;
    width:0;
    background:linear-gradient(135deg,#ef4444,#dc2626,#b91c1c);
    transition:all 0.4s ease;
    z-index:-1;
    border-radius:24px;
}

.logout-menu-item:hover::before{
    width:100%;
}

.logout-menu-item:hover{
    color:white;
    transform:translateX(8px) scale(1.02);
    box-shadow:0 15px 40px rgba(239,68,68,0.4);
    border-color:rgba(239,68,68,0.3);
}

.logout-menu-item i{
    width:35px;
    text-align:center;
    margin-right:20px;
    font-size:20px;
    background:linear-gradient(135deg, rgba(255,255,255,0.15), rgba(255,255,255,0.08));
    border-radius:14px;
    padding:10px;
    transition:0.3s ease;
}

.logout-menu-item:hover i{
    background:linear-gradient(135deg, rgba(255,255,255,0.3), rgba(255,255,255,0.2));
    transform:scale(1.1);
}

.sidebar.collapsed .logout-menu-item span{
    display:none;
}

.sidebar.collapsed .logout-menu-item i{
    margin-right:0;
    width:45px;
}

.sidebar.collapsed .logout-section{
    left:20px;
    right:20px;
}

/* ===== MAIN ===== */
.main{
    margin-left:290px;
    width:100%;
    transition:all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    min-height:100vh;
}

.main.collapsed{
    margin-left:85px;
}

header { 
    background:#111827; 
    color:white; 
    text-align:center; 
    padding:20px; 
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
    margin-top: 0;
}

header h1 { 
    margin:0; 
    font-size:28px; 
}

.company-container {
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(280px,1fr));
    gap:20px;
    padding:30px 40px;
}

.company-card {
    background:white;
    border-radius:15px;
    padding:20px;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
    display:flex;
    flex-direction:column;
    align-items:center;
    transition: transform 0.2s, box-shadow 0.2s;
}

.company-card:hover {
    transform:translateY(-5px);
    box-shadow:0 8px 25px rgba(0,0,0,0.15);
}

.company-logo { 
    width:100px; 
    height:100px; 
    object-fit:cover; 
    border-radius:50%; 
    margin-bottom:15px; 
}
.company-name { 
    font-size:22px; 
    font-weight:bold; 
    margin-bottom:5px; 
    text-align:center; 
}
.company-owner { 
    font-size:14px; 
    color:#555; 
    margin-bottom:10px; 
    text-align:center; 
}
.company-message { 
    font-size:14px; 
    color:#333; 
    margin-bottom:15px; 
    text-align:center; 
}
.visit-btn { 
    padding:10px 20px; 
    border:none; 
    border-radius:8px; 
    background:#111827; 
    color:white; 
    cursor:pointer; 
    font-weight:bold; 
    transition:0.2s; 
}
.visit-btn:hover { 
    background:#4ade80; 
    color:black; 
}

@media(max-width:768px){
    .sidebar{
        width:290px;
    }
    .sidebar.collapsed{
        width:85px;
    }
    .main{
        margin-left:290px;
    }
    .main.collapsed{
        margin-left:85px;
    }
    
    .company-container{ 
        grid-template-columns: 1fr; 
        padding:20px; 
    }
}

@media(max-width:480px){
    .sidebar{
        width:85px;
    }
    .main{
        margin-left:85px;
    }
}
</style>
</head>
<body>

<!-- ENHANCED SIDEBAR - FULLY VISIBLE BY DEFAULT -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <i class="fas fa-bars toggle-btn" onclick="toggleSidebar()"></i>
        <i class="fas fa-car logo-icon"></i>
        <span class="sidebar-title">Car Rental</span>
    </div>
    
    <ul class="menu">
        <li onclick="window.location.href='home.php'">
            <i class="fas fa-house"></i><span>Home</span>
        </li>
        <li onclick="window.location.href='visitcar.php'" class="active">
            <i class="fas fa-store"></i><span>Visit Cars</span>
        </li>
        <li onclick="window.location.href='my_rentals.php'">
            <i class="fas fa-car"></i><span>My Rentals</span>
        </li>
        <li onclick="window.location.href='notifications.php'">
            <i class="fas fa-bell"></i><span>Notifications</span>
        </li>
        <li onclick="window.location.href='About.php'">
            <i class="fas fa-circle-info"></i><span>About</span>
        </li>
    </ul>
    
    <!-- ENHANCED LOGOUT SECTION -->
    <div class="logout-section">
        <form method="POST">
            <button type="submit" name="logout" class="logout-menu-item">
                <i class="fas fa-right-from-bracket"></i><span>Logout</span>
            </button>
        </form>
    </div>
</div>

<!-- MAIN -->
<div class="main" id="main">

<header>
    <h1>Choose a Car Rental Company</h1>
</header>

<div class="company-container">

    <!-- COMPANY 1 -->
    <div class="company-card">
        <img src="images/spot (2).jpg" alt="Speedy Rentals Logo" class="company-logo">
        <div class="company-name">SPOT CAR RENTAL PAGADIAN</div>
        <div class="company-owner">Owner: Juan Dela Cruz</div>
        <div class="company-message">Fast and reliable cars for your daily commute.</div>
        <button class="visit-btn" onclick="visitCompany('SPOT CAR RENTAL PAGADIAN')">Visit Cars</button>
    </div>

    <!-- COMPANY 2 -->
    <div class="company-card">
        <img src="images/h&m.jpg" alt="Luxury Wheels Logo" class="company-logo">
        <div class="company-name">H&M CAR RENTAL SERVICES</div>
        <div class="company-owner">Owner: Maria Santos</div>
        <div class="company-message">Drive in style with our luxury car selection.</div>
        <button class="visit-btn" onclick="visitCompany('H&M CAR RENTAL SERVICES')">Visit Cars</button>
    </div>

    <!-- COMPANY 3 -->
    <div class="company-card">
        <img src="images/BREES.jpg" alt="Eco Rides Logo" class="company-logo">
        <div class="company-name">BREE'S RENT CAR</div>
        <div class="company-owner">Owner: Pedro Reyes</div>
        <div class="company-message">Affordable and eco-friendly cars for everyone.</div>
        <button class="visit-btn" onclick="visitCompany('BREE\'S RENT CAR')">Visit Cars</button>
    </div>

    <!-- COMPANY 4 -->
    <div class="company-card">
        <img src="images/EG.jpg" alt="Family Car Rentals Logo" class="company-logo">
        <div class="company-name">E.G BALAO CAR RENTAL</div>
        <div class="company-owner">Owner: Ana Cruz</div>
        <div class="company-message">Comfortable cars perfect for family trips.</div>
        <button class="visit-btn" onclick="visitCompany('E.G BALAO CAR RENTAL')">Visit Cars</button>
    </div>

    <!-- COMPANY 5 -->
    <div class="company-card">
        <img src="images/KMP.jpg" alt="Adventure Motors Logo" class="company-logo">
        <div class="company-name">KMP CAR RENTAL</div>
        <div class="company-owner">Owner: Luis Santos</div>
        <div class="company-message">Reliable SUVs and trucks for your adventure needs.</div>
        <button class="visit-btn" onclick="visitCompany('KMP CAR RENTAL')">Visit Cars</button>
    </div>

</div>

</div>

<script>
function toggleSidebar(){
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("main").classList.toggle("collapsed");
}

// Set active menu item based on current page
document.addEventListener('DOMContentLoaded', function() {
    const currentPage = window.location.pathname.split('/').pop() || 'visitcar.php';
    const menuItems = document.querySelectorAll('.menu li');
    
    menuItems.forEach(item => {
        const link = item.getAttribute('onclick');
        if (link && link.includes(currentPage)) {
            item.classList.add('active');
        }
    });
});

// listahan ng companies
let companies = [
"SPOT CAR RENTAL PAGADIAN",
"H&M CAR RENTAL SERVICES",
"BREE'S RENT CAR",
"E.G BALAO CAR RENTAL",
"KMP CAR RENTAL"
];

// save sa localStorage
localStorage.setItem("companies", JSON.stringify(companies));

// kapag nag-click sa Visit Cars
function visitCompany(companyName){

    localStorage.setItem("selectedCompany", companyName);

    window.location.href = "companycars.php";
}
</script>

</body>
</html>