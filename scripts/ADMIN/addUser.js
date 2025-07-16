document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('.customer');
  const submitBtn = document.getElementById('submit-btn');
  const branchSelect = document.getElementById('branch_id');

  // Load branches into the dropdown
  async function loadBranches() {
    try {
      const res = await fetch('/api/branchGET.php');
      const data = await res.json();

      if (data.success && data.branches) {
        data.branches.forEach(branch => {
          const option = document.createElement('option');
          option.value = branch.branch_id;
          option.textContent = branch.address;
          branchSelect.appendChild(option);
        });
      } else {
        alert('Failed to load branches.');
      }
    } catch (err) {
      console.error('Error loading branches:', err);
      alert('Could not load branches.');
    }
  }

  loadBranches();

  // Form submission logic
  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const data = {
      name: document.getElementById('employee_name').value.trim(),
      email: document.getElementById('email').value.trim(),
      password: document.getElementById('password').value.trim(),
      branch_id: document.getElementById('branch_id').value.trim()
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
        alert(`Success: ${result.message}`);
        form.reset();
      } else {
        alert(`Failed: ${result.message}`);
      }
    } catch (error) {
      console.error('Add user error:', error);
      alert('An error occurred while adding the user.');
    }
  });
});
