<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: ../login/login.html");
  exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Analytics Dashboard</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="icon" href="favicon.ico" />
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">





</head>
<body data-role="<?= $_SESSION['user']['role'] ?>">
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="logo">Renata PLC</div>
      <div class="highlight-box" id="highlightBox"></div>
      <nav class="nav">
        <ul id="navItems">
          <li class="active"><i class="fas fa-chart-line"></i> Dashboard</li>
          <li><i class="fas fa-chart-pie"></i> Chart 1</li>
          <li><i class="fas fa-chart-bar"></i> Chart 2</li>
          <li><i class="fas fa-chart-area"></i> Chart 3</li>
          <li><i class="fas fa-table"></i> Chart 4</li>
          <li><i class="fas fa-chart-column"></i> Chart 5</li>

          <!-- ✅ Manager-only edit review link -->
          <?php if ($_SESSION['user']['role'] === 'manager'): ?>
            <li>
              <i class="fas fa-tasks"></i>
              <a href="pending-edits.php" style="color: inherit; text-decoration: none;">Review Edits</a>
            </li>
          <?php endif; ?>
        </ul>

        <div class="account">
          <h4>ACCOUNT PAGES</h4>
          <ul id="accountItems">
            <li><i class="fas fa-user"></i> Profile</li>
            <li>
              <i class="fas fa-sign-out-alt"></i>
              <a href="../login/logout.php" style="color: inherit; text-decoration: none;">Sign Out</a>
            </li>
          </ul>
        </div>
      </nav>
      <div class="help-section">
        <h4>Need help?</h4>
        <p>Please check our docs</p>
        <button>Read Me</button>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="main">
      <!-- Header -->
      <header class="header">
        <h2>/ Dashboard</h2>

        <div class="search-login">
          <div class="search-wrapper">
            <input type="text" id="globalSearchInput" placeholder="Type here..." />
            <i class="fas fa-search"></i>
          </div>

          <!-- Notification Icon -->
          <div class="notif-btn">
            <i class="fas fa-bell"></i>
            <span id="notifCount" class="notif-count" style="display:none;">!</span>
            <div class="notif-dropdown" style="display: none;">
              <ul id="notifList">
                <!-- JS will inject notifications -->
              </ul>
            </div>
          </div>

          <button class="profile-button"><i class="fas fa-user-circle"></i> Profile</button>
        </div>

      </header>

      <!-- Metric Cards -->
      <section class="metric-cards">
        <div class="card">
          <div class="card-icon"><i class="fas fa-users"></i></div>
          <div class="card-details">
            <h4>Total Customers</h4>
            <p id="totalCustomers">50</p>
          </div>
        </div>
        <div class="card">
          <div class="card-icon"><i class="fas fa-dollar-sign"></i></div>
          <div class="card-details">
            <h4>Average Income</h4>
            <p id="averageIncome">৳49,482</p>
          </div>
        </div>
        <div class="card">
          <div class="card-icon"><i class="fas fa-money-bill-wave"></i></div>
          <div class="card-details">
            <h4>Highest Income</h4>
            <p id="highestIncome">৳99,845</p>
          </div>
        </div>
        <div class="card">
          <div class="card-icon"><i class="fas fa-city"></i></div>
          <div class="card-details">
            <h4>Divisions</h4>
            <p id="divisionCount">8</p>
          </div>
        </div>
      </section>

      <!-- Dashboard Second Row -->
      <section class="dashboard-row">
        <section class="welcome-card">
          <div class="welcome-text">
            <p class="welcome-greeting">Welcome back,</p>
            <h2 class="welcome-name">Mark Johnson</h2>
            <p class="welcome-sub">Glad to see you again!<br>Ask me anything.</p>
            <a href="#" class="tap-record">Tap to record <i class="fas fa-arrow-right"></i></a>
          </div>
          <div class="welcome-img">
            <img src="./assets/images/welcome.png" alt="Welcome Visual" />
          </div>
        </section>

        <section class="revenue-card">
          <div class="revenue-header">
            <p>Total Revenue</p>
            <i class="fas fa-coins revenue-icon"></i>
          </div>
          <h3><span class="currency">৳</span><span id="totalRevenue">1,830,821</span></h3>
        </section>

        <section class="top-customers-card">
          <h4>Top Customers</h4>
          <ul id="topCustomersList">
            <li><span class="rank">🥇</span> <span class="name">Grant</span> <span class="amount">৳99,845</span></li>
            <li><span class="rank">🥈</span> <span class="name">Karen</span> <span class="amount">৳97,541</span></li>
            <li><span class="rank">🥉</span> <span class="name">Steven</span> <span class="amount">৳92,834</span></li>
            <li><span class="rank">#4</span> <span class="name">Lorraine</span> <span class="amount">৳86,584</span></li>
            <li><span class="rank">#5</span> <span class="name">Gregory</span> <span class="amount">৳83,689</span></li>
          </ul>
        </section>
      </section>

      <!-- Dashboard Second Row: Bar + Donut side-by-side -->
      <section class="dashboard-row-second">
        <!-- Bar Chart Card -->
        <section class="chart-card">
          <div class="chart-header">
            <h4>Sales by Division</h4>
            <p>Income grouped by division (Bar Chart)</p>
          </div>
          <div class="chart-container">
            <canvas id="divisionChart"></canvas>
          </div>
        </section>

        <!-- Donut Chart Card -->
        <section class="chart-card">
          <div class="chart-header">
            <h4>Income Distribution</h4>
            <p>Customer segments by income level (Donut Chart)</p>
          </div>
          <div class="chart-container">
            <canvas id="incomeDonut"></canvas>
          </div>
        </section>
      </section>

      <!-- Dashboard Third Row: Marital Status Stacked Bar Chart -->
      <section class="dashboard-row-third">
        <!-- Marital Status Chart -->
        <section class="chart-card">
          <div class="chart-header">
            <h4>Customer Count by Marital Status</h4>
            <p>Distribution of customers segmented by Marital Status across Divisions</p>
          </div>
          <div class="chart-container">
            <canvas id="maritalStatusChart"></canvas>
          </div>
        </section>

        <!-- Gender-based Pie Chart -->
        <section class="chart-card">
          <div class="chart-header">
            <h4>Gender-based Sales Comparison</h4>
            <p>Total income contributed by each Gender (Pie Chart)</p>
          </div>
          <div class="chart-container">
            <canvas id="genderPieChart"></canvas>
          </div>
        </section>
      </section>
      <!-- Dashboard Fourth Row: Age vs. Income Correlation -->
      <section class="dashboard-row-fourth">
        <!-- Age vs Income Line Chart -->
        <section class="chart-card">
          <div class="chart-header">
            <h4>Age vs. Income Correlation</h4>
            <p>Average income grouped by customer age bands</p>
          </div>
          <div class="chart-container">
            <canvas id="ageIncomeChart"></canvas>
          </div>
        </section>
        <!-- Zero Income Card -->
        <section class="chart-card zero-income-card">
          <div class="chart-header">
            <h4>Customers with Zero Income</h4>
            <p>Identifies inactive leads or cleanup targets</p>
          </div>
          <div class="chart-container">
            <canvas id="zeroIncomeBar"></canvas>
          </div>
          <div class="zero-income-value" id="zeroIncomeCount">0</div>
        </section>

      </section>
      <?php if (
        $_SESSION['user']['role'] === 'admin' ||
        $_SESSION['user']['role'] === 'manager' ||
        $_SESSION['user']['role'] === 'sales'
      ): ?>
      <!-- Dashboard Fifth Row: Customer Information and Overview -->
      <section class="dashboard-row-fifth">
        <!-- Left: Customer Information Table Card -->
        <section class="customer-table-card">
          <div class="card-header">
            <h4>Customer List</h4>
            <p>Overview of all customers with demographic and income info</p>
          </div>

          <!-- 🔍 Filter + Sort Controls -->
          <div class="table-controls">
            <input type="text" id="nameSearchInput" placeholder="Search by Name..." />
            <input type="text" id="searchInput" placeholder="Filter by Division, Gender, MaritalStatus..." />
            <select id="sortSelect">
              <option value="">Sort by</option>
              <option value="age">Sort by Age</option>
              <option value="income">Sort by Income</option>
            </select>
            <button id="clearFiltersBtn" title="Clear filters">
              <i class="fas fa-times-circle"></i>
            </button>
          </div>

          <!-- Table Header -->
          <div class="customer-table-header">
            <span>Name</span>
            <span>Division</span>
            <span>Gender</span>
            <span>Age</span>
            <span>Marital status</span>
            <span>Progress</span>
          </div>
          <!-- Table Body (Populated by JS) -->
          <div class="customer-table-body" id="customerTableBody">
            <!-- JS will dynamically inject rows here -->
          </div>
        </section>


      </section>
      <?php endif; ?>

    </main>
  </div>

  <!-- Edit Modal (only shown to admin) -->
  <?php if ($_SESSION['user']['role'] === 'admin'): ?>
    <div id="editModal" class="modal hidden">
      <form id="editForm">
        <input type="hidden" name="customer_id" id="editCustomerId">
        <input type="text" name="name" id="editName" class="modal-input" placeholder="Name" required>
        <input type="text" name="division" id="editDivision" class="modal-input" placeholder="Division" required>
        <select name="gender" id="editGender" class="modal-input">
          <option>Male</option>
          <option>Female</option>
          <option>Other</option>
        </select>
        <input type="number" name="age" id="editAge" class="modal-input" placeholder="Age" required>
        <select name="marital_status" id="editMarital" class="modal-input">
          <option>Single</option>
          <option>Married</option>
          <option>Divorced</option>
        </select>
        <input type="number" name="income" id="editIncome" class="modal-input" placeholder="Income" required>
        <button type="submit" id="submitEditBtn" class="modal-submit">Submit for Approval</button>
      </form>
    </div>
  <?php endif; ?>

<script src="dashboard.js"></script>
</body>
</html>