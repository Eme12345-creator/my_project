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
<title>Company Cars | Visit Car</title>

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
}

header h1 { 
    margin:0; 
    font-size:28px; 
}

.container {
    padding:30px 40px;
}

.grid{
    display:grid;
    grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}

.card{
    background:white;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
    padding:15px;
    text-align:center;
    transition:0.2s;
}

.card:hover{transform:translateY(-5px);}

.card img{
    width:100%;
    height:150px;
    object-fit:cover;
    border-radius:8px;
}

.card h3{margin:10px 0 5px;}

.card p{margin:4px 0;font-size:14px;color:#555;}

.rentBtn{
    margin-top:10px;
    padding:10px;
    width:100%;
    background:#111827;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

.rentBtn:hover{background:#4ade80;color:black;}

.back{
    margin-bottom:20px;
}

.back button{
    padding:8px 14px;
    border:none;
    background:#2563eb;
    color:white;
    border-radius:6px;
    cursor:pointer;
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
    
    .container{ 
        padding:20px; 
    }
    
    .grid{ 
        grid-template-columns: 1fr; 
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
        <li onclick="window.location.href='visitcar.php'">
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
    <h1 id="companyTitle">Available Cars</h1>
</header>

<div class="container">
    <div class="grid" id="carsGrid"></div>
</div>

</div>

<script>
function toggleSidebar(){
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("main").classList.toggle("collapsed");
}

// Set active menu item based on current page
document.addEventListener('DOMContentLoaded', function() {
    const currentPage = window.location.pathname.split('/').pop() || 'companycars.php';
    const menuItems = document.querySelectorAll('.menu li');
    
    menuItems.forEach(item => {
        item.classList.remove('active');
    });
    
    const visitCarsItem = document.querySelector('li[onclick*="visitcar.php"]');
    if (visitCarsItem) {
        visitCarsItem.classList.add('active');
    }
});

// FULL CAR LIST PER COMPANY
const companyCars = {
    "SPOT CAR RENTAL PAGADIAN": [
        {model:"Vios", brand:"Toyota", year:2022, price:1200, capacity:5, image:"images/toyotavios.jpg"},
        {model:"Altis", brand:"Toyota", year:2021, price:1500, capacity:5, image:"images/toyotaaltis.jpg"},
        {model:"Fortuner", brand:"Toyota", year:2022, price:2500, capacity:7, image:"images/toyotafortuner.jpg"},
        {model:"Mirage", brand:"Mitsubishi", year:2020, price:1000, capacity:5, image:"images/mirage.jpg"},
        {model:"Jazz", brand:"Honda", year:2019, price:1200, capacity:5, image:"images/hondajazz.jpg"},
        {model:"Innova", brand:"Toyota", year:2021, price:2000, capacity:7, image:"images/toyotainnova.jpg"},
        {model:"Alphard", brand:"Toyota", year:2022, price:3500, capacity:7, image:"images/toyotaalphard.jpg"},
        {model:"Civic", brand:"Honda", year:2022, price:1800, capacity:5, image:"images/hondacivic.jpg"},
        {model:"Hiace", brand:"Toyota", year:2022, price:4000, capacity:15, image:"images/toyotahiace.jpg"},
        {model:"Transit", brand:"Ford", year:2022, price:4200, capacity:14, image:"images/fordtransit.jpg"}
    ],
    "H&M CAR RENTAL SERVICES": [
        {model:"C-Class", brand:"Mercedes", year:2022, price:5000, capacity:5, image:"images/mercedes.jpg"},
        {model:"X5", brand:"BMW", year:2021, price:5500, capacity:5, image:"images/bmwx5.jpg"},
        {model:"A6", brand:"Audi", year:2022, price:5200, capacity:5, image:"images/audia6.jpg"},
        {model:"GLA", brand:"Mercedes", year:2021, price:4800, capacity:5, image:"images/mercedesgla.jpg"},
        {model:"Q7", brand:"Audi", year:2020, price:5300, capacity:5, image:"images/audiq7.jpg"},
        {model:"7 Series", brand:"BMW", year:2022, price:6000, capacity:5, image:"images/bmw7series.jpg"},
        {model:"E-Class", brand:"Mercedes", year:2021, price:5100, capacity:5, image:"images/mercedeseclass.jpg"},
        {model:"X3", brand:"BMW", year:2022, price:5400, capacity:5, image:"images/bmwx3.jpg"},
        {model:"Caravan", brand:"Mercedes", year:2022, price:5000, capacity:12, image:"images/mercedescaravan.jpg"},
        {model:"Tourneo Custom", brand:"Ford", year:2022, price:4300, capacity:14, image:"images/fordtourneo.jpg"}
    ],
    "BREE'S RENT CAR": [
        {model:"Mirage", brand:"Mitsubishi", year:2020, price:1000, capacity:5, image:"images/mitsubishi.jpg"},
        {model:"Jazz", brand:"Honda", year:2019, price:1200, capacity:5, image:"images/hondajazz.jpg"},
        {model:"Yaris", brand:"Toyota", year:2021, price:1100, capacity:5, image:"images/toyotayaris.jpg"},
        {model:"Swift", brand:"Suzuki", year:2020, price:1050, capacity:5, image:"images/suzukiswift.jpg"},
        {model:"Brio", brand:"Honda", year:2019, price:950, capacity:5, image:"images/hondabrio.jpg"},
        {model:"EcoSport", brand:"Ford", year:2021, price:1300, capacity:5, image:"images/fordecosport.jpg"},
        {model:"i10", brand:"Hyundai", year:2020, price:1000, capacity:5, image:"images/hyundaii10.jpg"},
        {model:"Polo", brand:"Volkswagen", year:2021, price:1250, capacity:5, image:"images/toyotavios.jpg"},
                {model:"NV350", brand:"Nissan", year:2021, price:3900, capacity:13, image:"images/nissannv.jpg"},
        {model:"Quantum", brand:"Toyota", year:2020, price:4100, capacity:16, image:"images/toyotaquantum.jpg"}
    ],
    "E.G BALAO CAR RENTAL": [
        {model:"Innova", brand:"Toyota", year:2021, price:2000, capacity:7, image:"images/toyotainnova.jpg"},
        {model:"Alphard", brand:"Toyota", year:2022, price:3500, capacity:7, image:"images/toyotaalphard.jpg"},
        {model:"Odyssey", brand:"Honda", year:2021, price:3200, capacity:8, image:"images/hondacivic.jpg"},
        {model:"Sienna", brand:"Toyota", year:2022, price:3400, capacity:7, image:"images/sienna.jpg"},
        {model:"Grand Livina", brand:"Nissan", year:2020, price:2100, capacity:7, image:"images/livina.jpg"},
        {model:"X-Trail", brand:"Nissan", year:2021, price:2500, capacity:7, image:"images/trail.jpg"},
        {model:"Caravan", brand:"Mercedes", year:2022, price:4000, capacity:12, image:"images/mercedescaravan.jpg"},
        {model:"Voxy", brand:"Toyota", year:2022, price:3300, capacity:7, image:"images/voxy.jpg"},
        {model:"Hiace Commuter", brand:"Toyota", year:2021, price:4000, capacity:15, image:"images/commuter.jpg"},
        {model:"Grand Starex", brand:"Hyundai", year:2021, price:3800, capacity:12, image:"images/starex.jpg"}
    ],
    "KMP CAR RENTAL": [
        {model:"Fortuner", brand:"Toyota", year:2022, price:2500, capacity:7, image:"images/toyotafortuner.jpg"},
        {model:"Pajero", brand:"Mitsubishi", year:2021, price:2400, capacity:7, image:"images/pajero.jpg"},
        {model:"Ranger", brand:"Ford", year:2022, price:2600, capacity:7, image:"images/ranger.jpg"},
        {model:"Hilux", brand:"Toyota", year:2021, price:2450, capacity:7, image:"images/hilux.jpg"},
        {model:"Tucson", brand:"Hyundai", year:2022, price:2300, capacity:7, image:"images/tucson.jpg"},
        {model:"Trailblazer", brand:"Chevrolet", year:2021, price:2500, capacity:7, image:"images/trailblazer.jpg"},
        {model:"Defender", brand:"Land Rover", year:2022, price:5000, capacity:5, image:"images/defender.jpg"},
        {model:"Prado", brand:"Toyota", year:2021, price:2700, capacity:7, image:"images/prado.jpg"},
        {model:"Hiace", brand:"Toyota", year:2022, price:4000, capacity:15, image:"images/toyotahiace.jpg"},
        {model:"Tourneo Custom", brand:"Ford", year:2022, price:4300, capacity:14, image:"images/fordtourneo.jpg"}
    ]
};

// GET SELECTED COMPANY FROM PREVIOUS PAGE
const companyId = localStorage.getItem("selectedCompany");
const cars = companyCars[companyId] || [];

const grid = document.getElementById("carsGrid");
const title = document.getElementById("companyTitle");

// UPDATE PAGE TITLE
title.innerText = companyId 
    ? companyId.toUpperCase() + " - Available Cars"
    : "Available Cars";

// CREATE CAR CARDS
cars.forEach(car=>{
    const card = document.createElement("div");
    card.className="card";
    card.innerHTML = `
        <img src="${car.image}" onerror="this.src='https://via.placeholder.com/250x150/3b82f6/ffffff?text=${car.brand}+${car.model}'">
        <h3>${car.brand} ${car.model}</h3>
        <p>Year: ${car.year}</p>
        <p>₱${car.price.toLocaleString()} / day</p>
        <p>Capacity: ${car.capacity} persons</p>
        <button class="rentBtn">Rent</button>
    `;
    card.querySelector(".rentBtn").addEventListener("click", ()=>{
        // SAVE SELECTED COMPANY AND CAR
        localStorage.setItem("selectedCompany", companyId);
        localStorage.setItem("selectedCar", JSON.stringify(car));
        // REDIRECT TO RENTAL FORM
        window.location.href = "agreement.php"; 
    });
    grid.appendChild(card);
});

// sample cars
let carsSample = [
{ name:"Toyota Vios", status:"available"},
{ name:"Honda Civic", status:"available"},
{ name:"Ford Ranger", status:"rented"},
{ name:"Mitsubishi Montero", status:"available"}
];

// save sa localStorage
localStorage.setItem("cars", JSON.stringify(carsSample));
</script>

</body>
</html>