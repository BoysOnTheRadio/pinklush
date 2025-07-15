<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Selection</title>
    <link rel = "stylesheet" href = "pinklush.css">
</head>
    <style>
        .services-group {
            width: 120%;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            justify-content: center;
            justify-items: center;
            gap: 50px;
        }
        
            .service-box {
                cursor: pointer;
                background-color: rgb(255, 255, 255);
                padding: 20px;
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
                background-color: gray;
            }

                #pl-pno {
                    margin: 10px;
                    cursor: pointer;
                }

            #service-box-header {font-size: 0.8rem;}
            #service-box-detail {font-size: 0.65rem;}
            #pl-highlight-a {font-weight: 700;}
            #pl-highlight-b {font-size: 0.5rem;}
            #pl-highlight-c {font-style: italic;}
    </style>
<body>
    <section class = "pinklush_background">
        <form class="pl-section" action = "customer-scheduling.php" method = "GET">

            <h1 id = "pl-header-a">
                Select service type
            </h1>

                <div class="services-group">

                </div>

            <input type = "hidden" name = "service-id" id = "selected" value = "">

            <div class="pl-pagination">
                <span class = "toggle-direction" class = "pagination-icon" onclick = "paginationleft()"><</span>
                    <span id = "pl-pno">1</span>
                    <span id = "pl-pno">1</span>
                    <span id = "pl-pno">1</span>
                    <span id = "pl-pno">1</span>
                <span class = "toggle-direction" class = "pagination-icon" onclick = "paginationright()">></span>
            </div>
            
            <button class = "btn primary" id = "submit-btn" type = "submit" disabled>
                Customer Scheduling
            </button>
                    
            </form>
        
    </section>
        
    
    <script src="scripts/appointments/customerServiceSelection.js"></script>
</body>
</html>
