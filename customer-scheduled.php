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
            padding:  40px 25px;
        }

            #modalClose {
                position: absolute;
                top: 10px;
                right: 20px;
                font-size: 2rem;
                color: white;
                cursor: pointer;
                z-index: 1;
            }

        .section-divide {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
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
        <span id = "modalClose" onclick = "closeModal()">&times;</span>
        <div class="section-divide">
            <h1 class = "pl-header-a">
                You have successfully booked your appointment!
            </h1>

            <p class = "pl-subheader">
                A Text Message Will Be Sent To Your Phone Number Confirming Your Schedule.
                <br>
                You May Now Close This Window.
            </p>
        </div>
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
