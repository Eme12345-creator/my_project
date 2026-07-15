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
<title>Home | Car Rental System</title>

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
    background:#111;
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

/* ===== FULLSCREEN HERO ===== */
.hero{
    position:relative;
    height:100vh;
    background:url('https://images.unsplash.com/photo-1503376780353-7e6692767b70') no-repeat center center/cover;
    display:flex;
    justify-content:center;
    align-items:center;
    text-align:center;
    color:white;
}

/* DARK OVERLAY */
.hero::before{
    content:"";
    position:absolute;
    inset:0;
    background:rgba(0,0,0,0.65);
}

/* HERO CONTENT */
.hero-content{
    position:relative;
    z-index:2;
    max-width:850px;
    padding:20px;
}

.hero-content h1{
    font-size:52px;
    font-weight:800;
    margin-bottom:20px;
    letter-spacing:1px;
}

.hero-content p{
    font-size:22px;
    margin-bottom:45px;
    opacity:0.9;
    line-height:1.6;
}

/* BUTTON */
.primary-btn{
    padding:20px 50px;
    font-size:20px;
    font-weight:700;
    border:none;
    border-radius:12px;
    cursor:pointer;
    background:linear-gradient(135deg,#facc15,#f97316);
    color:#111827;
    transition:0.3s ease;
    box-shadow:0 12px 30px rgba(0,0,0,0.4);
    display:inline-flex;
    align-items:center;
    gap:12px;
}

.primary-btn:hover{
    transform:scale(1.1);
    box-shadow:0 18px 45px rgba(0,0,0,0.6);
}

/* BEAUTIFUL FLOATING LIVE CLOCK */
.live-clock{
    position:fixed;
    top:35px;
    right:35px;
    color:white;
    font-weight:700;
    letter-spacing:1px;
    z-index:999;
    text-shadow:0 2px 10px rgba(0,0,0,0.8);
}

.live-clock .date{
    font-size:16px;
    opacity:0.85;
    margin-bottom:4px;
    font-weight:500;
    letter-spacing:1.5px;
    text-shadow:0 1px 5px rgba(0,0,0,0.9);
}

.live-clock .time{
    font-size:28px;
    font-weight:800;
    letter-spacing:2px;
    background:linear-gradient(135deg, #60a5fa, #a78bfa, #f472b6);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    background-clip:text;
    text-shadow:0 4px 20px rgba(96,165,250,0.5);
    animation: timeGlow 3s ease-in-out infinite alternate;
    display:inline-block;
    padding:8px 16px;
    border-radius:12px;
    backdrop-filter: blur(20px);
    border:1px solid rgba(255,255,255,0.2);
}

@keyframes timeGlow{
    0%{
        filter: drop-shadow(0 0 10px rgba(96,165,250,0.6));
        transform:scale(1);
    }
    100%{
        filter: drop-shadow(0 0 25px rgba(167,139,250,0.8));
        transform:scale(1.02);
    }
}

/* Responsive */
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
    
    .hero-content h1{
        font-size:34px;
    }
    .hero-content p{
        font-size:17px;
    }
    
    .live-clock{
        top:25px;
        right:20px;
    }
    
    .live-clock .time{
        font-size:22px;
    }
    
    .live-clock .date{
        font-size:14px;
    }
}

@media(max-width:480px){
    .sidebar{
        width:85px;
    }
    .main{
        margin-left:85px;
    }
    
    .live-clock .time{
        font-size:20px;
        letter-spacing:1px;
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
        <li onclick="window.location.href='home.php'" class="active">
            <i class="fas fa-house"></i><span>Home</span>
        </li>
        <li onclick="window.location.href='account.php'">
            <i class="fas fa-car"></i><span>Account</span>
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
    <div class="hero">
        <div class="hero-content">
            <h1>Rent Your Perfect Car Today</h1>
            <p>
                Looking for a reliable and affordable ride?  
                Choose from our wide selection of vehicles and rent a car in just a few easy steps.
            </p>

            <button class="primary-btn" onclick="window.location.href='visitcar.php'">
                <i class="fas fa-key"></i> Book your Car NOW!
            </button>
        </div>
    </div>
</div>

<!-- BEAUTIFUL FLOATING LIVE CLOCK -->
<div class="live-clock" id="liveClock">
    <div class="date" id="liveDate"></div>
    <div class="time" id="liveTime"></div>
</div>

<script>
function toggleSidebar(){
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("main").classList.toggle("collapsed");
}

// Set active menu item based on current page
document.addEventListener('DOMContentLoaded', function() {
    const currentPage = window.location.pathname.split('/').pop() || 'home.php';
    const menuItems = document.querySelectorAll('.menu li');
    
    menuItems.forEach(item => {
        const link = item.getAttribute('onclick');
        if (link && link.includes(currentPage)) {
            item.classList.add('active');
        }
    });
    
    // Enhanced Live Clock
    function updateClock() {
        const now = new Date();
        const optionsDate = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        };
        const optionsTime = { 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit',
            hour12: true
        };
        
        document.getElementById('liveDate').textContent = now.toLocaleDateString('en-US', optionsDate);
        document.getElementById('liveTime').textContent = now.toLocaleTimeString('en-US', optionsTime);
    }
    
    updateClock();
    setInterval(updateClock, 1000);
});
</script>
</body>
</html>