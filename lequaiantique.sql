-- MySQL dump 10.13  Distrib 5.7.24, for Win64 (x86_64)
--
-- Host: localhost    Database: lequaiantique
-- ------------------------------------------------------
-- Server version	5.7.24

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `title`, `description`, `image_path`, `is_visible`) VALUES
(1, 'Pates aux truffes sur son émulsion de la mer', 'Le premier plat est un véritable voyage gustatif, mélangeant des influences locales et exotiques pour une découverte de nouvelles saveurs.', 'assets/img/repas/plats/plat8.jpg', 1),
(2, 'Papillotes de légumes et son bouillon', 'Le deuxième plat est une ode à la nature, avec des ingrédients locaux réunis de manière inattendue pour une explosion de saveurs en bouche.', 'assets/img/repas/plats/plat1.jpg', 1),
(3, 'Fondue aux trois fromages', 'Enfin, le troisième plat, quant à lui, est une revisite d\'un classique de la gastronomie locale, réinterprété avec une touche d\'originalité pour une expérience culinaire unique.', 'assets/img/repas/plats/plat3.png', 1);

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `users_id` int(11) DEFAULT NULL,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `phone_number` varchar(45) NOT NULL,
  `menu` varchar(255) DEFAULT NULL,
  `nb_guests` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time DEFAULT NULL,
  `allergies` text,
  `other_info` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `users_id`, `name`, `email`, `phone_number`, `menu`, `nb_guests`, `date`, `time`, `allergies`, `other_info`) VALUES
(6424561, 1, 'admin', 'admin@lequaiantique.fr', '0606060606', '0', 5, '2023-08-08', '19:45:00', 'lactose', 'Il y aura 2 enfants.'),
(64625267, 9, 'John Doe', 'john@doe.fr', '0615896574', '0', 2, '2023-06-03', '21:00:00', 'lactose', 'Il n\'y aura pas d\'enfant.');

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `max_guests` int(11) DEFAULT '100',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `id` int(11) NOT NULL,
  `max_guests` int(11) DEFAULT '100'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`id`, `max_guests`) VALUES
(1, 100);

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `day` enum('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche') NOT NULL,
  `time` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `day`, `time`) VALUES
(1, 'Lundi', '12h - 15h / 19h - 23h'),
(2, 'Mardi', '12h - 15h / 19h - 23h'),
(3, 'Mercredi', '12h - 15h / 19h - 23h'),
(4, 'Jeudi', '12h - 15h / 19h - 23h'),
(5, 'Vendredi', '12h - 15h / 19h - 23h'),
(6, 'Samedi', '12h - 15h / 19h - 23h'),
(7, 'Dimanche', 'Fermé');

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `allergies` text,
  `nb_guests` int(11) NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `phone_number`, `allergies`, `nb_guests`, `is_admin`) VALUES
(1, 'admin@lequaiantique.fr', '$2y$10$NA1qUhFDUBCPcbjaF/fwgOT/CwQZ98PxN4fuoY348iCGDZcihDCBW', 'admin', NULL, 'lactose', 0, 1),
(9, 'john@doe.fr', '$2y$10$gPejePJZevxJgSpAI5XS6uCmAr6llhWnGdHMfRd/jH88TRoQ./U8a', 'John Doe', '0615896574', 'lactose', 2, 0),
(16, 'michel@dupont.fr', '$2y$10$R5fedFnV45ZIqWMP8POSnu14AVRdNSKAehQE/lukVMCYEg/SsKuoG', 'Michel Dupont', '0611223344', 'aucune', 5, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reservations_users_idx` (`users_id`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64625268;

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- Dump completed on 2023-05-22 13:48:18
