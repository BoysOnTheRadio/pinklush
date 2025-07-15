document.addEventListener('DOMContentLoaded', async () => {
    const providerList = document.querySelector('.service-provider-list');
    const confirmBtn = document.getElementById('confirmScheduleBtn');
    const noneBtn = document.querySelector('.none-button');
    const calendarGrid = document.getElementById('calendarGrid');
    let selectedProvider = null;
    let selectedDate = null;
    let selectedTimeSlot = null;
    let employees = [];

    // Get branch and service from query params
    const params = new URLSearchParams(window.location.search);
    const branchId = params.get('branch-id');
    const serviceId = params.get('service-id');

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
            btn.title = currentDate.toLocaleDateString(); // Optional: show full date on hover
            btn.addEventListener('click', () => {
                if (!isAvailable) return;
                document.querySelectorAll('.date-circle.selected').forEach(b => b.classList.remove('selected'));
                btn.classList.add('selected');
                selectedDate = currentDate.toISOString().slice(0,10);
                selectedTimeSlot = null; 
                updateConfirmState();

                const provider = employees.find(e => e.employee_id === selectedProvider);
                const timeSlots = generateTimeSlots(provider.shift_start, provider.shift_end);
                renderTimeSlots(timeSlots);
            });
            calendarGrid.appendChild(btn);

            // Move to next day
            currentDate.setDate(currentDate.getDate() + 1);
        }
    }

    function renderTimeSlots(slots) {
    const timeSlotList = document.querySelector('.time-slot-list');
    timeSlotList.innerHTML = '';

    if (slots.length === 0) {
        timeSlotList.innerHTML = "<p>No time slots available.</p>";
        return;
    }

    slots.forEach(slot => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'time-slot-btn';
        btn.textContent = slot;

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
});