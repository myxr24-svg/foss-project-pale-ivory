import './bootstrap';

// Mock Data Initialization
const INITIAL_TRADES = [
    { id: 1, name: 'Tie and Dye', capacity: 50, enrolled: 0 },
    { id: 2, name: 'Photography', capacity: 30, enrolled: 0 },
    { id: 3, name: 'Baking', capacity: 40, enrolled: 0 },
    { id: 4, name: 'Web Design', capacity: 25, enrolled: 0 }
];

const INITIAL_ADMINS = [
    { username: 'admin', password: 'password', role: 'admin' }, // Entrepreneurship Admin
    { username: 'super', password: 'password', role: 'superadmin' } // Super Admin
];

// State Management
let currentUser = null;

// LocalStorage Helpers
const Storage = {
    getTrades: () => JSON.parse(localStorage.getItem('trades')) || INITIAL_TRADES,
    setTrades: (trades) => localStorage.setItem('trades', JSON.stringify(trades)),
    
    getAdmins: () => JSON.parse(localStorage.getItem('admins')) || INITIAL_ADMINS,
    setAdmins: (admins) => localStorage.setItem('admins', JSON.stringify(admins)),
    
    getStudents: () => JSON.parse(localStorage.getItem('students')) || [],
    setStudents: (students) => localStorage.setItem('students', JSON.stringify(students)),
    
    getCurrentUser: () => JSON.parse(sessionStorage.getItem('currentUser')),
    setCurrentUser: (user) => sessionStorage.setItem('currentUser', JSON.stringify(user)),
    clearSession: () => sessionStorage.removeItem('currentUser')
};

// Initialize Data if empty
if (!localStorage.getItem('trades')) Storage.setTrades(INITIAL_TRADES);
if (!localStorage.getItem('admins')) Storage.setAdmins(INITIAL_ADMINS);

// DOM Elements & Page Detection
const pages = {
    login: document.getElementById('login-form'),
    registration: document.getElementById('registration-form'),
    dashboard: document.querySelector('.dashboard-layout')
};

const adminSections = {
    dashboard: document.getElementById('admin-dashboard-home'),
    trades: document.getElementById('admin-trades-view'),
    students: document.getElementById('admin-students-view'),
    superAdmin: document.getElementById('super-admin-view')
};

// Navigation Logic for Dashboard Tabs
function navigateAdminContent(targetId) {
    // Hide all admin sections
    Object.values(adminSections).forEach(section => {
        if(section) section.classList.add('hidden');
    });
    
    // Show target section
    const target = document.getElementById(targetId);
    if (target) target.classList.remove('hidden');

    // Update Sidebar Active State
    document.querySelectorAll('.nav-item').forEach(item => {
        if (item.dataset.target === targetId) {
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });

    // Refresh data
    if (targetId === 'admin-trades-view') renderTradesTable();
    if (targetId === 'admin-students-view') renderStudentsTable();
    if (targetId === 'super-admin-view') renderAdminsTable();
    if (targetId === 'admin-dashboard-home') updateDashboardStats();

    // Close sidebar on mobile
    if (window.innerWidth <= 768) {
        const sidebar = document.getElementById('sidebar');
        if(sidebar) sidebar.classList.remove('open');
    }
}

// Authentication Logic
function login(username, password, role) {
    const admins = Storage.getAdmins();
    const admin = admins.find(a => a.username === username && a.password === password && a.role === role);
    
    if (admin) {
        currentUser = admin;
        Storage.setCurrentUser(currentUser);
        window.location.href = '/admin/dashboard'; // Updated for Laravel Route
    } else {
        alert('Invalid credentials or role selection.');
    }
}

function logout() {
    Storage.clearSession();
    currentUser = null;
    window.location.href = '/admin/login'; // Updated for Laravel Route
}

function setupAdminUI(user) {
    const usernameEl = document.getElementById('current-username');
    const roleEl = document.getElementById('current-role');
    
    if(usernameEl) usernameEl.textContent = user.username;
    if(roleEl) roleEl.textContent = user.role === 'superadmin' ? 'Super Admin' : 'Entrepreneurship Admin';

    // Role Based Access
    const superAdminLinks = document.querySelectorAll('.super-admin-only');
    if (user.role === 'superadmin') {
        superAdminLinks.forEach(el => el.classList.remove('hidden'));
    } else {
        superAdminLinks.forEach(el => el.classList.add('hidden'));
    }
}

// Modal Logic
window.toggleModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (modal.classList.contains('hidden')) {
        modal.classList.remove('hidden');
    } else {
        modal.classList.add('hidden');
    }
}

