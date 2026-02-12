<!-- Nepal Tourism Management System - Navigation Header -->
<!-- Include this in header section of all pages -->

<header class="navbar navbar-dark bg-dark sticky-top flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">
    ✈️ Nepal Tourism
  </a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="w-100"></div>
  <div class="navbar-nav flex-row order-md-last">
    <div class="nav-item text-nowrap">
      <span class="nav-link px-3 text-light">Welcome, <strong id="username">Guest</strong></span>
    </div>
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="logout.php">Sign out</a>
    </div>
  </div>
</header>

<!-- Sidebar Navigation for Admin Panel -->
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3 ps-3 pe-3">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="dashboard.php">
          📊 Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="manage-packages.php">
          📦 Manage Packages
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="create-package.php">
          ➕ Add Package
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="manage-users.php">
          👥 Users
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="manage-bookings.php">
          🎫 Bookings
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="manage-enquiries.php">
          ❓ Enquiries
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="manage-issues.php">
          ⚠️ Issues
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="change-password.php">
          🔐 Change Password
        </a>
      </li>
    </ul>
    <hr>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link text-danger" href="logout.php">
          🚪 Logout
        </a>
      </li>
    </ul>
  </div>
</nav>
