<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard | Car Rental System</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%);
    color: #e2e8f0;
    min-height: 100vh;
    overflow-x: hidden;
}

/* Enhanced Sidebar */
.sidebar {
    width: 280px;
    height: 100vh;
    background: linear-gradient(180deg, #1e293b 0%, #0f172a 50%, #020617 100%);
    position: fixed;
    backdrop-filter: blur(20px);
    border-right: 1px solid rgba(148, 163, 184, 0.1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    z-index: 1000;
    box-shadow: 0 0 40px rgba(0, 0, 0, 0.3);
}

.sidebar.collapsed {
    width: 85px;
}

.sidebar-header {
    display: flex;
    align-items: center;
    padding: 28px 24px;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(79, 70, 229, 0.1));
    border-bottom: 1px solid rgba(148, 163, 184, 0.1);
    position: relative;
    overflow: hidden;
}

.sidebar-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    opacity: 0.05;
}

.sidebar-header-content {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    width: 100%;
}

.toggle-btn {
    font-size: 24px;
    cursor: pointer;
    margin-right: 16px;
    color: #f8fafc;
    padding: 8px;
    border-radius: 12px;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.1);
}

.toggle-btn:hover {
    background: rgba(99, 102, 241, 0.2);
    transform: rotate(90deg);
}

.sidebar-title {
    font-size: 20px;
    font-weight: 700;
    color: #f8fafc;
    letter-spacing: -0.025em;
}

.sidebar.collapsed .sidebar-title {
    display: none;
}

.logo-icon {
    font-size: 28px;
    margin-right: 12px;
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Enhanced Menu */
.menu {
    list-style: none;
    margin-top: 8px;
    padding: 0 8px;
}

.menu li {
    margin-bottom: 4px;
}

.menu-item {
    display: flex;
    align-items: center;
    padding: 16px 20px;
    border-radius: 16px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    color: #94a3b8;
    font-weight: 500;
    position: relative;
    overflow: hidden;
    text-decoration: none;
}

.menu-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.2), transparent);
    transition: left 0.6s;
}

.menu-item:hover::before {
    left: 100%;
}

.menu-item:hover {
    background: rgba(99, 102, 241, 0.15);
    color: #f8fafc;
    transform: translateX(8px);
}

.menu-item.active {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(79, 70, 229, 0.2));
    color: #6366f1;
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.15);
}

.menu-icon {
    width: 24px;
    text-align: center;
    margin-right: 16px;
    font-size: 20px;
}

.sidebar.collapsed .menu-text {
    display: none;
}

.sidebar.collapsed .menu-item {
    justify-content: center;
    padding: 16px;
}

/* Enhanced Main Content */
.main {
    margin-left: 280px;
    width: calc(100% - 280px);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 40px;
    min-height: 100vh;
}

.main.collapsed {
    margin-left: 85px;
    width: calc(100% - 85px);
}

/* Header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
    padding-bottom: 24px;
    border-bottom: 1px solid rgba(148, 163, 184, 0.1);
}

.page-title {
    font-size: 36px;
    font-weight: 700;
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: -0.02em;
}

.page-subtitle {
    color: #64748b;
    font-size: 16px;
    margin-top: 8px;
}

/* DASHBOARD STATS FROM RENTAL HISTORY */
.dashboard-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
    margin-bottom: 40px;
}

.stat-card {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(79, 70, 229, 0.1));
    backdrop-filter: blur(20px);
    padding: 32px;
    border-radius: 20px;
    border: 1px solid rgba(99, 102, 241, 0.2);
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #6366f1, #4f46e5, #6366f1);
}

.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(99, 102, 241, 0.2);
}

.stat-icon {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.8;
}

.stat-number {
    font-size: 40px;
    font-weight: 700;
    color: #6366f1;
    margin-bottom: 8px;
}

.stat-label {
    font-size: 16px;
    color: #94a3b8;
    font-weight: 500;
}

/* Logout Button */
.logout-btn {
    position: fixed;
    top: 28px;
    right: 28px;
    padding: 14px 28px;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border: none;
    border-radius: 50px;
    color: white;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    z-index: 999;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 10px 25px rgba(239, 68, 68, 0.3);
}

.logout-btn:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(239, 68, 68, 0.4);
    background: linear-gradient(135deg, #f87171, #ef4444);
}

.logout-btn:active {
    transform: scale(0.97);
}

