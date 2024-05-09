CREATE TABLE `Users` (
  `login` varchar(255) NOT NULL PRIMARY KEY,
  `password` varchar(255) NOT NULL,
  `connected` int(11) NOT NULL DEFAULT 0,
  X int(11) NOT NULL DEFAULT 0,
  Y int(11) NOT NULL DEFAULT 0,
  orientation varchar(255) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

