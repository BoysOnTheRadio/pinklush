document.addEventListener('DOMContentLoaded', async () => {
  const branchBox = document.getElementById('branchCheckboxes');
  const employeeBox = document.getElementById('employeeCheckboxes');

  // Load branches
  try {
    const res = await fetch('/api/branchGET.php');
    const data = await res.json();
    const branches = data.branches || [];

    branches.forEach(branch => {
      const wrapper = document.createElement('div');
      wrapper.classList.add('checkbox-item');

      const checkbox = document.createElement('input');
      checkbox.type = 'checkbox';
      checkbox.name = 'branches[]';
      checkbox.value = branch.branch_id;

      const label = document.createElement('label');
      label.textContent = branch.address;
      label.style.marginLeft = '8px';

      wrapper.appendChild(checkbox);
      wrapper.appendChild(label);
      branchBox.appendChild(wrapper);
    });
  } catch (err) {
    console.error('Failed to load branches:', err);
  }

  // Load employees
  try {
    const res = await fetch('/api/admin/employeeShow.php');
    const data = await res.json();
    const employees = data.employees || [];

    employees.forEach(emp => {
      const wrapper = document.createElement('div');
      wrapper.classList.add('checkbox-item');

      const checkbox = document.createElement('input');
      checkbox.type = 'checkbox';
      checkbox.name = 'employees[]';
      checkbox.value = emp.employee_id;

      const label = document.createElement('label');
      label.textContent = emp.name;
      label.style.marginLeft = '8px';

      wrapper.appendChild(checkbox);
      wrapper.appendChild(label);
      employeeBox.appendChild(wrapper);
    });
  } catch (err) {
    console.error('Failed to load employees:', err);
  }

  // Handle form submission
  document.getElementById('addServiceForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const serviceName = document.getElementById('service_name').value;
    const duration = document.getElementById('duration').value;
    const price = document.getElementById('price').value;
    const description = document.getElementById('description').value;
    const serviceType = document.getElementById('service_type').value;

    const branchIds = Array.from(document.querySelectorAll('input[name="branches[]"]:checked')).map(cb => cb.value);
    const employeeIds = Array.from(document.querySelectorAll('input[name="employees[]"]:checked')).map(cb => cb.value);

    const response = await fetch('/api/admin/addService.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        service_name: serviceName,
        service_type: serviceType,
        duration: duration,
        price: price,
        description: description,
        branch_id: branchIds,
        employee_id: employeeIds
      })
    });

    const result = await response.json();
    alert(result.message);
    if (result.success) document.getElementById('addServiceForm').reset();
  });
});
