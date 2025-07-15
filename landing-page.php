<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pink Lush Lounge</title>
    <link href="pinklush.css" rel="stylesheet">
    
    <style>
        .line-container {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .line {
            width: 80%;
            max-width: 600px;
            height: 1px;
            background-color: rgba(255, 255, 255, 0.7);
            animation: line-entrance 1.5s ease-out;
        }

        .top-text {
            font-family: 'Raleway', sans-serif;
            font-size: clamp(0.8rem, 2vw, 1.2rem);
            letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 10px;
            animation: fade-in 1.25s;
        }

        .pl-landing-a {
            background: url(https://assets-metrostyle.abs-cbn.com/prod/metrostyle/attachments/bd8722f2-f491-4c22-97a0-9c00be223ad5_inshot_20230627_194720841.jpg) center/cover no-repeat;
            position: relative;
            z-index: 0;
        }

        .pl-landing-a::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.45);
            z-index: 1;
        }

        .fade {
            animation: fade-in 1s ease;
        }

        @media (max-width: 768px) {
            .line {
                width: 90%;
            }

            .top-text {
                font-size: clamp(0.7rem, 3vw, 1rem);
            }
        }

        @media (max-width: 480px) {
            .line {
                width: 95%;
            }
        }

        @keyframes line-entrance {
            0% {
                width: 0%;
            }
            100% {
                width: 100%;
            }
        }

    </style>
</head>
<body>
    <section class="pinklush_background pl-landing-a">
        <div class="pl-section fade">
            <div class="line-container">
                <div class="line"></div>
                <h2 class="top-text">PinkLush Beauty Lounge</h2>
            </div>

            <h1 class="pl-header" id="pl-header-a">
                Letting Your <br /> True Beauty Shine
            </h1>

            <p id="pl-subheader">
                 Your go-to beauty lounge is located at the heart of the city & opens daily for your pampering needs!
            </p>
                <a href = "customer-branchselection.php" class = "btn primary">
                    Book An Appointment Now!
                </a>
                <div class="line"></div>
            </div>
        </div>
    </section>
</body>
</html>
