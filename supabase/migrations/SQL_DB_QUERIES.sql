-- MySQL Database for Five Star Hotel
-- This script creates the database and tables required for the hotel reservation system

-- Create database
CREATE DATABASE IF NOT EXISTS SankanHotel_Database;
USE SankanHotel_Database;

-- Create Customers table
CREATE TABLE IF NOT EXISTS customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    contact_number VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Room Types table
CREATE TABLE IF NOT EXISTS room_types (
    room_type_id INT AUTO_INCREMENT PRIMARY KEY,
    room_type VARCHAR(20) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Room Capacity table
CREATE TABLE IF NOT EXISTS room_capacities (
    room_capacity_id INT AUTO_INCREMENT PRIMARY KEY,
    capacity_name VARCHAR(20) NOT NULL,
    max_guests INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Rooms table
CREATE TABLE IF NOT EXISTS rooms (
    room_id INT AUTO_INCREMENT PRIMARY KEY,
    room_number VARCHAR(10) NOT NULL,
    room_type_id INT NOT NULL,
    room_capacity_id INT NOT NULL,
    rate_per_day DECIMAL(10,2) NOT NULL,
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (room_type_id) REFERENCES room_types(room_type_id),
    FOREIGN KEY (room_capacity_id) REFERENCES room_capacities(room_capacity_id)
);

-- Create Payment Types table
CREATE TABLE IF NOT EXISTS payment_types (
    payment_type_id INT AUTO_INCREMENT PRIMARY KEY,
    payment_name VARCHAR(20) NOT NULL,
    additional_charge_percentage DECIMAL(5,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Reservations table
CREATE TABLE IF NOT EXISTS reservations (
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    room_id INT NOT NULL,
    date_reserved DATE NOT NULL,
    date_from DATE NOT NULL,
    date_to DATE NOT NULL,
    payment_type_id INT NOT NULL,
    special_requests TEXT,
    num_days INT NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    discount DECIMAL(10,2) DEFAULT 0.00,
    additional_charge DECIMAL(10,2) DEFAULT 0.00,
    total_bill DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id),
    FOREIGN KEY (room_id) REFERENCES rooms(room_id),
    FOREIGN KEY (payment_type_id) REFERENCES payment_types(payment_type_id)
);

-- Create Contact Messages table
CREATE TABLE IF NOT EXISTS contact_messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    date_submitted TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert initial data for Room Types
INSERT INTO room_types (room_type, description) VALUES
('Regular', 'Standard room with essential amenities for a comfortable stay'),
('De Luxe', 'Spacious room with premium amenities and elegant furnishings'),
('Suite', 'Luxurious suite with separate living area and exclusive amenities');

-- Insert initial data for Room Capacities
INSERT INTO room_capacities (capacity_name, max_guests) VALUES
('Single', 1),
('Double', 2),
('Family', 4);

-- Insert initial data for Payment Types
INSERT INTO payment_types (payment_name, additional_charge_percentage) VALUES
('Cash', 0.00),
('Check', 5.00),
('Credit Card', 10.00);

-- Insert sample rooms with rates based on capacity and type
-- Single capacity rooms
INSERT INTO rooms (room_number, room_type_id, room_capacity_id, rate_per_day) VALUES
('101', 1, 1, 100.00), -- Single Regular
('102', 1, 1, 100.00),
('103', 2, 1, 300.00), -- Single De Luxe
('104', 2, 1, 300.00),
('105', 3, 1, 500.00), -- Single Suite
('106', 3, 1, 500.00);

-- Double capacity rooms
INSERT INTO rooms (room_number, room_type_id, room_capacity_id, rate_per_day) VALUES
('201', 1, 2, 200.00), -- Double Regular
('202', 1, 2, 200.00),
('203', 2, 2, 500.00), -- Double De Luxe
('204', 2, 2, 500.00),
('205', 3, 2, 800.00), -- Double Suite
('206', 3, 2, 800.00);

-- Family capacity rooms
INSERT INTO rooms (room_number, room_type_id, room_capacity_id, rate_per_day) VALUES
('301', 1, 3, 500.00), -- Family Regular
('302', 1, 3, 500.00),
('303', 2, 3, 750.00), -- Family De Luxe
('304', 2, 3, 750.00),
('305', 3, 3, 1000.00), -- Family Suite
('306', 3, 3, 1000.00);