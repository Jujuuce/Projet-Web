CREATE TABLE `Users` (
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `Users` (`login`, `password`) VALUES
('user1', '123456789'),
('user2', '123456789'),
('user3', '123456789'),
('user4', '123456789');