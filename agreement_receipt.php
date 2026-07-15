<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Car Rental Agreement Receipt</title>

<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
body { background:#f5f5f5; padding:20px; min-height:100vh; }
.receipt-container { 
    max-width:800px; 
    margin:0 auto; 
    background:white; 
    box-shadow:0 10px 30px rgba(0,0,0,0.2); 
    border-radius:15px; 
    overflow:hidden;
}
.header { 
    background:linear-gradient(135deg, #333 0%, #555 100%); 
    color:white; 
    padding:30px; 
    text-align:center; 
}
.header h1 { font-size:36px; margin-bottom:10px; }
.header p { font-size:18px; opacity:0.9; }
.receipt-body { padding:40px; }
.section { margin-bottom:30px; }
.section-title { 
    background:#333; 
    color:white; 
    padding:15px 20px; 
    font-size:20px; 
    font-weight:600; 
    margin:-20px -40px 20px -40px; 
    border-radius:8px 8px 0 0;
}
.detail-row { display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px solid #eee; }
.detail-row:last-child { border-bottom:none; }
.detail-label { font-weight:600; color:#555; }
.detail-value { color:#333; font-size:16px; }
.car-info { 
    background:#f8f9fa; 
    padding:25px; 
    border-radius:10px; 
    border-left:5px solid #333; 
    margin:20px 0;
}
.signature-section { text-align:center; margin:40px 0; }
.signature-canvas { 
    border:3px solid #333; 
    border-radius:15px; 
    max-width:100%; 
    height:200px; 
    background:#f9f9f9; 
    margin:20px auto; 
    display:block;
}
.buttons { 
    display:flex; 
    gap:15px; 
    justify-content:center; 
    margin-top:40px; 
    flex-wrap:wrap;
}
.btn { 
    padding:15px 30px; 
    border:none; 
    border-radius:8px; 
    font-size:18px; 
    font-weight:600; 
    cursor:pointer; 
    transition:all 0.3s; 
    text-decoration:none; 
    display:inline-block;
}
.btn-print { background:#333; color:white; }
.btn-print:hover { background:#000; transform:translateY(-2px); }
.btn-back { background:#666; color:white; }
.btn-back:hover { background:#555; transform:translateY(-2px); }
.btn-email { background:#007bff; color:white; }
.btn-email:hover { background:#0056b3; transform:translateY(-2px); }
.status-active { color:#28a745; font-weight:600; }
.status-pending { color:#ffc107; font-weight:600; }
@media print {
    body { background:white; padding:0; }
    .receipt-container { box-shadow:none; max-width:none; }
    .buttons { display:none; }
    .no-print { display:none; }
}
@media (max-width:768px) {
    .receipt-body { padding:20px; }
    .detail-row { flex-direction:column; gap:5px; }
    .header h1 { font-size:28px; }
}
</style>

</head>

<body>

<div class="receipt-container" id="receiptContainer">
    <div class="header">
        <h1>🎉 RENTAL AGREEMENT RECEIPT</h1>
        <p>Official Receipt & Contract Confirmation</p>
        <p id="receiptId">Receipt # Loading...</p>
    </div>
    
    <div class="receipt-body">
        <div class="section">
            <div class="section-title">📋 Receipt Information</div>
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
            <div class="section-title">👤 Renter Details</div>
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
            <div class="section-title">🚗 Rental Details</div>
            <div class="car-info">
                <div style="font-size:24px; font-weight:600; margin-bottom:15px;" id="carDisplay">-</div>
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
            <div class="section-title">🛡️ Insurance & Liability</div>
            <div style="padding:20px; background:#f0f8ff; border-radius:8px;">
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
            <div class="section-title">💰 Payment Summary</div>
            <div style="padding:20px; background:#fff3cd; border-radius:8px; border-left:5px solid #ffc107;">
                <div style="font-size:22px; font-weight:600; color:#856404; margin-bottom:15px;">
                    ⏳ Amount to be calculated based on rental duration
                </div>
                <div class="detail-row">
                    <span class="detail-label">Total Amount:</span>
                    <span class="detail-value" style="color:#856404; font-size:20px; font-weight:600;">₱<span id="totalAmount">0.00</span></span>
                </div>
            </div>
        </div>

        <div class="signature-section">
            <div style="font-size:24px; font-weight:600; margin-bottom:20px; color:#333;">
                ✍️ Renter's Digital Signature
            </div>
            <img id="signatureImage" class="signature-canvas" src="" alt="Signature">
            <div style="margin-top:15px; font-size:14px; color:#666;">
                Signed electronically on <span id="signatureDate">-</span>
            </div>
        </div>

        <div class="section no-print">
            <div class="section-title">📄 Actions</div>
            <div class="buttons">
                <button onclick="window.print()" class="btn btn-print">🖨️ Print Receipt</button>
                <a href="index.html" class="btn btn-back">🏠 New Rental</a>
                <button onclick="emailReceipt()" class="btn btn-email">📧 Email Receipt</button>
            </div>
        </div>
    </div>
</div>

<script>
// ✅ LOAD RENTAL DATA
function loadRentalData() {
    // Get rental ID from URL or latest from localStorage
    const urlParams = new URLSearchParams(window.location.search);
    const rentalId = urlParams.get('id');
    
    let rentals = JSON.parse(localStorage.getItem("rentals") || "[]");
    let rental;
    
    if (rentalId) {
        rental = rentals.find(r => r.id == rentalId);
    } else {
        rental = rentals[rentals.length - 1]; // Latest
    }
    
    if (!rental) {
        alert("❌ No rental data found!");
        window.location.href = "index.html";
        return;
    }
    
    // ✅ POPULATE ALL FIELDS
    document.getElementById('receiptIdValue').textContent = `#${rental.id}`;
    document.getElementById('receiptId').textContent = `Receipt #${rental.id}`;
    document.getElementById('submittedDate').textContent = new Date(rental.submittedAt).toLocaleString('en-PH');
    document.getElementById('status').textContent = rental.status;
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
    
    // ✅ INSURANCE CHECKBOXES
    document.getElementById('insuranceDisplay').innerHTML = rental.insurance ? '✅ YES (Additional coverage)' : '❌ NO';
    document.getElementById('liabilityDisplay').innerHTML = rental.liability ? '✅ Acknowledged' : '❌ Not acknowledged';
    
    // ✅ SIMPLE AMOUNT CALCULATION (customize as needed)
    const start = new Date(rental.start);
    const end = new Date(rental.end);
    const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
    const baseRate = 1500; // ₱1500 per day
    const total = days * baseRate;
    document.getElementById('totalAmount').textContent = total.toLocaleString();
    
    // Save current rental for email
    localStorage.setItem('currentReceipt', JSON.stringify(rental));
}

// ✅ EMAIL RECEIPT
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

// ✅ LOAD ON PAGE READY
document.addEventListener('DOMContentLoaded', loadRentalData);

// ✅ AUTO PRINT OPTION (uncomment if needed)
// window.onload = () => { setTimeout(() => window.print(), 1000); };
</script>

</body>
</html>