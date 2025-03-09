CREATE TABLE `product` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(128) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `size` INT(11) NOT NULL,
    UNIQUE KEY `unique_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `product` (`name`, `description`, `size`) VALUES
    ('Product One', NULL, 10),
    ('Product Two', 'example', 20);