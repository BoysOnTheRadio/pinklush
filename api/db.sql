-- SQL script to create the Pinklush System database and its tables
CREATE DATABASE pinklush;

CREATE TABLE branch (
    branch_id INT AUTO_INCREMENT PRIMARY KEY,
    address VARCHAR(255),
);

CREATE TABLE employee (
    employee_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255)
);

CREATE TABLE schedule (
    shift_id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT,
    branch_id INT,
    day VARCHAR(20),
    shift_start TIME,
    shift_end TIME,
    FOREIGN KEY (employee_id) REFERENCES Employee(employee_id),
    FOREIGN KEY (branch_id) REFERENCES Branch(branch_id)
);

CREATE TABLE service (
    service_id INT AUTO_INCREMENT PRIMARY KEY,
    service_type VARCHAR(50),
    shift_id INT,
    service_name VARCHAR(100),
    description VARCHAR(255),
    duration INT, -- in minutes
    price DECIMAL(10,2),
    FOREIGN KEY (shift_id) REFERENCES Schedule(shift_id)
);

CREATE TABLE appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    service_id INT,
    employee_id INT,
    customer_name VARCHAR(100),
    customer_phone VARCHAR(15),
    customer_address VARCHAR(255),
    appointment_date DATETIME,
    status VARCHAR(20) DEFAULT 'Scheduled',
   FOREIGN KEY (service_id) REFERENCES Service(service_id)
   FOREIGN KEY (employee_id) REFERENCES Employee(employee_id)
);

INSERT INTO branch (address) VALUES
('Fuente Osmena, Primeway Plaza'),
('IT Park, The Walk');

	
INSERT INTO employee (name, email, password) VALUES
('Jessa', 'jessa@example.com', 'hashed_pw1'),
('Kris', 'kris@example.com', 'hashed_pw2'),
('Imee', 'imee@example.com', 'hashed_pw3'),
('Smile', 'smile@example.com', 'hashed_pw4'),
('Camille', 'camille@example.com', 'hashed_pw5'),
('Jay', 'jay@example.com', 'hashed_pw6'),
('Carmel', 'carmel@example.com', 'hashed_pw7'),
('Angel', 'angel@example.com', 'hashed_pw8');

INSERT INTO schedule (employee_id, branch_id, day, shift_start, shift_end) VALUES
(1, 2, 'Sunday', '11:00:00', '20:00:00'),
(1, 2, 'Monday', '11:00:00', '20:00:00'), 
(1, 2, 'Tuesday', '11:00:00', '20:00:00'),
(1, 2, 'Wednesday', '11:00:00', '20:00:00'),
(1, 2, 'Friday', '11:00:00', '20:00:00'),
(1, 2, 'Saturday', '11:00:00', '20:00:00'),
(1, 2, 'Sunday', '10:00:00', '19:00:00'),
(1, 2, 'Monday', '10:00:00', '19:00:00'),
(1, 2, 'Wednesday', '10:00:00', '19:00:00'),
(1, 2, 'Thursday', '10:00:00', '19:00:00'),
(1, 2, 'Friday', '10:00:00', '19:00:00'),
(1, 2, 'Saturday', '10:00:00', '19:00:00'),
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
