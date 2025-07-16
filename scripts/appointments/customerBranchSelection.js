 document.addEventListener('DOMContentLoaded', async () => {
 
 // Branch Select
        const branchbox = document.querySelectorAll('.branch-box');
        const submitBtn = document.getElementById('submit-btn');
        const hidden = document.getElementById('selected');
        const form = document.querySelector('form.pl-section');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const branchId = hidden.value;
            if (branchId) {
                window.location.href = `customer-serviceselection.php?branch-id=${branchId}`;
            }
        });

        branchbox.forEach(box => {
        box.addEventListener('click', () => {
            document.querySelector('.selected')?.classList.remove('selected');
            box.classList.add('selected');
            hidden.value = box.dataset.id;
            submitBtn.disabled = false;
        });
        });

    const container = document.querySelector('.branch-items');
    fetch('api/branchGET.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                container.innerHTML = "";
                data.branches.forEach(branch => {
                    const div = document.createElement('div');
                    div.classList.add('branch-box');
                    div.dataset.id = branch.branch_id;
                    div.innerHTML = `
                        <p>Branch ${branch.branch_id}</p>
                        <div class="image-wrapper">
                            <img src="default-branch.jpg" alt="Branch Image" style="width:100px;height:100px;">
                        </div>
                        <p>${branch.address}</p>
                    `;
                    container.appendChild(div);
                });

                const branchbox = document.querySelectorAll('.branch-box');
                const submitBtn = document.getElementById('submit-btn');
                const hidden = document.getElementById('selected');
                branchbox.forEach(box => {
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
        .catch(() => {
            container.innerHTML = "<p>Could not load branches.</p>";
        });

});