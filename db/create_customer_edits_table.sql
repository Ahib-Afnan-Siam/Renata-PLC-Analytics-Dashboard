CREATE TABLE IF NOT EXISTS customer_edits (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT NOT NULL,
  name VARCHAR(100),
  division VARCHAR(50),
  gender VARCHAR(10),
  age INT,
  marital_status VARCHAR(20),
  income INT,
  submitted_by VARCHAR(50),
  status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);




