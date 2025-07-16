document.addEventListener('DOMContentLoaded', async () => {
    const providerList = document.querySelector('.service-provider-list');
    const confirmBtn = document.getElementById('confirmScheduleBtn');
    const noneBtn = document.querySelector('.none-button');
    const calendarGrid = document.getElementById('calendarGrid');
    let selectedProvider = null;
    let selectedDate = null;
    let selectedTimeSlot = null;
    let employees = [];

    const branchId = AppointmentStorage.get('branch_id');
    const serviceId = AppointmentStorage.get('service_id');

    if (!branchId || !serviceId) {
        window.location.href = 'customer-branchselection.php';
    }


    // Function to render time slots for the selected provider and date
    function generateTimeSlots(start, end, interval = 60) {
    const slots = [];
    const [startHour, startMin] = start.split(':').map(Number);
    const [endHour, endMin] = end.split(':').map(Number);

    const startDate = new Date(0, 0, 0, startHour, startMin);
    const endDate = new Date(0, 0, 0, endHour, endMin);

    while (startDate < endDate) {
        const timeString = startDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        slots.push(timeString);
        startDate.setMinutes(startDate.getMinutes() + interval);
    }

    return slots;
}


    // Load employees who can do the service in the branch
    async function loadProviders() {
        try {
            const res = await fetch(`api/appointments/employeeScheduling.php?branch_id=${branchId}&service_id=${serviceId}`);
            const data = await res.json();
            employees = data.employees || [];
            providerList.innerHTML = '';
            if (employees.length === 0) {
                providerList.innerHTML = "<p>No available providers for this service in this branch.</p>";
                renderCalendar(today.getFullYear(), today.getMonth(), []); // No available days
                return;
            }
            employees.forEach(provider => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'provider-item';
                btn.textContent = provider.name;
                btn.dataset.id = provider.employee_id;
                btn.addEventListener('click', () => {
                    document.querySelectorAll('.provider-item').forEach(b => b.classList.remove('selected'));
                    btn.classList.add('selected');
                    selectedProvider = provider.employee_id;
                    updateConfirmState();
                    renderCalendar(today, 30, provider.days);
                });
                providerList.appendChild(btn);
            });
            renderCalendar(today, 30, employees[0].days);
        } catch (err) {
            providerList.innerHTML = "<p>Could not load providers.</p>";
            renderCalendar(today.getFullYear(), today.getMonth(), []);
        }
    }

    // "None" option
    noneBtn.onclick = () => {
        document.querySelectorAll('.provider-item').forEach(b => b.classList.remove('selected'));
        selectedProvider = null;
        updateConfirmState();
        renderCalendar(today.getFullYear(), today.getMonth(), []); // No available days
    };

    function updateConfirmState() {
        confirmBtn.disabled = (selectedProvider === undefined || selectedProvider === null || selectedDate === null);
    }
    
    // Calendar grid logic
        function renderCalendar(startDate, daysToShow, availableDays = []) {
        const monthYearSpan = document.getElementById('currentMonthYear');
        const options = { month: 'long'};
        monthYearSpan.textContent = startDate.toLocaleDateString('en-US', options);

        calendarGrid.innerHTML = '';
        // Add day headers
        ['Mo','Tu','We','Th','Fr','Sa','Su'].forEach(day => {
            const header = document.createElement('div');
            header.className = 'day-header';
            header.textContent = day;
            calendarGrid.appendChild(header);
        });

        let currentDate = new Date(startDate);
        for (let i = 0; i < daysToShow; i++) {
            const dayName = currentDate.toLocaleDateString('en-US', { weekday: 'long' });
            const isAvailable = availableDays.includes(dayName);

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'date-circle' + (isAvailable ? ' available' : ' booked');
            btn.textContent = currentDate.getDate();
            btn.disabled = !isAvailable;
            btn.title = currentDate.toLocaleDateString();
            btn.addEventListener('click', () => {
                if (!isAvailable) return;
                document.querySelectorAll('.date-circle.selected').forEach(b => b.classList.remove('selected'));
                btn.classList.add('selected');
                selectedDate = currentDate.toISOString().slice(0,10);
                selectedTimeSlot = null; 
                updateConfirmState();
                
                console.log("employees =", employees);
                console.log("selectedProvider =", selectedProvider);

                const provider = employees.find(e => e.employee_id == selectedProvider);
                if (provider && provider.shift_start && provider.shift_end) {
                    const timeSlots = generateTimeSlots(provider.shift_start, provider.shift_end);
                    renderTimeSlots(timeSlots);
                } else {
                    console.warn("Provider or shift data missing", provider);
                }
            });
            calendarGrid.appendChild(btn);

            // Move to next day
            currentDate.setDate(currentDate.getDate() + 1);
        }
    }

    async function renderTimeSlots(slots) {
    const timeSlotList = document.querySelector('.time-slot-list');
    timeSlotList.innerHTML = '';

    const provider = employees.find(e => String(e.employee_id) === String(selectedProvider));
    if (!provider || !selectedDate) return;

    const serviceId = AppointmentStorage.get('service-id');

    // Get booking info from the backend
    const res = await fetch(`api/appointments/bookedAppointmentsGET.php?provider_id=${selectedProvider}&date=${selectedDate}&service_id=${serviceId}`);
    const data = await res.json();

    const bookedSlots = data.booked || {};
    const maxPerSlot = data.max_per_slot || 1;

    slots.forEach(slot => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'time-slot-btn';
        btn.textContent = slot;

        const isFullyBooked = (bookedSlots[slot] || 0) >= maxPerSlot;
        if (isFullyBooked) {
            btn.disabled = true;
            btn.classList.add('booked');
        }

        btn.addEventListener('click', () => {
            document.querySelectorAll('.time-slot-btn').forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');
            selectedTimeSlot = slot;
            updateConfirmState();
        });

        timeSlotList.appendChild(btn);
    });
}

    // Show next 30 days starting from today
    const today = new Date();
    await loadProviders();
    // When rendering calendar for a provider:
    renderCalendar(today, 30, employees[0].days);
    updateConfirmState();

    document.getElementById('confirmScheduleBtn').addEventListener('click', () => {
    if (selectedProvider && selectedDate && selectedTimeSlot) {
        AppointmentStorage.set('employee_id', selectedProvider);
        AppointmentStorage.set('appointment_date', selectedDate);
        AppointmentStorage.set('appointment_time', selectedTimeSlot);

        window.location.href = 'customer-informationsheet.php'; 
    } else {
        alert('Please select a provider, date, and time.');
    }

    const allData = AppointmentStorage.getAll();
    console.log(allData);
});

});