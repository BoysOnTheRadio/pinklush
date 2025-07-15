document.addEventListener('DOMContentLoaded', async () => {
 function getBranchIdFromUrl() {
            const params = new URLSearchParams(window.location.search);
            return params.get('branch-id');
        }
        const branchId = getBranchIdFromUrl();
        const servicesGroup = document.querySelector('.services-group');
        const submitBtn = document.getElementById('submit-btn');
        const hidden = document.getElementById('selected');
        const form = document.querySelector('form.pl-section');

        // Fetch and render services for the selected branch
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
                        <h1>${service.service_name}</h1>
                        <p>Duration: ${service.duration ? service.duration + " min" : "N/A"}</p>
                        <div class="image-wrapper"></div>
                        <p>Price: ₱${service.price}</p>
                        <p>${service.description ? service.description : ""}</p>
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

            // Intercept form submit to add branch-id and service-id to URL
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const serviceId = hidden.value;
                if (serviceId && branchId) {
                    window.location.href = `customer-scheduling.php?branch-id=${branchId}&service-id=${serviceId}`;
                }
            });
});