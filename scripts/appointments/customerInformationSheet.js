document.addEventListener('DOMContentLoaded', () => {
    const branchId = AppointmentStorage.get('branch_id');
    const serviceId = AppointmentStorage.get('service_id');
    const employeeId = AppointmentStorage.get('employee_id');
    const appointmentDateTime = AppointmentStorage.get('appointment_date');
    console.log('Confirmed DateTime:', appointmentDateTime);

    if (!branchId || !serviceId || !employeeId || !appointmentDateTime) {
        alert("Missing appointment data. Please start again.");
        window.location.href = 'customer-branchselection.php';
        return;
    }

    const form = document.getElementById('cinfo');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const name = document.getElementById('customer_name').value.trim();
        const phone = document.getElementById('customer_phone').value.trim();
        const facebook = document.getElementById('facebook_username').value.trim();
        const instagram = document.getElementById('instagram_username').value.trim();
        const email = document.getElementById('customer_email').value.trim();
        if (!name || !phone) {
            alert("Please fill in all customer fields.");
            return;
        }

        // Validate Philippine phone number
        // Accepts: 09XXXXXXXXX (11 digits) or +639XXXXXXXXX (13 chars)
        const phonePH = /^(09\d{9}|\+639\d{9})$/;
        if (!phonePH.test(phone)) {
            alert("Please enter a valid Philippine phone number (e.g., 09XXXXXXXXX or +639XXXXXXXXX)");
            return;
        }

        // Validate email if provided
        if (email) {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return;
            }
        }

        try {
            const res = await fetch('api/appointments/appointmentPOST.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    employee_id: employeeId,
                    service_id: serviceId,
                    appointment_date: appointmentDateTime,
                    customer_name: name,
                    customer_phone: phone,
                    facebook_username: facebook,
                    instagram_username: instagram,
                    customer_email: email
                })
            });

            const raw = await res.text();
            console.log('Raw server response:', raw);

            let result;
            try {
                result = JSON.parse(raw);
            } catch (jsonError) {
                console.error("Failed to parse JSON:", jsonError);
                alert("Server returned an invalid response.");
                return;
            }

            if (result.success) {
                AppointmentStorage.clear();
                window.location.href = 'customer-scheduled.php';
            } else {
                alert(result.message || "Failed to book appointment.");
            }

        } catch (err) {
            console.error(" Network or server error:", err);
            alert("Something went wrong. Please try again.");
        };
    });
});
