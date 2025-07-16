document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('.customer');
  const submitBtn = document.getElementById('submit-btn');

    const inputs = form.querySelectorAll('input');

    inputs.forEach(input => {
      input.addEventListener('input', () => {
        const allFilled = Array.from(inputs).every(i => i.value.trim() !== '');
        submitBtn.disabled = !allFilled;
      });
    });

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const data = {
      name: document.getElementById('employee_name').value.trim(),
      email: document.getElementById('email').value.trim(),
      password: document.getElementById('password').value.trim(),
    };

    try {
      const response = await fetch('/api/admin/employeeAdd.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      });


      const result = await response.json();

      if (result.success) {
        alert(`success ${result.message}`);
        form.reset();
        submitBtn.disabled = true;
      } else {
        alert(`failure ${result.message}`);
      }
    } catch (error) {
      console.error('Add user error:', error);
      alert('An error occurred while adding the user.');
    }
  });
});

