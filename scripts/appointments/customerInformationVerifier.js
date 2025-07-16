const cname = document.getElementById('customer_name');
const cphone = document.getElementById('customer_phone');
const submit = document.getElementById('submit-btn');

function checkinput() {
    if(cname.value.trim() !== "" && cphone.value.trim() !== "") submit.disabled = false;
    else submit.disabled = true;
}

cname.addEventListener('input', checkinput);
cphone.addEventListener('input', checkinput);