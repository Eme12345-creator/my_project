<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rental History & Sales | Car Rental System</title>
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

/* [Previous sidebar styles remain the same - keeping it short] */
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

.page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; padding-bottom: 24px; border-bottom: 1px solid rgba(148, 163, 184, 0.1); }
.page-title { font-size: 36px; font-weight: 700; background: linear-gradient(135deg, #f8fafc, #e2e8f0); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

.container { max-width: 1400px; margin: 0 auto; }

.card {
    background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(20px); padding: 32px;
    border-radius: 24px; border: 1px solid rgba(148, 163, 184, 0.1); margin-bottom: 40px;
    overflow-x: auto; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.card h3 { font-size: 24px; font-weight: 600; color: #f8fafc; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; }

table { width: 100%; border-collapse: collapse; font-size: 14px; }
table th {
    padding: 20px 24px; text-align: left; font-weight: 600; font-size: 13px; color: #6366f1;
    text-transform: uppercase; letter-spacing: 0.05em; background: rgba(99, 102, 241, 0.1);
}
table td { padding: 20px 24px; border-bottom: 1px solid rgba(148, 163, 184, 0.1); font-weight: 500; }
table tr:hover { background: rgba(99, 102, 241, 0.08); }

/* ENHANCED STATUS & APPROVAL BUTTONS */
.status-btn, .approval-btn {
    padding: 8px 16px; border: none; border-radius: 50px; cursor: pointer;
    color: white; font-weight: 600; font-size: 12px; text-transform: uppercase;
    letter-spacing: 0.025em; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    margin-right: 8px; margin-bottom: 4px;
}

.status-btn:hover, .approval-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.3); }

.status-active { background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); }
.status-returned { background: linear-gradient(135deg, #3b82f6, #2563eb); box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3); }
.status-pending { background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3); }
.status-approved { background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4); }
.status-rejected { background: linear-gradient(135deg, #ef4444, #dc2626); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4); }

.approval-btn { font-size: 11px; padding: 6px 12px; }
.approval-btn i { margin-right: 4px; }

.delete-btn { background: linear-gradient(135deg, #ef4444, #dc2626) !important; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3) !important; }

/* Approval Modal */
.approval-modal {
    display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.8); backdrop-filter: blur(10px); z-index: 2000;
    align-items: center; justify-content: center;
}

.approval-modal.active { display: flex; }

.modal-content {
    background: rgba(15, 23, 42, 0.95); backdrop-filter: blur(20px); padding: 40px;
    border-radius: 24px; border: 1px solid rgba(148, 163, 184, 0.2); max-width: 500px;
    width: 90%; box-shadow: 0 25px 50px rgba(0,0,0,0.5);
    animation: modalSlideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes modalSlideIn {
    from { opacity: 0; transform: translateY(-50px) scale(0.9); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.modal-header { display: flex; align-items: center; gap: 12px; margin-bottom: 24px; }
.modal-title { font-size: 24px; font-weight: 700; color: #f8fafc; }
.modal-body textarea { width: 100%; height: 120px; padding: 16px; border: 1px solid rgba(148, 163, 184, 0.3); border-radius: 12px; background: rgba(30, 41, 59, 0.8); color: #f8fafc; font-family: inherit; font-size: 14px; resize: vertical; margin-bottom: 20px; }
.modal-body textarea::placeholder { color: #94a3b8; }

.modal-actions { display: flex; gap: 12px; justify-content: flex-end; }

.btn {
    padding: 12px 24px; border: none; border-radius: 12px; font-weight: 600;
    font-size: 14px; cursor: pointer; transition: all 0.3s ease; display: flex;
    align-items: center; gap: 8px;
}

.btn-primary { background: linear-gradient(135deg, #6366f1, #4f46e5); color: white; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3); }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4); }
.btn-secondary { background: rgba(148, 163, 184, 0.2); color: #f8fafc; border: 1px solid rgba(148, 163, 184, 0.3); }
.btn-secondary:hover { background: rgba(148, 163, 184, 0.3); }
.btn-success { background: linear-gradient(135deg, #10b981, #059669); color: white; }
.btn-danger { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }

.toast {
    position: fixed; top: 100px; right: 30px; padding: 16px 24px; border-radius: 12px;
    color: white; font-weight: 600; font-size: 14px; z-index: 3000;
    transform: translateX(400px); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

.toast.show { transform: translateX(0); }
.toast.success { background: linear-gradient(135deg, #10b981, #059669); }
.toast.error { background: linear-gradient(135deg, #ef4444, #dc2626); }
.toast.info { background: linear-gradient(135deg, #3b82f6, #2563eb); }

.vertical-sales { display: flex; gap: 20px; overflow-x: auto; padding: 20px 0; scrollbar-width: thin; }
.vertical-column {
    min-width: 160px; display: flex; flex-direction: column; gap: 16px;
    background: rgba(99, 102, 241, 0.1); padding: 24px; border-radius: 16px;
    border: 1px solid rgba(99, 102, 241, 0.2); backdrop-filter: blur(10px);
}
.vertical-column .header { font-weight: 700; font-size: 16px; color: #6366f1; text-transform: uppercase; letter-spacing: 0.05em; }
.vertical-column .item { background: linear-gradient(135deg, #6366f1, #4f46e5); color: white; padding: 16px; border-radius: 12px; font-weight: 600; font-size: 20px; text-align: center; box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3); }

.logout-btn {
    position: fixed; top: 28px; right: 28px; padding: 14px 28px;
    background: linear-gradient(135deg, #ef4444, #dc2626); border: none; border-radius: 50px;
    color: white; font-weight: 600; font-size: 14px; cursor: pointer; z-index: 999;
    display: flex; align-items: center; gap: 10px; transition: all 0.3s;
    box-shadow: 0 10px 25px rgba(239, 68, 68, 0.3);
}
.logout-btn:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(239, 68, 68, 0.4); }

/* Responsive */
@media (max-width: 768px) { .main { margin-left: 0 !important; width: 100% !important; padding: 20px; } }
</style>
</head>

<body>

<button class="logout-btn" onclick="logout()"><i class="fas fa-right-from-bracket"></i> Logout</button>

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
        <li><a href="rentalhistory.php" class="menu-item active"><i class="fas fa-list menu-icon"></i><span class="menu-text">Rental History</span></a></li>
        <li><a href="admin_receipt.php" class="menu-item"><i class="fas fa-file-contract menu-icon"></i><span class="menu-text">Agreements</span></a></li>
        <li><a href="sales.php" class="menu-item"><i class="fas fa-shopping-cart menu-icon"></i><span class="menu-text">Sales</span></a></li>
        <li><a href="about.php" class="menu-item"><i class="fas fa-circle-info menu-icon"></i><span class="menu-text">About</span></a></li>
    </ul>
</div>

<div class="main" id="main">
    <div class="page-header">
        <h1 class="page-title">Rental History & Sales</h1>
    </div>

    <div class="container">
        <div class="card">
            <h3><i class="fas fa-history"></i> Rental History & Approvals</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Company</th>
                        <th>Car</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Approval</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="rentalTable"></tbody>
            </table>
        </div>

        <div class="card">
            <h3><i class="fas fa-chart-bar"></i> Sales Summary</h3>
            <div class="vertical-sales" id="salesContainer"></div>
        </div>
    </div>
</div>

<!-- Message Modal -->
<div class="message-modal approval-modal" id="messageModal">
    <div class="modal-content">
        <div class="modal-header">
            <i class="fas fa-comment-dots" style="color: #6366f1; font-size: 24px;"></i>
            <div class="modal-title" id="modalTitle">Send Message</div>
        </div>
        <div class="modal-body">
            <strong id="renterName"></strong>
            <textarea id="messageText" placeholder="Enter your message..."></textarea>
        </div>
        <div class="modal-actions">
                        <button class="btn btn-secondary" onclick="closeMessageModal()">
                <i class="fas fa-times"></i> Cancel
            </button>
            <button class="btn btn-primary" onclick="sendMessage()">
                <i class="fas fa-paper-plane"></i> Send Message
            </button>
        </div>
    </div>
</div>

<!-- Approval Modal -->
<div class="approval-modal" id="approvalModal">
    <div class="modal-content">
        <div class="modal-header">
            <i class="fas fa-check-circle" style="color: #10b981; font-size: 24px;"></i>
            <div class="modal-title" id="approvalTitle">Approval Decision</div>
        </div>
        <div class="modal-body">
            <div id="approvalDetails" style="background: rgba(99,102,241,0.1); padding: 20px; border-radius: 12px; margin-bottom: 20px; border-left: 4px solid #6366f1;">
                <strong>Loading...</strong>
            </div>
            <textarea id="approvalReason" placeholder="Enter reason for approval/rejection (optional)..."></textarea>
        </div>
        <div class="modal-actions">
            <button class="btn btn-secondary" onclick="closeApprovalModal()">
                <i class="fas fa-times"></i> Cancel
            </button>
            <button class="btn btn-success" onclick="confirmApproval()">
                <i class="fas fa-check"></i> Approve
            </button>
            <button class="btn btn-danger" onclick="rejectRental()">
                <i class="fas fa-times-circle"></i> Reject
            </button>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div class="toast" id="toast"></div>

<script>
// =========================================
// COMPLETE ENHANCED SYSTEM WITH APPROVALS
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
    
    if(!localStorage.getItem("renterNotifications")){
        localStorage.setItem("renterNotifications", JSON.stringify({}));
    }
}

function getRentals(){ return JSON.parse(localStorage.getItem("rentals")) || []; }
function saveRentals(data){ localStorage.setItem("rentals", JSON.stringify(data)); }
function getRenterNotifications(){ return JSON.parse(localStorage.getItem("renterNotifications")) || {}; }
function saveRenterNotifications(data){ localStorage.setItem("renterNotifications", JSON.stringify(data)); }

// =========================================
// ENHANCED TABLE WITH APPROVAL COLUMN
// =========================================

function renderTable(){
    const data = getRentals();
    const table = document.getElementById("rentalTable");
    table.innerHTML = "";

    data.forEach(r => {
        const statusClass = r.status === 'Active' ? 'status-active' : 
                           r.status === 'Approved' ? 'status-approved' :
                           r.status === 'Returned' ? 'status-returned' : 
                           r.status === 'Rejected' ? 'status-rejected' : 'status-pending';
        
        const approvalBtn = !r.approved ? 
            `<button onclick="openApprovalModal(${r.id})" class="approval-btn" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <i class="fas fa-clock"></i> Pending
            </button>` :
            `<span style="color: #10b981; font-weight: 600; font-size: 11px;">
                <i class="fas fa-check-circle"></i> Approved
            </span>`;
        
        table.innerHTML += `
        <tr style="${r.status === 'Pending' ? 'background: rgba(245,158,11,0.1);' : ''}">
            <td><strong>#${r.id}</strong></td>
            <td>${r.customer}</td>
            <td><span style="color: #6366f1; font-weight: 600;">${r.company}</span></td>
            <td>${r.car}</td>
            <td>${formatDate(r.start)}</td>
            <td>${formatDate(r.end)}</td>
            <td><strong>₱${r.amount.toLocaleString()}</strong></td>
            <td>
                <button onclick="toggleStatus(${r.id})" class="status-btn ${statusClass}">
                    ${r.status}
                </button>
                <button onclick="openMessageModal(${r.id})" class="status-btn" style="background: linear-gradient(135deg, #6366f1, #4f46e5); font-size: 10px; padding: 6px 12px;">
                    <i class="fas fa-comment"></i>
                </button>
            </td>
            <td>${approvalBtn}</td>
            <td>
                <button onclick="deleteRental(${r.id})" class="status-btn delete-btn">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
        `;
    });

    renderSales();
}

function formatDate(dateStr) {
    return new Date(dateStr).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
}

// =========================================
// APPROVAL SYSTEM
// =========================================

let currentRentalId = null;

function openApprovalModal(id){
    const rental = getRentals().find(r => r.id === id);
    if(!rental || rental.approved) return;
    
    currentRentalId = id;
    document.getElementById('approvalTitle').textContent = `Review Rental #${rental.id}`;
    document.getElementById('approvalReason').value = '';
    
    // Show rental details
    document.getElementById('approvalDetails').innerHTML = `
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; font-size: 14px;">
            <div><strong>Customer:</strong> ${rental.customer}</div>
            <div><strong>Car:</strong> ${rental.car}</div>
            <div><strong>Company:</strong> ${rental.company}</div>
            <div><strong>Amount:</strong> ₱${rental.amount.toLocaleString()}</div>
            <div><strong>Period:</strong> ${formatDate(rental.start)} - ${formatDate(rental.end)}</div>
            <div style="color: #f59e0b;"><strong>Status:</strong> ${rental.status}</div>
        </div>
    `;
    
    document.getElementById('approvalModal').classList.add('active');
}

function closeApprovalModal(){
    document.getElementById('approvalModal').classList.remove('active');
    currentRentalId = null;
}

function confirmApproval(){
    const rental = getRentals().find(r => r.id === currentRentalId);
    if(!rental) return;
    
    const reason = document.getElementById('approvalReason').value.trim();
    
    if(confirm(`✅ Approve rental for ${rental.customer}?\n\nCar: ${rental.car}\nAmount: ₱${rental.amount.toLocaleString()}`)){
        
        let data = getRentals();
        data = data.map(r => {
            if(r.id === currentRentalId){
                r.approved = true;
                r.status = 'Approved';
                r.approvalDate = new Date().toISOString();
                r.approvalReason = reason;
                
                // Send notification
                sendNotification(r, '✅ Rental Approved', 
                    `Your rental request for ${r.car} has been APPROVED!\n\nPeriod: ${formatDate(r.start)} - ${formatDate(r.end)}\nAmount: ₱${r.amount.toLocaleString()}${reason ? `\n\nReason: ${reason}` : ''}`);
            }
            return r;
        });
        
        saveRentals(data);
        showToast('Rental approved successfully!', 'success');
        closeApprovalModal();
        renderTable();
    }
}

function rejectRental(){
    const rental = getRentals().find(r => r.id === currentRentalId);
    if(!rental) return;
    
    const reason = document.getElementById('approvalReason').value.trim() || 'No reason provided';
    
    if(confirm(`❌ Reject rental for ${rental.customer}?\n\nReason: ${reason}`)){
        
        let data = getRentals();
        data = data.map(r => {
            if(r.id === currentRentalId){
                r.approved = false;
                r.status = 'Rejected';
                r.approvalDate = new Date().toISOString();
                r.approvalReason = reason;
                
                // Send notification
                sendNotification(r, '❌ Rental Rejected', 
                    `Your rental request for ${r.car} has been REJECTED.\n\nReason: ${reason}\n\nPlease contact admin for more details.`);
            }
            return r;
        });
        
        saveRentals(data);
        showToast('Rental rejected', 'error');
        closeApprovalModal();
        renderTable();
    }
}

// =========================================
// OTHER FUNCTIONS (Status, Message, etc.)
// =========================================

function toggleStatus(id){
    const rental = getRentals().find(r => r.id === id);
    if(!rental || !rental.approved) {
        showToast('Must approve first!', 'error');
        return;
    }
    
    const newStatus = rental.status === "Active" ? "Returned" : "Active";
    
    if(confirm(`Change status to "${newStatus}"?\n\n${rental.customer} - ${rental.car}`)){
        let data = getRentals();
        data = data.map(r => {
            if(r.id === id){
                const oldStatus = r.status;
                r.status = newStatus;
                sendAutoNotification(r, `Status Updated`, `Status changed from "${oldStatus}" to "${newStatus}"`);
            }
            return r;
        });
        saveRentals(data);
        showToast(`Status: ${newStatus}`, 'success');
        renderTable();
    }
}

let messageRentalId = null;
function openMessageModal(id){
    const rental = getRentals().find(r => r.id === id);
    if(!rental) return;
    
    messageRentalId = id;
    document.getElementById('modalTitle').textContent = `Message ${rental.customer}`;
    document.getElementById('renterName').textContent = rental.customer;
    document.getElementById('messageText').value = '';
    document.getElementById('messageModal').classList.add('active');
}

function closeMessageModal(){
    document.getElementById('messageModal').classList.remove('active');
    messageRentalId = null;
}

function sendMessage(){
    const rental = getRentals().find(r => r.id === messageRentalId);
    const messageText = document.getElementById('messageText').value.trim();
    
    if(!messageText || !rental) {
        showToast('Invalid message', 'error');
        return;
    }
    
    sendNotification(rental, 'Admin Message', messageText);
    showToast(`Message sent to ${rental.customer}`, 'success');
    closeMessageModal();
}

function sendAutoNotification(rental, title, message){
    sendNotification(rental, title, message);
}

function sendNotification(renter, title, message){
    const notifications = getRenterNotifications();
    const renterEmail = renter.email;
    
    if(!notifications[renterEmail]) notifications[renterEmail] = [];
    
    notifications[renterEmail].unshift({
        id: Date.now(),
        title: title,
        message: message,
        date: new Date().toISOString(),
        read: false
    });
    
    saveRenterNotifications(notifications);
}

function deleteRental(id){
    const rental = getRentals().find(r => r.id === id);
    if(!rental) return;
    
    if(confirm(`⚠️ Delete #${rental.id}?\n\n${rental.customer} - ${rental.car}\n₱${rental.amount.toLocaleString()}`)){
        let data = getRentals().filter(r => r.id !== id);
        saveRentals(data);
        showToast('Rental deleted', 'error');
        renderTable();
    }
}

function renderSales(){
    const data = getRentals();
    const sales = {};
    data.filter(r => r.status === "Returned" || r.status === "Approved").forEach(r => {
        if(!sales[r.company]) sales[r.company] = 0;
        sales[r.company] += Number(r.amount);
    });

    const container = document.getElementById("salesContainer");
    container.innerHTML = Object.keys(sales).length ? 
        Object.entries(sales).map(([company, amount]) => `
            <div class="vertical-column">
                <span class="header">${company}</span>
                <span class="item">₱${amount.toLocaleString()}</span>
            </div>
        `).join('') + `
            <div class="vertical-column" style="background: linear-gradient(135deg, rgba(16,185,129,0.2), rgba(5,150,105,0.2));">
                <span class="header" style="color: #10b981;">TOTAL</span>
                <span class="item" style="background: linear-gradient(135deg, #10b981, #059669);">₱${Object.values(sales).reduce((a,b)=>a+b,0).toLocaleString()}</span>
            </div>` :
        '<div style="text-align:center; padding:40px; color:#94a3b8;">No approved sales yet</div>';
}

function showToast(message, type = 'info'){
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
    if(confirm('Logout?')) { localStorage.removeItem('admin'); window.location.href = 'login.php'; }
}

// Close modals on outside click
document.addEventListener('click', function(e){
    if(e.target.classList.contains('approval-modal')) closeApprovalModal();
    if(e.target.classList.contains('message-modal')) closeMessageModal();
});

// =========================================
// INITIALIZATION
// =========================================

document.addEventListener('DOMContentLoaded', function() {
    initSampleData();
    renderTable();
    localStorage.setItem('admin', 'true');
    
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.6s';
    setTimeout(() => { document.body.style.opacity = '1'; }, 100);
    
    console.log('🚀 COMPLETE Rental System with APPROVALS Loaded!');
    console.log('✅ Approval workflow: PENDING → APPROVE/REJECT');
    console.log('✅ Auto-notifications sent to renters');
});

</script>
</body>
</html>