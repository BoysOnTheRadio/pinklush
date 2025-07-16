document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.admin-login');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();

        try {
            const res = await fetch('/api/admin/loginAuth.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ email, password })
            });

            const raw = await res.text(); 
            console.log("RAW response:", raw);

            const result = JSON.parse(raw); 

            if (result.success) {
                const user = result.user;
                localStorage.setItem('user', JSON.stringify(user));

                if (user.is_admin) {
                    window.location.href = 'admin-dashboard.php';
                } else {
                    window.location.href = 'employee-dashboard.php';
                }
            } else {
                alert(result.message || "Login failed.");
            }

        } catch (err) {
            console.error("Login failed:", err);
            alert("Server error. Please try again.");
        }
    });
});
