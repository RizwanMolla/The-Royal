-- Database setup for The Royal Hotel Management System
-- Run this script in phpMyAdmin or MySQL command line

-- Create database
CREATE DATABASE IF NOT EXISTS the_royal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE the_royal;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Rooms table
CREATE TABLE IF NOT EXISTS rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_number VARCHAR(50) NOT NULL UNIQUE,
    floor_number INT NOT NULL,
    price_per_night DECIMAL(10, 2) NOT NULL,
    type ENUM('Standard', 'Deluxe', 'Suite') NOT NULL,
    description TEXT NOT NULL,
    image_url VARCHAR(500) NOT NULL,
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_room_number (room_number),
    INDEX idx_type (type),
    INDEX idx_available (is_available)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bookings table
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    room_id INT NOT NULL,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    guests_adults INT NOT NULL DEFAULT 1,
    guests_children INT NOT NULL DEFAULT 0,
    status ENUM('pending', 'paid') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_room_id (room_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert admin user (password: password)
INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@theroyal.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insert regular test user (password: password)
INSERT INTO users (name, email, password, role) VALUES
('John Doe', 'guest@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

-- Insert sample rooms
INSERT INTO rooms (room_number, floor_number, price_per_night, type, description, image_url, is_available) VALUES
('101', 1, 100.00, 'Standard', 'Comfortable standard room with queen bed, private bathroom, flat-screen TV, and complimentary Wi-Fi. Perfect for solo travelers or couples.', 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=800', TRUE),
('102', 1, 110.00, 'Standard', 'Cozy standard room featuring modern amenities, work desk, and city views. Ideal for business travelers.', 'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?w=800', TRUE),
('201', 2, 120.00, 'Standard', 'Spacious standard room with two double beds, perfect for families or friends traveling together.', 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800', TRUE),
('301', 3, 180.00, 'Deluxe', 'Elegant deluxe room with king bed, sitting area, premium bedding, and stunning city views. Includes complimentary breakfast.', 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800', TRUE),
('302', 3, 200.00, 'Deluxe', 'Luxurious deluxe room featuring marble bathroom, walk-in closet, and premium amenities. Perfect for special occasions.', 'https://images.unsplash.com/photo-1591088398332-8a7791972843?w=800', TRUE),
('401', 4, 220.00, 'Deluxe', 'Premium deluxe room with panoramic views, separate living area, and upgraded bathroom with soaking tub.', 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=800', TRUE),
('501', 5, 350.00, 'Suite', 'Magnificent suite with separate bedroom and living room, kitchenette, dining area, and breathtaking views. Ultimate luxury experience.', 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=800', TRUE),
('502', 5, 400.00, 'Suite', 'Presidential suite featuring two bedrooms, full kitchen, private balcony, jacuzzi, and exclusive concierge service.', 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800', TRUE);


-- Display success message
SELECT 'Database setup completed successfully!' as Message;
SELECT 'Admin Login: admin@theroyal.com / password' as Credentials;
SELECT 'Guest Login: guest@example.com / password' as Credentials;
