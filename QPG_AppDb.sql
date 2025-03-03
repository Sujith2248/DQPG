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
    public_id CHAR(36) NOT NULL UNIQUE,
    institution_id INT,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255),
    email VARCHAR(255) NOT NULL UNIQUE,
    phone_number VARCHAR(15),
    password VARCHAR(255) NOT NULL,
    role ENUM('master_admin', 'institution_admin', 'faculty', 'student') NOT NULL,
    address VARCHAR(255),
    gender ENUM('male', 'female')
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

-- Permissions Table: Lists all permissions
CREATE TABLE IF NOT EXISTS permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    action VARCHAR(255) NOT NULL,
    resource VARCHAR(255) NOT NULL,
    UNIQUE (action, resource) -- Ensures no duplicate action-resource pair
);

-- User Permissions Table: Maps users directly to permissions
CREATE TABLE IF NOT EXISTS user_permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    permission_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
    UNIQUE (user_id, permission_id) -- Prevents duplicate mappings
);



-- Insert sample data into institutions
INSERT INTO institutions (public_id, name, address, contact_number) VALUES
(UUID(), 'Global Institution', '123 Main St, City, Country', '1234567890'),
(UUID(), 'Tech Academy', '456 Tech Ave, City, Country', '9876543210'),
(UUID(), 'Science College', '789 Science Rd, City, Country', '5555555555');

-- Insert sample data into users
INSERT INTO users (public_id, institution_id, first_name, last_name, email, phone_number, password, role, address) VALUES
(UUID(), NULL, 'John', 'Doe', 'masteradmin@example.com', '1231231231', 'password123', 'master_admin', 'Admin Street, City'),
(UUID(), 1, 'Jane', 'Smith', 'jane.smith@example.com', '9879879879', 'password123', 'institution_admin', 'Tech Ave, City'),
(UUID(), 2, 'Mark', 'Taylor', 'mark.taylor@example.com', '5555555555', 'password123', 'faculty', 'Tech Lane, City'),
(UUID(), 3, 'Lucy', 'Brown', 'lucy.brown@example.com', '4444444444', 'password123', 'student', 'Student Dorm, City');

-- Insert sample data into departments
INSERT INTO departments (public_id, institution_id, name, department_code, description) VALUES
(UUID(), 2, 'Computer Science', 'CS101', 'Department of Computer Science'),
(UUID(), 2, 'Mathematics', 'MATH102', 'Department of Mathematics'),
(UUID(), 3, 'Physics', 'PHYS103', 'Department of Physics');

-- Insert sample data into subjects
INSERT INTO subjects (public_id, institution_id, department_id, name, subject_code, created_by) VALUES
(UUID(), 2, 1, 'Data Structures', 'CS201', 3),
(UUID(), 2, 2, 'Linear Algebra', 'MATH202', 3),
(UUID(), 3, 3, 'Quantum Mechanics', 'PHYS203', 2);

-- Insert sample data into questions
INSERT INTO questions (public_id, subject_id, question_text, marks, difficulty_level) VALUES
(UUID(), 1, 'What is a binary tree? Explain with an example.', 10, 'medium'),
(UUID(), 1, 'Describe the concept of stack and its applications.', 8, 'easy'),
(UUID(), 2, 'Solve the following system of linear equations.', 12, 'hard'),
(UUID(), 3, 'What is the Heisenberg uncertainty principle?', 15, 'hard');


INSERT INTO permissions (action, resource) VALUES
('create', 'question'),
('read', 'question'),
('update', 'question'),
('delete', 'question'),
('create', 'user'),
('read', 'user'),
('update', 'user'),
('delete', 'user'),
('create', 'subject'),
('read', 'subject'),
('update', 'subject'),
('delete', 'subject'),
('create', 'department'),
('read', 'department'),
('update', 'department'),
('delete', 'department');

-- Map all permissions to the Master Admin user
INSERT INTO user_permissions (user_id, permission_id)
SELECT 1, id FROM permissions;
