CREATE TABLE IF NOT EXISTS `cart_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `quantity` double NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(512) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `image`  varchar(512) NOT NULL, 
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='products that can be added to cart' AUTO_INCREMENT=41 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `created`, `modified`,`image`) VALUES
(1, 'Hot Taro Ball#1', 'mung beans, barley, boba, taro balls, red bean soup', '6.00', '2016-10-28 20:49:40', '2016-10-28 12:49:40','1.jpg'),
(2, 'Qingtuan', 'sweet green rice ball', '10.50', '2016-10-28 20:52:43', '2016-10-28 12:52:43','2.jpg'),
(3, 'Milk tea', 'top is cream,can add pudding, grass jelly', '5.50', '2016-10-28 20:56:23', '2016-10-28 12:56:23','3.jpg'),
(4, 'Bao', 'Pork and mixed vetgetable inside', '10.55', '2016-10-28 20:58:02', '2016-10-28 12:58:02','4.jpg'),
(5, 'Matcha crepe(8inch)', 'cream and little pieces of mango inside', '70.50', '2016-10-28 20:59:20', '2016-10-28 12:59:20','5.jpg'),
(6, 'Spicy Oxtail soup', 'Korean style', '60.00', '2016-10-28 21:03:19', '2016-10-28 13:03:19','6.jpg'),
(7, 'Sushi', 'mixed vegetable and pork slices', '20.50', '2016-10-28 21:05:30', '2016-10-28 13:05:30','7.jpg'),
(8, 'Chocolate ice-cream', 'soft', '9.00', '2016-10-28 21:06:34', '2016-10-28 13:06:34','8.jpg'),
(9, 'Pizza', 'thin base', '32.24', '2016-10-28 21:08:05', '2016-10-28 13:08:05','9.jpg'),
(10, 'Macaron', 'different tastes', '30.00', '2016-10-28 21:08:52', '2016-10-28 13:08:52','10.jpg'),
(11, 'Bread and Garlic on top', 'soft and fresh feel', '16.00', '2016-10-28 21:09:44', '2016-10-28 13:09:44','11.jpg'),
(12, 'Mixed Fruit drink', 'Organic and healthy', '15.00', '2016-10-28 21:46:06', '2016-10-28 13:46:06','12.jpg'),
(13, 'Latte Coffee', 'customized design', '10.00', '2016-11-02 20:15:38', '2016-11-02 12:15:38','13.jpg'),
(14, 'Thai tea', 'sweet', '4.00','2016-11-02 20:15:38', '2016-11-02 12:15:38','14.jpg'),
(15, 'Chocolate cake', 'sweet', '32.24', '2016-10-28 21:08:05', '2016-10-28 13:08:05','15.jpg'),
(16, 'Apple pie 4pieces', 'juicy', '32.24', '2016-10-28 21:08:05', '2016-10-28 13:08:05','16.jpg'),
(17, 'Soft Bread', 'sweet', '32.24', '2016-10-28 21:08:05', '2016-10-28 13:08:05','17.jpg'),
(18, 'Cheese cake(8inch)', 'sweet', '32.24', '2016-10-28 21:08:05', '2016-10-28 13:08:05','18.jpg'),
(19, 'Oreos cake(8inch)', 'sweet', '32.24', '2016-10-28 21:08:05', '2016-10-28 13:08:05','19.jpg'),
(20, 'Coffee cake(8inch)', 'sweet', '32.24', '2016-10-28 21:08:05', '2016-10-28 13:08:05','20.jpg'),
(21, 'Mango cake(8inch)', 'sweet', '32.24', '2016-10-28 21:08:05', '2016-10-28 13:08:05','21.jpg'),
(22, 'Fruit tart', 'sweet', '10.00', '2016-10-28 21:08:05', '2016-10-28 13:08:05','22.jpg'),
(23, 'Chocolate chip cookies', 'sweet', '6.00', '2016-10-28 21:08:05', '2016-10-28 13:08:05','23.jpg'),
(24, 'Egg tart', 'sweet', '10.00', '2016-10-28 21:08:05', '2016-10-28 13:08:05','24.jpg'),
(25, 'Caremel pudding', 'sweet', '6.00', '2016-10-28 21:08:05', '2016-10-28 13:08:05','25.jpg'),
(26, 'Colorful dumping', 'mixed vegetable', '30.00', '2016-10-28 21:08:05', '2016-10-28 13:08:05','26.jpg');


CREATE TABLE IF NOT EXISTS `users` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    type ENUM('admin', 'client') NOT NULL
);
INSERT INTO users (username, password, type) VALUES ('med', 'med', 'admin');
INSERT INTO users (username, password, type) VALUES ('anoun', 'anoun', 'client');
INSERT INTO users (username, password, type) VALUES ('mohamed', 'mohamed', 'client');