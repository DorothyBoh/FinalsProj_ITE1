CREATE DATABASE barcode_db;

USE barcode_db;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    series_no VARCHAR(255) NOT NULL UNIQUE,  -- Series number is now user-inputted and unique
    price DECIMAL(10, 2) NOT NULL
);

-- Insert product details but leave out the series_no
INSERT INTO products (product_name, series_no, price) VALUES
('Manila Paper', 'MP001', 4.00),
('Crayola Crayons 24s', 'CC024', 83.00),
('Crayola Crayons 16s', 'CC016', 61.00),
('AMSPEC Highlighter Yellow', 'AHY001', 22.75),
('Faber Castell Pencil #2', 'FCP002', 7.75),
('Ruler 12', 'R12001', 10.50);

--if not
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    series_no VARCHAR(255) UNIQUE, 
    price DECIMAL(10, 2) NOT NULL
);

-- Insert product details but leave out the series_no
INSERT INTO products (product_name, price) VALUES
('Manila Paper', 4.00),
('Crayola Crayons 24s', 83.00),
('Crayola Crayons 16s', 61.00),
('AMSPEC Highlighter Yellow', 22.75),
('Faber Castell Pencil #2', 7.75),
('Ruler 12', 10.50);