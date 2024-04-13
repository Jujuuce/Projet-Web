CREATE TABLE `Users` (
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `connected` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `Users` (`login`, `password`, `connected`) VALUES
('user1', '123456789', 0),
('user2', '123456789', 0),
('user3', '123456789', 0),
('user4', '123456789', 0);

ALTER TABLE `Users`
  ADD PRIMARY KEY (`login`);
COMMIT;
