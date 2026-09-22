-- =========================================================
-- Engineer Jules Portfolio - Database Schema + Seed Data
-- Import this file in phpMyAdmin or via:
--   mysql -u root -p < schema.sql
-- =========================================================

CREATE DATABASE IF NOT EXISTS engineer_jules_portfolio
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE engineer_jules_portfolio;

-- ---------------------------------------------------------
-- Users (Admin accounts)
-- ---------------------------------------------------------
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Default admin login:
--   Email:    admin@engineerjules.com
--   Password: Admin@123
--
-- IMPORTANT: Run database/generate_admin_hash.php once in your browser
-- (e.g. http://localhost/engineer-jules/database/generate_admin_hash.php)
-- to generate a fresh, correct bcrypt hash for this PHP install, then
-- replace the hash below (or just run the UPDATE statement it prints)
-- before or after importing this file. A placeholder hash is inserted
-- here so the row exists immediately:
INSERT INTO users (name, email, password, role) VALUES
('Engineer Jules', 'admin@engineerjules.com', '$2y$10$placeholderplaceholderplaceholderplaceholderplaceho', 'admin');

-- ---------------------------------------------------------
-- Projects
-- ---------------------------------------------------------
DROP TABLE IF EXISTS projects;
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    short_description VARCHAR(500),
    description TEXT,
    features TEXT COMMENT 'One feature per line',
    technologies VARCHAR(500) COMMENT 'Comma-separated list',
    github_link VARCHAR(255),
    live_demo VARCHAR(255),
    image VARCHAR(255),
    gallery TEXT COMMENT 'Comma-separated list of image filenames',
    featured BOOLEAN DEFAULT 0,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO projects (title, slug, short_description, description, features, technologies, github_link, live_demo, image, gallery, featured, sort_order) VALUES
(
    'E-Commerce Store',
    'ecommerce-store',
    'Modern online store with products, cart, orders and admin management.',
    'A full-featured e-commerce platform built for small and medium businesses. Customers can browse products by category, add items to a cart, and check out securely. The admin panel allows full control over inventory, pricing, orders and customer data.',
    'Product catalog with categories and search\nShopping cart with live totals\nSecure checkout flow\nOrder tracking for customers\nAdmin dashboard for inventory and order management\nResponsive design for mobile shopping',
    'PHP,MySQL,JavaScript,Tailwind CSS',
    'https://github.com/engineerjules/project1',
    '#',
    'ecommerce.jpg',
    'ecommerce-1.jpg,ecommerce-2.jpg,ecommerce-3.jpg',
    1,
    1
),
(
    'Smart Table Website',
    'smart-table-website',
    'Digital smart table ordering system with QR code menu and ordering features.',
    'A digital ordering system designed for modern restaurants and cafes. Customers scan a QR code at their table to view the live menu and place orders directly from their phone, which are sent instantly to the kitchen and staff dashboard.',
    'QR code table-based menu access\nReal-time order submission to kitchen\nLive menu management for staff\nOrder status tracking\nMulti-table session handling\nMobile-first customer experience',
    'PHP,MySQL,JavaScript',
    'https://github.com/engineerjules/project2',
    '#',
    'smart-table.jpg',
    'smart-table-1.jpg,smart-table-2.jpg,smart-table-3.jpg',
    1,
    2
),
(
    'Restaurant Website',
    'restaurant-website',
    'Modern restaurant website with menu, reservations and ordering features.',
    'A polished, modern website for restaurants that showcases the menu, allows customers to book a table online, and supports simple food ordering — all wrapped in a warm, appetite-driving design.',
    'Interactive digital menu with categories\nOnline table reservation system\nFood ordering with order summary\nGallery of dishes and ambience\nContact and location integration\nFully responsive across devices',
    'PHP,MySQL,JavaScript',
    'https://github.com/engineerjules/project3',
    '#',
    'restaurant.jpg',
    'restaurant-1.jpg,restaurant-2.jpg,restaurant-3.jpg',
    1,
    3
);

-- ---------------------------------------------------------
-- Services
-- ---------------------------------------------------------
DROP TABLE IF EXISTS services;
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    icon VARCHAR(100) DEFAULT 'code',
    sort_order INT DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO services (title, description, icon, sort_order) VALUES
('E-Commerce Development', 'Fully functional online stores with product management, cart, checkout and order tracking.', 'shopping-cart', 1),
('Business Websites', 'Professional, conversion-focused websites that represent your brand and grow your business online.', 'briefcase', 2),
('Restaurant Websites', 'Menu showcases, reservation systems and ordering platforms tailored for restaurants and cafes.', 'utensils', 3),
('Custom Web Applications', 'Tailor-made web applications built around your specific business logic and workflows.', 'layout-grid', 4),
('Database Design', 'Efficient, normalized database architecture for performance, scalability and data integrity.', 'database', 5),
('API Integration', 'Seamless integration with third-party services and REST APIs to extend your application''s capability.', 'plug', 6);

-- ---------------------------------------------------------
-- Contact Messages
-- ---------------------------------------------------------
DROP TABLE IF EXISTS messages;
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    project_type VARCHAR(100),
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Site Settings (single-row config table)
-- ---------------------------------------------------------
DROP TABLE IF EXISTS settings;
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    site_name VARCHAR(255) DEFAULT 'Engineer Jules',
    tagline VARCHAR(255) DEFAULT 'Full-Stack Developer & Software Engineer',
    hero_title VARCHAR(255) DEFAULT 'I Build Digital Products That Solve Real Problems',
    hero_subtitle TEXT,
    email VARCHAR(255) DEFAULT 'engineerjules250@gmail.com',
    whatsapp VARCHAR(50) DEFAULT '250785689108',
    github VARCHAR(255) DEFAULT 'https://github.com/engineerjules',
    whatsapp_message VARCHAR(500) DEFAULT 'Hello Engineer Jules, I would like to discuss a project.',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO settings (site_name, tagline, hero_title, hero_subtitle, email, whatsapp, github, whatsapp_message) VALUES
(
    'Engineer Jules',
    'Full-Stack Developer & Software Engineer',
    'I Build Digital Products That Solve Real Problems',
    'Full-Stack Developer specializing in modern web applications, e-commerce systems and business websites.',
    'engineerjules250@gmail.com',
    '250785689108',
    'https://github.com/engineerjules',
    'Hello Engineer Jules, I would like to discuss a project.'
);