/* Responsive */
@media (max-width: 1200px) {
    .dashboard-stats { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 768px) {
    .sidebar { transform: translateX(-100%); }
    .sidebar.open { transform: translateX(0); }
    .main { margin-left: 0 !important; width: 100% !important; padding: 20px; }
    .dashboard-stats { grid-template-columns: 1fr; gap: 16px; }
    .stat-number { font-size: 32px; }
}

@media (max-width: 480px) {
    .main { padding: 16px; }
    .stat-card { padding: 24px; }
}
</style>
</head>
<body>

<button class="logout-btn" onclick="logout()">
    <i class="fas fa-right-from-bracket"></i>
    Logout
</button>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-header-content">
            <i class="fas fa-car logo-icon"></i>
            <i class="fas fa-bars toggle-btn" onclick="toggleSidebar()"></i>
            <span class="sidebar-title">Car Rental Admin</span>
        </div>
    </div>
    <ul class="menu">
        <li>
            <a href="mydashboard.php" class="menu-item active" target="_self">
                <i class="fas fa-chart-line menu-icon"></i>
                <span class="menu-text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="rentalhistory.php" class="menu-item" target="_self">
                <i class="fas fa-list menu-icon"></i>
                <span class="menu-text">Rental History</span>
            </a>
        </li>
        <li>
            <a href="admin_receipt.php" class="menu-item" target="_self">
                <i class="fas fa-file-contract menu-icon"></i>
                <span class="menu-text">Agreements</span>
            </a>
        </li>
        <li>
            <a href="sales.php" class="menu-item" target="_self">
                <i class="fas fa-shopping-cart menu-icon"></i>
                <span class="menu-text">Sales</span>
            </a>
        </li>
        <li>
            <a href="about.php" class="menu-item" target="_self">
                <i class="fas fa-circle-info menu-icon"></i>
                <span class="menu-text">About</span>
            </a>
        </li>
    </ul>
</div>

<div class="main" id="main">
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">Real-time overview of your rental business performance.</p>
        </div>
        <div style="display:flex;gap:16px;">
            <button onclick="refreshData()" style="padding:12px 24px;border-radius:16px;background:rgba(99,102,241,0.2);border:1px solid rgba(99,102,241,0.3);color:#6366f1;font-weight:500;cursor:pointer;transition:0.3s;">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
        </div>
    </div>

    <!-- DASHBOARD STATS FROM RENTAL HISTORY - FULLY CONNECTED -->
    <div class="dashboard-stats" id="dashboardStats">
        <div class="stat-card">
            <i class="fas fa-users stat-icon" style="color: #6366f1;"></i>
            <div class="stat-number" id="totalUsers">0</div>
            <div class="stat-label">Total Users</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-car stat-icon" style="color: #10b981;"></i>
            <div class="stat-number" id="totalRentals">0</div>
            <div class="stat-label">Total Rentals</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-check-circle stat-icon" style="color: #10b981;"></i>
            <div class="stat-number" id="approvedCount">0</div>
            <div class="stat-label">Approved</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-clock stat-icon" style="color: #f59e0b;"></i>
            <div class="stat-number" id="pendingCount">0</div>
            <div class="stat-label">Pending</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-coins stat-icon" style="color: #f59e0b;"></i>
            <div class="stat-number" id="totalRevenue">₱0</div>
            <div class="stat-label">Total Revenue</div>
        </div>
    </div>
</div>

<script>
// =========================================
// SAME DATA SYSTEM AS RENTAL HISTORY - FULLY CONNECTED
// =========================================

function initSampleData() {
    if(!localStorage.getItem("rentals")){
        const sample = [
            {id:1, customer:"Juan Dela Cruz", company:"Toyota", car:"Vios", start:"2026-03-01", end:"2026-03-03", amount:3000, status:"Approved", approved:true, approvalDate:"2026-01-15", email:"juan@example.com"},
            {id:2, customer:"Maria Santos", company:"Honda", car:"Civic", start:"2026-03-05", end:"2026-03-07", amount:5000, status:"Active", approved:true, approvalDate:"2026-01-16", email:"maria@example.com"},
            {id:3, customer:"Pedro Reyes", company:"Toyota", car:"Corolla", start:"2026-03-10", end:"2026-03-15", amount:7500, status:"Pending", approved:false, email:"pedro@example.com"},
            {id:4, customer:"Ana Lim", company:"Honda", car:"CR-V", start:"2026-03-12", end:"2026-03-14", amount:4500, status:"Rejected", approved:false, approvalDate:"2026-01-14", reason:"Insufficient documents", email:"ana@example.com"},
            {id:5, customer:"Jose Rizal", company:"Toyota", car:"Camry", start:"2026-03-20", end:"2026-03-25", amount:12000, status:"Pending", approved:false, email:"jose@example.com"}
        ];
        localStorage.setItem("rentals", JSON.stringify(sample));
    }
}

function getRentals(){ 
    initSampleData(); 
    return JSON.parse(localStorage.getItem("rentals")) || []; 
}

// =========================================
// ENHANCED DASHBOARD STATS - SAME AS RENTAL HISTORY
// =========================================
function renderDashboardStats() {
    const data = getRentals();
    const uniqueUsers = new Set(data.map(r => r.customer)).size;
    const totalRentals = data.length;
    const totalRevenue = data.reduce((sum, r) => sum + Number(r.amount), 0);
    const approvedCount = data.filter(r => r.approved).length;
    const pendingCount = data.filter(r => !r.approved && r.status !== 'Rejected').length;

    document.getElementById('totalUsers').textContent = uniqueUsers;
    document.getElementById('totalRentals').textContent = totalRentals;
    document.getElementById('approvedCount').textContent = approvedCount;
    document.getElementById('pendingCount').textContent = pendingCount;
    document.getElementById('totalRevenue').textContent = `₱${totalRevenue.toLocaleString()}`;
}

// =========================================
// REFRESH FUNCTION - UPDATES FROM SAME DATA SOURCE
// =========================================
function refreshData() {
    const refreshBtn = event.target.closest('button');
    const originalText = refreshBtn.innerHTML;
    
    refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Refreshing...';
    refreshBtn.style.opacity = '0.7';
    
    setTimeout(() => {
        renderDashboardStats();
        refreshBtn.innerHTML = originalText;
        refreshBtn.style.opacity = '1';
        
        // Success animation
        refreshBtn.style.transform = 'scale(1.05)';
        setTimeout(() => {
            refreshBtn.style.transform = 'scale(1)';
        }, 200);
        
        showToast('Dashboard refreshed!', 'success');
    }, 800);
}

// Toast notification (same as rental history)
function showToast(message, type = 'info'){
    const toast = document.createElement('div');
    toast.className = `toast ${type} show`;
    toast.style.cssText = `
                position: fixed; top: 100px; right: 30px; padding: 16px 24px; 
        border-radius: 12px; color: white; font-weight: 600; font-size: 14px; 
        z-index: 3000; transform: translateX(400px); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    `;
    
    if(type === 'success') {
        toast.style.background = 'linear-gradient(135deg, #10b981, #059669)';
    } else if(type === 'error') {
        toast.style.background = 'linear-gradient(135deg, #ef4444, #dc2626)';
    } else {
        toast.style.background = 'linear-gradient(135deg, #3b82f6, #2563eb)';
    }
    
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.transform = 'translateX(0)';
    }, 100);
    
    setTimeout(() => {
        toast.style.transform = 'translateX(400px)';
        setTimeout(() => document.body.removeChild(toast), 400);
    }, 3000);
}

