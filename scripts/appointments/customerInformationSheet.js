document.addEventListener('DOMContentLoaded', () => {
    const branchId = AppointmentStorage.get('branch_id');
    const serviceId = AppointmentStorage.get('service_id');
    const employeeId = AppointmentStorage.get('employee_id');
    const appointmentDate = AppointmentStorage.get('appointment_date');
    const appointmentTime = AppointmentStorage.get('appointment_time');

    if (!branchId || !serviceId || !employeeId || !appointmentDate || !appointmentTime) {
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

            const appointmentDatetime = `${appointmentDate} ${appointmentTime}`;

            try {
                const res = await fetch('api/appointments/appointmentPOST.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        employee_id: employeeId,
                        service_id: serviceId,
                        appointment_date: appointmentDatetime,
                        customer_name: name,
                        customer_phone: phone,
                        facebook_username: facebook,
                        instagram_username: instagram,
                        customer_email: email

                    })
                });

                
            // ✅ Get the raw text response
            const raw = await res.text();
            console.log('🚨 Raw server response:', raw);

            // ✅ Try to parse the raw text into JSON
            let result;
            try {
                result = JSON.parse(raw);
            } catch (jsonError) {
                console.error("❌ Failed to parse JSON:", jsonError);
                alert("Server returned an invalid response.");
                return;
            }

            // ✅ Handle the parsed result
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
