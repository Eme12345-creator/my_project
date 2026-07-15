<?php
session_start();

// Redirect to login page if user is not logged in
if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();
}

// Generate CSRF token for security
if(!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Account | Car Rental System</title>

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

/* ===== SAME ENHANCED SIDEBAR ===== */
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
    padding:40px;
}

.main.collapsed{
    margin-left:85px;
}

/* ===== ACCOUNT DASHBOARD ===== */
.account-hero{
    background:linear-gradient(135deg, rgba(59,130,246,0.1), rgba(139,92,246,0.1));
    backdrop-filter: blur(20px);
    border-radius:30px;
    padding:50px;
    margin-bottom:40px;
    border:1px solid rgba(255,255,255,0.1);
    box-shadow:0 25px 60px rgba(0,0,0,0.3);
    position:relative;
    overflow:hidden;
}

.account-hero::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    right:0;
    height:4px;
    background:linear-gradient(90deg, #3b82f6, #8b5cf6, #f472b6);
}

.account-hero h1{
    color:white;
    font-size:42px;
    font-weight:800;
    margin-bottom:15px;
    letter-spacing:1px;
    text-shadow:0 4px 20px rgba(0,0,0,0.5);
}

.account-hero p{
    color:rgba(255,255,255,0.9);
    font-size:18px;
    line-height:1.6;
    margin-bottom:30px;
}

.status-badge{
    display:inline-flex;
    align-items:center;
    gap:10px;
    padding:12px 24px;
    background:linear-gradient(135deg, rgba(34,197,94,0.2), rgba(74,222,128,0.2));
    border:1px solid rgba(34,197,94,0.3);
    border-radius:50px;
    color:#22c55e;
    font-weight:600;
    font-size:16px;
    backdrop-filter: blur(10px);
}

.status-badge.saved{
    background:linear-gradient(135deg, rgba(34,197,94,0.3), rgba(74,222,128,0.3));
    animation: pulseGlow 2s infinite;
}

/* ===== FORM STYLES ===== */
.form-container{
    background:linear-gradient(135deg, rgba(15,15,35,0.95), rgba(26,26,46,0.95));
    backdrop-filter: blur(30px);
    border-radius:25px;
    padding:50px;
    border:1px solid rgba(255,255,255,0.08);
    box-shadow:0 20px 50px rgba(0,0,0,0.4);
    max-width:900px;
    margin:0 auto;
}

.form-grid{
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap:30px;
    margin-bottom:40px;
}

.form-group{
    position:relative;
    margin-bottom:25px;
}

.form-group.full-width{
    grid-column: 1 / -1;
}

label{
    display:block;
    color:rgba(255,255,255,0.9);
    font-weight:600;
    margin-bottom:10px;
    font-size:15px;
    letter-spacing:0.5px;
}

input, select, textarea{
    width:100%;
    padding:18px 20px;
    background:rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.15);
    border-radius:16px;
    color:white;
    font-size:16px;
    transition:all 0.3s ease;
    backdrop-filter: blur(10px);
}

input:focus, select:focus, textarea:focus{
    outline:none;
    border-color:rgba(59,130,246,0.5);
    box-shadow:0 0 0 4px rgba(59,130,246,0.1);
    background:rgba(255,255,255,0.12);
    transform:translateY(-2px);
}

input::placeholder, textarea::placeholder{
    color:rgba(255,255,255,0.5);
}

.form-row{
    display:flex;
    gap:20px;
}

.form-row .form-group{
    flex:1;
}

.btn-group{
    display:flex;
    gap:20px;
    justify-content:center;
    flex-wrap:wrap;
}

.btn-primary, .btn-secondary{
    padding:18px 40px;
    border:none;
    border-radius:16px;
    font-size:17px;
    font-weight:700;
    cursor:pointer;
    transition:all 0.3s ease;
    display:inline-flex;
    align-items:center;
    gap:12px;
    min-width:180px;
}

