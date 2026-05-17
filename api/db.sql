CREATE TABLE branch (
    branch_id INT AUTO_INCREMENT PRIMARY KEY,
    branch_image VARCHAR(300),
    address VARCHAR(255)
);

CREATE TABLE employee (
    employee_id INT AUTO_INCREMENT PRIMARY KEY,
    branch_id INT,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    is_admin BOOLEAN NOT NULL DEFAULT 0;
);

CREATE TABLE schedule (
    shift_id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT,
    branch_id INT,
    day VARCHAR(20),
    shift_start TIME,
    shift_end TIME,
    FOREIGN KEY (employee_id) REFERENCES employee(employee_id),
    FOREIGN KEY (branch_id) REFERENCES branch(branch_id)
);

CREATE TABLE service (
    service_id INT AUTO_INCREMENT PRIMARY KEY,
    service_type VARCHAR(50),
    service_name VARCHAR(100),
    description VARCHAR(255),
    duration INT, -- in minutes
    price DECIMAL(10,2),
    max_bookings_per_slot INT DEFAULT 1;
);

CREATE TABLE employeeservices (
    employee_id INT,
    service_id INT,
    PRIMARY KEY (employee_id, service_id),
    FOREIGN KEY (employee_id) REFERENCES employee(employee_id),
    FOREIGN KEY (service_id) REFERENCES service(service_id)
);

CREATE TABLE branch_services (
    branch_id INT,
    service_id INT,
    PRIMARY KEY (branch_id, service_id),
    FOREIGN KEY (branch_id) REFERENCES branch(branch_id),
    FOREIGN KEY (service_id) REFERENCES service(service_id)
);

