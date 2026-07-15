<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About - Car Rental System</title>
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

/* ===== ENHANCED SIDEBAR - IDENTICAL TO HOME ===== */
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
    padding:30px 30px 50px;
}

.main.collapsed{
    margin-left:85px;
}

/* ===== EXISTING ABOUT PAGE STYLES (UNCHANGED) ===== */
.hero{
    background:linear-gradient(135deg, rgba(59,130,246,0.12), rgba(99,102,241,0.12));
    backdrop-filter:blur(15px); color:#f1f5f9; padding:40px 30px; 
    text-align:center; border-radius:20px; margin-bottom:40px;
    border:1px solid rgba(255,255,255,0.08);
}
.hero h1{ 
    font-size:36px; font-weight:900; margin-bottom:15px; 
    background:linear-gradient(135deg, #3b82f6, #f8fafc); 
    -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; 
}
.hero p{ font-size:17px; max-width:700px; margin:0 auto; line-height:1.6; opacity:0.95; }

.container{ 
    max-width:1200px; margin:0 auto; display:grid; 
    grid-template-columns:repeat(auto-fit, minmax(380px, 1fr)); gap:25px; padding:0 10px; 
}

.company-card{
    background:linear-gradient(145deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02));
    backdrop-filter:blur(15px); border-radius:20px; overflow:hidden;
    transition:all 0.3s cubic-bezier(0.4,0,0.2,1); border:1px solid rgba(255,255,255,0.06);
    box-shadow:0 10px 35px rgba(0,0,0,0.2);
}
.company-card:hover{ 
    transform:translateY(-8px); 
    box-shadow:0 20px 50px rgba(59,130,246,0.2);
    border-color:rgba(59,130,246,0.2);
}

.company-left{
    background:linear-gradient(135deg, #3b82f6, #1e40af); color:#f8fafc;
    padding:25px 20px; display:flex; flex-direction:column; align-items:center;
    min-height:140px; position:relative;
}
.company-logo{
    width:80px; height:80px; border-radius:50%; object-fit:cover; margin-bottom:12px;
    border:3px solid rgba(255,255,255,0.3); box-shadow:0 6px 20px rgba(0,0,0,0.3);
}
.company-name{ font-size:18px; font-weight:800; text-align:center; margin-bottom:4px; letter-spacing:-0.2px; }
.company-owner{ font-size:13px; opacity:0.9; text-align:center; font-weight:500; }

.company-right{ padding:25px 25px 20px; }
.company-about{
    font-size:16px; line-height:1.6; color:#e2e8f0; margin-bottom:15px;
    font-weight:500; position:relative;
}
.company-extra{
    font-size:14px; color:#cbd5e1; line-height:1.5; font-weight:500;
    display:flex; flex-direction:column; gap:8px;
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
        padding:20px 15px 40px;
    }
    .main.collapsed{
        margin-left:85px;
    }
    
    .container{ grid-template-columns:1fr; gap:20px; }
    .hero{ padding:30px 20px; margin-bottom:30px; }
    .company-left, .company-right{ padding:20px; }
    .company-logo{ width:70px; height:70px; }
}

@media(max-width:480px){
    .sidebar{
        width:85px;
    }
    .main{
        margin-left:85px;
        padding:20px 15px 40px;
    }
}
</style>
</head>

<body>

<!-- ENHANCED SIDEBAR - IDENTICAL TO HOME -->
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
        <li onclick="window.location.href='my_rentals.php'">
            <i class="fas fa-car"></i><span>My Rentals</span>
        </li>
        <li onclick="window.location.href='notifications.php'">
            <i class="fas fa-bell"></i><span>Notifications</span>
        </li>
        <li onclick="window.location.href='About.php'" class="active">
            <i class="fas fa-circle-info"></i><span>About</span>
        </li>
    </ul>
    
    
        </form>
    </div>
</div>

<!-- MAIN -->
<div class="main" id="main">

<section class="hero">
    <h1>Our Partner Companies</h1>
    <p>We collaborate with trusted car rental companies across the region. Discover each partner's story, fleet, and exceptional services below.</p>
</section>

