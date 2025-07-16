<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Information Sheet</title>
    <link rel = "stylesheet" href = "pinklush.css">
    <style>
        #pl-modal {
            background-color: rgb(0, 0, 0, 0.95);
            position: absolute;
            animation: fade-in 1.5s; 
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
    </style>
</head>
<body>
    <section class = "pinklush_background">

        <section class="pl-section">
            <div id = "pinklush_logo"></div>
            <h1 class = "pl-header-a pl-color-black">
                Thank you for booking with us!
            </h1>
       
        </section>

        <div class="pl-section" id = "pl-modal">
            <h1 class = "pl-header-a">
                You have successfully booked your appointment!
            </h1>

            <p class = "pl-subheader">
                A Text Message Will Be Sent To Your Phone Number Confirming Your Schedule.
                <br>
                You May Now Close This Window.
            </p>
            <button class = "btn primary" onclick = "closeModal()">Mama</button>
        </div>

    </section>

    <script>
        const modalBox = document.getElementById('pl-modal');
        const closeModal = () => {
            modalBox.style.animation = 'fade-out 1s';
            modalBox.addEventListener('animationend', () => {
            modalBox.style.display = 'none';
            }, {once: true});
        }
    </script>
</body>
</html>
