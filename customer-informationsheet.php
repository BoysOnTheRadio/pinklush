<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Information Sheet</title>
    <link rel = "stylesheet" href = "pinklush.css">
    <script src="scripts/appointments/appointmentStorage.js" defer></script>
    <style>
        .form-group {
            padding: 10px;
            display: flex;
            flex-direction: column;
            width: 95%;
            align-items: flex-start;
            margin: 0 0 -35px 0;
        }

        .cinfo {
            width: 650px;
            padding: 50px 25px;
            margin: 25px;
            background-color: rgb(245, 235, 237);
        }
            .form-group input {
                border: none;
                background-color: rgb(255, 245, 248);
                height: 45px;
                border-radius: 7.5px;
                width: 100%;
                margin: 10px 0;
                padding-left: 15px;
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
                transition: 0.5s ease all;
            }

                .form-group input:focus {
                    outline: none;
                    border-color: hotpink;
                    box-shadow: 0 0 0 3px rgba(255, 105, 180, 0.3);
                }

                .form-group ::placeholder {
                    font-style: italic;
                    letter-spacing: 1.1px;
                    color: #aaa;
                }
        
        .pl-input-label {
            color: #4f4c4b;
            font-size: 1.3rem;
            text-align: left;
            font-family: 'Playfair Display', serif;
            font-weight: 750;
        }

            #optional {
                font-size: 0.9rem;
                font-weight: 500;
            }
    </style>
</head>
<body>
    <section class = "pinklush_background">


        <form class="pl-section cinfo" action = "customer-scheduled.php" method = "POST">
            <h1 class = "pl-header-c pl-color-black">Customer Information Sheet</h1>

            <div class="form-group">
                <label for = "customer_name" class = "pl-input-label">Name</label>
                    <input type = "text" id = "customer_name" placeholder = "Enter Your Full Name" required>
            </div>

            <div class="form-group">
                <label for = "customer_phone" class = "pl-input-label">Phone</label>
                    <input type = "tel" id = "customer_phone" placeholder = "eg (63+) 123-456-789"  required>
            </div>

            <div class="form-group">
                <label for = "customer_socialmedia_facebook" class = "pl-input-label">Facebook Username <span id = "optional">(Optional)</label>
                    <input type = "text" id = "customer_socialmedia_facebook" placeholder = "John Doe">
            </div>

            <div class="form-group">
                <label for = "customer_socialmedia_instagram" class = "pl-input-label">Instagram Username <span id = "optional">(Optional)</span></label>
                    <input type = "text" id = "customer_socialmedia_instagram" placeholder = "@JohnDoe">
            </div>
            
            <button type = "submit" class = "btn primary" id = "submit-btn" disabled>
                Submit booking
            </button>
       
       
        </form>
    <script src = "scripts/appointments/customerInformationVerifier.js"></script>
</body>
</html>
