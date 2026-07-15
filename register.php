<?php
include "db.php";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if ($email == "" || $password == "") {
        $message = "Complete all fields!";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "Email already registered!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $hashedPassword);

            if ($stmt->execute()) {
                $message = "Account created successfully!";
            } else {
                $message = "Error creating account. Try again!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Create Account</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #020617 100%);
    position: relative;
    overflow: hidden;
}

body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: 
        radial-gradient(circle at 20% 30%, rgba(34,197,94,0.3) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(16,185,129,0.2) 0%, transparent 50%);
    animation: float 20s infinite linear;
}

@keyframes float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

.card {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(20px);
    padding: 50px 40px;
    width: 380px;
    max-width: 90vw;
    border-radius: 24px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.4);
    border: 1px solid rgba(255,255,255,0.1);
    color: white;
    text-align: center;
    position: relative;
    z-index: 2;
}

.logo {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    box-shadow: 0 12px 30px rgba(34,197,94,0.4);
    font-size: 28px;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

h1 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 8px;
    background: linear-gradient(135deg, #fff, #e2e8f0);
    -webkit-background-clip: text;
    background-clip: text;
}

p {
    color: #cbd5e1;
    font-size: 15px;
    margin-bottom: 30px;
    font-weight: 300;
}

.input-group {
    margin-bottom: 20px;
    text-align: left;
}

label {
    display: block;
    font-size: 14px;
    color: #e2e8f0;
    margin-bottom: 8px;
    font-weight: 500;
}

.input-box {
    display: flex;
    align-items: center;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 12px;
    padding: 14px 16px;
    transition: all 0.3s ease;
}

.input-box:focus-within {
    background: rgba(255,255,255,0.2);
    border-color: #22c55e;
    box-shadow: 0 8px 25px rgba(34,197,94,0.2);
    transform: translateY(-1px);
}

.input-box i {
    color: #86efac;
    margin-right: 12px;
    font-size: 16px;
}

.input-box input {
    flex: 1;
    border: none;
    outline: none;
    background: transparent;
    color: white;
    font-size: 15px;
}

.input-box input::placeholder {
    color: #94a3b8;
}

.btn {
    width: 100%;
    padding: 16px;
    border: none;
    border-radius: 14px;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: white;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 10px;
    box-shadow: 0 10px 30px rgba(34,197,94,0.4);
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 40px rgba(34,197,94,0.5);
}

.message {
    padding: 12px;
    margin-top: 15px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 500;
    min-height: 20px;
}

.message.success {
    background: rgba(34,197,94,0.2);
    color: #86efac;
    border: 1px solid rgba(34,197,94,0.3);
}

.message.error {
    background: rgba(248,113,113,0.2);
    color: #f87171;
    border: 1px solid rgba(248,113,113,0.3);
}

.footer {
    margin-top: 25px;
    font-size: 14px;
    color: #94a3b8;
}

.footer span {
    color: #60a5fa;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s ease;
}

.footer span:hover {
    color: #93c5fd;
    text-shadow: 0 0 10px rgba(96,165,250,0.5);
}

@media (max-width: 480px) {
    .card {
        padding: 40px 30px;
        margin: 10px;
    }
    h1 { font-size: 24px; }
}
</style>
</head>
<body>

<div class="card">
    <div class="logo">
        <i class="fas fa-user-plus"></i>
    </div>
    <h1>Create Account</h1>
    <p>Join us today</p>

    <form method="POST">
        <div class="input-group">
            <label>Email</label>
            <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="example@email.com" required>
            </div>
        </div>

        <div class="input-group">
            <label>Password</label>
            <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Create password" required>
            </div>
        </div>

        <button class="btn" type="submit">
            <i class="fas fa-user-plus"></i> Create Account
        </button>
    </form>

    <div class="message 
        <?php 
        if ($message == "Account created successfully!") echo 'success'; 
        elseif ($message) echo 'error'; 
        ?>">
        <?php echo $message; ?>
    </div>

    <div class="footer">
        Already have an account? 
        <span onclick="window.location.href='index.php'">Login</span>
    </div>
</div>

</body>
</html>