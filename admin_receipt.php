<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Car Rental Agreement Receipt</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
* { 
    margin:0; 
    padding:0; 
    box-sizing:border-box; 
    font-family:'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

body { 
    background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%);
    color: #e2e8f0;
    min-height: 100vh;
    overflow-x: hidden;
}

/* Enhanced Sidebar - SAME AS ADMIN DASHBOARD */
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

/* Main Content Area */
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

/* ORIGINAL RECEIPT STYLES - ADAPTED TO NEW THEME */
.receipt-container { 
    background: rgba(15, 23, 42, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(148, 163, 184, 0.1);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
}

.header { 
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 50%, #7c3aed 100%);
    color: #f8fafc;
    padding: 40px;
    text-align: center;
}

.header h1 { 
    font-size: 36px; 
    font-weight: 700;
    margin-bottom: 12px;
    letter-spacing: -0.025em;
}

.header p { 
    font-size: 18px; 
    opacity: 0.95;
    margin-bottom: 8px;
}

.receipt-body { 
    padding: 40px; 
}

.section { 
    margin-bottom: 32px; 
}

.section-title { 
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(79, 70, 229, 0.2));
    color: #6366f1;
    padding: 18px 24px; 
    font-size: 20px; 
    font-weight: 600; 
    margin: -24px -40px 24px -40px; 
    border-radius: 16px 16px 0 0;
    border-bottom: 1px solid rgba(99, 102, 241, 0.2);
}

.detail-row { 
    display: flex; 
    justify-content: space-between; 
    padding: 16px 0; 
    border-bottom: 1px solid rgba(148, 163, 184, 0.1);
    transition: all 0.3s ease;
}

.detail-row:hover {
    background: rgba(99, 102, 241, 0.05);
    border-radius: 12px;
    padding-left: 12px;
    padding-right: 12px;
}

.detail-row:last-child { 
    border-bottom: none; 
}

.detail-label { 
    font-weight: 600; 
    color: #94a3b8;
    font-size: 15px;
}

.detail-value { 
    color: #f8fafc; 
    font-size: 16px; 
    font-weight: 500;
}

.car-info { 
    background: rgba(99, 102, 241, 0.1);
    backdrop-filter: blur(10px);
    padding: 32px; 
    border-radius: 16px; 
    border: 1px solid rgba(99, 102, 241, 0.2);
    margin: 24px 0;
    position: relative;
    overflow: hidden;
}

.car-info::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #6366f1, #4f46e5, #ec4899);
}

.signature-section { 
    text-align: center; 
    margin: 48px 0; 
}

.signature-canvas { 
    border: 3px solid rgba(99, 102, 241, 0.5); 
    border-radius: 20px; 
    max-width: 100%; 
    height: 220px; 
    background: rgba(248, 250, 252, 0.05); 
    margin: 24px auto; 
    display: block;
    backdrop-filter: blur(10px);
}

.buttons { 
    display: flex; 
    gap: 20px; 
    justify-content: center; 
    margin-top: 48px; 
    flex-wrap: wrap;
}

.btn { 
    padding: 16px 32px; 
    border: none; 
    border-radius: 16px; 
    font-size: 16px; 
    font-weight: 600; 
    cursor: pointer; 
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
    text-decoration: none; 
    display: inline-flex;
    align-items: center;
    gap: 8px;
    backdrop-filter: blur(10px);
}

.btn-print { 
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: #f8fafc;
    border: 1px solid rgba(99, 102, 241, 0.3);
}

.btn-print:hover { 
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(99, 102, 241, 0.3);
}

