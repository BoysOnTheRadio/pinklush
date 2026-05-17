<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Status</title>
<link rel="stylesheet" href="pinklush_admin.css">
<style>
     html, body {
  height: 100%;
  margin: 0;
  overflow-y: hidden; 
}

/* Status dropdown styles for admin dashboard */
.status-select {
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
}

.status-select:focus {
  border-color: hotpink;
  box-shadow: 0 0 0 3px rgba(255, 105, 180, 0.15);
  background-color: #ffe4ef;
}

.status-select option {
  color: #e96994;
  background: #fff0f6;
  font-size: 1rem;
}

.status-select option:checked {
  background: #ffe4ef;
  color: #d72660;
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
            <div class="user-name">Employee</div>
        </header>
        <main class="dashboard-main">
            <nav class="sidebar">
                <a href = "employee-dashboard.php" class="nav-button">Dashboard</a>
                <a href = "employee-customers.php" class="nav-button active">Customers</a>
                <a href = "" class="nav-button" id="logoutBtn">Logout</a>
            </nav>
            <div class="content-area">
              <div class="content-header">
                <h1 class="bookings-header">Completed Customers</h1>
                <input type="search" class="search-bar" placeholder="Search..." id="customerSearch">
              </div>
                <div class="bookings-table-container">
                    <table class="bookings-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Service</th>
                                <th>Stylist</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Number</th>
                                <th>Facebook User</th>
                                <th>Instagram User</th>
                                <th>Branch</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="customerTableBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const tableBody = document.getElementById('customerTableBody');
  const searchInput = document.getElementById('customerSearch');

  fetch('/api/admin/appointmentGET.php')
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        renderCustomers(data.appointments);
      } else {
        tableBody.innerHTML = `<tr><td colspan="11">No data found.</td></tr>`;
      }
    })
    .catch(err => {
      console.error('Error fetching customers:', err);
      tableBody.innerHTML = `<tr><td colspan="11">Error loading data.</td></tr>`;
    });

  function renderCustomers(appointments) {
    tableBody.innerHTML = '';
    const doneCustomers = appointments.filter(appt => appt.status === 'done');
    doneCustomers.forEach((appt, index) => {
      const dateTime = new Date(appt.appointment_date);
      const date = dateTime.toLocaleDateString();
      const time = dateTime.toLocaleTimeString([], {
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
      }).replace(/ AM| PM/, '');
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${index + 1}</td>
        <td>${appt.customer_name || '—'}</td>
        <td>${appt.service_type || '—'}</td>
        <td>${appt.name || '—'}</td>
        <td>${date}</td>
        <td>${time}</td>
        <td>${appt.customer_phone || '—'}</td>
        <td>${appt.facebook_username || '—'}</td>
        <td>${appt.instagram_username || '—'}</td>
        <td>${appt.address || '—'}</td>
        <td>${appt.status || '—'}</td>
      `;
      tableBody.appendChild(row);
    });
  }

  // Live Search Functionality
  searchInput.addEventListener('input', () => {
    const searchTerm = searchInput.value.toLowerCase();
    const rows = document.querySelectorAll('#customerTableBody tr');
    rows.forEach(row => {
      const rowText = row.textContent.toLowerCase();
      row.style.display = rowText.includes(searchTerm) ? '' : 'none';
    });
  });
});
</script>
<script>

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
