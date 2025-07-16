document.addEventListener('DOMContentLoaded', async () => {
  const branchId   = AppointmentStorage.get('branch_id');
  if (!branchId) {
    // No branch chosen → bounce back
    window.location.href = 'customer-branchselection.php';
    return;
  }

  const servicesGroup = document.querySelector('.services-group');
  const submitBtn     = document.getElementById('submit-btn');
  const hidden        = document.getElementById('selected');
  const form          = document.querySelector('form.pl-section');

  let servicesData = [];
  let currentPage  = 1;
  const perPage    = 14;

  // ——— Render a single page of services ———
  function renderPage(page) {
    servicesGroup.innerHTML = '';
    const start = (page - 1) * perPage;
    const slice = servicesData.slice(start, start + perPage);

    if (!slice.length) {
      servicesGroup.innerHTML = '<p>No services available for this page.</p>';
      submitBtn.disabled = true;
      return;
    }

    slice.forEach(service => {
      const box = document.createElement('div');
      box.classList.add('service-box');
      box.dataset.id = service.service_id;
      box.innerHTML = `
        <h1 id="service-box-header">${service.service_name}</h1>
        <p id="service-box-detail">
          <span id="pl-highlight-a">Duration:</span>
          <span id="pl-highlight-b">${service.duration ? service.duration + ' min' : 'N/A'}</span>
        </p>
        <div class="image-wrapper"></div>
        <p id="service-box-detail">
          <span id="pl-highlight-a">Price:</span>
          <span id="pl-highlight-b">₱${service.price}</span>
        </p>
        <p id="service-box-detail">
          <span id="pl-highlight-c">${service.description || ''}</span>
        </p>
      `;
      servicesGroup.appendChild(box);
    });

    // re‑attach your click handlers
    document.querySelectorAll('.service-box').forEach(box => {
      box.addEventListener('click', () => {
        document.querySelector('.selected')?.classList.remove('selected');
        box.classList.add('selected');
        hidden.value = box.dataset.id;
        submitBtn.disabled = false;
      });
    });

    // update pagination highlight
    document
      .querySelectorAll('.pl-pagination .pl-icon')
      .forEach(el => {
        if (!el.classList.contains('toggle-direction')) {
          el.id = (+el.textContent === page) ? 'icon-active' : '';
        }
      });
  }

  // ——— Build pagination controls ———
  function buildPagination(totalItems) {
    const container = document.querySelector('.pl-pagination');
    container.innerHTML = '';

    // Prev button (constant)
    const prev = document.createElement('span');
    prev.className = 'toggle-direction pl-icon';
    prev.textContent = '<';
    prev.onclick = paginationleft;
    container.appendChild(prev);

    // generate page numbers
    const totalPages = Math.ceil(totalItems / perPage);
    for (let i = 1; i <= totalPages; i++) {
      const span = document.createElement('span');
      span.className = 'pl-icon';
      span.textContent = i;
      span.onclick = () => {
        currentPage = i;
        renderPage(i);
      };
      container.appendChild(span);
    }

    // Next button (constant)
    const next = document.createElement('span');
    next.className = 'toggle-direction pl-icon';
    next.textContent = '>';
    next.onclick = paginationright;
    container.appendChild(next);
  }

  // ——— Fetch and initialize ———
  fetch(`api/servicesGET.php?branch_id=${branchId}`)
    .then(r => r.json())
    .then(data => {
      servicesData = data;
      buildPagination(data.length);
      renderPage(currentPage);
    })
    .catch(() => {
      servicesGroup.innerHTML = '<p>Could not load services.</p>';
      submitBtn.disabled = true;
    });

  // ——— Prev/Next globals (used by the constant ← and →) ———
  window.paginationleft = () => {
    if (currentPage > 1) {
      renderPage(--currentPage);
    }
  };
  window.paginationright = () => {
    const max = Math.ceil(servicesData.length / perPage);
    if (currentPage < max) {
      renderPage(++currentPage);
    }
  };

  // ——— Form submit (constant) ———
  form.addEventListener('submit', e => {
    e.preventDefault();
    const serviceId = hidden.value;
    if (serviceId && branchId) {
      AppointmentStorage.set('service_id', serviceId);
      window.location.href = 'customer-scheduling.php';
    }
  });
});