.btn-primary{
    background:linear-gradient(135deg,#3b82f6,#6366f1);
    color:white;
    box-shadow:0 10px 30px rgba(59,130,246,0.4);
}

.btn-primary:hover{
    transform:translateY(-3px) scale(1.05);
    box-shadow:0 20px 40px rgba(59,130,246,0.5);
}

.btn-secondary{
    background:rgba(255,255,255,0.1);
    color:white;
    border:1px solid rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
}

.btn-secondary:hover{
    background:rgba(255,255,255,0.2);
    transform:translateY(-2px);
}

.saved-success{
    background:linear-gradient(135deg, #22c55e, #4ade80);
    color:white;
    padding:20px;
    border-radius:16px;
    margin-bottom:30px;
    display:none;
    animation: slideIn 0.5s ease;
    border:1px solid rgba(255,255,255,0.2);
}

@keyframes slideIn{
    from{ transform: translateY(-20px); opacity:0; }
    to{ transform: translateY(0); opacity:1; }
}

/* Live Clock */
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
}

.live-clock .time{
    font-size:28px;
    font-weight:800;
    letter-spacing:2px;
    background:linear-gradient(135deg, #60a5fa, #a78bfa, #f472b6);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    background-clip:text;
    animation: timeGlow 3s ease-in-out infinite alternate;
}

@keyframes timeGlow{
    0%{ filter: drop-shadow(0 0 10px rgba(96,165,250,0.6)); transform:scale(1); }
    100%{ filter: drop-shadow(0 0 25px rgba(167,139,250,0.8)); transform:scale(1.02); }
}

/* Responsive */
@media(max-width:768px){
    .main{ margin-left:290px; padding:20px; }
    .main.collapsed{ margin-left:85px; }
    .form-grid{ grid-template-columns: 1fr; gap:20px; }
    .form-row{ flex-direction: column; gap:0; }
    .account-hero h1{ font-size:32px; }
    .btn-group{ flex-direction: column; }
}
</style>
</head>
<body>

<!-- SAME SIDEBAR -->
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
        <li onclick="window.location.href='account.php'" class="active">
            <i class="fas fa-car"></i><span>Account</span>
        </li>
        <li onclick="window.location.href='notifications.php'">
            <i class="fas fa-bell"></i><span>Notifications</span>
        </li>
        <li onclick="window.location.href='About.php'">
            <i class="fas fa-circle-info"></i><span>About</span>
        </li>
    </ul>
    
    
        </form>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="main" id="main">
    <div class="account-hero">
               <h1><i class="fas fa-user-cog"></i> Rental Details</h1>
                <p>Save your personal information here to make booking faster. Your data is securely stored locally in your browser.</p>
        <div class="status-badge" id="statusBadge">
            <i class="fas fa-circle-check"></i>
            <span id="statusText">Load your saved details</span>
        </div>
    </div>

    <div class="form-container">
        <!-- Success Message -->
        <div class="saved-success" id="successMessage">
            <i class="fas fa-check-circle" style="font-size:24px; margin-right:12px;"></i>
            <strong>Details saved successfully!</strong> Your rental information is now ready for booking.
        </div>

        <form id="rentalForm">
            <div class="form-grid">
                <!-- Personal Info -->
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Full Name *</label>
                    <input type="text" id="fullName" placeholder="Enter your full name" required>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-phone"></i> Phone Number *</label>
                    <input type="tel" id="phone" placeholder="+63 912 345 6789" required>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email Address *</label>
                    <input type="email" id="email" placeholder="your.email@example.com" required>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-calendar-alt"></i> Date of Birth</label>
                    <input type="date" id="dob">
                </div>

                <!-- Address -->
                <div class="form-group full-width">
                    <label><i class="fas fa-map-marker-alt"></i> Complete Address *</label>
                    <textarea id="address" rows="3" placeholder="Enter your complete address" required></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-city"></i> City *</label>
                        <input type="text" id="city" placeholder="e.g. Manila" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-hashtag"></i> ZIP Code</label>
                        <input type="text" id="zipcode" placeholder="e.g. 1000">
                    </div>
                </div>

                <!-- License & Documents -->
                <div class="form-group">
                    <label><i class="fas fa-id-card"></i> Driver's License Number *</label>
                    <input type="text" id="licenseNumber" placeholder="e.g. N12-345678-901" required>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-file-upload"></i> Driver's License Image</label>
                    <input type="file" id="licenseImage" accept="image/*">
                    <small style="color:rgba(255,255,255,0.6); font-size:13px; margin-top:5px; display:block;">Upload a clear photo of your driver's license (optional)</small>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-calendar"></i> License Expiry Date *</label>
                    <input type="date" id="licenseExpiry" required>
                </div>
            </div>

            <div class="btn-group">
                <button type="button" class="btn-secondary" onclick="clearForm()">
                    <i class="fas fa-trash"></i> Clear All
                </button>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Save Details
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Live Clock -->
<div class="live-clock" id="liveClock">
    <div class="date" id="liveDate"></div>
    <div class="time" id="liveTime"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set active menu item
    const currentPage = window.location.pathname.split('/').pop() || 'account.php';
    const menuItems = document.querySelectorAll('.menu li');
    menuItems.forEach(item => {
        const href = item.getAttribute('onclick');
        if (href && href.includes(currentPage)) {
            item.classList.add('active');
        }
    });

    // Load saved rental details from localStorage
    loadRentalDetails();

    // Form submission
    const form = document.getElementById('rentalForm');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        saveRentalDetails();
    });

    // Update clock
    updateClock();
    setInterval(updateClock, 1000);
});

