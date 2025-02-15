--php Version 8.2
--Maria db and phpMyadmin verion
--server localhost 127.0.0.1


SET SQL_MODE = "NO_AUTO_VALUE_NO_ZERO";
START TRANSACTION;
SET time_zone = "=00:00";
--CREATE DATABSE IF EXISTS OR NOT
CREATE DATABASE IF NOT EXISTS store;
CREATE store;

CREATE TABLE admins (
    id  INIT (50) AUTO_INCREMENT PRIMARY KEY,
    name  VARCHAR (100) NOT NULL,
    email VARCHAR (100) NOT NULL,
    password VARCHAR (100) NOT NULL
);

CREATE TABLE cart(
    id INIT (100) AUTO_INCREMENT PRIMARY KEY,
    user_id INIT (100) NOT NULL ,
    pid INIT (100) NOT NULL,
    name VARCHAR (50) NOT NULL,
    price INIT (100) NOT NULL,
    quantity INIT (100) NOT NULL,
    image VARCHAR (100) NOT NULL
);

CREATE TABLE orders (
      `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` date NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
--If you use utf8, some emojis or special characters may not be stored correctly in the database.
--With utf8mb4, these characters can be stored without issues.


CREATE TABLE products(
      `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(10) NOT NULL,
  `image_01` varchar(100) NOT NULL,
  `image_02` varchar(100) NOT NULL,
  `image_03` varchar(100) NOT NULL

)ENGINE=InnDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `wishlist` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