.btn-back { 
    background: linear-gradient(135deg, #64748b, #475569);
    color: #f8fafc;
    border: 1px solid rgba(100, 116, 139, 0.3);
}

.btn-back:hover { 
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(100, 116, 139, 0.3);
}

.btn-email { 
    background: linear-gradient(135deg, #10b981, #059669);
    color: #f8fafc;
    border: 1px solid rgba(16, 185, 129, 0.3);
}

.btn-email:hover { 
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(16, 185, 129, 0.3);
}

.status-active { 
    color: #10b981; 
    font-weight: 600; 
}

.status-pending { 
    color: #f59e0b; 
    font-weight: 600; 
}

@media print {
    .sidebar { display: none !important; }
    body { 
        background: white !important; 
        color: black !important;
        padding: 0 !important;
    }
    .main {
        margin-left: 0 !important;
        width: 100% !important;
        padding: 20px !important;
    }
    .receipt-container { 
        box-shadow: none !important; 
        border: none !important;
        background: white !important;
    }
    .buttons { display: none !important; }
    .no-print { display: none !important; }
    .detail-row:hover { background: none !important; }
}

@media (max-width: 768px) {
    .sidebar { 
        transform: translateX(-100%); 
        z-index: 2000;
    }
    .sidebar.open { 
        transform: translateX(0); 
    }
    .main { 
        margin-left: 0 !important; 
        width: 100% !important; 
        padding: 20px; 
    }
    .receipt-body { 
        padding: 24px; 
    }
    .detail-row { 
        flex-direction: column; 
        gap: 8px; 
    }
    .header h1 { 
        font-size: 28px; 
    }
    .buttons {
        flex-direction: column;
        align-items: center;
    }
    .btn {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
}
</style>
</head>

<body>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-header-content">
            <i class="fas fa-car logo-icon"></i>
            <i class="fas fa-bars toggle-btn" onclick="toggleSidebar()"></i>
            <span class="sidebar-title">Car Rental System</span>
        </div>
    </div>
    <ul class="menu">
        <li>
            <a href="admin_dashboard.php" class="menu-item">
                <i class="fas fa-chart-line menu-icon"></i>
                <span class="menu-text">Admin Dashboard</span>
            </a>
        </li>
        <li>
            <a href="rentalhistory.php" class="menu-item">
                <i class="fas fa-list menu-icon"></i>
                <span class="menu-text">Rental History</span>
            </a>
        </li>
        <li>
            <a href="admin_receipt.php" class="menu-item active">
                <i class="fas fa-file-contract menu-icon"></i>
                <span class="menu-text">Receipts</span>
            </a>
        </li>
        <li>
            <a href="about.php" class="menu-item">
                <i class="fas fa-circle-info menu-icon"></i>
                <span class="menu-text">About</span>
            </a>
        </li>
    </ul>
</div>

<div class="main" id="main">
    <div class="receipt-container" id="receiptContainer">
        <div class="header">
            <h1><i class="fas fa-file-contract"></i> RENTAL AGREEMENT RECEIPT</h1>
            <p>Official Receipt & Contract Confirmation</p>
            <p id="receiptId">Receipt # Loading...</p>
        </div>
        
        <div class="receipt-body">
            <div class="section">
                <div class="section-title"><i class="fas fa-receipt"></i> Receipt Information</div>
                <div class="detail-row">
                    <span class="detail-label">Receipt ID:</span>
                    <span class="detail-value" id="receiptIdValue">-</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Date Submitted:</span>
                    <span class="detail-value" id="submittedDate">-</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value status-active" id="status">Active</span>
                </div>
            </div>

            <div class="section">
                <div class="section-title"><i class="fas fa-user"></i> Renter Details</div>
                <div class="detail-row">
                    <span class="detail-label">Full Name:</span>
                    <span class="detail-value" id="customer">-</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Phone:</span>
                    <span class="detail-value" id="phone">-</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value" id="email">-</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Driver's License:</span>
                    <span class="detail-value" id="license">-</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Address:</span>
                    <span class="detail-value" id="address">-</span>
                </div>
            </div>

            <div class="section">
                <div class="section-title"><i class="fas fa-car-side"></i> Rental Details</div>
                <div class="car-info">
                    <div style="font-size:28px; font-weight:700; margin-bottom:20px;" id="carDisplay">-</div>
                    <div class="detail-row">
                        <span class="detail-label">Rental Company:</span>
                        <span class="detail-value" id="company">-</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Start Date:</span>
                        <span class="detail-value" id="startDate">-</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">End Date:</span>
                        <span class="detail-value" id="endDate">-</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Payment Method:</span>
                        <span class="detail-value" id="paymentMethod">-</span>
                    </div>
                </div>
            </div>

            <div class="section">
                               <div class="section-title"><i class="fas fa-shield-alt"></i> Insurance & Liability</div>
                <div style="padding:28px; background:rgba(16,185,129,0.1); border-radius:16px; border:1px solid rgba(16,185,129,0.2);">
                    <div class="detail-row">
                        <span class="detail-label">Insurance Coverage:</span>
                        <span class="detail-value" id="insuranceDisplay">-</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Liability Acknowledged:</span>
                        <span class="detail-value" id="liabilityDisplay">-</span>
                    </div>
                </div>
            </div>

            <div class="section">
                <div class="section-title"><i class="fas fa-dollar-sign"></i> Payment Summary</div>
                <div style="padding:28px; background:rgba(245,158,11,0.1); border-radius:16px; border:1px solid rgba(245,158,11,0.2);">
                    <div style="font-size:24px; font-weight:700; color:#f59e0b; margin-bottom:20px;">
                        💰 Amount to be calculated based on rental duration
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Total Amount:</span>
                        <span class="detail-value" style="color:#f59e0b; font-size:24px; font-weight:700;">₱<span id="totalAmount">0.00</span></span>
                    </div>
                </div>
            </div>

            <div class="signature-section">
                <div style="font-size:28px; font-weight:700; margin-bottom:24px; color:#f8fafc;">
                    <i class="fas fa-signature"></i> Renter's Digital Signature
                </div>
                <img id="signatureImage" class="signature-canvas" src="" alt="Signature">
                <div style="margin-top:20px; font-size:16px; color:#94a3b8;">
                    Signed electronically on <span id="signatureDate">-</span>
                </div>
            </div>

            <div class="section no-print">
                <div class="section-title"><i class="fas fa-cogs"></i> Actions</div>
                <div class="buttons">
                    <button onclick="window.print()" class="btn btn-print">
                        <i class="fas fa-print"></i> Print Receipt
                    </button>
                    <a href="index.html" class="btn btn-back">
                        <i class="fas fa-home"></i> New Rental
                    </a>
                    <button onclick="emailReceipt()" class="btn btn-email">
                        <i class="fas fa-envelope"></i> Email Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// SAME EXACT FUNCTIONALITY - NO CHANGES
function loadRentalData() {
    const urlParams = new URLSearchParams(window.location.search);
    const rentalId = urlParams.get('id');
    
    let rentals = JSON.parse(localStorage.getItem("rentals") || "[]");
    let rental;
    
    if (rentalId) {
        rental = rentals.find(r => r.id == rentalId);
    } else {
        rental = rentals[rentals.length - 1];
    }
    
    if (!rental) {
        alert("❌ No rental data found!");
        window.location.href = "index.html";
        return;
    }
    
    document.getElementById('receiptIdValue').textContent = `#${rental.id}`;
    document.getElementById('receiptId').textContent = `Receipt #${rental.id}`;
    document.getElementById('submittedDate').textContent = new Date(rental.submittedAt).toLocaleString('en-PH');
    document.getElementById('status').textContent = rental.status;
    document.getElementById('status').className = `detail-value status-${rental.status}`;
    document.getElementById('customer').textContent = rental.customer;
    document.getElementById('phone').textContent = rental.phone;
    document.getElementById('email').textContent = rental.email;
    document.getElementById('license').textContent = rental.license;
    document.getElementById('address').textContent = rental.address;
    document.getElementById('company').textContent = rental.company;
    document.getElementById('startDate').textContent = new Date(rental.start).toLocaleDateString('en-PH');
    document.getElementById('endDate').textContent = new Date(rental.end).toLocaleDateString('en-PH');
    document.getElementById('paymentMethod').textContent = rental.paymentMethod.replace('_', ' ').toUpperCase();
    document.getElementById('carDisplay').innerHTML = `🚗 ${rental.car}`;
    document.getElementById('signatureImage').src = rental.signature;
    document.getElementById('signatureDate').textContent = new Date(rental.submittedAt).toLocaleString('en-PH');
    
    document.getElementById('insuranceDisplay').innerHTML = rental.insurance ? '✅ YES (Additional coverage)' : '❌ NO';
    document.getElementById('liabilityDisplay').innerHTML = rental.liability ? '✅ Acknowledged' : '❌ Not acknowledged';
    
    const start = new Date(rental.start);
    const end = new Date(rental.end);
    const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
    const baseRate = 1500;
    const total = days * baseRate;
    document.getElementById('totalAmount').textContent = total.toLocaleString();
    
    localStorage.setItem('currentReceipt', JSON.stringify(rental));
}

function emailReceipt() {
    const rental = JSON.parse(localStorage.getItem('currentReceipt') || '{}');
    const subject = `Car Rental Receipt #${rental.id}`;
    const body = `
🎉 CAR RENTAL RECEIPT #${rental.id}

Customer: ${rental.customer}
Car: ${rental.car}
Company: ${rental.company}
Dates: ${new Date(rental.start).toLocaleDateString()} - ${new Date(rental.end).toLocaleDateString()}
Total: ₱${document.getElementById('totalAmount').textContent}

Signature attached above.

Thank you for renting with us! 🚗
    `;
    
    const mailto = `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    window.open(mailto);
}

// SIDEBAR FUNCTIONALITY
function toggleSidebar(){
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("main").classList.toggle("collapsed");
}

// LOAD ON PAGE READY
document.addEventListener('DOMContentLoaded', function() {
    loadRentalData();
    
    // Smooth loading animation
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
    setTimeout(() => {
        document.body.style.opacity = '1';
    }, 100);
});
</script>

</body>
</html>