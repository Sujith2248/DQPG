-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS qpg_appdb;

-- Use the created database
USE qpg_appdb;

-- Create institutions table
CREATE TABLE IF NOT EXISTS institutions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    public_id CHAR(36) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    contact_number VARCHAR(15),
    status BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    public_id CHAR(36),
    institution_id INT,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255),
    email VARCHAR(255) NOT NULL UNIQUE,
    phone_number VARCHAR(15),
    password VARCHAR(255) NOT NULL,
    role ENUM('master_admin', 'faculty', 'student') NOT NULL,
    address VARCHAR(255),
    gender ENUM('male', 'female'),
    status BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (institution_id) REFERENCES institutions(id) ON DELETE SET NULL
);

-- Create departments table
CREATE TABLE IF NOT EXISTS departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    public_id CHAR(36) NOT NULL UNIQUE,
    institution_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    department_code VARCHAR(255),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (institution_id) REFERENCES institutions(id) ON DELETE CASCADE
);

-- Create subjects table
CREATE TABLE IF NOT EXISTS subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    public_id CHAR(36) NOT NULL UNIQUE,
    institution_id INT NOT NULL,
    department_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    subject_code VARCHAR(255),
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (institution_id) REFERENCES institutions(id) ON DELETE CASCADE,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
);

-- Create questions table
CREATE TABLE IF NOT EXISTS questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    public_id CHAR(36) NOT NULL UNIQUE,
    subject_id INT NOT NULL,
    question_text TEXT NOT NULL,
    marks INT NOT NULL,
    difficulty_level ENUM('hard', 'medium', 'easy') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);


-- Insert sample data into institutions
INSERT INTO institutions (public_id, name, address, contact_number) VALUES
(UUID(), 'Global Institution', '123 Main St, City, Country', '1234567890'),
(UUID(), 'Tech Academy', '456 Tech Ave, City, Country', '9876543210'),
(UUID(), 'Science College', '789 Science Rd, City, Country', '5555555555');


-- Insert sample data into departments
INSERT INTO departments (public_id, institution_id, name, department_code, description) VALUES
(UUID(), 2, 'Computer Science', 'CS101', 'Department of Computer Science'),
(UUID(), 2, 'Mathematics', 'MATH102', 'Department of Mathematics'),
(UUID(), 3, 'Physics', 'PHYS103', 'Department of Physics');

