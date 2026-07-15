<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Confirm Payment</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
*{ box-sizing:border-box; }
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background: linear-gradient(135deg,#111827,#1f2937);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}
header{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    background:#111827;
    color:white;
    padding:20px;
    font-size:22px;
    font-weight:bold;
    text-align:center;
    z-index:10;
}
.back-btn{
    position:absolute;
    left:20px;
    top:50%;
    transform:translateY(-50%);
    color:white;
    font-size:22px;
    text-decoration:none;
}
.back-btn:hover{ transform:scale(1.2); }

.container{
    width:100%;
    max-width:1200px;
    height:80%;        
    margin-top: 85px;  
    margin-bottom: 40px; 
    background:white;
    border-radius:20px;
    box-shadow:0 20px 60px rgba(0,0,0,0.3);
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    padding:40px;
    text-align:center;
}
.car-title{ font-size:28px; font-weight:bold; margin-bottom:20px; color:#111827; }
.amount{ font-size:26px; font-weight:700; color:#2ed573; margin-bottom:15px; }
.days{ font-size:18px; color:#555; margin-bottom:20px; }
.payment-info{ font-size:18px; font-weight:600; margin-bottom:30px; }
.payment-cash{ color:#f59e0b; }
.payment-online{ color:#2ed573; }
button{
    padding:16px 25px;
    font-size:16px;
    font-weight:bold;
    border:none;
    border-radius:12px;
    background:#111827;
    color:white;
    cursor:pointer;
    transition:0.3s;
}
button:hover{
    background:#4ade80;
    color:black;
}
</style>
</head>
<body>

<header>
    <a href="dashboard.html" class="back-btn"><i class="fas fa-arrow-left"></i></a>
    Confirm Your Payment
</header>

<div class="container">
    <div class="car-title" id="carTitle"></div>
    <div class="amount" id="amount"></div>
    <div class="days" id="daysInfo"></div>
    <div class="payment-info" id="paymentInfo"></div>
    <button id="confirmPaymentBtn"><i class="fas fa-check-circle"></i> Confirm Payment</button>
</div>

<script>
// Load latest rental
let activeRentals = JSON.parse(localStorage.getItem("activeRentals")) || [];
if(activeRentals.length===0){ alert("No rental found!"); window.location.href="rentform.html"; }
let rental = activeRentals[activeRentals.length-1];

// Display rental info
document.getElementById("carTitle").textContent = rental.car + " (" + rental.plate.split("-")[0] + ")";
document.getElementById("amount").textContent = "Total Amount: ₱"+rental.amount.toLocaleString();
document.getElementById("daysInfo").textContent = "Rental Duration: "+rental.days+" day(s)";

const paymentInfo = document.getElementById("paymentInfo");
if(rental.payment.toLowerCase()==="cash"){
    paymentInfo.textContent = "Payment will be collected in cash upon pick-up.";
    paymentInfo.classList.add("payment-cash");
}else{
    paymentInfo.textContent = `Payment successfully completed via ${rental.payment}. ✅`;
    paymentInfo.classList.add("payment-online");
}

// Confirm Payment
document.getElementById("confirmPaymentBtn").addEventListener("click", function(){
    let rentalHistory = JSON.parse(localStorage.getItem("rentalHistory")) || [];
    rentalHistory.push(rental);
    localStorage.setItem("rentalHistory", JSON.stringify(rentalHistory));

    activeRentals.pop();
    localStorage.setItem("activeRentals", JSON.stringify(activeRentals));

    alert("Your rental has been recorded in history!");
    window.location.href="thankyou.php";
});
</script>

</body>
</html>