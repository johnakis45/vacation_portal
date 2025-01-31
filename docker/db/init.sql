CREATE DATABASE IF NOT EXISTS vacation_portal_database;
USE vacation_portal_database;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    user_code VARCHAR(7) NOT NULL CHECK (user_code REGEXP '^[0-9]{7}$'),
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL CHECK (
        email REGEXP '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$'),
    role ENUM('manager','user') DEFAULT 'user',
    UNIQUE KEY (username),
    UNIQUE KEY (user_code),
    UNIQUE KEY (email)
);


CREATE TABLE IF NOT EXISTS vacations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    description VARCHAR(255),
    submit_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO users (username, user_code, password, email, role) VALUES
('admin', '0000000', 'admin', 'email@sax.com' , 'manager'),
('user', '7654321', '1234', 'saer@mimos.com', 'user');

INSERT INTO vacations (user_id, description, start_date, end_date) VALUES
(2, 'Vacation 1', '2021-01-01', '2021-01-10'),
(2, 'Vacation 2', '2021-02-01', '2021-02-10'),
(2, 'Vacation 3', '2021-03-01', '2021-03-10');