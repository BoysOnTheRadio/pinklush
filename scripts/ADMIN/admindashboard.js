document.addEventListener('DOMContentLoaded', () => {
  // Check admin access
  const user = JSON.parse(localStorage.getItem('user'));
  if (!user || !user.is_admin) {
    alert("Access denied. Admins only.");
    window.location.href = 'admin.php';
    return;
  }

  const tableBody = document.querySelector('.bookings-table tbody');
  const searchInput = document.querySelector('.search-bar');

  // Fetch and display appointments
  fetchAppointments();

  function fetchAppointments() {
    fetch('/api/admin/appointmentGET.php') 
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          renderAppointments(data.appointments);
        } else {
          tableBody.innerHTML = `<tr><td colspan="9">No data found.</td></tr>`;
        }
      })
      .catch(err => {
        console.error('Error fetching appointments:', err);
        tableBody.innerHTML = `<tr><td colspan="9">Error loading data.</td></tr>`;
      });
  }

  function renderAppointments(appointments) {
    tableBody.innerHTML = ''; 
    
    appointments = appointments.filter(appt => appt.status === 'Scheduled');

    appointments.forEach((appt, index) => {
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
          <td>
          <select class="status-select" data-id="${appt.appointment_id}">
            <option value="scheduled" ${appt.status === 'scheduled' ? 'selected' : ''}>Scheduled</option>
            <option value="done" ${appt.status === 'done' ? 'selected' : ''}>Done</option>
            <option value="cancelled" ${appt.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
            <option value="no show" ${appt.status === 'no show' ? 'selected' : ''}>No show</option>
          </select>
        </td>
      `;
      tableBody.appendChild(row);
    });
    addStatusListeners();
  }

  

  function addStatusListeners() {
    document.querySelectorAll('.status-select').forEach(select => {
      select.addEventListener('change', function() {
        const appointmentId = this.dataset.id;
        const newStatus = this.value;
  
        fetch('/api/admin/appointmentStatusUpdate.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ appointment_id: appointmentId, status: newStatus })
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            // Remove row if status is done, cancelled, or no show
            if (['done', 'cancelled', 'no show'].includes(newStatus)) {
              this.closest('tr').remove();
            }
          } else {
            alert('Failed to update status: ' + (data.message || 'Unknown error'));
          }
        })
        .catch(() => alert('Network error updating status.'));
      });
    });
  }

  // Live Search Functionality
  searchInput.addEventListener('input', () => {
    const searchTerm = searchInput.value.toLowerCase();
    const rows = document.querySelectorAll('.bookings-table tbody tr');

    rows.forEach(row => {
      const rowText = row.textContent.toLowerCase();
      row.style.display = rowText.includes(searchTerm) ? '' : 'none';
    });
  });
});
