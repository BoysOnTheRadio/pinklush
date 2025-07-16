<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin User</title>
<link rel="stylesheet" href="pinklush_admin.css">
    <style>
        html, body {
  height: 100%;
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


  .bookings-header {
  font-family: "Playfair Display", serif;
  font-size: clamp(2rem, 4vw, 3rem);
  font-weight: 800;
  color: #333;
}

.search-bar {
  width: 100%;
  max-width: 400px;
  padding: 0.8rem 1.2rem;
  border: 1px solid rgba(255, 105, 180, 0.2);
  border-radius: 8px;
  background-color: rgb(255, 245, 248);
  font-family: "Poppins", sans-serif;
  font-size: 1rem;
  color: #333;
  transition: 0.3s ease;
  margin: 0 0 0 50px;
}

.search-bar::placeholder {
  color: #aaa;
  font-style: italic;
}

.search-bar:focus {
  outline: none;
  border-color: hotpink;
  box-shadow: 0 0 0 3px rgba(255, 105, 180, 0.3);
}

.bookings-table-container {
  max-height: 70vh;
  overflow-y: auto;
  border-radius: 10px;
  background-color: white;
  width: 100%;
  border-radius: 10px;
  border: 1px solid rgba(255, 105, 180, 0.2);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
  background-color: rgb(255, 240, 245);
  max-height: 700px;
  
}

.bookings-table {
  width: 100%;
  border-collapse: collapse;
  min-width: 800px;
  overflow-y: auto; 
}

.bookings-table th,
.bookings-table td {
  padding: 1rem 1.2rem;
  text-align: left;
  border-bottom: 1px solid rgba(255, 105, 180, 0.1);
  font-family: "Poppins", sans-serif;
  font-size: 0.95rem;
  color: #333;
   overflow-y: auto; 
}

.bookings-table th {
  background-color: rgb(255, 223, 228);
  font-weight: 600;
  color: hotpink;
  text-transform: uppercase;
  font-size: 0.9rem;
  position: sticky;
  top: 0;
  z-index: 1;
}

h1{
  margin-bottom: 30px;
}

.bookings-table tbody tr:last-child td {
  border-bottom: none;
}

.bookings-table tbody tr:hover {
  background-color: rgb(255, 245, 250);
}

  .content-header {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
  }

  @media (max-width: 1024px) {
  .bookings-header {
    font-size: clamp(1.8rem, 5vw, 2.5rem);
  }
  .search-bar {
    padding: 0.6rem 1rem;
    font-size: 0.9rem;
  }
  .bookings-table th,
  .bookings-table td {
    padding: 0.8rem 1rem;
    font-size: 0.85rem;
  }
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
                <a href = "admin-add-service.php" class="nav-button">Add Service</a>
                <a href = "admin-delete-service.php" class="nav-button active">Delete Service</a>
                <a href = "admin-customers.php" class="nav-button">Customers</a>
                <a href = "" class="nav-button">Logout</a>
            </nav>
            <div class="content-area">
                <form class="customer" action="admin-delete-user" method="POST">
                <h1 id="pl-admin-header-c">Delete User</h1>

  
            <div class="bookings-table-container">
              <table class="bookings-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Service Type</th>
                    <th>Service Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="serviceTableBody">
                  <!-- JS will inject rows here -->
                </tbody>
              </table>
            </div>
            </div>
        </main>
    </div>
</section>
 <script>
  document.addEventListener("DOMContentLoaded", async () => {
    const tableBody = document.getElementById("serviceTableBody");

    try {
      const res = await fetch("/api/admin/serviceGet.php");
      const data = await res.json();

      if (!data.success) throw new Error(data.message);

      data.services.forEach((service, index) => {
        const row = document.createElement("tr");
        row.innerHTML = `
          <td>${index + 1}</td>
          <td>${service.service_type}</td>
          <td>${service.service_name}</td>
          <td>${service.description}</td>
          <td>₱${parseFloat(service.price).toFixed(2)}</td>
          <td>${service.duration} min</td>
          <td><button class="btn danger" onclick="deleteService(${service.service_id})">Delete</button></td>
        `;
        tableBody.appendChild(row);
      });
    } catch (err) {
      console.error("Failed to load services:", err);
    }
  });

  async function deleteService(serviceId) {
    if (!confirm("Are you sure you want to delete this service?")) return;

    try {
      const res = await fetch(`/api/admin/serviceDelete.php?id=${serviceId}`, {
        method: "DELETE"
      });
      const data = await res.json();

      if (data.success) {
        alert("Service deleted!");
        location.reload();
      } else {
        alert("Delete failed: " + data.message);
      }
    } catch (err) {
      console.error("Error deleting service:", err);
    }
  }
</script>

</body>
</html>
