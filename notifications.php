<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Notifications | Car Rental System</title>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
* { 
    margin: 0; 
    padding: 0; 
    box-sizing: border-box; 
    font-family: 'Inter', 'Segoe UI', sans-serif;
}

body {
    display: flex;
    background: #111;
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
    padding: 40px 20px;
}

.main.collapsed{
    margin-left:85px;
}

.container {
    max-width: 900px;
    margin: 0 auto;
}

.header {
    text-align: center;
    margin-bottom: 40px;
}

.logo {
    font-size: 48px;
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 16px;
}

.page-title {
    font-size: 32px;
    font-weight: 700;
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 8px;
}

.notification-count {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    padding: 8px 20px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 16px;
    display: inline-block;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}

.stats {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-bottom: 40px;
    flex-wrap: wrap;
}

.stat-card {
    background: rgba(15, 23, 42, 0.8);
    backdrop-filter: blur(20px);
    padding: 24px;
    border-radius: 20px;
    border: 1px solid rgba(148, 163, 184, 0.1);
    text-align: center;
    min-width: 120px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 30px 60px rgba(0,0,0,0.3);
}

.stat-number {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 8px;
}

.stat-label { font-size: 14px; color: #94a3b8; }

.unread { color: #10b981; }

.notifications {
    background: rgba(15, 23, 42, 0.8);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    border: 1px solid rgba(148, 163, 184, 0.1);
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.notifications-header {
    padding: 28px 32px;
    border-bottom: 1px solid rgba(148, 163, 184, 0.1);
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(79, 70, 229, 0.1));
}

.section-title {
    font-size: 24px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 12px;
}

.empty-state {
    text-align: center;
    padding: 60px 40px;
    color: #94a3b8;
}

.empty-icon { font-size: 64px; opacity: 0.3; margin-bottom: 20px; }

.notification-list {
    max-height: 600px;
    overflow-y: auto;
}

.notification-item {
    padding: 24px 32px;
    border-bottom: 1px solid rgba(148, 163, 184, 0.05);
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.notification-item:hover {
    background: rgba(99, 102, 241, 0.1);
    transform: translateX(8px);
}

.notification-item.unread {
    background: rgba(16, 185, 129, 0.05);
    border-left: 4px solid #10b981;
}

.notification-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 12px;
}

.notification-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.icon-approved { background: linear-gradient(135deg, #10b981, #059669); color: white; }
.icon-rejected { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }
.icon-message { background: linear-gradient(135deg, #6366f1, #4f46e5); color: white; }
.icon-status { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; }
.icon-active { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }

.notification-meta {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 8px;
}

.notification-title {
    font-weight: 600;
    font-size: 16px;
    color: #f8fafc;
}

.notification-time {
    font-size: 13px;
    color: #94a3b8;
}

.notification-message {
    font-size: 15px;
    line-height: 1.6;
    color: #cbd5e1;
    white-space: pre-wrap;
}

.read-indicator {
    position: absolute;
    top: 24px;
    right: 32px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #10b981;
    opacity: 0;
    transition: all 0.3s ease;
}

.notification-item.unread .read-indicator {
    opacity: 1;
}

.btn {
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: white;
    border: none;
    padding: 12px 28px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
    margin-left: 10px;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
}

.btn-secondary {
    background: rgba(148, 163, 184, 0.2);
    color: #f8fafc;
    border: 1px solid rgba(148, 163, 184, 0.3);
}

.user-selector {
    background: rgba(99, 102, 241, 0.1);
    padding: 20px;
    border-radius: 16px;
    margin-bottom: 30px;
    border-left: 4px solid #6366f1;
}

.user-info {
    font-size: 18px;
    font-weight: 600;
    color: #f8fafc;
    margin-bottom: 12px;
}

.user-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.user-btn {
    padding: 8px 16px;
    border: 2px solid rgba(99, 102, 241, 0.3);
    background: transparent;
    color: #e2e8f0;
    border-radius: 20px;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.user-btn.active {
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    border-color: #6366f1;
    color: white;
}

.user-btn:hover {
    background: rgba(99, 102, 241, 0.2);
    border-color: #6366f1;
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
        padding:20px 16px;
    }
    .main.collapsed{
        margin-left:85px;
    }
    
    .container { padding: 20px 16px; }
    .stats { gap: 16px; }
    .stat-card { min-width: 100px; padding: 20px; }
    .notification-item { padding: 20px 24px; }
    .btn { margin-left: 0; margin-top: 10px; }
    .user-list { justify-content: center; }
}

@media(max-width:480px){
    .sidebar{
        width:85px;
    }
    .main{
        margin-left:85px;
        padding:20px 16px;
    }
    
    .live-clock .time{
        font-size:20px;
        letter-spacing:1px;
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
        <li onclick="window.location.href='notifications.php'" class="active">
            <i class="fas fa-bell"></i><span>Notifications</span>
        </li>
        <li onclick="window.location.href='About.php'">
            <i class="fas fa-circle-info"></i><span>About</span>
        </li>
    </ul>
    
    
        </form>
    </div>
</div>

<!-- MAIN -->
<div class="main" id="main">
    <div class="container">
        <div class="header">
            <div class="logo">
                <i class="fas fa-bell"></i>
            </div>
            <h1 class="page-title">My Notifications</h1>
            <div class="notification-count" id="notificationCount">0</div>
        </div>

        <!-- UNIVERSAL USER SELECTOR -->
        <div class="user-selector">
            <div class="user-info">
                <i class="fas fa-users"></i>
                Select Renter: <span id="currentUserDisplay">All Users</span>
            </div>
            <div class="user-list" id="userList"></div>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-number unread" id="unreadCount">0</div>
                <div class="stat-label">Unread</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="totalCount">0</div>
                <div class="stat-label">Total</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="approvedCount">0</div>
                <div class="stat-label">Approved</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="messageCount">0</div>
                <div class="stat-label">Messages</div>
            </div>
        </div>

        <div class="notifications">
            <div class="notifications-header">
                <h2 class="section-title">
                    <i class="fas fa-list"></i>
                    Recent Notifications
                </h2>
            </div>
            <div class="notification-list" id="notificationList">
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-bell-slash"></i>
                    </div>
                    <h3>No notifications yet</h3>
                    <p>Select a user to see their notifications from the rental system</p>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 40px;">
            <button class="btn btn-secondary" onclick="notificationSystem.markAllRead()">
                <i class="fas fa-eye"></i> Mark All Read
            </button>
            <button class="btn" onclick="notificationSystem.clearAllNotifications()">
                <i class="fas fa-trash"></i> Clear All
            </button>
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
    const currentPage = window.location.pathname.split('/').pop() || 'notifications.php';
    const menuItems = document.querySelectorAll('.menu li');
    
    menuItems.forEach(item => {
        const link = item.getAttribute('onclick');
        if (link && link.includes(currentPage)) {
            item.classList.add('active');
        }
    });
});

// =========================================
// UNIVERSAL NOTIFICATIONS SYSTEM
// ✅ WORKS FOR ALL USERS AUTOMATICALLY
// =========================================

class UniversalNotificationSystem {
    constructor() {
        this.currentUserEmail = null; // No default user
        this.allUsers = [];
        this.init();
    }

    init() {
        this.loadAllUsers();
        this.renderUserSelector();
        this.renderNotifications(); // Show all users initially
    }

    getAllNotificationsData() {
        return JSON.parse(localStorage.getItem("renterNotifications")) || {};
    }

    getNotificationsForUser(email = null) {
        const allData = this.getAllNotificationsData();
        return email ? (allData[email] || []) : [];
    }

    getRentals() {
        return JSON.parse(localStorage.getItem("rentals")) || [];
    }

    loadAllUsers() {
        const allData = this.getAllNotificationsData();
        this.allUsers = Object.keys(allData).filter(email => allData[email].length > 0);
        
        // Add users from rentals who might not have notifications yet
        this.getRentals().forEach(rental => {
            if(!this.allUsers.includes(rental.email)) {
                this.allUsers.push(rental.email);
            }
        });
        
        this.allUsers.sort();
    }

    renderUserSelector() {
        const container = document.getElementById('userList');
        container.innerHTML = `
            <button class="user-btn ${!this.currentUserEmail ? 'active' : ''}" onclick="notificationSystem.selectUser(null)">
                <i class="fas fa-users"></i> All Users
            </button>
            ${this.allUsers.map(email => `
                <button class="user-btn ${this.currentUserEmail === email ? 'active' : ''}" onclick="notificationSystem.selectUser('${email}')">
                    ${email.split('@')[0]}
                </button>
            `).join('')}
        `;
    }

    selectUser(email) {
        this.currentUserEmail = email;
        document.getElementById('currentUserDisplay').textContent = 
            email ? email.split('@')[0] : 'All Users';
        this.renderNotifications();
        this.renderUserSelector();
    }

    formatTimeAgo(dateStr) {
        const now = new Date();
        const date = new Date(dateStr);
        const diff = now - date;
        
        if(diff < 60000) return "Just now";
        if(diff < 3600000) return `${Math.floor(diff/60000)}m ago`;
        if(diff < 86400000) return `${Math.floor(diff/3600000)}h ago`;
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
    }

    getNotificationIcon(title) {
        if(title.includes('Approved')) return { class: 'icon-approved', icon: 'fas fa-check-circle' };
        if(title.includes('Rejected')) return { class: 'icon-rejected', icon: 'fas fa-times-circle' };
        if(title.includes('Message') || title.includes('Admin Message')) return { class: 'icon-message', icon: 'fas fa-comment-dots' };
        if(title.includes('Active') || title.includes('Status Updated')) return { class: 'icon-active', icon: 'fas fa-play-circle' };
        return { class: 'icon-status', icon: 'fas fa-info-circle' };
    }

    renderNotifications() {
        let notifications = [];
        
        if(this.currentUserEmail) {
            notifications = this.getNotificationsForUser(this.currentUserEmail);
        } else {
            // Show latest notifications from all users
            const allData = this.getAllNotificationsData();
            Object.keys(allData).forEach(email => {
                allData[email].forEach(notif => {
                    notif.userEmail = email; // Add user info
                    notifications.push(notif);
                });
            });
            // Sort by date, newest first
            notifications.sort((a, b) => new Date(b.date) - new Date(a.date));
            // Limit to 50 most recent
            notifications = notifications.slice(0, 50);
        }

        const list = document.getElementById('notificationList');
        const unreadCount = notifications.filter(n => !n.read).length;
        
        // Update stats
        document.getElementById('notificationCount').textContent = `${notifications.length} Notifications`;
        document.getElementById('unreadCount').textContent = unreadCount;
        document.getElementById('totalCount').textContent = notifications.length;
        document.getElementById('approvedCount').textContent = notifications.filter(n => n.title.includes('Approved')).length;
        document.getElementById('messageCount').textContent = notifications.filter(n => n.title.includes('Message')).length;
        
        if(notifications.length === 0){
            list.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-bell-slash"></i></div>
                    <h3>No notifications</h3>
                    <p>${this.currentUserEmail ? 'No notifications for this user.' : 'No notifications across all users yet.'}<br>
                    Notifications are created automatically from the Rental History admin panel.</p>
                </div>
            `;
            return;
        }
        
        list.innerHTML = notifications.map(notif => {
            const iconData = this.getNotificationIcon(notif.title);
            const isUnread = !notif.read;
            const userDisplay = notif.userEmail ? `(${notif.userEmail.split('@')[0]})` : '';
            
            return `
            <div class="notification-item ${isUnread ? 'unread' : ''}" onclick="notificationSystem.markRead('${notif.id}')">
                <div class="read-indicator"></div>
                <div class="notification-header">
                    <div class="notification-icon ${iconData.class}">
                        <i class="${iconData.icon}"></i>
                    </div>
                    <div>
                        <div class="notification-title">${notif.title} ${userDisplay}</div>
                        <div class="notification-meta">
                            <span class="notification-time">${this.formatTimeAgo(notif.date)}</span>
                        </div>
                    </div>
                </div>
                <div class="notification-message">${notif.message}</div>
            </div>
            `;
        }).join('');
    }

    markRead(id) {
        if(this.currentUserEmail) {
            const notifications = this.getNotificationsForUser(this.currentUserEmail);
            const notification = notifications.find(n => n.id == id);
            if(notification && !notification.read){
                notification.read = true;
                const allData = this.getAllNotificationsData();
                allData[this.currentUserEmail] = notifications;
                localStorage.setItem("renterNotifications", JSON.stringify(allData));
                this.renderNotifications();
                this.showToast('Notification marked as read');
            }
        }
    }

    markAllRead() {
        if(this.currentUserEmail && confirm('Mark all notifications as read?')){
            const allData = this.getAllNotificationsData();
            const notifications = this.getNotificationsForUser(this.currentUserEmail).map(n => ({...n, read: true}));
            allData[this.currentUserEmail] = notifications;
            localStorage.setItem("renterNotifications", JSON.stringify(allData));
            this.renderNotifications();
            this.showToast('All notifications marked as read!');
        }
    }

    clearAllNotifications() {
        if(this.currentUserEmail && confirm('Delete all notifications? This cannot be undone.')){
            const allData = this.getAllNotificationsData();
            delete allData[this.currentUserEmail];
            localStorage.setItem("renterNotifications", JSON.stringify(allData));
            this.loadAllUsers();
            this.renderUserSelector();
            this.renderNotifications();
            this.showToast('All notifications cleared!');
        }
    }

    showToast(message) {
        const toast = document.createElement('div');
        toast.style.cssText = `
            position: fixed; top: 80px; right: 20px; background: linear-gradient(135deg, #10b981, #059669);
            color: white; padding: 16px 24px; border-radius: 12px; font-weight: 600;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3); z-index: 9999; transform: translateX(400px);
            transition: transform 0.4s ease;
        `;
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => toast.style.transform = 'translateX(0)', 100);
        setTimeout(() => {
            toast.style.transform = 'translateX(400px)';
            setTimeout(() => document.body.removeChild(toast), 400);
        }, 3000);
    }
}

// Initialize universal notification system
const notificationSystem = new UniversalNotificationSystem();

// Auto-refresh every 5 seconds to catch new notifications from admin
setInterval(() => {
    notificationSystem.loadAllUsers();
    notificationSystem.renderNotifications();
}, 5000);

// =========================================
// INITIALIZE
// =========================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔔 Universal Notifications system loaded!');
    console.log('✅ Works for ALL users automatically');
    console.log('✅ Connected to Rental History - notifications appear instantly!');
    console.log('🔄 Auto-refreshing every 5 seconds');
    console.log('👥 Click any user button to filter their notifications');
});
</script>
</body>
</html>