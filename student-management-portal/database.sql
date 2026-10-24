-- ============================================
-- Student Management Portal - Database Setup
-- Run this in phpMyAdmin on InfinityFree
-- ============================================

CREATE TABLE IF NOT EXISTS `students` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `age` INT(3) NOT NULL,
  `course` VARCHAR(100) NOT NULL,
  `address` TEXT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Optional: Sample data (you can delete this later)
INSERT INTO `students` (`name`, `email`, `age`, `course`, `address`) VALUES
('Ava Richardson', 'ava.richards@email.com', 19, 'Computer Science', '123 Maple Street, Boston, MA'),
('Liam Johnson', 'liam.johnson@email.com', 21, 'Business Administration', '456 Oak Avenue, Cambridge, MA'),
('Noah Martinez', 'noah.martinez@email.com', 20, 'Graphic Design', '789 Pine Road, Somerville, MA'),
('Emma Singh', 'emma.singh@email.com', 22, 'Psychology', '321 Cedar Lane, Brookline, MA'),
('William Thompson', 'will.thompson@email.com', 18, 'Marketing', '654 Birch Boulevard, Newton, MA');
