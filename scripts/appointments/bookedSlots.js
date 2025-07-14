// these are max bookings per service per branch
const MAX_BOOKINGS = {
    // branch_id: { service_type: max }
    1: { "Hair": 2, "Nails": 3 },
    2: { "Hair": 1, "Nails": 2 }
    // add more as needed
};

const slots = [
    "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00"
];

let bookedSlots = []; 

// fetch booked slots from API (should include service_type and branch_id)
async function fetchBookedSlots() {
    const res = await fetch('api/appointments/customerScheduling.php');
    const data = await res.json();
    // expecting: [{appointment_date, service_type, branch_id}, ...]
    bookedSlots = data.booked_slots || [];
}

// Helper to get selected branch from storage
function getSelectedBranch() {
    // Use the same key as you used on the branch selection page
    return localStorage.getItem('selectedBranch');
}

// Render time slots, graying out fully booked ones
function renderSlots() {
    const selectedDate = document.getElementById('datePicker').value;
    const selectedServiceType = document.getElementById('serviceTypeSelect').value;
    const selectedBranch = getSelectedBranch();
    const container = document.getElementById('timeSlots');
    container.innerHTML = '';

    if (!selectedBranch) {
        container.innerHTML = '<p style="color:red;">Please select a branch first.</p>';
        return;
    }

    // Get max bookings for this branch/service_type
    const max = (MAX_BOOKINGS[selectedBranch] && MAX_BOOKINGS[selectedBranch][selectedServiceType]) || 1;

    slots.forEach(time => {
        // Count bookings for this service_type, date, time, and branch
        const count = bookedSlots.filter(slot => {
            const [slotDate, slotTime] = slot.appointment_date.split(' ');
            return slotDate === selectedDate &&
                   slotTime.slice(0,5) === time &&
                   slot.service_type === selectedServiceType &&
                   String(slot.branch_id) === String(selectedBranch);
        }).length;

        const disabled = count >= max;
        const btn = document.createElement('button');
        btn.textContent = time;
        btn.disabled = disabled;
        btn.style.background = disabled ? '#ccc' : '';
        container.appendChild(btn);
    });
}

// Event listeners
document.getElementById('datePicker').addEventListener('change', renderSlots);
document.getElementById('serviceTypeSelect').addEventListener('change', renderSlots);

// Initial load
fetchBookedSlots().then(renderSlots);
