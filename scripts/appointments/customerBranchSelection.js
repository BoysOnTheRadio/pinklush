let map;
let markers = [];
let markerGroup;

document.addEventListener('DOMContentLoaded', async () => {
    
    // 1. Initialize the Leaflet Map
    // Set default view to Cebu City [Latitude, Longitude] and zoom level 13
    map = L.map('map').setView([10.3157, 123.8854], 13);

    // Load the free OpenStreetMap visual tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    
    // Create a group to hold our pins so we can auto-zoom to fit them all
    markerGroup = L.featureGroup().addTo(map);

    const submitBtn = document.getElementById('submit-btn');
    const hidden = document.getElementById('selected');
    const form = document.querySelector('form.pl-section');

    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const branchId = hidden.value;
        if (branchId) {
            AppointmentStorage.set('branch_id', branchId); 
            window.location.href = 'customer-serviceselection.php';
        }
    });

    const container = document.querySelector('.branch-items');
    
    // Fetch branch data from your Spring Boot Backend
    //fetch('http://localhost:8080/api/branches')
   fetch('api/branchGET.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                container.innerHTML = "";

                data.branches.forEach(branch => {
                    // Create branch boxes
                    const div = document.createElement('div');
                    div.classList.add('branch-box');
                    div.dataset.id = branch.branch_id;
                    div.innerHTML = `
                        <p class="pl-header-b">Branch ${branch.branch_id}</p>
                        <div class="image-wrapper">
                            <img src="images/${branch.branch_image}" onerror="this.src='images/pinklush_logo.jpg'">
                        </div>
                        <p>${branch.address}</p>
                    `;
                    container.appendChild(div);

                    // Plot Leaflet Map Markers
                    if (branch.latitude && branch.longitude) {
                        const lat = parseFloat(branch.latitude);
                        const lng = parseFloat(branch.longitude);
                        
                        // Create a pin and add it to our group
                        const marker = L.marker([lat, lng]).addTo(markerGroup);
                        
                        // Add a little popup text when clicked
                        marker.bindPopup(`<b>Branch ${branch.branch_id}</b><br>${branch.address}`);

                        // Link the map pin to the branch box click
                        marker.on('click', () => {
                            div.click();
                            map.flyTo([lat, lng], 16); // Cool zoom-in animation
                            marker.openPopup();
                        });
                        
                        markers.push(marker);
                    }
                });

                // Auto-adjust map to show all pins perfectly
                if (markers.length > 0) {
                    map.fitBounds(markerGroup.getBounds().pad(0.1));
                }

                // Add click events to the newly created boxes
                const generatedBranchBoxes = document.querySelectorAll('.branch-box');
                generatedBranchBoxes.forEach(box => {
                    box.addEventListener('click', () => {
                        document.querySelector('.selected')?.classList.remove('selected');
                        box.classList.add('selected');
                        hidden.value = box.dataset.id;
                        submitBtn.disabled = false;
                    });
                });
            } else {
                container.innerHTML = "<p>Could not load branches.</p>";
            }
        })
        .catch((e) => {
            console.error(e);
            container.innerHTML = "<p>Could not load branches.</p>";
        });
});