<div class="container">

    <!-- COMPANY 1 -->
    <div class="company-card">
        <div class="company-left">
            <img src="images/spot.jpg" alt="SPOT CAR RENTAL PAGADIAN" class="company-logo">
            <div class="company-name">SPOT CAR RENTAL PAGADIAN</div>
            <div class="company-owner">Owner: Juan Dela Cruz</div>
        </div>
        <div class="company-right">
            <div class="company-about">
                SPOT CAR RENTAL PAGADIAN is a trusted partner providing fast and reliable cars for daily commutes. 
                Our fleet includes compact, sedan, and SUV options. We ensure that every vehicle is well-maintained.
            </div>
            <div class="company-extra">
                <span>📅 Established: 2010</span>
                <span>📍 Rizal St., Pagadian City</span>
                <span>📞 +63 912 345 6789</span>
            </div>
        </div>
    </div>

    <!-- COMPANY 2 -->
    <div class="company-card">
        <div class="company-left">
            <img src="images/HM.jpg" alt="H&M CAR RENTAL SERVICES" class="company-logo">
            <div class="company-name">H&M CAR RENTAL SERVICES</div>
            <div class="company-owner">Owner: Maria Santos</div>
        </div>
        <div class="company-right">
            <div class="company-about">
                H&M CAR RENTAL SERVICES specializes in luxury vehicles for clients who want comfort and style.
                Each vehicle is inspected and comes with premium service.
            </div>
            <div class="company-extra">
                <span>📅 Established: 2015</span>
                <span>📍 Mabini Ave., Zamboanga City</span>
                <span>📞 +63 923 456 7890</span>
                <span>Premium insurance available</span>
            </div>
        </div>
    </div>

    <!-- COMPANY 3 -->
    <div class="company-card">
        <div class="company-left">
            <img src="images/BREES.jpg" alt="BREE'S RENT CAR" class="company-logo">
            <div class="company-name">BREE'S RENT CAR</div>
            <div class="company-owner">Owner: Pedro Reyes</div>
        </div>
        <div class="company-right">
            <div class="company-about">
                BREE'S RENT CAR offers affordable and eco-friendly vehicles suitable for students, families, 
                and daily commuters with fuel-efficient options.
            </div>
            <div class="company-extra">
                <span>📅 Established: 2012</span>
                <span>📍 San Jose Rd., Dipolog City</span>
                <span>📞 +63 934 567 8901</span>
                <span>Repeat customer discounts</span>
            </div>
        </div>
    </div>

    <!-- COMPANY 4 -->
    <div class="company-card">
        <div class="company-left">
            <img src="images/EG.jpg" alt="E.G BALAO CAR RENTAL" class="company-logo">
            <div class="company-name">E.G BALAO CAR RENTAL</div>
            <div class="company-owner">Owner: Ana Cruz</div>
        </div>
        <div class="company-right">
            <div class="company-about">
                E.G BALAO CAR RENTAL focuses on family-friendly vehicles perfect for trips and vacations 
                with comfort and safety features.
            </div>
            <div class="company-extra">
                <span>📅 Established: 2011</span>
                <span>📍 P. Gomez St., Pagadian City</span>
                                <span>📞 +63 945 678 9012</span>
                <span>Child seats available</span>
            </div>
        </div>
    </div>

    <!-- COMPANY 5 -->
    <div class="company-card">
        <div class="company-left">
            <img src="images/KMP.jpg" alt="KMP CAR RENTAL" class="company-logo">
            <div class="company-name">KMP CAR RENTAL</div>
            <div class="company-owner">Owner: Luis Santos</div>
        </div>
        <div class="company-right">
            <div class="company-about">
                KMP CAR RENTAL provides SUVs and trucks for adventure and outdoor activities 
                with smooth booking process.
            </div>
            <div class="company-extra">
                <span>📅 Established: 2013</span>
                <span>📍 Diversion Rd., Pagadian City</span>
                <span>📞 +63 956 789 0123</span>
                <span>Off-road vehicles available</span>
            </div>
        </div>
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
    const currentPage = window.location.pathname.split('/').pop() || 'About.php';
    const menuItems = document.querySelectorAll('.menu li');
    
    menuItems.forEach(item => {
        const link = item.getAttribute('onclick');
        if (link && link.includes(currentPage)) {
            item.classList.add('active');
        }
    });
});
</script>

</body>
</html>