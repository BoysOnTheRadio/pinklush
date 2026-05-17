<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Selection</title>
    <link rel = "stylesheet" href = "pinklush.css">
</head>
    <style>
        .search-bar {
        width: 100%;
        max-width: 400px;
        padding: 0.8rem 1.2rem;
        border: 1px solid rgba(255, 105, 180, 0.2);
        border-radius: 8px;
        background-color: rgb(255, 245, 248);
        font-family: "Poppins", sans-serif;
        font-size: 1rem;
        color: #333;
        transition: 0.3s ease;
        margin: 0 0 0 50px;
        }

        .search-bar::placeholder {
        color: #aaa;
        font-style: italic;
        }

        .search-bar:focus {
        outline: none;
        border-color: hotpink;
        box-shadow: 0 0 0 3px rgba(255, 105, 180, 0.3);
        }
        
        .services-group {
            width: 120%;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            justify-content: center;
            justify-items: center;
            gap: 50px;
            min-height: 500px; /* Adjust this value as needed */
        }
        
            .service-box {
                cursor: pointer;
                background-color: rgb(255, 255, 255);
                padding: 15px;
                border-radius: 5px;
                transition: all ease 0.4s;
                display: flex;
                height: 225px;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                color: #e96994ff; 
            }

                .service-box:hover {
                    transform: scale(1.05) translateY(-10px);
                }

                .service-box:active {
                    background-color: pink;
                }

                    .image-wrapper {
                    display: flex;
                    outline: 4px white solid;
                    border-radius: 100%;
                    overflow: hidden;
                    position: relative;
                    outline: 3px solid pink;
                    min-height: 75px;
                    min-width: 75px;
                    margin: 10px;
                    }

                    .image-wrapper:before {
                        position: absolute;
                        background-color: white;
                        content: '';
                        height: 400px;
                        width: 75px;
                        opacity: 0.8;
                        box-shadow: 0 0 10px white;
                        transform: rotate(5deg) translate(-350px, -50px);
                        transition: all ease 0.75s;
                    }

            .pl-pagination {
                margin: 25px;
            }

                .pl-icon {
                    margin: 5px;
                    cursor: pointer;
                    background-color: pink;
                    padding: 5px 12px;
                    border-radius: 100%;
                    background: none;
                    transition: 1s ease;
                }

                    #icon-active {
                        background-color: pink;
                    }

                .pl-icon:hover {
                    background-color: pink;
                }

            #service-box-header {font-size: 0.8rem;}
            #service-box-detail {font-size: 0.65rem;}

            @media (max-width:768px) {
                .service-box {
                    transform: scale(0.9);
                }
            }
    </style>
<body>
    <section class = "pinklush_background">
        <form class="pl-section" action = "customer-scheduling.php" method = "GET">

            <h1 class = "pl-header-a">
                Select service type
            </h1>
                <input type="search" class="search-bar" placeholder="Search...">
                <div class="services-group">

                </div>

            <input type = "hidden" name = "service-id" id = "selected" value = "">

            <div class="pl-pagination">
                <span class = "toggle-direction pl-icon" onclick = "paginationleft()"><</span>
                    <span class = "pl-icon">1</span>
                    <span class = "pl-icon">2</span>
                    <span class = "pl-icon">3</span>
                    <span class = "pl-icon">4</span>
                <span class = "pl-icon toggle-direction pl-icon" onclick = "paginationright()">></span>
            </div>
            
            <button class = "btn primary" id = "submit-btn" type = "submit" disabled>
                Customer Scheduling
            </button>
                    
            </form>
        
    </section>
        
    <script src="scripts/appointments/appointmentStorage.js" defer></script>
    <script src="scripts/appointments/customerServiceSelection.js"></script>
</body>
</html>
