<?php
session_start();
include "db.php";

// Redirect if not admin
if(!isset($_SESSION['admin'])){
    header("Location: index.php");
    exit();
}

// Fetch stats from DB
$userCount = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
$rentalCount = $conn->query("SELECT COUNT(*) as total FROM rentals")->fetch_assoc()['total'];
$sales = $conn->query("SELECT SUM(total_price) as total FROM rentals")->fetch_assoc()['total'] ?? 0;
$companyCount = $conn->query("SELECT COUNT(*) as total FROM companies")->fetch_assoc()['total'];
$carCount = $conn->query("SELECT COUNT(*) as total FROM cars")->fetch_assoc()['total'];
$availableCars = $conn->query("SELECT COUNT(*) as total FROM cars WHERE status='available'")->fetch_assoc()['total'];

// Fetch recent rentals
$rentalsResult = $conn->query("SELECT r.id, u.email, r.car_model, r.rental_date, r.return_date, r.total_price 
                               FROM rentals r 
                               JOIN users u ON r.user_id = u.id 
                               ORDER BY r.rental_date DESC LIMIT 10");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard | Car Rental System</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{display:flex;background:#111;color:white;}

/* SIDEBAR */
.sidebar{
    width:270px;height:100vh;background:linear-gradient(180deg,#1f2937,#111827);
    position:fixed;transition:0.3s ease;overflow:auto;
}
.sidebar.collapsed{width:80px;}
.sidebar-header{display:flex;align-items:center;padding:20px;font-size:18px;font-weight:600;border-bottom:1px solid rgba(255,255,255,0.1);}
.toggle-btn{font-size:22px;cursor:pointer;margin-right:15px;}
.sidebar.collapsed .sidebar-title{display:none;}
.menu{list-style:none;margin-top:20px;}
.menu li{padding:15px 22px;display:flex;align-items:center;cursor:pointer;transition:0.2s;color:#d1d5db;}
.menu li:hover{background:#374151;color:white;}
.menu li i{width:30px;text-align:center;margin-right:15px;}
.sidebar.collapsed .menu li span{display:none;}

/* MAIN */
.main{margin-left:270px;width:100%;transition:0.3s ease;padding:30px;}
.main.collapsed{margin-left:80px;}

/* LOGOUT BUTTON */
.logout-btn{
    position:fixed;top:20px;right:25px;padding:10px 20px;
    background:linear-gradient(135deg,#ef4444,#dc2626);border:none;border-radius:50px;color:white;
    font-weight:600;cursor:pointer;z-index:999;display:flex;align-items:center;gap:8px;transition:0.3s;
}
.logout-btn:hover{transform:translateY(-3px);background:linear-gradient(135deg,#f87171,#ef4444);box-shadow:0 10px 25px rgba(0,0,0,0.4);}
.logout-btn:active{transform:scale(0.95);}

/* DASHBOARD CARDS - 3x2 GRID */
.cards{
    display:grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom:30px;
}

.card{
    background:#1f2937;
    padding:25px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.3);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
    box-shadow:0 15px 35px rgba(0,0,0,0.5);
}

.card h3{font-size:20px;margin-bottom:10px;color:#60a5fa;}
.card p{font-size:24px;font-weight:700;}

/* TABLE */
table{width:100%;border-collapse:collapse;background:#1f2937;border-radius:12px;overflow:hidden;box-shadow:0 10px 25px rgba(0,0,0,0.3);}
table th, table td{padding:15px;text-align:left;border-bottom:1px solid rgba(255,255,255,0.1);}
table th{background:#111827;color:#60a5fa;font-weight:600;}
table tr:hover{background:#374151;}

/* RESPONSIVE */
@media(max-width:992px){.cards{grid-template-columns: repeat(2, 1fr);}}
@media(max-width:600px){.cards{grid-template-columns: 1fr;}}
</style>
</head>
<body>

<button class="logout-btn" onclick="logout()"><i class="fas fa-right-from-bracket"></i> Logout</button>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <i class="fas fa-bars toggle-btn" onclick="toggleSidebar()"></i>
        <span class="sidebar-title">Car Rental Admin</span>
    </div>
    <ul class="menu">
    <li>
        <a href="admin_dashboard.php" style="display:flex;align-items:center;color:inherit;text-decoration:none;">
            <i class="fas fa-chart-line"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li>
        <a href="history.php" style="display:flex;align-items:center;color:inherit;text-decoration:none;">
            <i class="fas fa-list"></i>
            <span>Rental History</span>
        </a>
    </li>
    <li>
        <a href="rental_agreements.php" style="display:flex;align-items:center;color:inherit;text-decoration:none;">
            <i class="fas fa-file-contract"></i>
            <span>Agreements</span>
        </a>
    </li>
    <li>
        <a href="sales.php" style="display:flex;align-items:center;color:inherit;text-decoration:none;">
            <i class="fas fa-shopping-cart"></i>
            <span>Sales</span>
        </a>
    </li>
    <li>
        <a href="About.php" style="display:flex;align-items:center;color:inherit;text-decoration:none;">
            <i class="fas fa-circle-info"></i>
            <span>About</span>
        </a>
    </li>
</ul>
</div>

<div class="main" id="main">
    <h1>Admin Dashboard</h1>

    <div class="cards">
        <div class="card">
            <h3>Total Users</h3>
            <p><?php echo $userCount; ?></p>
        </div>
        <div class="card">
            <h3>Total Companies</h3>
            <p><?php echo $companyCount; ?></p>
        </div>
        <div class="card">
            <h3>Total Cars</h3>
            <p><?php echo $carCount; ?></p>
        </div>
        <div class="card">
            <h3>Available Cars</h3>
            <p><?php echo $availableCars; ?></p>
        </div>
        <div class="card">
            <h3>Total Rentals</h3>
            <p><?php echo $rentalCount; ?></p>
        </div>
        <div class="card">
            <h3>Total Sales</h3>
            <p>$<?php echo number_format($sales, 2); ?></p>
        </div>
    </div>

    <h2>Recent Rentals</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User Email</th>
                <th>Car Model</th>
                <th>Rental Date</th>
                <th>Return Date</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $rentalsResult->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['car_model']; ?></td>
                <td><?php echo $row['rental_date']; ?></td>
                <td><?php echo $row['return_date']; ?></td>
                <td>$<?php echo number_format($row['total_price'],2); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function toggleSidebar(){
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("main").classList.toggle("collapsed");
}

function logout(){
    <?php session_destroy(); ?>
    window.location.href="index.php";
}
</script>
</body>
</html>