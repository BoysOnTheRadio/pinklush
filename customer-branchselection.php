<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Selection</title>
    <link rel = "stylesheet" href = "pinklush.css">
    <style>
    /* Branch Selection Boxes */
        .branch-items {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            width: 100%;
        }

        .branch-box {
            filter: brightness(0.9);
            display: flex;
            flex-direction: column;
            width: 45%;
            height: 300px;
            border-radius: 10px;
            padding: 25px;
            align-items: center;
            justify-content: center;
            background-color: rgb(255, 217, 246);
            margin: 10px;
            gap: 10px;
            transition: all 0.5s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            margin: 0 15px;
        }

            .branch-box:hover {
                filter: brightness(1);
                transform: scale(1.05) translateY(-15px);
            }

            .branch-box:active {
                animation: bounce-click 0.5s ease;
            }

                .branch-box:after {
                    background-color: yellow;
                }

                    .branch-box:hover .branch-box:after {
                        transform: scale(1.1);
                    }

                .branch-box:hover .image-wrapper {
                    outline: 6px solid pink;
                }

                .branch-box:hover .image-wrapper:before {
                    opacity: 0.15;
                    transform: rotate(5deg) translate(500px, -50px);
                }

                    .image-wrapper {
                    display: flex;
                    outline: 4px white solid;
                    border-radius: 2.5px;;
                    width: 95%;
                    overflow: hidden;
                    position: relative;
                    outline: 3px solid pink;
                    margin: 10px;
                    }
                        .image-wimg {
                            width: 100%;
                            height: 100%;
                        }

                    .image-wrapper:before {
                        position: absolute;
                        background-color: white;
                        content: '';
                        height: 400px;
                        width: 75px;
                        opacity: 0.8;
                        box-shadow: 0 0 10px white;
                        transform: rotate(5deg) translate(-300px, -50px);
                        transition: all ease 0.75s;
                    }

        @media (max-width: 800px) {
            .branch-items {
                flex-direction: column;
            }
            .branch-box {
            width: 95%;
            height: 250px;
            }
        }

    </style>
</head>
<body>
    <section class = "pinklush_background">
        <form class="pl-section" action="customer-serviceselection.php" method="GET">

            <h1 class = "pl-header-a">
                Select which Branch
            </h1>

            <section class="branch-items">
            </section>
            <input type="hidden" name="branch-id" id="selected" value="">
                <button class = "btn primary" id = "submit-btn" type = "submit" disabled>
                    Continue
                </button>
        
            </form>
    </section>
    
    <script src="scripts/appointments/appointmentStorage.js" defer></script>
    <script src="scripts/appointments/customerBranchSelection.js"></script>
</body>
</html>
