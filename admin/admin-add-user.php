<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin User</title>
<link rel="stylesheet" href="pinklush_admin.css">
    <style>
        .form-group {
            padding: 10px;
            display: flex;
            flex-direction: column;
            width: 95%;
            align-items: flex-start;
            margin: -10px 0 -25px 0;
        }

        .customer {
            background-color: #ffdfee;
            outline: 2px solid hotpink;
            border-radius: 15px;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
            width: 100%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

            .cinfo {
                justify-content: center;
                align-items: center;
            }

            .form-group input {
                border: none;
                background-color: rgb(255, 245, 248);
                height: 45px;
                border-radius: 7.5px;
                width: 100%;
                padding-left: 15px;
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
                transition: 0.5s ease all;
            }

                .form-group input:focus {
                    outline: none;
                    border-color: hotpink;
                    box-shadow: 0 0 0 3px rgba(255, 105, 180, 0.3);
                }

                .form-group ::placeholder {
                    font-style: italic;
                    letter-spacing: 1.1px;
                    color: #aaa;
                }
        .pl-select-option {
            width: 100%;
        }
        .pl-input-label {
            color: gray;
            font-size: 1.3rem;
            text-align: left;
            font-family: 'Playfair Display', serif;
            font-weight: 750;
        }

            #base-option {
                color: gray;
                cursor: not-allowed;
            }
    
            .pl-select-option {
                border: 1px solid rgba(255, 105, 180, 0.2);
                background-color: rgb(255, 245, 248);
                height: 45px;
                border-radius: 7.5px;
                width: 100%;
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
                font-family: 'Poppins', sans-serif;
                color: #333;
                transition: 0.5s ease all;
                    -webkit-appearance: none;
                    -moz-appearance: none;
                    appearance: none;
            }
            
            

                .pl-select-option:focus {
                    outline: none;
                    border-color: hotpink;
                    box-shadow: 0 0 0 3px rgba(255, 105, 180, 0.3);
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
                <a href = "admin-add-user.php" class="nav-button active">Add User</a>
                <a href = "admin-modify-profile.php" class="nav-button">Modify Profile</a>
                <a href = "admin-modify-service.php" class="nav-button">Modify Service</a>
                <a href = "" class="nav-button">Logout</a>
            </nav>
            <div class="content-area cinfo">
                
            <form class="customer" action = "landing-page.php" method = "POST">
            <h1 id = "pl-admin-header-c">User Information Sheet</h1>

            <div class="form-group">
                <label for = "customer_name" class = "pl-input-label">Name</label>
                    <input type = "text" id = "customer_name" placeholder = "John Doe" required>
            </div>

            <div class="form-group">
                <label for = "employee_id" class = "pl-input-label">Employee ID</label>
                    <input type = "text" id = "employee_id" placeholder = "#123" required>
            </div>

            <div class="form-group">
                <label for = "user-name" class = "pl-input-label">Username</label>
                    <input type = "text" id = "user-name" placeholder = "pinklush" required>
            </div>

            <div class="form-group">
                <label for = "password" class = "pl-input-label">Password</label>
                    <input type = "text" id = "password" placeholder = "@1234" required>
            </div>

            <div class="form-group">
                <label for = "permissions" class = "pl-input-label">Permissions</label>
                <select class = "pl-select-option" id = "permissions" required>
                    <option id = "base-option">Select Permissions</option>
                    <option>Customer</option>
                    <option>Employee</option>
            </div>
            
            <button type = "submit" class = "btn primary" id = "submit-btn" disabled>
                Add User
            </button>
       
       
        </form>
            </div>
        </main>
    </div>
</section>
<script src="pinklush_admin.js"></script>
</body>
</html>