CREATE TABLE appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    service_id INT,
    employee_id INT,
    customer_name VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(15),
    appointment_date DATETIME,
    status VARCHAR(20) DEFAULT 'scheduled',
        facebook_username VARCHAR(50) DEFAULT NULL,
        instagram_username VARCHAR(50) DEFAULT NULL,
    email VARCHAR(100) DEFAULT NULL,
    FOREIGN KEY (service_id) REFERENCES service(service_id),
    FOREIGN KEY (employee_id) REFERENCES employee(employee_id)
);

    INSERT INTO branch (address) VALUES
    ('Fuente Osmena, Primeway Plaza'),
    ('IT Park, The Walk');


    -- IT Branch Employees
    INSERT INTO employee (name, email, password) VALUES
    ('Jessa', 'jessa@example.com', 'hashed_pw1'),
    ('Kris', 'kris@example.com', 'hashed_pw2'),
    ('Imee', 'imee@example.com', 'hashed_pw3'),
    ('Smile', 'smile@example.com', 'hashed_pw4'),
    ('Camille', 'camille@example.com', 'hashed_pw5'),
    ('Jay', 'jay@example.com', 'hashed_pw6'),
    ('Carmel', 'carmel@example.com', 'hashed_pw7'),
    ('Angel', 'angel@example.com', 'hashed_pw8');

    -- Primeway Branch Employees
    INSERT INTO employee (name, email, password) VALUES
    ('Kime', 'kimw@example.com', 'hashed_pw9'),
    ('Ashly', 'ashly@example.com', 'hashed_pw10'),
    ('Jm', 'jm@example.com', 'hashed_pw11'),
    ('Charl', 'charl@example.com', 'hashed_pw12'),
    ('Janet', 'janet@example.com', 'hashed_pw13'),
    ('Marlene', 'marlene@example.com', 'hashed_pw14'),
    ('Khristine', 'khristine@example.com', 'hashed_pw15');

    -- IT Branch Schedule
    INSERT INTO schedule (employee_id, branch_id, day, shift_start, shift_end) VALUES
    (1, 2, 'Sunday', '11:00:00', '20:00:00'),
    (1, 2, 'Monday', '11:00:00', '20:00:00'), 
    (1, 2, 'Tuesday', '11:00:00', '20:00:00'),
    (1, 2, 'Wednesday', '11:00:00', '20:00:00'),
    (1, 2, 'Friday', '11:00:00', '20:00:00'),
    (1, 2, 'Saturday', '11:00:00', '20:00:00'),
    (2, 2, 'Tuesday', '11:00:00', '20:00:00'),
    (2, 2, 'Wednesday', '11:00:00', '20:00:00'),
    (2, 2, 'Thursday', '11:00:00', '20:00:00'),
    (2, 2, 'Friday', '11:00:00', '20:00:00'),
    (2, 2, 'Saturday', '11:00:00', '20:00:00'),
    (3, 2, 'Sunday', '11:00:00', '20:00:00'),
    (3, 2, 'Wednesday', '10:00:00', '19:00:00'),
    (3, 2, 'Thursday', '10:00:00', '19:00:00'),
    (3, 2, 'Friday', '10:00:00', '19:00:00'),
    (3, 2, 'Saturday', '10:00:00', '19:00:00'),
    (4, 2, 'Tuesday', '11:00:00', '20:00:00'),
    (4, 2, 'Wednesday', '11:00:00', '20:00:00'),
    (4, 2, 'Thursday', '11:00:00', '20:00:00'),
    (4, 2, 'Friday', '11:00:00', '20:00:00'),
    (4, 2, 'Saturday', '11:00:00', '20:00:00'),
    (5, 2, 'Sunday', '10:00:00', '19:00:00'),
    (5, 2, 'Monday', '10:00:00', '19:00:00'),
    (5, 2, 'Wednesday', '10:00:00', '19:00:00'),
    (5, 2, 'Friday', '10:00:00', '19:00:00'),
    (5, 2, 'Saturday', '10:00:00', '19:00:00'),
    (6, 2, 'Sunday', '10:00:00', '19:00:00'),
    (6, 2, 'Monday', '10:00:00', '19:00:00'),
    (6, 2, 'Tuesday', '10:00:00', '19:00:00'),
    (6, 2, 'Thursday', '10:00:00', '19:00:00'),
    (6, 2, 'Saturday', '10:00:00', '19:00:00'),
    (7, 2, 'Sunday', '10:00:00', '19:00:00'),
    (7, 2, 'Tuesday', '10:00:00', '19:00:00'),
    (7, 2, 'Wednesday', '10:00:00', '19:00:00'),
    (7, 2, 'Thursday', '10:00:00', '19:00:00'),
    (7, 2, 'Friday', '10:00:00', '19:00:00'),
    (7, 2, 'Saturday', '10:00:00', '19:00:00'),
    (8, 2, 'Sunday', '11:00:00', '20:00:00'),
    (8, 2, 'Monday', '11:00:00', '20:00:00'),
    (8, 2, 'Tuesday', '11:00:00', '20:00:00'),
    (8, 2, 'Wednesday', '11:00:00', '20:00:00'),
    (8, 2, 'Friday', '11:00:00', '20:00:00'),
    (8, 2, 'Saturday', '11:00:00', '20:00:00');

    -- Primeway Branch Schedule
    INSERT INTO schedule (employee_id, branch_id, day, shift_start, shift_end) VALUES
    (9, 1, 'Sunday', '10:00:00', '19:00:00'),
    (9, 1, 'Tuesday', '10:00:00', '19:00:00'),
    (9, 1, 'Wednesday', '10:00:00', '19:00:00'),
    (9, 1, 'Thursday', '10:00:00', '19:00:00'),
    (9, 1, 'Friday', '10:00:00', '19:00:00'),
    (9, 1, 'Saturday', '10:00:00', '19:00:00'),
    (10, 1, 'Monday', '11:00:00', '20:00:00'),
    (10, 1, 'Tuesday', '11:00:00', '20:00:00'),
    (10, 1, 'Thursday', '11:00:00', '20:00:00'),
    (10, 1, 'Friday', '11:00:00', '20:00:00'),
    (10, 1, 'Saturday', '11:00:00', '20:00:00'),
    (11, 1, 'Sunday', '10:00:00', '19:00:00'),
    (11, 1, 'Monday', '10:00:00', '19:00:00'),
    (11, 1, 'Wednesday', '10:00:00', '19:00:00'),
    (11, 1, 'Thursday', '10:00:00', '19:00:00'),
    (11, 1, 'Friday', '10:00:00', '19:00:00'),
    (11, 1, 'Saturday', '10:00:00', '19:00:00'),
    (12, 1, 'Sunday', '11:00:00', '20:00:00'),
    (12, 1, 'Monday', '11:00:00', '20:00:00'),
    (12, 1, 'Tuesday', '11:00:00', '20:00:00'),
    (12, 1, 'Thursday', '11:00:00', '20:00:00'),
    (12, 1, 'Friday', '11:00:00', '20:00:00'),
    (12, 1, 'Saturday', '11:00:00', '20:00:00'),
    (13, 1, 'Sunday', '10:00:00', '19:00:00'),
    (13, 1, 'Tuesday', '10:00:00', '19:00:00'),
    (13, 1, 'Wednesday', '10:00:00', '19:00:00'),
    (13, 1, 'Thursday', '10:00:00', '19:00:00'),
    (13, 1, 'Friday', '10:00:00', '19:00:00'),
    (13, 1, 'Saturday', '10:00:00', '19:00:00'),
    (14, 1, 'Sunday', '11:00:00', '20:00:00'),
    (14, 1, 'Monday', '11:00:00', '20:00:00'),
    (14, 1, 'Tuesday', '11:00:00', '20:00:00'),
    (14, 1, 'Wednesday', '11:00:00', '20:00:00'),
    (14, 1, 'Friday', '11:00:00', '20:00:00'),
    (14, 1, 'Saturday', '11:00:00', '20:00:00'),
    (15, 1, 'Sunday', '10:00:00', '19:00:00'),
    (15, 1, 'Monday', '10:00:00', '19:00:00'),
    (15, 1, 'Wednesday', '10:00:00', '19:00:00'),
    (15, 1, 'Thursday', '10:00:00', '19:00:00'),
    (15, 1, 'Friday', '10:00:00', '19:00:00'),
    (15, 1, 'Saturday', '10:00:00', '19:00:00');

    INSERT INTO service (service_type, service_name, description, duration, price) VALUES
    -- Hair
    ('Hair Color', 'Hair Color - Short', 'For short hair', 90, 1500),
    ('Hair Color', 'Hair Color - Medium', 'For medium hair', 90, 2000),
    ('Hair Color', 'Hair Color - Medium Long', 'For medium long hair', 90, 2500),
    ('Hair Color', 'Hair Color - Long', 'For long hair', 90, 3000),
    ('Hair Color', 'Hair Color - Extra Long', 'For extra long hair', 90, 4000),

    ('Balayage', 'Balayage - Short', 'For short hair', 120, 4500),
    ('Balayage', 'Balayage - Medium', 'For medium hair', 120, 5000),
    ('Balayage', 'Balayage - Medium Long', 'For medium long hair', 120, 5500),
    ('Balayage', 'Balayage - Long', 'For long hair', 120, 6000),
    ('Balayage', 'Balayage - Extra Long', 'For extra long hair', 120, 7000),

    ('Brazilian Keratin', 'Brazilian Keratin - Short', 'For short hair', 120, 1500),
    ('Brazilian Keratin', 'Brazilian Keratin - Medium', 'For medium hair', 120, 2000),
    ('Brazilian Keratin', 'Brazilian Keratin - Medium Long', 'For medium long hair', 120, 2500),
    ('Brazilian Keratin', 'Brazilian Keratin - Long', 'For long hair', 120, 3000),
    ('Brazilian Keratin', 'Brazilian Keratin - Extra Long', 'For extra long hair', 120, 4000),

    ('Rebond', 'Rebond - Short', 'For short hair', 150, 2000),
    ('Rebond', 'Rebond - Medium', 'For medium hair', 150, 2500),
    ('Rebond', 'Rebond - Medium Long', 'For medium long hair', 150, 3000),
    ('Rebond', 'Rebond - Long', 'For long hair', 150, 3500),
    ('Rebond', 'Rebond - Extra Long', 'For extra long hair', 150, 4500),

    ('Color Highlights', 'Color Highlights - Short', 'For short hair', 100, 3500),
    ('Color Highlights', 'Color Highlights - Medium', 'For medium hair', 100, 4000),
    ('Color Highlights', 'Color Highlights - Medium Long', 'For medium long hair', 100, 4500),
    ('Color Highlights', 'Color Highlights - Long', 'For long hair', 100, 5000),
    ('Color Highlights', 'Color Highlights - Extra Long', 'For extra long hair', 100, 6000),

    ('Organic Ultra Repair', 'Organic Ultra Repair - Short', 'For short hair', 90, 5000),
    ('Organic Ultra Repair', 'Organic Ultra Repair - Medium', 'For medium hair', 90, 5500),
    ('Organic Ultra Repair', 'Organic Ultra Repair - Medium Long', 'For medium long hair', 90, 6000),
    ('Organic Ultra Repair', 'Organic Ultra Repair - Long', 'For long hair', 90, 6500),
    ('Organic Ultra Repair', 'Organic Ultra Repair - Extra Long', 'For extra long hair', 90, 7500),

    ('Hair and Scalp Detox', 'Hair and Scalp Detox - Men', 'For men', 60, 1500),
    ('Hair and Scalp Detox', 'Hair and Scalp Detox - Women', 'For women', 60, 2000);

    INSERT INTO service (service_type, service_name, description, duration, price) VALUES
    -- Nails - Mani
    ('Nails - Mani', 'Classic Manicure', NULL, NULL, 200.00),
    ('Nails - Mani', 'Classic Mani + Handspa', NULL, NULL, 500.00),
    ('Nails - Mani', 'Gel Manicure', 'Accent: +150/nail', NULL, 500.00),
    ('Nails - Mani', 'Gel Mani + Handspa', NULL, NULL, 800.00),
    ('Nails - Mani', 'Nail Extensions + Gel Mani', NULL, NULL, 2000.00),
    ('Nails - Mani', 'Paraffin Wax + Mani + Handspa', NULL, NULL, 1000.00),

    -- Nails - Pedi
    ('Nails - Pedi', 'Classic Pedicure', NULL, NULL, 250.00),
    ('Nails - Pedi', 'Classic Pedi + Footspa', NULL, NULL, 500.00),
    ('Nails - Pedi', 'Gel Pedicure', NULL, NULL, 500.00),
    ('Nails - Pedi', 'Gel Pedi + Footspa', NULL, NULL, 1200.00),
    ('Nails - Pedi', 'Foot Mask Treatment + Pedi', NULL, NULL, 950.00),
    ('Nails - Pedi', 'Paraffin Wax + Pedi + Footspa', NULL, NULL, 1250.00),

    -- Lashes
    ('Lashes', 'Eyelash Lift/Perm', '+100 for tint', NULL, 600.00),
    ('Lashes', 'Eyelash Extensions - Woke Up Like This - Natural', NULL, NULL, 800.00),
    ('Lashes', 'Eyelash Extensions - Cat Eye', NULL, NULL, 1000.00),
    ('Lashes', 'Eyelash Extensions - Wispy', NULL, NULL, 1000.00),
    ('Lashes', 'Eyelash Extensions - Celebrity - Full', NULL, NULL, 1000.00),
    ('Lashes', 'Eyelash Extensions - Retouch', NULL, NULL, 500.00),
    ('Lashes', 'Eyelash Extensions - Removal', 'Range: 300-500', NULL, 300.00),

    -- Haircuts
    ('Hair', 'Haircut w/ Blow Dry', NULL, NULL, 350.00),
    ('Hair', 'Haircut w/ Shampoo and Blow Dry', NULL, NULL, 500.00),
    ('Hair', 'Mens Haircut', NULL, NULL, 350.00),
    ('Hair', 'Mens Shave', NULL, NULL, 250.00),

    -- Hair Styling
    ('Hair Styling', 'Straightening', NULL, NULL, 600.00),
    ('Hair Styling', 'Curling', NULL, NULL, 600.00),
    ('Hair Styling', 'Blow Dry', 'From 300++', NULL, 300.00),
    ('Hair Styling', 'Hair Extensions', NULL, NULL, 6000.00),

    -- Hair Treatment
    ('Hair Treatment', 'Hair Spa', NULL, NULL, 800.00),
    ('Hair Treatment', 'Hot Oil', NULL, NULL, 500.00),
    ('Hair Treatment', 'Cellophane', NULL, NULL, 1200.00),
    ('Hair Treatment', 'Hair and Scalp Detox - Men', NULL, NULL, 1500.00),
    ('Hair Treatment', 'Hair and Scalp Detox - Women', NULL, NULL, 2000.00),

    -- Waxing
    ('Waxing', 'Full Arms', NULL, NULL, 1000.00),
    ('Waxing', 'Half Arms', NULL, NULL, 500.00),
    ('Waxing', 'Full Legs', NULL, NULL, 1500.00),
    ('Waxing', 'Half Legs', NULL, NULL, 800.00),
    ('Waxing', 'Full Body', NULL, NULL, 4500.00),
    ('Waxing', 'Eyebrow', NULL, NULL, 250.00),
    ('Waxing', 'Upper Lip', NULL, NULL, 200.00),
    ('Waxing', 'Underarms', NULL, NULL, 350.00),
    ('Waxing', 'Back + Belly', NULL, NULL, 2000.00),
    ('Waxing', 'Brazilian', NULL, NULL, 1500.00),

    -- Other Services
    ('Other Services', 'Upper Lip Threading', NULL, NULL, 150.00),
    ('Other Services', 'Eyebrow Threading', NULL, NULL, 200.00),
    ('Other Services', 'Undereye Dark Circles Treatment', NULL, NULL, 500.00),
    ('Other Services', 'UA Whitening Diamond Peel', NULL, NULL, 900.00),
    ('Other Services', 'Footspa', NULL, NULL, 700.00),
    ('Other Services', 'Warts Removal (piece)', NULL, NULL, 200.00),
    ('Other Services', 'Unli Removal - Face', NULL, NULL, 1500.00),
    ('Other Services', 'Unli Removal - Neck', NULL, NULL, 1500.00),
    ('Other Services', 'Ear Candling', NULL, NULL, 500.00),
    ('Other Services', 'Brow Lamination', NULL, NULL, 700.00),


    -- Facial Treatments
    ('Facial Treatment', 'Basic Facial', NULL, NULL, 699.00),
    ('Facial Treatment', 'Korean Facial', NULL, NULL, 999.00),
    ('Facial Treatment', 'Diamond Peel Facial', NULL, NULL, 999.00),
    ('Facial Treatment', 'Acne Facial with LED Mask', NULL, NULL, 1299.00),
    ('Facial Treatment', 'Pinklush Signature Facial', NULL, NULL, 1299.00),
    ('Facial Treatment', 'Micro Needling', NULL, NULL, 1799.00),
    ('Facial Treatment', 'Add on: Hydrating Jelly Mask', 'Add-on service', NULL, 200.00),

    -- Whitening Laser Treatments
    ('Whitening Laser Treatment', 'Skin Rejuvenation Laser', NULL, NULL, 799.00),
    ('Whitening Laser Treatment', 'Pigmentation Laser Therapy', NULL, NULL, 799.00),
    ('Whitening Laser Treatment', 'Pico Laser - Face', NULL, NULL, 1299.00),
    ('Whitening Laser Treatment', 'Carbon Peel Laser - UA/Face', NULL, NULL, 1499.00),
    ('Whitening Laser Treatment', 'Whitening Laser - UA/Groin', NULL, NULL, 1299.00),
    ('Whitening Laser Treatment', 'Whitening Laser - Butt', NULL, NULL, 1799.00),

    -- Diode Laser Hair Removal
    ('Diode Laser Hair Removal', 'Upper/Lower Lip', NULL, NULL, 499.00),
    ('Diode Laser Hair Removal', 'Underarms', NULL, NULL, 599.00),
    ('Diode Laser Hair Removal', 'Beard', NULL, NULL, 599.00),
    ('Diode Laser Hair Removal', 'Mustache', NULL, NULL, 599.00),
    ('Diode Laser Hair Removal', 'Whole Face', NULL, NULL, 999.00),
    ('Diode Laser Hair Removal', 'Chest', NULL, NULL, 999.00),
    ('Diode Laser Hair Removal', 'Half Arms', NULL, NULL, 799.00),
    ('Diode Laser Hair Removal', 'Full Arms', NULL, NULL, 1299.00),
    ('Diode Laser Hair Removal', 'Half Legs', NULL, NULL, 1599.00),
    ('Diode Laser Hair Removal', 'Full Legs', NULL, NULL, 1999.00),
    ('Diode Laser Hair Removal', 'Bikini', NULL, NULL, 1599.00),
    ('Diode Laser Hair Removal', 'Brazilian', NULL, NULL, 1799.00),
    ('Diode Laser Hair Removal', 'Full Back', NULL, NULL, 1799.00),

    -- Slimming Treatments - RF
    ('Slimming Treatment - RF', 'Face Contour', NULL, NULL, 499.00),
    ('Slimming Treatment - RF', 'Eyebags', NULL, NULL, 299.00),
    ('Slimming Treatment - RF', 'Double Chin', NULL, NULL, 299.00),
    ('Slimming Treatment - RF', 'Arms', NULL, NULL, 599.00),
    ('Slimming Treatment - RF', 'Tummy', NULL, NULL, 799.00),
    ('Slimming Treatment - RF', 'Thigh', NULL, NULL, 799.00),
    ('Slimming Treatment - RF', 'Back', NULL, NULL, 799.00),

    -- Slimming Treatments - Cavitation
    ('Slimming Treatment - Cavitation', 'Arms', NULL, NULL, 799.00),
    ('Slimming Treatment - Cavitation', 'Tummy', NULL, NULL, 799.00),
    ('Slimming Treatment - Cavitation', 'Thigh', NULL, NULL, 899.00),

    -- Slimming Treatments - Emsculpt
    ('Slimming Treatment - Emsculpt', 'Arms / Tummy / Thigh', NULL, NULL, 999.00),

    -- Slimming Treatments - Exilift
    ('Slimming Treatment - Exilift', 'Face', NULL, NULL, 799.00),
    ('Slimming Treatment - Exilift', 'Double Chin', NULL, NULL, 799.00),
    ('Slimming Treatment - Exilift', 'Arms', NULL, NULL, 799.00),
    ('Slimming Treatment - Exilift', 'Thigh', NULL, NULL, 799.00),
    ('Slimming Treatment - Exilift', 'Back', NULL, NULL, 999.00),
    ('Slimming Treatment - Exilift', 'Tummy', NULL, NULL, 999.00),

    -- Other Services
    ('Other Services', 'Tattoo Removal (2")', NULL, NULL, 999.00),
    ('Other Services', 'Whitening Bleach - UA/Groin', NULL, NULL, 399.00),
    ('Other Services', 'Whitening Bleach - Butt', NULL, NULL, 599.00),
    ('Other Services', 'Scar Removal (2x2")', NULL, NULL, 999.00),

    ('Massage', 'Signature Massage', NULL, 60, 500.00),
    ('Massage', 'Foot Massage', NULL, 60, 450.00),
    ('Massage', 'Aromatherapy Oil Massage', NULL, 60, 550.00),
    ('Massage', 'Signature Massage', NULL, 90, 700.00),
    ('Massage', 'Hot Stone', NULL, 90, 950.00),
    ('Massage', 'Aromatherapy Oil Massage', NULL, 90, 775.00),
    ('Massage', 'Signature Massage w/ Foot Massage', NULL, 90, 700.00),
    ('Massage', 'Signature Massage w/ Foot Massage', NULL, 120, 900.00),
    ('Massage', 'Aromatherapy Massage w/ Foot Massage', NULL, 90, 950.00);

    INSERT INTO branch_services (branch_id, service_id)
    SELECT b.branch_id, s.service_id
    FROM branch b
    JOIN service s ON s.service_type IN ('Hair Color', 'Balayage', 'Brazilian Keratin', 'Rebond', 'Color Highlights', 'Organic Ultra Repair', 'Hair and Scalp Detox',
    'Nails - Mani', 'Nails - Pedi', 'Lashes', 'Haircuts', 'Hair Styling', 'Hair Treatment', 'Waxing', 'Other Services')
    WHERE b.branch_id IN (1, 2);

    INSERT INTO branch_services (branch_id, service_id)
    SELECT b.branch_id, s.service_id
    FROM branch b
    JOIN service s ON s.service_type IN ('Facial Treatment', 'Whitening Laser Treatment', 'Diode Laser Hair Removal', 'Slimming Treatment - RF', 'Slimming Treatment - Cavitation', 'Slimming Treatment - Emsculpt', 'Slimming Treatment - Exilift', 'Massage')
    WHERE b.branch_id IN (2);

    INSERT INTO employeeservices (employee_id, service_id)
    SELECT e.employee_id, s.service_id
    FROM employee e
    JOIN service s ON s.service_type IN ('Hair Color', 'Balayage', 'Brazilian Keratin', 'Rebond', 'Color Highlights', 'Organic Ultra Repair', 'Hair and Scalp Detox', 'Haircuts', 'Hair Styling', 'Hair Treatment')
    WHERE e.name IN ('Kime', 'Jm', 'Charl', 'Smile', 'Jay', 'Camille');

    INSERT INTO employeeservices (employee_id, service_id)
    SELECT e.employee_id, s.service_id
    FROM employee e
    JOIN service s ON s.service_type IN ('Nails - Mani', 'Nails - Pedi')
    WHERE e.name IN ('Janet', 'Khristine', 'Ashly', 'Marlene', 'Angel', 'Jessa');

    INSERT INTO employeeservices (employee_id, service_id)
    SELECT e.employee_id, s.service_id
    FROM employee e
    JOIN service s ON s.service_type = 'Lashes'
    WHERE e.name IN ('Ashly', 'Imee');

    INSERT INTO employeeservices (employee_id, service_id)
    SELECT e.employee_id, s.service_id
    FROM employee e
    JOIN service s ON s.service_type = 'Waxing'
    WHERE e.name IN ('Imee', 'Janet', 'Marlene');

    INSERT INTO employeeservices (employee_id, service_id)
    SELECT e.employee_id, s.service_id
    FROM employee e
    JOIN service s ON s.service_type IN ('Other Services', 'Facial Treatment', 'Whitening Laser Treatment', 'Diode Laser Hair Removal', 'Slimming Treatment - RF', 'Slimming Treatment - Cavitation', 'Slimming Treatment - Emsculpt', 'Slimming Treatment - Exilift')
    WHERE e.name IN ('Imee', 'Kris');

    INSERT INTO employeeservices (employee_id, service_id)
    SELECT e.employee_id, s.service_id
    FROM employee e
    JOIN service s ON s.service_type = 'Massage'
    WHERE e.name IN ('Imee', 'Angel');