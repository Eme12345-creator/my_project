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
<title>Car Rental Agreement</title>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
    width:calc(100% - 290px);
    transition:all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    min-height:100vh;
    padding:40px;
    background:#ffffff;
}

.main.collapsed{
    margin-left:85px;
    width:calc(100% - 85px);
}

body{
    display:flex;
    background:#ffffff;
    min-height:100vh;
}

/* ===== WIDENED FORM STYLES ===== */
h2{ 
    text-align:center; 
    padding:30px 0; 
    font-size:42px; 
    color:#333; 
    margin-bottom:40px;
    letter-spacing:1px;
    text-shadow:0 2px 10px rgba(0,0,0,0.1);
}

form{ 
    width:100%; 
    max-width:1400px; 
    margin:0 auto; 
}

table{ 
    width:100%; 
    border-collapse:collapse; 
    background:white; 
    box-shadow:0 25px 60px rgba(0,0,0,0.15); 
    border-radius:25px; 
    overflow:hidden;
    border:1px solid rgba(0,0,0,0.05);
}

td,th{ 
    padding:25px 30px; 
    border:1px solid #e5e7eb; 
    vertical-align:top; 
    font-size:16px;
}

.section-title{ 
    background:linear-gradient(135deg, #3b82f6, #6366f1, #8b5cf6); 
    color:white; 
    font-weight:700; 
    font-size:22px; 
    text-align:left;
    letter-spacing:1px;
    text-shadow:0 2px 10px rgba(0,0,0,0.3);
}

label{ 
    display:block; 
    margin-bottom:12px; 
    font-weight:600; 
    color:#374151; 
    font-size:16px;
}

input, textarea, select{ 
    width:100%; 
    padding:18px 20px; 
    border-radius:12px; 
    border:2px solid #e5e7eb; 
    font-size:16px; 
    transition:all 0.3s ease;
    background:#fafafa;
    font-family:inherit;
}

input:focus, textarea:focus, select:focus{ 
    outline:none; 
    border-color:#3b82f6; 
    box-shadow:0 0 0 4px rgba(59,130,246,0.1);
    background:white;
    transform:translateY(-2px);
}

textarea{ 
    line-height:1.7; 
    resize:vertical; 
    min-height:90px; 
}

canvas{ 
    border:3px solid #e5e7eb; 
    border-radius:16px; 
    cursor:crosshair; 
    width:100%; 
    height:200px; 
    background:#f9fafb; 
    touch-action:none;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
}

.submit-btn{ 
    width:100%; 
    padding:25px; 
    border:none; 
    background:linear-gradient(135deg, #3b82f6, #6366f1); 
    color:white; 
    font-size:24px; 
    font-weight:700; 
    cursor:pointer; 
    border-radius:16px; 
    transition:all 0.3s ease;
    letter-spacing:1px;
    box-shadow:0 15px 40px rgba(59,130,246,0.3);
    display:flex;
    align-items:center;
    justify-content:center;
    gap:12px;
}

.submit-btn:hover:not(:disabled){ 
    background:linear-gradient(135deg, #2563eb, #4f46e5); 
    transform:translateY(-4px); 
    box-shadow:0 25px 50px rgba(59,130,246,0.4);
}

.submit-btn:disabled{ 
    background:#9ca3af; 
    cursor:not-allowed; 
    transform:none; 
    box-shadow:none;
}

.clear-btn{ 
    padding:15px 25px; 
    background:#6b7280; 
    border:none; 
    color:white; 
    border-radius:12px; 
    cursor:pointer; 
    margin-top:15px; 
    font-size:16px; 
    font-weight:600;
    transition:all 0.3s ease;
}

.clear-btn:hover{ 
    background:#4b5563; 
    transform:translateY(-2px);
}

.agreement-text h4{ 
    margin:25px 0 15px 0; 
    color:#1f2937; 
    font-size:20px;
    font-weight:700;
}

.agreement-text p{ 
    margin-bottom:15px; 
    line-height:1.8; 
    color:#4b5563; 
    font-size:16px;
}

.checkbox-group{ 
    display:flex; 
    flex-direction:column; 
    gap:25px; 
    padding:20px 0;
}

.checkbox-group label{
    font-size:20px;
    display:flex;
    align-items:center;
    gap:15px;
    padding:15px;
    background:rgba(59,130,246,0.05);
    border-radius:12px;
    border:2px solid rgba(59,130,246,0.1);
    transition:all 0.3s ease;
    cursor:pointer;
}

.checkbox-group label:hover{
    background:rgba(59,130,246,0.1);
    border-color:rgba(59,130,246,0.3);
}

.price-display{ 
    background:linear-gradient(135deg, rgba(59,130,246,0.1), rgba(99,102,241,0.1)); 
    padding:25px; 
    border-radius:16px; 
    border-left:6px solid #3b82f6; 
    margin-top:20px; 
    font-weight:700; 
    color:#1f2937; 
    font-size:22px;
    box-shadow:0 10px 30px rgba(59,130,246,0.1);
}

@media (max-width:768px){ 
    .main{ margin-left:290px; padding:20px; width:calc(100% - 290px); }
    .main.collapsed{ margin-left:85px; width:calc(100% - 85px); }
    h2{ font-size:32px; padding:20px 0; }
    td,th{ padding:20px 15px; font-size:15px; }
    canvas{ height:150px; }
    .checkbox-group label{ font-size:18px; padding:12px; }
}

/* Live Clock */
.live-clock{
    position:fixed;
    top:35px;
    right:35px;
    color:#333;
    font-weight:700;
    letter-spacing:1px;
    z-index:999;
    text-shadow:0 2px 10px rgba(0,0,0,0.1);
}

.live-clock .date{
    font-size:16px;
    opacity:0.85;
    margin-bottom:4px;
    font-weight:500;
    letter-spacing:1.5px;
}

.live-clock .time{
    font-size:24px;
    font-weight:800;
    letter-spacing:1.5px;
    background:linear-gradient(135deg, #60a5fa, #a78bfa);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    background-clip:text;
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
        <li onclick="window.location.href='account.php'">
            <i class="fas fa-car"></i><span>Account</span>
        </li>
        <li onclick="window.location.href='notifications.php'">
            <i class="fas fa-bell"></i><span>Notifications</span>
        </li>
        <li onclick="window.location.href='agreement.php'" class="active">
            <i class="fas fa-file-contract"></i><span>Agreement</span>
        </li>
        <li onclick="window.location.href='About.php'">
            <i class="fas fa-circle-info"></i><span>About</span>
        </li>
    </ul>
    
    <div class="logout-section">
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <button type="submit" name="logout" class="logout-menu-item">
                <i class="fas fa-right-from-bracket"></i><span>Logout</span>
            </button>
        </form>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="main" id="main">

<h2>🚗 Car Rental Agreement</h2>

<form id="rentalForm">

<table>

<tr>
<th colspan="2" class="section-title">👤 Renter Details</th>
</tr>
<tr>
<td>
<label>Full Name *</label>
<input type="text" id="name" required>
</td>

<td>
<label>Phone *</label>
<input type="tel" id="phone" required>
</td>
</tr>

<tr>
<td>
<label>Email *</label>
<input type="email" id="email" required>
</td>

<td>
<label>Driver's License *</label>
<input type="text" id="license" required>
</td>
</tr>

<tr>
<td colspan="2">
<label>Address / Bayan *</label>
<input type="text" id="address" required>
</td>
</tr>

<tr>
<td>
<label>Start Date *</label>
<input type="date" id="startDate" required>
</td>

<td>
<label>End Date *</label>
<input type="date" id="endDate" required>
</td>
</tr>

<tr>
<td colspan="2" id="priceContainer" style="display:none;">
<div class="price-display">
💰 <span id="totalPrice">Total Amount: ₱0</span>
</div>
</td>
</tr>

<tr>
<td colspan="2">
<label>Payment Method *</label>
<select id="paymentMethod" required>
<option value="">Select Payment Method</option>
<option value="cash">💵 Cash</option>
<option value="credit_card">💳 Credit Card</option>
<option value="gcash">📱 Gcash</option>
<option value="paypal">🌐 PayPal</option>
</select>
</td>
</tr>

<tr>
<td>
<label>Company *</label>
<select id="companySelect" required>
<option value="">Select Company</option>
</select>
</td>

<td>
<label>Car Selected *</label>
<select id="carSelect" required>
<option value="">Select Car</option>
</select>
</td>
</tr>

<tr>
<th colspan="2" class="section-title">📋 Agreement Terms</th>
</tr>

<tr>
<td colspan="2" class="agreement-text">

<h4>1. Vehicle Condition & Use</h4>
<p>The renter must return the vehicle in the same condition it was rented. Any damages will be charged to the renter.</p>

<h4>2. Rental Fees & Payment</h4>
<p>Rental fees must be paid in full upfront. Late payments will incur additional charges.</p>

<h4>3. Insurance & Liability</h4>
<p>The renter is responsible for damages not covered by insurance. Check the insurance option below.</p>

<h4>4. Fuel & Mileage Policy</h4>
<p>Vehicle must be returned with the same fuel level. Unlimited mileage applies.</p>

<h4>5. Cancellation & Refund</h4>
<p>Cancellations must be made 24 hours prior for full refund. No refund within 24 hours.</p>

<h4>6. Personal Data & Privacy</h4>
<p>Information will only be used for rental purposes and will be kept confidential.</p>

<h4>7. Agreement Confirmation</h4>
<p>Signing confirms acceptance of all terms and conditions above.</p>

</td>
</tr>

<tr>
<th colspan="2" class="section-title">🛡️ Insurance & Liability</th>
</tr>

<tr>
<td colspan="2" class="checkbox-group">

<label style="font-size:16px;">
<input type="checkbox" id="insurance">
✅ I want insurance coverage (Additional ₱500 fee applies)
</label>

<label style="font-size:16px;">
<input type="checkbox" id="liability">
⚠️ I understand my liability for damages
</label>

</td>
</tr>

<tr>
<th colspan="2" class="section-title">✍️ Signature</th>
</tr>

<tr>
<td colspan="2">

<canvas id="signature" width="800" height="150"></canvas>

<br>

<button type="button" id="clearSig" class="clear-btn">
🗑️ Clear Signature
</button>

</td>
</tr>

<tr>
<td colspan="2">

<label style="font-size:18px; font-weight:600;">
<input type="checkbox" id="agree">
✅ I have read and agree to all terms & conditions above
</label>

</td>
</tr>

<tr>
<td colspan="2">
<button type="submit" class="submit-btn" id="submitBtn" disabled>
<i class="fas fa-check-circle"></i> 🎉 Submit Agreement & Generate Receipt
</button>
</td>
</tr>

</table>

</form>

</div>

<!-- Live Clock -->
<div class="live-clock" id="liveClock">
    <div class="date" id="liveDate"></div>
    <div class="time" id="liveTime"></div>
</div>

<script>

const companySelect = document.getElementById("companySelect");
const carSelect = document.getElementById("carSelect");
const agreeCheckbox = document.getElementById("agree");
const submitBtn = document.getElementById("submitBtn");
const canvas = document.getElementById("signature");
const ctx = canvas.getContext("2d");
const form = document.getElementById("rentalForm");
const priceContainer = document.getElementById("priceContainer");
const totalPrice = document.getElementById("totalPrice");

// ✅ PRICING SYSTEM
const carPrices = {
    "Toyota Vios": 1500,
    "Toyota Altis": 1800,
    "Mercedes C-Class": 3500,
    "BMW X5": 5000,
    "Mitsubishi Mirage": 1200,
    "Honda Jazz": 1400,
    "Toyota Innova": 2500,
    "Toyota Alphard": 4000,
    "Toyota Fortuner": 3000,
    "Mitsubishi Pajero": 3200
};

const insuranceFee = 500;

// ✅ CALCULATE TOTAL PRICE
function calculatePrice() {
    const startDate = document.getElementById("startDate").value;
    const endDate = document.getElementById("endDate").value;
    const selectedCar = carSelect.value;
    const insuranceChecked = document.getElementById("insurance").checked;

    if (!startDate || !endDate || !selectedCar) {
        priceContainer.style.display = "none";
        return;
    }

    const start = new Date(startDate);
    const end = new Date(endDate);
    const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24));

    if (days <= 0) {
        priceContainer.style.display = "none";
        return;
    }

    const basePricePerDay = carPrices[selectedCar] || 0;
    const insurancePrice = insuranceChecked ? insuranceFee : 0;
    const totalAmount = (basePricePerDay * days) + insurancePrice;

    totalPrice.textContent = `Total Amount: ₱${totalAmount.toLocaleString()} (₱${basePricePerDay.toLocaleString()}/day × ${days} days ${insuranceChecked ? `+ ₱${insuranceFee} insurance` : ''})`;
    priceContainer.style.display = "block";
}

// ✅ RESPONSIVE CANVAS SIZE
function resizeCanvas() {
    const rect = canvas.getBoundingClientRect();
    canvas.width = rect.width;
    canvas.height = 200;
}
window.addEventListener('resize', resizeCanvas);
resizeCanvas();

// ✅ AGREE CHECKBOX - ENABLE SUBMIT
agreeCheckbox.addEventListener("change", () => {
    submitBtn.disabled = !agreeCheckbox.checked;
});

// ✅ SIGNATURE DRAWING (MOUSE + TOUCH)
let drawing = false;

function getCanvasPos(e) {
    const rect = canvas.getBoundingClientRect();
    return {
        x: (e.clientX || e.touches[0].clientX) - rect.left,
        y: (e.clientY || e.touches[0].clientY) - rect.top
    };
}

// Mouse events
canvas.addEventListener("mousedown", e => {
    drawing = true;
    const pos = getCanvasPos(e);
    ctx.beginPath();
    ctx.moveTo(pos.x, pos.y);
});

canvas.addEventListener("mouseup", () => drawing = false);
canvas.addEventListener("mouseout", () => drawing = false);

canvas.addEventListener("mousemove", e => {
    if (!drawing) return;
    const pos = getCanvasPos(e);
    ctx.lineWidth = 3;
    ctx.lineCap = "round";
    ctx.strokeStyle = "#1f2937";
    ctx.lineTo(pos.x, pos.y);
    ctx.stroke();
});

// Touch events (MOBILE)
canvas.addEventListener("touchstart", e => {
    e.preventDefault();
    drawing = true;
    const pos = getCanvasPos(e);
    ctx.beginPath();
    ctx.moveTo(pos.x, pos.y);
});

canvas.addEventListener("touchend", e => {
    e.preventDefault();
    drawing = false;
});

canvas.addEventListener("touchcancel", e => {
    e.preventDefault();
    drawing = false;
});

canvas.addEventListener("touchmove", e => {
    e.preventDefault();
    if (!drawing) return;
    const pos = getCanvasPos(e);
    ctx.lineWidth = 3;
    ctx.lineCap = "round";
    ctx.strokeStyle = "#1f2937";
    ctx.lineTo(pos.x, pos.y);
    ctx.stroke();
});

document.getElementById("clearSig").addEventListener("click", () => {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
});

// ✅ COMPANIES & CARS DATA
const companies = [
    "SPOT CAR RENTAL PAGADIAN",
    "H&M CAR RENTAL SERVICES",
    "BREE'S RENT CAR",
    "E.G BALAO CAR RENTAL",
    "KMP CAR RENTAL"
];

const carsByCompany = {
    "SPOT CAR RENTAL PAGADIAN": ["Toyota Vios", "Toyota Altis"],
    "H&M CAR RENTAL SERVICES": ["Mercedes C-Class", "BMW X5"],
    "BREE'S RENT CAR": ["Mitsubishi Mirage", "Honda Jazz"],
    "E.G BALAO CAR RENTAL": ["Toyota Innova", "Toyota Alphard"],
    "KMP CAR RENTAL": ["Toyota Fortuner", "Mitsubishi Pajero"]
};

// ✅ POPULATE COMPANIES
companies.forEach(c => {
    let opt = document.createElement("option");
    opt.value = c;
    opt.textContent = c;
    companySelect.appendChild(opt);
});

// ✅ RESTORE SAVED SELECTIONS
const savedCompany = localStorage.getItem("selectedCompany");
const savedCarObj = JSON.parse(localStorage.getItem("selectedCar") || "null");

if (savedCompany) {
    companySelect.value = savedCompany;
    // Auto-populate cars
    if (carsByCompany[savedCompany]) {
        carSelect.innerHTML = '<option value="">Select Car</option>';
        carsByCompany[savedCompany].forEach(car => {
            let opt = document.createElement("option");
            opt.value = car;
            opt.textContent = car;
            carSelect.appendChild(opt);
        });
    }
}

if (savedCarObj) {
    carSelect.value = `${savedCarObj.brand} ${savedCarObj.model}`;
}

// ✅ DATE CHANGE HANDLER
document.getElementById("startDate").addEventListener("change", calculatePrice);
document.getElementById("endDate").addEventListener("change", calculatePrice);
document.getElementById("insurance").addEventListener("change", calculatePrice);

// ✅ COMPANY CHANGE HANDLER
companySelect.addEventListener("change", () => {
    const comp = companySelect.value;
    carSelect.innerHTML = '<option value="">Select Car</option>';

    if (comp && carsByCompany[comp]) {
        carsByCompany[comp].forEach(car => {
            let opt = document.createElement("option");
            opt.value = car;
            opt.textContent = car;
            carSelect.appendChild(opt);
        });
    }

    localStorage.setItem("selectedCompany", comp);
    localStorage.removeItem("selectedCar");
    calculatePrice();
});

// ✅ CAR CHANGE HANDLER
carSelect.addEventListener("change", () => {
    let sel = carSelect.value;
    if (sel) {
        localStorage.setItem("selectedCar", JSON.stringify({
            brand: sel.split(" ")[0],
            model: sel.split(" ").slice(1).join(" ")
        }));
    }
    calculatePrice();
});

// ✅ COMPLETE SUBMIT - SAVES EVERYTHING WITH EXACT CALCULATED AMOUNT!
form.addEventListener("submit", e => {
    e.preventDefault();

    // Check signature exists
    const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
    const hasSignature = imageData.some(p => p !== 0);
    
    if (!hasSignature) {
        alert("❌ Please provide your signature before submitting.");
        canvas.focus();
        return;
    }

    // ✅ VALIDATE ALL REQUIRED FIELDS
    const startDate = document.getElementById("startDate").value;
    const endDate = document.getElementById("endDate").value;
    if (!startDate || !endDate) {
        alert("❌ Please select start and end dates.");
        return;
    }

    const start = new Date(startDate);
    const end = new Date(endDate);
    const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
    if (days <= 0) {
        alert("❌ End date must be after start date.");
        return;
    }

    // ✅ CAPTURE ALL FORM DATA + EXACT CALCULATED AMOUNT
    const selectedCar = carSelect.value;
    const basePricePerDay = carPrices[selectedCar] || 0;
    const insuranceChecked = document.getElementById("insurance").checked;
    const insurancePrice = insuranceChecked ? insuranceFee : 0;
    const totalAmount = (basePricePerDay * days) + insurancePrice;

    let newRental = {
        id: Date.now(),
        // 👤 RENTER DETAILS
        customer: document.getElementById("name").value.trim(),
        phone: document.getElementById("phone").value.trim(),
        email: document.getElementById("email").value.trim(),
        license: document.getElementById("license").value.trim(),
        address: document.getElementById("address").value.trim(),
        // 📅 DATES
        start: document.getElementById("startDate").value,
        end: document.getElementById("endDate").value,
        days: days,
        // 💰 EXACT AMOUNT
        basePricePerDay: basePricePerDay,
        insuranceFee: insurancePrice,
        amount: totalAmount,
        // 💳 PAYMENT
        paymentMethod: document.getElementById("paymentMethod").value,
        // 🚗 RENTAL
        company: companySelect.value,
        car: selectedCar,
        // 🛡️ INSURANCE
        insurance: insuranceChecked,
        liability: document.getElementById("liability").checked,
        // ✍️ SIGNATURE
        signature: canvas.toDataURL("image/png"),
        status: "Active",
        submittedAt: new Date().toISOString()
    };

    // ✅ SAVE TO LOCALSTORAGE (ALL EXACT DATA!)
    let rentals = JSON.parse(localStorage.getItem("rentals") || "[]");
    rentals.push(newRental);
    localStorage.setItem("rentals", JSON.stringify(rentals));

    // ✅ SUCCESS FEEDBACK
    alert(`✅ Agreement submitted successfully!\n\nTotal Amount: ₱${totalAmount.toLocaleString()}\n\nRedirecting to receipt...`);
    
    // ✅ GO TO RECEIPT (pass latest rental ID)
    window.location.href = `agreement_receipt.php?id=${newRental.id}`;
});

// Sidebar toggle
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("main").classList.toggle("collapsed");
}

// Live clock
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
        hour12: true
    };
    
    document.getElementById('liveDate').textContent = now.toLocaleDateString('en-US', optionsDate);
    document.getElementById('liveTime').textContent = now.toLocaleTimeString('en-US', optionsTime);
}
updateClock();
setInterval(updateClock, 1000);

</script>

</body>
</html>