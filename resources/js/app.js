import './bootstrap';

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

    // Close sidebar on mobile
    if (window.innerWidth <= 768) {
        const sidebar = document.getElementById('sidebar');
        if(sidebar) sidebar.classList.remove('open');
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