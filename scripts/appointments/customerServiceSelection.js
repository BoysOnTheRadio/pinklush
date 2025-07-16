document.addEventListener('DOMContentLoaded', async () => {

        const branchId = AppointmentStorage.get('branch_id');
        if (!branchId) {
            window.location.href = 'customer-branchselection.php';
            return;
        }

        const allData = AppointmentStorage.getAll();
        console.log(allData);
        
        const servicesGroup = document.querySelector('.services-group');
        const submitBtn = document.getElementById('submit-btn');
        const hidden = document.getElementById('selected');
        const form = document.querySelector('form.pl-section');

        fetch(`api/servicesGET.php?branch_id=${branchId}`)  
            .then(response => response.json())
            .then(data => {
                servicesGroup.innerHTML = "";
                if (data.length === 0) {
                    servicesGroup.innerHTML = "<p>No services available for this branch.</p>";
                    submitBtn.disabled = true;
                    return;
                }
                data.forEach(service => {
                    const box = document.createElement('div');
                    box.classList.add('service-box');
                    box.dataset.id = service.service_id;
                    box.innerHTML = `
                        <h1 id = "service-box-header">${service.service_name}</h1>
                        <p id = "service-box-detail"><span id = "pl-highlight-a">Duration:</span> <span id = "pl-highlight-b">${service.duration ? service.duration + " min" : "N/A"}</span></p>
                        <div class="image-wrapper"></div>
                        <p id = "service-box-detail"><span id = "pl-highlight-a">Price:</span> <span id = "pl-highlight-b">₱${service.price}</span></p>
                        <p id = "service-box-detail"><span id = "pl-highlight-c">${service.description ? service.description : ""}</span></p>
                    `;
                    servicesGroup.appendChild(box);
                });

                // Add click event listeners to each service box
                const serviceBoxes = document.querySelectorAll('.service-box');
                serviceBoxes.forEach(box => {
                    box.addEventListener('click', () => {
                        document.querySelector('.selected')?.classList.remove('selected');
                        box.classList.add('selected');
                        hidden.value = box.dataset.id;
                        submitBtn.disabled = false;
                    });
                });
            })
            .catch(() => {
                servicesGroup.innerHTML = "<p>Could not load services.</p>";
                submitBtn.disabled = true;
            });

            form.addEventListener('submit', function(e) {
            e.preventDefault();
            const serviceId = hidden.value;
            if (serviceId && branchId) {
                AppointmentStorage.set('service_id', serviceId);
                window.location.href = 'customer-scheduling.php';
            }
});

});