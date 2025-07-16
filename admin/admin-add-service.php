<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Service</title>
    <link rel="stylesheet" href="pinklush_admin.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            overflow-y: hidden; 
        }   

        .sidebar {
        width: 250px;         /* or whatever fixed width you prefer */
        flex-shrink: 0;       /* prevents shrinking */
        flex-grow: 0;         /* prevents growing */
        height: 100vh;        /* full height */
        overflow-y: auto;     /* scroll if sidebar content is long */
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
</style>
</head>
<body>
<section class="admin_bg">
    <div class="dashboard-container">
        <header class="dashboard-header">
            <div class="site-name">Pink Lush Beauty Lounge</div>
            <div class="user-name">Name</div>
        </header>
        <main class="dashboard-main">
             <nav class="sidebar">
                <a href = "admin-dashboard.php" class="nav-button">Dashboard</a>
                <a href = "admin-add-user.php" class="nav-button">Add User</a>
                <a href = "admin-delete-user.php" class="nav-button">Delete User</a>
                <a href = "admin-add-service.php" class="nav-button active">Add Service</a>
                <a href = "admin-delete-service.php" class="nav-button">Delete Service</a>
                <a href = "admin-customers.php" class="nav-button">Customers</a>
                <a href = "" class="nav-button">Logout</a>
            </nav>
            <div class="content-area">
                <h1>Add New Service</h1>
        <form id="addServiceForm">
          <div class="form-group">
            <label for="service_name">Service Name</label>
            <input type="text" id="service_name" required>
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
</body>
</html>
