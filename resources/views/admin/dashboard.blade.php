<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Pale Ivory</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-layout">
        <!-- Mobile Header -->
        <header class="mobile-header">
            <button id="mobile-menu-btn"><i class="fa-solid fa-bars"></i></button>
            <span class="brand">Pale Ivory Admin</span>
            <div class="user-avatar-sm"><i class="fa-regular fa-user"></i></div>
        </header>

        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Pale Ivory</span>
                <button id="close-sidebar-btn" class="mobile-only"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <nav class="sidebar-menu">
                <div class="menu-label">Menu</div>
                
                <!-- Common Admin Links -->
                <a href="#" class="nav-item active" data-target="admin-dashboard-home">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Overview</span>
                </a>
                
                <a href="#" class="nav-item" data-target="admin-trades-view">
                    <i class="fa-solid fa-briefcase"></i>
                    <span>Manage Trades</span>
                </a>
                
                <a href="#" class="nav-item" data-target="admin-students-view">
                    <i class="fa-solid fa-users"></i>
                    <span>Student Records</span>
                </a>

                <!-- Super Admin Only -->
                @if($user->role === 'superadmin')
                <a href="#" class="nav-item super-admin-only" data-target="super-admin-view">
                    <i class="fa-solid fa-user-shield"></i>
                    <span>Manage Admins</span>
                </a>
                @endif
            </nav>

            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar"><i class="fa-regular fa-user"></i></div>
                    <div class="user-details">
                        <span id="current-username">{{ $user->name }}</span>
                        <span id="current-role">{{ $user->role === 'superadmin' ? 'Super Admin' : 'Entrepreneurship Admin' }}</span>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-icon"><i class="fa-solid fa-right-from-bracket"></i></button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Dashboard Home -->
            <section id="admin-dashboard-home" class="content-section active">
                <div class="section-header">
                    <h1>Dashboard Overview</h1>
                    <p>Welcome back to the administration panel.</p>
                </div>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon blue"><i class="fa-solid fa-users"></i></div>
                        <div class="stat-info">
                            <h3>Total Students</h3>
                            <p id="stat-total-students">{{ $totalStudents }}</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon green"><i class="fa-solid fa-briefcase"></i></div>
                        <div class="stat-info">
                            <h3>Active Trades</h3>
                            <p id="stat-total-trades">{{ $activeTrades }}</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon purple"><i class="fa-solid fa-check-circle"></i></div>
                        <div class="stat-info">
                            <h3>Total Capacity</h3>
                            <p id="stat-total-capacity">{{ $totalCapacity }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Manage Trades -->
            <section id="admin-trades-view" class="content-section hidden">
                <div class="section-header">
                    <h1>Manage Trades</h1>
                    <button class="btn-primary" onclick="toggleModal('add-trade-modal')">
                        <i class="fa-solid fa-plus"></i> Add Trade
                    </button>
                </div>
                
                <div class="card-container">
                    <div class="table-responsive">
                        <table id="trades-table">
                            <thead>
                                <tr>
                                    <th>Trade Name</th>
                                    <th>Capacity</th>
                                    <th>Enrolled</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trades as $trade)
                                <tr>
                                    <td>{{ $trade->name }}</td>
                                    <td>{{ $trade->capacity }}</td>
                                    <td>{{ $trade->students_count }}</td>
                                    <td>
                                        @if($trade->students_count >= $trade->capacity)
                                            <span class="badge red">Full</span>
                                        @else
                                            <span class="badge green">Available</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.trades.destroy', $trade) }}" method="POST" onsubmit="return confirm('Are you sure?')" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon red"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Student Records -->
            <section id="admin-students-view" class="content-section hidden">
                <div class="section-header">
                    <h1>Student Records</h1>
                    <div class="header-actions">
                        <select id="filter-trade" class="form-select-sm">
                            <option value="all">All Trades</option>
                            @foreach($trades as $trade)
                                <option value="{{ $trade->id }}">{{ $trade->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn-secondary" onclick="renderStudentsTable()"><i class="fa-solid fa-rotate"></i></button>
                    </div>
                </div>

                <div class="card-container">
                    <div class="table-responsive">
                        <table id="students-table">
                            <thead>
                                    <tr>
                                    <th>Student Name</th>
                                    <th>Matric Number</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Department</th>
                                    <th>Level</th>
                                    <th>Trade</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->matric_number }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->phone_number }}</td>
                                    <td>{{ $student->department }}</td>
                                    <td>{{ $student->level }}</td>
                                    <td>{{ $student->trade ? $student->trade->name : 'None' }}</td>
                                    <td><span class="badge green">Active</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Manage Admins (Super Admin) -->
            <section id="super-admin-view" class="content-section hidden">
                <div class="section-header">
                    <h1>System Administrators</h1>
                    <button class="btn-primary" onclick="toggleModal('add-admin-modal')">
                        <i class="fa-solid fa-user-plus"></i> New Admin
                    </button>
                </div>

                <div class="card-container">
                    <div class="table-responsive">
                        <table id="admins-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($admins as $admin)
                                <tr>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->role }}</td>
                                    <td>{{ $admin->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        @if($admin->id !== auth()->guard('admin')->id())
                                        <form action="{{ route('admin.admins.destroy', $admin) }}" method="POST" onsubmit="return confirm('Are you sure?')" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon red"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Modals -->
    <div id="add-trade-modal" class="modal hidden">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add New Trade</h3>
                <button class="close-modal" onclick="toggleModal('add-trade-modal')">&times;</button>
            </div>
            <form action="{{ route('admin.trades.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Trade Name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Capacity</label>
                    <input type="number" name="capacity" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="toggleModal('add-trade-modal')">Cancel</button>
                    <button type="submit" class="btn-primary">Create Trade</button>
                </div>
            </form>
        </div>
    </div>

    <div id="add-admin-modal" class="modal hidden">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Create New Admin</h3>
                <button class="close-modal" onclick="toggleModal('add-admin-modal')">&times;</button>
            </div>
            <form action="{{ route('admin.admins.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <div class="select-wrapper">
                        <select name="role">
                            <option value="admin">Entrepreneurship Admin</option>
                            <option value="superadmin">Super Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="toggleModal('add-admin-modal')">Cancel</button>
                    <button type="submit" class="btn-primary">Create Admin</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
