CREATE DATABASE IF NOT EXISTS mindful_haven;
USE mindful_haven;

CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(100),
    image VARCHAR(255),
    description TEXT,
    in_stock BOOLEAN DEFAULT TRUE
);

CREATE TABLE cart (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    session_id VARCHAR(255) NOT NULL
);

CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_number VARCHAR(50) UNIQUE,
    customer_name VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    customer_address TEXT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    notes TEXT,
    status VARCHAR(50) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(255),
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL
);

CREATE TABLE contacts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, price, category, image, description) VALUES
('Daily Reflection Journal', 120, 'journals', 'journal-daily.jpg', 'A daily journal to organize your thoughts and express your feelings.'),
('Gratitude Journal', 100, 'journals', 'journal-gratitude.jpg', 'Record your daily gratitude and focus on positive aspects of life.'),
('Self-Love Notebook', 110, 'journals', 'journal-selflove.jpg', 'A notebook dedicated to enhancing self-love and self-appreciation.'),
('Motivation Cards Set', 80, 'cards', 'cards-motivation.jpg', 'A set of motivational cards to start your day with positive energy.'),
('Positive Affirmations', 75, 'cards', 'cards-affirmations.jpg', 'Positive affirmation cards to boost your self-confidence.'),
('Scented Candle', 90, 'relaxation', 'candle.jpg', 'Lavender scented candle for relaxation and stress relief.'),
('Stress Relief Kit', 150, 'relaxation', 'stress-relief-kit.jpg', 'Complete kit including scented candle and natural stress relievers.'),
('Heal Your Mind', 130, 'books', 'book-heal.jpg', 'A book guiding you through the journey of mental healing.'),
('Calm Yourself', 120, 'books', 'book-calm.jpg', 'Practical techniques for calmness and peace in daily life.');