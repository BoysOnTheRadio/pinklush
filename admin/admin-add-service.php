<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Service</title>
    <link rel="stylesheet" href="pinklush_admin.css">
    <style>
        html, body {
            max-height: 60%;
            margin: 0;
            overflow-y: hidden; 
        }   

        .dashboard-container {
          display: flex;
          flex-direction: column;
          height: 90vh;
          max-width: 80%;
        }

        .dashboard-main {
          overflow-y: hidden; 
        }

        .content-area {
          flex: 1;
          overflow-y: auto;
          min-height: 0;
        }

        .sidebar {
        width: 250px;         
        flex-shrink: 0;       
        flex-grow: 0;     
        height: 100vh; 
        overflow-y: auto;     
}
        .checkbox-group {
        display: flex;
        flex-wrap: wrap;
        }

        .checkbox-item {
        display: flex;
        align-items: center;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 8px 12px;
        cursor: pointer;
        transition: background-color 0.2s;
        }

        .checkbox-item:hover {
        background-color: #fef0f5;
        }

        .checkbox-item input[type="checkbox"] {
        transform: scale(1.2);
        outline: none;
        box-shadow: none;
        border: none;

        }
        #service_type {
            padding: 0.5rem 1.2rem;
            border: 1.5px solid #e96994;
            border-radius: 8px;
            background-color: #fff0f6;
            color: #e96994;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
            outline: none;
            cursor: pointer;
            box-shadow: 0 1px 4px rgba(233, 105, 148, 0.08);
            margin-top: 0.3rem;
        }
        #service_type:focus {
            border-color: hotpink;
            box-shadow: 0 0 0 3px rgba(255, 105, 180, 0.15);
            background-color: #ffe4ef;
        }
        #service_type option {
            color: #e96994;
            background: #fff0f6;
            font-size: 1rem;
        }
        #service_type option:checked {
            background: #ffe4ef;
            color: #d72660;
        }
</style>
</head>
<body>
<section class="admin_bg">
    <div class="dashboard-container">
        <header class="dashboard-header">
            <div class="site-name">Pink Lush Beauty Lounge</div>
            <div class="user-name">Admin</div>
        </header>
        <main class="dashboard-main">
             <nav class="sidebar">
                <a href = "admin-dashboard.php" class="nav-button">Dashboard</a>
                <a href = "admin-add-user.php" class="nav-button">Add User</a>
                <a href = "admin-delete-user.php" class="nav-button">Delete User</a>
                <a href = "admin-add-service.php" class="nav-button active">Add Service</a>
                <a href = "admin-delete-service.php" class="nav-button">Delete Service</a>
                <a href = "admin-customers.php" class="nav-button">Customers</a>
                <a href = "" class="nav-button" id="logoutBtn">Logout</a>
            </nav>
            <div class="content-area">
                <h1>Add New Service</h1>
        <form id="addServiceForm">
          <div class="form-group">
            <label for="service_name">Service Name</label>
            <input type="text" id="service_name" required>
          </div>

          <div class="form-group">
            <label for="service_type">Service Type</label>
            <select id="service_type" required>
              <option value="">Select type</option>
              <option value="Hair">Hair</option>
              <option value="Nails">Nails</option>
              <option value="Nails">Lashes</option>
              <!-- etc -->
            </select>
          </div>

          <div class="form-group">
            <label for="duration">Duration (minutes)</label>
            <input type="number" id="duration" min="5" required>
          </div>

          <div class="form-group">
            <label for="price">Price (₱)</label>
            <input type="number" id="price" min="0" step="0.01" required>
          </div>

          <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" rows="3" required></textarea>
          </div>

          <div class="form-group checkbox-group">
            <label class = "custom-checkbox">Select Branches:</label>
            <div id="branchCheckboxes" class="checkbox-group"></div>
          </div>

          <div class="form-group checkbox-group">
            <label class="custom-checkbox">Select Employees:</label>
            <div id="employeeCheckboxes" class="checkbox-group"></div>
          </div>

          <button type="submit" class="btn primary">Add Service</button>
        </form>
            </div>
        </main>
    </div>
</section>
<script src="/scripts/admin/addService.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const user = JSON.parse(localStorage.getItem('user'));
    if (!user || !user.is_admin) {
        alert("Access denied. Admins only.");
        window.location.href = 'admin.php'; 
    }
});

document.addEventListener('DOMContentLoaded', () => {
  const logoutBtn = document.getElementById('logoutBtn');
  if (logoutBtn) {
    logoutBtn.addEventListener('click', function(e) {
      e.preventDefault();
      localStorage.removeItem('user');
      window.location.href = 'admin.php';
    });
  }
});
</script>
</body>
</html>