function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("main").classList.toggle("collapsed");
}

function loadRentalDetails() {
    const rentalDetails = JSON.parse(localStorage.getItem('rentalDetails') || '{}');
    
    // Populate form fields
    document.getElementById('fullName').value = rentalDetails.fullName || '';
    document.getElementById('phone').value = rentalDetails.phone || '';
    document.getElementById('email').value = rentalDetails.email || '';
    document.getElementById('dob').value = rentalDetails.dob || '';
    document.getElementById('address').value = rentalDetails.address || '';
    document.getElementById('city').value = rentalDetails.city || '';
    document.getElementById('zipcode').value = rentalDetails.zipcode || '';
    document.getElementById('licenseNumber').value = rentalDetails.licenseNumber || '';
    document.getElementById('licenseImage').value = '';
    document.getElementById('licenseExpiry').value = rentalDetails.licenseExpiry || '';

    // Update status
    if (Object.keys(rentalDetails).length > 0) {
        document.getElementById('statusText').textContent = 'Details loaded successfully!';
        document.getElementById('statusBadge').classList.add('saved');
    }
}

function saveRentalDetails() {
    const licenseImageFile = document.getElementById('licenseImage').files[0];
    let licenseImageData = null;

    // Handle license image upload (convert to base64)
    if (licenseImageFile) {
        const reader = new FileReader();
        reader.onload = function(e) {
            licenseImageData = e.target.result;
            finalizeSave(licenseImageData);
        };
        reader.readAsDataURL(licenseImageFile);
    } else {
        finalizeSave(licenseImageData);
    }

    function finalizeSave(imageData) {
        const rentalDetails = {
            fullName: document.getElementById('fullName').value,
            phone: document.getElementById('phone').value,
            email: document.getElementById('email').value,
            dob: document.getElementById('dob').value,
            address: document.getElementById('address').value,
            city: document.getElementById('city').value,
            zipcode: document.getElementById('zipcode').value,
            licenseNumber: document.getElementById('licenseNumber').value,
            licenseImage: imageData || null,
            licenseExpiry: document.getElementById('licenseExpiry').value,
            savedAt: new Date().toISOString()
        };

        localStorage.setItem('rentalDetails', JSON.stringify(rentalDetails));

        // Show success message
        const successMsg = document.getElementById('successMessage');
        successMsg.style.display = 'block';
        document.getElementById('statusBadge').classList.add('saved');
        document.getElementById('statusText').textContent = 'Details saved! Ready for booking.';

        // Auto-hide success message
        setTimeout(() => {
            successMsg.style.display = 'none';
        }, 5000);

        // Visual feedback
        const btn = document.querySelector('.btn-primary');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Saved!';
        btn.style.background = 'linear-gradient(135deg, #22c55e, #4ade80)';
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.style.background = 'linear-gradient(135deg, #3b82f6, #6366f1)';
        }, 2000);
    }
}

function clearForm() {
    if (confirm('Are you sure you want to clear all saved details?')) {
        localStorage.removeItem('rentalDetails');
        document.getElementById('rentalForm').reset();
        document.getElementById('statusBadge').classList.remove('saved');
        document.getElementById('statusText').textContent = 'Details cleared';
        document.getElementById('successMessage').style.display = 'none';
    }
}

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
</script>
</body>
</html>