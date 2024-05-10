CREATE TABLE `Users` (
  `login` varchar(255) NOT NULL PRIMARY KEY,
  `password` varchar(255) NOT NULL,
  `connected` int(11) NOT NULL DEFAULT 0,
  X int(11) NOT NULL DEFAULT 0,
  Y int(11) NOT NULL DEFAULT 0,
  orientation varchar(255) NOT NULL,
  lastConnection int(11) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `messages` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `heure` varchar(255) NOT NULL,
  `mess` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

