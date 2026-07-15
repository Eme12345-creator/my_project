<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sales Dashboard | Car Rental System</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
/* SAME STYLES as rentalhistory.php - copy all styles from there */
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

.sidebar.collapsed { width: 85px; }

.sidebar-header {
    display: flex; align-items: center; padding: 28px 24px;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(79, 70, 229, 0.1));
    border-bottom: 1px solid rgba(148, 163, 184, 0.1);
}

.toggle-btn {
    font-size: 24px; cursor: pointer; margin-right: 16px; color: #f8fafc;
    padding: 8px; border-radius: 12px; transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.1);
}

.toggle-btn:hover { background: rgba(99, 102, 241, 0.2); transform: rotate(90deg); }

.sidebar-title { font-size: 20px; font-weight: 700; color: #f8fafc; }

.sidebar.collapsed .sidebar-title { display: none; }

.logo-icon {
    font-size: 28px; margin-right: 12px;
    background: linear-gradient(135deg, #6366f1, #4f46e5); -webkit-background-clip: text;
    -webkit-text-fill-color: transparent; background-clip: text;
}

.menu { list-style: none; margin-top: 8px; padding: 0 8px; }
.menu li { margin-bottom: 4px; }
.menu-item {
    display: flex; align-items: center; padding: 16px 20px; border-radius: 16px;
    cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); color: #94a3b8;
    font-weight: 500; position: relative; overflow: hidden; text-decoration: none;
}
.menu-item:hover { background: rgba(99, 102, 241, 0.15); color: #f8fafc; transform: translateX(8px); }
.menu-item.active { background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(79, 70, 229, 0.2)); color: #6366f1; }
.menu-icon { width: 24px; text-align: center; margin-right: 16px; font-size: 20px; }
.sidebar.collapsed .menu-text { display: none; }
.sidebar.collapsed .menu-item { justify-content: center; padding: 16px; }

.main { margin-left: 280px; width: calc(100% - 280px); transition: all 0.4s; padding: 40px; min-height: 100vh; }
.main.collapsed { margin-left: 85px; width: calc(100% - 85px); }

.page-header { 
    display: flex; justify-content: space-between; align-items: center; 
    margin-bottom: 40px; padding-bottom: 24px; border-bottom: 1px solid rgba(148, 163, 184, 0.1); 
}
.page-title { 
    font-size: 36px; font-weight: 700; 
    background: linear-gradient(135deg, #f8fafc, #e2e8f0); -webkit-background-clip: text; 
    -webkit-text-fill-color: transparent; background-clip: text; 
}

.container { max-width: 1400px; margin: 0 auto; }

.card {
    background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(20px); padding: 32px;
    border-radius: 24px; border: 1px solid rgba(148, 163, 184, 0.1); margin-bottom: 40px;
    overflow-x: auto; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.card h3 { 
    font-size: 24px; font-weight: 600; color: #f8fafc; margin-bottom: 24px; 
    display: flex; align-items: center; gap: 12px; 
}

.stats-grid {
    display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 40px;
}

.stat-card {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(79, 70, 229, 0.1));
    backdrop-filter: blur(20px); padding: 32px; border-radius: 20px;
    border: 1px solid rgba(99, 102, 241, 0.2); text-align: center; position: relative;
    overflow: hidden; transition: all 0.3s ease;
}

.stat-card:hover { transform: translateY(-8px); box-shadow: 0 25px 50px rgba(99, 102, 241, 0.2); }

.stat-icon { font-size: 48px; background: linear-gradient(135deg, #6366f1, #4f46e5); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 16px; }
.stat-number { font-size: 40px; font-weight: 700; background: linear-gradient(135deg, #6366f1, #4f46e5); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 8px; }
.stat-label { font-size: 16px; color: #94a3b8; font-weight: 500; }

.vertical-sales { 
    display: flex; gap: 20px; overflow-x: auto; padding: 20px 0; 
    scrollbar-width: thin; padding-bottom: 20px;
}
.vertical-column {
    min-width: 180px; display: flex; flex-direction: column; gap: 16px;
    background: rgba(99, 102, 241, 0.1); padding: 28px; border-radius: 20px;
    border: 1px solid rgba(99, 102, 241, 0.2); backdrop-filter: blur(15px);
    transition: all 0.3s ease; flex: 1;
}
.vertical-column:hover { transform: translateY(-4px); box-shadow: 0 15px 35px rgba(99, 102, 241, 0.2); }
.vertical-column .header { 
    font-weight: 700; font-size: 16px; color: #6366f1; 
    text-transform: uppercase; letter-spacing: 0.05em; 
}
.vertical-column .item { 
    background: linear-gradient(135deg, #6366f1, #4f46e5); color: white; 
    padding: 20px; border-radius: 16px; font-weight: 700; font-size: 24px; 
    text-align: center; box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3); 
}

.sales-table-container { overflow-x: auto; }
.sales-table { 
    width: 100%; border-collapse: collapse; font-size: 14px; 
    background: rgba(30, 41, 59, 0.5); border-radius: 16px; overflow: hidden;
}
.sales-table th {
    padding: 20px 24px; text-align: left; font-weight: 600; font-size: 13px; 
    color: #10b981; text-transform: uppercase; letter-spacing: 0.05em; 
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(5, 150, 105, 0.2));
}
.sales-table td { 
    padding: 20px 24px; border-bottom: 1px solid rgba(148, 163, 184, 0.1); 
    font-weight: 500; 
}
.sales-table tr:hover { background: rgba(99, 102, 241, 0.1); }

.total-card {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(5, 150, 105, 0.2)) !important;
    border-color: rgba(16, 185, 129, 0.3) !important;
}
.total-card .header { color: #10b981 !important; }
.total-card .item { background: linear-gradient(135deg, #10b981, #059669) !important; }

.logout-btn {
    position: fixed; top: 28px; right: 28px; padding: 14px 28px;
    background: linear-gradient(135deg, #ef4444, #dc2626); border: none; border-radius: 50px;
    color: white; font-weight: 600; font-size: 14px; cursor: pointer; z-index: 999;
    display: flex; align-items: center; gap: 10px; transition: all 0.3s;
    box-shadow: 0 10px 25px rgba(239, 68, 68, 0.3);
}
.logout-btn:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(239, 68, 68, 0.4); }

.toast {
    position: fixed; top: 100px; right: 30px; padding: 16px 24px; border-radius: 12px;
    color: white; font-weight: 600; font-size: 14px; z-index: 3000;
    transform: translateX(400px); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}
.toast.show { transform: translateX(0); }
.toast.success { background: linear-gradient(135deg, #10b981, #059669); }

@media (max-width: 768px) { 
    .main { margin-left: 0 !important; width: 100% !important; padding: 20px; } 
    .stats-grid { grid-template-columns: 1fr; }
    .vertical-sales { flex-direction: column; }
}
</style>
</head>

<body>
<button class="logout-btn" onclick="logout()">
    <i class="fas fa-right-from-bracket"></i> Logout
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
        <li><a href="admin_dashboard.php" class="menu-item"><i class="fas fa-chart-line menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
        <li><a href="rentalhistory.php" class="menu-item"><i class="fas fa-list menu-icon"></i><span class="menu-text">Rental History</span></a></li>
        <li><a href="admin_receipt.php" class="menu-item"><i class="fas fa-file-contract menu-icon"></i><span class="menu-text">Agreements</span></a></li>
        <li><a href="sales.php" class="menu-item active"><i class="fas fa-shopping-cart menu-icon"></i><span class="menu-text">Sales</span></a></li>
        <li><a href="about.php" class="menu-item"><i class="fas fa-circle-info menu-icon"></i><span class="menu-text">About</span></a></li>
    </ul>
</div>

<div class="main" id="main">
    <div class="page-header">
        <h1 class="page-title">Sales Dashboard</h1>
        <div style="font-size: 16px; color: #94a3b8;">
            Last updated: <span id="lastUpdate"></span>
        </div>
    </div>

    <div class="container">
        <!-- Stats Overview -->
        <div class="card">
            <h3><i class="fas fa-chart-line"></i> Sales Overview</h3>
            <div class="stats-grid">
                <div class="stat-card">
                    <i class="fas fa-dollar-sign stat-icon"></i>
                    <div class="stat-number" id="totalSales">₱0</div>
                    <div class="stat-label">Total Revenue</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-car stat-icon"></i>
                    <div class="stat-number" id="totalRentals">0</div>
                    <div class="stat-label">Total Rentals</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-building stat-icon"></i>
                    <div class="stat-number" id="activeCompanies">0</div>
                    <div class="stat-label">Active Companies</div>
                </div>
            </div>
        </div>

        <!-- Company Sales Breakdown -->
        <div class="card">
            <h3><i class="fas fa-chart-bar"></i> Company Sales Breakdown</h3>
            <div class="vertical-sales" id="salesContainer"></div>
        </div>

        <!-- Detailed Sales Table -->
        <div class="card">
            <h3><i class="fas fa-table"></i> Sales Details</h3>
            <div class="sales-table-container">
                <table class="sales-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Company</th>
                            <th>Car</th>
                            <th>Amount</th>
                            <th>Date Approved</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="salesTable"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div class="toast" id="toast"></div>

<script>
function getRentals(){ 
    return JSON.parse(localStorage.getItem("rentals")) || []; 
}

function renderSalesDashboard(){
    const data = getRentals();
    const approvedRentals = data.filter(r => r.approved && (r.status === "Approved" || r.status === "Returned" || r.status === "Active"));
    
    // Update stats
    const totalSales = approvedRentals.reduce((sum, r) => sum + Number(r.amount), 0);
    const totalRentalsCount = approvedRentals.length;
    const activeCompanies = new Set(approvedRentals.map(r => r.company)).size;
    
    document.getElementById('totalSales').textContent = `₱${totalSales.toLocaleString()}`;
    document.getElementById('totalRentals').textContent = totalRentalsCount;
    document.getElementById('activeCompanies').textContent = activeCompanies;
    document.getElementById('lastUpdate').textContent = new Date().toLocaleString();
    
    // Company breakdown
    const salesByCompany = {};
    approvedRentals.forEach(r => {
        if(!salesByCompany[r.company]) salesByCompany[r.company] = 0;
        salesByCompany[r.company] += Number(r.amount);
    });
    
    const salesContainer = document.getElementById("salesContainer");
    if(Object.keys(salesByCompany).length){
        salesContainer.innerHTML = Object.entries(salesByCompany)
            .sort(([,a], [,b]) => b - a)
            .map(([company, amount], index) => `
                <div class="vertical-column ${index === 0 ? 'total-card' : ''}">
                                    <span class="header">${company}</span>
                <span class="item">₱${amount.toLocaleString()}</span>
                <div style="font-size: 12px; color: #94a3b8; margin-top: 8px;">
                    ${Math.round((amount/totalSales)*100)}% of total
                </div>
            </div>
        `).join('') + `
            <div class="vertical-column total-card">
                <span class="header">TOTAL REVENUE</span>
                <span class="item">₱${totalSales.toLocaleString()}</span>
                <div style="font-size: 12px; color: #94a3b8; margin-top: 8px;">
                    ${approvedRentals.length} rentals
                </div>
            </div>`;
    } else {
        salesContainer.innerHTML = '<div style="text-align:center; padding:40px; color:#94a3b8; width:100%;"><i class="fas fa-shopping-cart" style="font-size:64px; opacity:0.3; margin-bottom:16px;"></i><div>No sales yet. Approve rentals to see data here!</div></div>';
    }
    
    // Detailed sales table
    const salesTable = document.getElementById("salesTable");
    salesTable.innerHTML = approvedRentals.sort((a,b) => new Date(b.approvalDate) - new Date(a.approvalDate))
        .map(r => {
            const statusClass = r.status === 'Active' ? 'status-active' : 
                               r.status === 'Returned' ? 'status-returned' : 'status-approved';
            return `
                <tr>
                    <td><strong>#${r.id}</strong></td>
                    <td>${r.customer}</td>
                    <td><span style="color: #6366f1; font-weight: 600;">${r.company}</span></td>
                    <td>${r.car}</td>
                    <td><strong style="color: #10b981;">₱${r.amount.toLocaleString()}</strong></td>
                    <td>${r.approvalDate ? new Date(r.approvalDate).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) : 'N/A'}</td>
                    <td><span class="status-btn ${statusClass}" style="padding: 6px 12px; font-size: 11px;">${r.status}</span></td>
                </tr>
            `;
        }).join('') || '<tr><td colspan="7" style="text-align:center; padding:40px; color:#94a3b8;">No approved sales yet</td></tr>';
}

function showToast(message, type = 'success'){
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.className = `toast ${type} show`;
    setTimeout(() => toast.classList.remove('show'), 4000);
}

function toggleSidebar(){
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("main").classList.toggle("collapsed");
}

function logout(){
    if(confirm('Logout?')) { 
        localStorage.removeItem('admin'); 
        window.location.href = 'login.php'; 
    }
}

// Auto-refresh every 10 seconds (optional - detects changes from other tabs)
setInterval(renderSalesDashboard, 10000);

// =========================================
// INITIALIZATION
// =========================================
document.addEventListener('DOMContentLoaded', function() {
    if(!localStorage.getItem('admin')){
        window.location.href = 'login.php';
        return;
    }
    
    renderSalesDashboard();
    
    // Listen for storage changes (when approving from other tabs)
    window.addEventListener('storage', function(e) {
        if(e.key === 'rentals') {
            showToast('Sales updated!', 'success');
            renderSalesDashboard();
        }
    });
    
    // Animate in
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.6s';
    setTimeout(() => { document.body.style.opacity = '1'; }, 100);
    
    console.log('🚀 Sales Dashboard Loaded!');
    console.log('✅ Fully connected to rental approvals');
    console.log('✅ Auto-updates when rentals are approved');
});
</script>
</body>
</html>