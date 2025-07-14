// Example function to mark an appointment as done
async function markAppointmentDone(appointmentId) {
    const response = await fetch('api/appointments/appointmentDone.php', {
        method: 'PUT', // or 'POST' if your server only allows POST
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ appointment_id: appointmentId })
    });

    const result = await response.json();
    if (result.success) {
        alert('Appointment marked as done!');
        // Optionally refresh your appointments list here
    } else {
        alert('Failed to update appointment: ' + result.message);
    }
}

