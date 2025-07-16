// admindashboard.js

document.addEventListener("DOMContentLoaded", () => {
    loadAppointments();
});

async function loadAppointments() {
    try {
        const response = await fetch("api/admin/appointmentGet.php");
        const data = await response.json();

        if (data.success && Array.isArray(data.appointments)) {
            const tbody = document.querySelector(".bookings-table tbody");
            tbody.innerHTML = ""; // Clear old data

            data.appointments.forEach((appt, index) => {
                const row = document.createElement("tr");

                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${appt.customer_name}</td>
                    <td>${appt.service_name || 'N/A'}</td>
                    <td>${formatDate(appt.appointment_date)}</td>
                    <td>${formatTime(appt.appointment_date)}</td>
                    <td>${appt.customer_phone}</td>
                    <td>${appt.facebook_user || 'N/A'}</td>
                    <td>${appt.instagram_user || 'N/A'}</td>
                    <td>${appt.email || 'N/A'}</td>
                    <td>Pending</td>
                `;

                tbody.appendChild(row);
            });
        } else {
            alert("No appointments found.");
        }
    } catch (error) {
        console.error("Failed to load appointments:", error);
        alert("Error fetching appointments.");
    }
}

// Format date (e.g., 2025-07-16 -> July 16, 2025)
function formatDate(dateString) {
    const options = { year: "numeric", month: "long", day: "numeric" };
    return new Date(dateString).toLocaleDateString(undefined, options);
}

// Format time (e.g., 2025-07-16T10:30:00 -> 10:30 AM)
function formatTime(dateString) {
    const options = { hour: "2-digit", minute: "2-digit" };
    return new Date(dateString).toLocaleTimeString(undefined, options);
}