// UI Controls
function toggleSidebar(){
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("main").classList.toggle("collapsed");
}

function logout(){
    if(confirm('Are you sure you want to logout?')) {
        localStorage.removeItem('admin');
        window.location.href = 'login.php';
    }
}

// =========================================
// INITIALIZATION - FULLY CONNECTED TO RENTAL HISTORY DATA
// =========================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Car Rental Admin Dashboard Loaded Successfully!');
    console.log('✅ Connected to same rental data as Rental History page');
    
    // Load dashboard data from SAME SOURCE as rental history
    renderDashboardStats();
    
    // Auto-login demo
    localStorage.setItem('admin', 'true');
    
    // Smooth loading animation
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
    setTimeout(() => {
        document.body.style.opacity = '1';
    }, 100);
    
    // Auto-refresh every 5 minutes (optional)
    setInterval(() => {
        if (document.visibilityState === 'visible') {
            renderDashboardStats();
        }
    }, 300000); // 5 minutes
    
    console.log('✅ Dashboard shows: Total Users, Total Rentals, Approved, Pending, Revenue');
    console.log('✅ Data synced with rentalhistory.php');
});

// Listen for storage changes (if user adds data from rental history page)
window.addEventListener('storage', function(e) {
    if(e.key === 'rentals') {
        renderDashboardStats();
    }
});
</script>

</body>
</html>