// Event Listeners
document.addEventListener('DOMContentLoaded', () => {
    // 1. Dashboard Logic
    if (pages.dashboard) {
        const savedUser = Storage.getCurrentUser();
        if (!savedUser) {
            window.location.href = '/admin/login'; // Updated for Laravel Route
            return;
        }
        currentUser = savedUser;
        setupAdminUI(currentUser);
        updateDashboardStats();

        // Admin Sidebar Navigation
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const target = item.dataset.target;
                if (target) navigateAdminContent(target);
            });
        });

        // Mobile Sidebar Toggle
        const menuBtn = document.getElementById('mobile-menu-btn');
        const closeBtn = document.getElementById('close-sidebar-btn');
        if(menuBtn) menuBtn.addEventListener('click', () => document.getElementById('sidebar').classList.add('open'));
        if(closeBtn) closeBtn.addEventListener('click', () => document.getElementById('sidebar').classList.remove('open'));

        // Logout
        const logoutBtn = document.getElementById('logout-btn');
        if(logoutBtn) logoutBtn.addEventListener('click', logout);

        // Admin Forms
        const addTradeForm = document.getElementById('add-trade-form');
        if(addTradeForm) {
            addTradeForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const name = document.getElementById('new-trade-name').value;
                const cap = parseInt(document.getElementById('new-trade-cap').value);
                
                const trades = Storage.getTrades();
                trades.push({ id: Date.now(), name, capacity: cap, enrolled: 0 });
                Storage.setTrades(trades);
                
                renderTradesTable();
                toggleModal('add-trade-modal');
                e.target.reset();
            });
        }

        const createAdminForm = document.getElementById('create-admin-form');
        if(createAdminForm) {
            createAdminForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const user = document.getElementById('new-admin-user').value;
                const pass = document.getElementById('new-admin-pass').value;
                const role = document.getElementById('new-admin-role').value;

                const admins = Storage.getAdmins();
                if (admins.some(a => a.username === user)) {
                    alert('Username already exists');
                    return;
                }

                admins.push({ username: user, password: pass, role });
                Storage.setAdmins(admins);
                
                renderAdminsTable();
                toggleModal('add-admin-modal');
                e.target.reset();
            });
        }
    }

    // 2. Login Logic
    if (pages.login) {
        pages.login.addEventListener('submit', (e) => {
            e.preventDefault();
            const id = document.getElementById('login-id').value;
            const pass = document.getElementById('login-pass').value;
            const role = document.getElementById('login-role').value;
            login(id, pass, role);
        });
    }

    // 3. Registration Logic
    if (pages.registration) {
        populateTradeDropdown();
        
        pages.registration.addEventListener('submit', (e) => {
            e.preventDefault();
            const tradeName = document.getElementById('reg-trade').value;
            
            // Check capacity again
            const trades = Storage.getTrades();
            const selectedTrade = trades.find(t => t.name === tradeName);
            
            if (!selectedTrade) {
                alert('Please select a valid trade.');
                return;
            }

            if (selectedTrade.enrolled >= selectedTrade.capacity) {
                alert('Sorry, this trade is fully booked.');
                return;
            }

            const studentData = {
                name: document.getElementById('reg-name').value,
                matric: document.getElementById('reg-matric').value,
                email: document.getElementById('reg-email').value,
                phone: document.getElementById('reg-phone').value,
                dept: document.getElementById('reg-dept').value,
                level: document.getElementById('reg-level').value,
                trade: tradeName,
                paymentStatus: 'Pending', // In real app, this updates after Paystack callback
                date: new Date().toLocaleDateString()
            };

            // Simulate Paystack Redirect
            if(confirm(`Proceed to pay ₦5,000 for ${tradeName} via Paystack?`)) {
                // Save Student
                const students = Storage.getStudents();
                students.push(studentData);
                Storage.setStudents(students);

                // Update Trade Count
                selectedTrade.enrolled++;
                Storage.setTrades(trades);

                alert('Payment Successful! Registration Complete.');
                e.target.reset();
                populateTradeDropdown(); // Refresh capacities
            }
        });
    }
});

