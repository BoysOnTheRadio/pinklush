const modalBox = document.getElementById('pl-modal');

    const closeModal = () => {
        modalBox.style.animation = 'fade-out 1s';
        modalBox.addEventListener('animationend', () => {
        modalBox.style.display = 'none';
        }, {once: true});
    }