// Helper Functions
function populateTradeDropdown() {
    const trades = Storage.getTrades();
    const select = document.getElementById('reg-trade');
    const hint = document.getElementById('trade-capacity-hint');
    
    if(!select) return;

    select.innerHTML = '<option value="" disabled selected>Select Trade</option>';
    
    trades.forEach(trade => {
        const option = document.createElement('option');
        option.value = trade.name;
        const remaining = trade.capacity - trade.enrolled;
        option.textContent = `${trade.name}`;
        
        if (remaining <= 0) {
            option.disabled = true;
            option.textContent += ' (Full)';
        }
        select.appendChild(option);
    });

    select.onchange = () => {
        const t = trades.find(tr => tr.name === select.value);
        if (t) {
            hint.textContent = `${t.capacity - t.enrolled} spots remaining out of ${t.capacity}`;
        }
    };
}

function updateDashboardStats() {
    const students = Storage.getStudents();
    const trades = Storage.getTrades();
    
    const statStudents = document.getElementById('stat-total-students');
    const statTrades = document.getElementById('stat-total-trades');
    const statCap = document.getElementById('stat-total-capacity');

    if(statStudents) statStudents.textContent = students.length;
    if(statTrades) statTrades.textContent = trades.length;
    
    if(statCap) {
        const totalCap = trades.reduce((acc, curr) => acc + curr.capacity, 0);
        statCap.textContent = totalCap;
    }
}

function renderTradesTable() {
    const trades = Storage.getTrades();
    const tbody = document.querySelector('#trades-table tbody');
    if(!tbody) return;

    tbody.innerHTML = '';
    
    trades.forEach(trade => {
        const tr = document.createElement('tr');
        const percent = Math.round((trade.enrolled / trade.capacity) * 100);
        
        tr.innerHTML = `
            <td><strong>${trade.name}</strong></td>
            <td>${trade.capacity}</td>
            <td>${trade.enrolled}</td>
            <td>
                <div style="width: 100px; height: 6px; background: #eee; border-radius: 3px; overflow: hidden;">
                    <div style="width: ${percent}%; height: 100%; background: ${percent > 90 ? 'red' : '#10b981'};"></div>
                </div>
                <small>${percent}% Full</small>
            </td>
            <td>
                <button class="btn-danger" onclick="deleteTrade(${trade.id})"><i class="fa-solid fa-trash"></i></button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function renderStudentsTable() {
    const students = Storage.getStudents();
    const tbody = document.querySelector('#students-table tbody');
    const filterEl = document.getElementById('filter-trade');
    
    if(!tbody) return;

    const filter = filterEl ? filterEl.value : 'all';
    
    // Update filter dropdown if needed
    if (filterEl && filterEl.options.length === 1) {
        const trades = Storage.getTrades();
        trades.forEach(t => {
            filterEl.innerHTML += `<option value="${t.name}">${t.name}</option>`;
        });
    }

    tbody.innerHTML = '';
    students.forEach(s => {
        if (filter !== 'all' && s.trade !== filter) return;
        
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <div style="font-weight: 500;">${s.name}</div>
                <small style="color: #666;">${s.email}</small>
            </td>
            <td>${s.matric}</td>
            <td>${s.dept}</td>
            <td>${s.trade}</td>
            <td><span style="background: #dcfce7; color: #16a34a; padding: 2px 8px; border-radius: 10px; font-size: 0.8rem;">${s.paymentStatus}</span></td>
        `;
        tbody.appendChild(tr);
    });
}

function renderAdminsTable() {
    const admins = Storage.getAdmins();
    const tbody = document.querySelector('#admins-table tbody');
    if(!tbody) return;

    tbody.innerHTML = '';
    
    admins.forEach(a => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${a.username}</td>
            <td><span style="text-transform: capitalize;">${a.role}</span></td>
            <td>-</td>
            <td>
                ${a.role !== 'superadmin' ? `<button class="btn-danger" onclick="deleteAdmin('${a.username}')">Remove</button>` : '<span style="color: #ccc;">Protected</span>'}
            </td>
        `;
        tbody.appendChild(tr);
    });
}

// Global Actions
window.deleteTrade = function(id) {
    if(!confirm('Delete this trade?')) return;
    let trades = Storage.getTrades();
    trades = trades.filter(t => t.id !== id);
    Storage.setTrades(trades);
    renderTradesTable();
    updateDashboardStats();
}

window.deleteAdmin = function(username) {
    if(!confirm('Remove this admin?')) return;
    let admins = Storage.getAdmins();
    admins = admins.filter(a => a.username !== username);
    Storage.setAdmins(admins);
    renderAdminsTable();
}
