-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 23, 2024 at 08:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `serverside`
--

-- --------------------------------------------------------

--
-- Table structure for table `armors`
--

CREATE TABLE `armors` (
  `armor_id` int(11) NOT NULL,
  `armor_type_id` int(11) NOT NULL,
  `armor_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `armors`
--

INSERT INTO `armors` (`armor_id`, `armor_type_id`, `armor_name`) VALUES
(1, 1, 'Band\'s Polarized Sunglasses'),
(2, 2, 'Band\'s Touring Bracelet'),
(3, 3, 'Band\'s Leather Jacket with Studs'),
(4, 4, 'Band\'s Ankle Boots With Rivets'),
(5, 1, 'Champion\'s Headgear'),
(6, 2, 'Champion\'s Heavy Gloves'),
(7, 3, 'Champion\'s Chest Guard'),
(8, 4, 'Champion\'s Fleetfoot Boots'),
(9, 1, 'Eagle\'s Beaked Helmet'),
(10, 2, 'Eagle\'s Soaring Ring'),
(11, 3, 'Eagle\'s Winged Suit'),
(12, 4, 'Eagle\'s Quilted Puttees'),
(13, 1, 'Firesmith\'s Obsidian Goggles'),
(14, 2, 'Firesmith\'s Ring of Fire'),
(15, 3, 'Firesmith\'s Apron'),
(16, 4, 'Firesmith\'s Alloy Leggings'),
(17, 5, 'Ardent Censer'),
(18, 5, 'Seraph\'s Embrace'),
(19, 5, 'Shard of True Ice'),
(20, 5, 'Anathema\'s Chains'),
(21, 3, 'Dead Man\'s Plate'),
(23, 1, 'Abyssal Mask'),
(24, 2, 'The Collector'),
(25, 5, 'Lightning Braid'),
(26, 1, 'Hunter\'s Frozen Hood'),
(27, 2, 'Hunter\'s Frozen Gloves'),
(28, 3, 'Hunter\'s Ice Dragon Cloak'),
(29, 4, 'Hunter\'s Icewalking Boots'),
(30, 5, 'Zhonya\'s Hourglass');

-- --------------------------------------------------------

--
-- Table structure for table `armortypes`
--

CREATE TABLE `armortypes` (
  `armor_type_id` int(11) NOT NULL,
  `armor_type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `armortypes`
--

INSERT INTO `armortypes` (`armor_type_id`, `armor_type_name`) VALUES
(1, 'Head'),
(2, 'Hands'),
(3, 'Body'),
(4, 'Shoes'),
(5, 'Accessories');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `date_posted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `title`, `content`, `date_posted`) VALUES
(1, 'Lorem', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2024-02-14 02:40:50'),
(2, 'First Post!', 'Hello World!\r\n\r\nEdit: This edit worked!', '2024-02-14 02:23:55'),
(4, 'WOOHOO!', 'Just completed the functionality of the website, time to add in the CSS!!', '2024-02-14 02:40:56'),
(5, 'The Bee Movie Script', 'According to all known laws of aviation, there is no way a bee should be able to fly. Its wings are too small to get its fat little body off the ground. The bee, of course, flies anyway because bees don&#039;t care what humans think is impossible. Yellow, black. Yellow, black. Yellow, black. Yellow, black. Ooh, black and yellow! Let&#039;s shake it up a little. Barry! Breakfast is ready! Ooming! Hang on a second. Hello? - Barry? - Adam? - Oan you believe this is happening? - I can&#039;t. I&#039;ll pick you up. Looking sharp. Use the stairs. Your father paid good money for those. Sorry. I&#039;m excited. Here&#039;s the graduate. We&#039;re very proud of you, son. A perfect report card, all B&#039;s. Very proud.', '2024-02-14 02:44:07'),
(6, 'Post #5', 'Huh!', '2024-02-14 02:44:40'),
(7, 'a', 'tests', '2024-04-12 02:45:20');

-- --------------------------------------------------------

--
-- Table structure for table `characterarmors`
--

CREATE TABLE `characterarmors` (
  `character_armor_id` int(11) NOT NULL,
  `character_id` int(11) NOT NULL,
  `armor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `characterarmors`
--

INSERT INTO `characterarmors` (`character_armor_id`, `character_id`, `armor_id`) VALUES
(1, 10, 1),
(66, 10, 9),
(2, 10, 10),
(67, 10, 11),
(68, 10, 12),
(3, 10, 15),
(69, 23, 1),
(70, 23, 2),
(71, 23, 3),
(72, 23, 4),
(73, 24, 26),
(74, 24, 27),
(75, 24, 28),
(76, 24, 29),
(80, 25, 8),
(79, 25, 21),
(77, 25, 23),
(78, 25, 24),
(82, 26, 6),
(81, 26, 13),
(83, 26, 21),
(84, 26, 29);

-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE `characters` (
  `character_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `character_name` varchar(20) NOT NULL,
  `level` int(11) NOT NULL DEFAULT 1,
  `date_created` varchar(10) DEFAULT date_format(current_timestamp(),'%d/%m/%Y'),
  `class_id` int(11) DEFAULT NULL,
  `weapon_id` int(11) DEFAULT NULL,
  `element_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `characters`
--

INSERT INTO `characters` (`character_id`, `user_id`, `character_name`, `level`, `date_created`, `class_id`, `weapon_id`, `element_id`, `image_path`) VALUES
(10, 6, 'Dan Heng', 72, '14/04/2024', 1, 13, 4, 'uploads/dan.png'),
(23, 7, 'Kafka', 100, '22/04/2024', 7, 29, 3, 'uploads\\kafka.png'),
(24, 5, 'March', 7, '22/04/2024', 4, 17, 2, 'uploads\\march.png'),
(25, 4, 'Stelle', 100, '22/04/2024', 1, 33, 7, 'uploads/stelle.png'),
(26, 8, 'Welt', 76, '22/04/2024', 6, 11, 7, 'uploads\\welt.png');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`, `description`) VALUES
(1, 'Warrior', 'Masters of brute strength and weapon proficiency, warriors charge into battle, relying on sheer might to overwhelm foes.'),
(2, 'Knight', 'Clad in formidable armor, knights are noble protectors skilled in both offense and defense, bound by chivalric code.'),
(3, 'Healer', 'With mending hands and potent remedies, healers support allies by restoring health and curing ailments in the heat of battle.'),
(4, 'Paladin', 'Devoted champions of righteousness, paladins wield divine powers to smite evil and shield their comrades with unwavering resolve.'),
(5, 'Mage', 'Harnessing the arcane, mages command powerful spells to manipulate elements and shape reality to their will.'),
(6, 'Rogue', 'Agile and cunning, rogues excel in stealth and deception, striking swiftly from the shadows to exploit weaknesses.'),
(7, 'Ranger', 'Masters of the wilderness, rangers are adept trackers and skilled marksmen, using their bond with nature to survive and hunt their prey.');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `date_posted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `user_id`, `content`, `date_posted`) VALUES
(10, 5, 5, 'That&#039;s pretty cool!', '2024-04-22 17:59:33'),
(12, 18, 4, 'Pretty smart. Would consider a different weapon to synergize better with the armor set.', '2024-04-22 21:19:25'),
(13, 19, 6, 'Wow!', '2024-04-22 21:28:41'),
(14, 20, 8, 'Who is kermit?', '2024-04-22 21:34:16'),
(15, 18, 8, 'I&#039;d stand to disagree. That weapon gives enough speed to dodge most enemies attacks.', '2024-04-22 21:34:55');

-- --------------------------------------------------------

--
-- Table structure for table `elements`
--

CREATE TABLE `elements` (
  `element_id` int(11) NOT NULL,
  `element_name` varchar(50) NOT NULL,
  `description` varchar(300) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `elements`
--

INSERT INTO `elements` (`element_id`, `element_name`, `description`, `image_path`) VALUES
(1, 'Fire', 'Using Fire attacks to trigger Weakness Break will deal Fire DMG and apply the Burn effect, dealing Fire DoT.', 'images/fire.png'),
(2, 'Ice', 'Using Ice attacks to trigger Weakness Break will deal Ice DMG and Freeze the target, immobilizing the enemy and dealing additional Ice DMG.', 'images/Ice.png'),
(3, 'Lightning', 'Using Lightning attacks to trigger Weakness Break will deal Lightning DMG and apply the Shock effect, dealing Lightning DoT.', 'images/Lightning.png'),
(4, 'Wind', 'Using Wind attacks to trigger Weakness Break will deal Wind DMG and apply the Wind Shear effect, dealing Wind DoT.', 'images/Wind.png'),
(5, 'Void', 'Using Void attacks to trigger Weakness Break will deal Void DMG and apply the Entanglement effect, delaying the enemy\'s action and dealing Additional Void DMG to the affected enemy at the start of the next turn. When the enemy is hit, this extra DMG will increase.', 'images/Void.png'),
(6, 'Water', 'Using Water attacks to trigger Weakness Break will deal Water DMG and apply the Soak effect, making the enemy more prone to other damage types.', 'images/Water.png'),
(7, 'Light', 'Using Light attacks to trigger Weakness Break will deal Light DMG and apply the Imprisonment effect, delaying the enemy\'s action and reducing its SPD.', 'images/Light.png');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `character_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `date_posted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `character_id`, `user_id`, `title`, `content`, `date_posted`) VALUES
(5, 10, 6, '', 'This sanctuary is but a vision!', '2024-04-14 18:43:51'),
(18, 23, 7, '', 'Standard Setup. Nothing too grand. The Band&#039;s set gives her enough Lightning DMG to overpower the enemy.', '2024-04-22 20:00:50'),
(19, 24, 5, '', 'Check out this awesome move!', '2024-04-22 21:06:23'),
(20, 25, 4, '', 'Rules are made to be broken! Kermit the frog told me that.', '2024-04-22 21:12:56'),
(21, 26, 8, '', 'Survive or be destroyed. There is no other options.', '2024-04-22 21:32:48');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `skill_id` int(11) NOT NULL,
  `skill_name` varchar(50) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`skill_id`, `skill_name`, `class_id`) VALUES
(1, 'Decisive Strike', 1),
(2, 'Judgment', 1),
(3, 'Ice Shard', 5),
(4, 'Ring of Frost', 5),
(5, 'Glacial Path', 5),
(6, 'Frozen Tomb', 5),
(7, 'Ace in the Hole', 7),
(8, 'Enchanted Crystal Arrow', 7),
(9, 'Infernal Chains', 1),
(10, 'Umbral Dash', 6),
(11, 'Void Surge', 7),
(12, 'Pillar of Flame', 5),
(13, 'Conflagration', 5),
(14, 'Stand Behind Me', 4),
(15, 'Unbreakable', 4),
(16, 'Decimate', 1),
(17, 'Shield of Durand', 4),
(18, 'Justice Punch', 4),
(19, 'Life Touch', 3),
(20, 'Astral Infusion', 3),
(21, 'Wish', 3),
(22, 'Savagery', 6),
(23, 'Thrill of the Hunt', 6),
(24, 'Blade\'s End', 6),
(25, 'Shadow Assault', 6),
(26, 'Pyre Ball', 5),
(27, 'Breath of Life', 3),
(28, 'Starlight', 3),
(29, 'Ardent Blaze', 7),
(30, 'Relentless Pursuit', 7),
(31, 'Whirling Death', 7),
(32, 'Mystic Shot', 7),
(33, 'Steadfast Presence', 4),
(34, 'Titan\'s Wrath', 4),
(35, 'Unstoppable Force', 4),
(37, 'Courage', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `hashed_password` varchar(255) NOT NULL,
  `role` enum('Administrator','User','Non-User') NOT NULL DEFAULT 'User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `hashed_password`, `role`) VALUES
(4, 'AdministratorStelle', 'fake@email.com', '', '$2y$10$f2aIsVTXc0f9LJD5xGIafeMpUkKibqWdZeyM6Nk9LLz8cVYzadVla', 'Administrator'),
(5, 'BigMarchFan', 'fake2@email.com', '', '$2y$10$r9Y.08GWf//TxjQyHeO7i..aVS/aonEFRGfbt6ooMi3qeOsLCRVjK', 'User'),
(6, 'FollowTheWind16', 'fake@email.com', '', '$2y$10$z0SEomFczQ4G73s8yh2tmeI1/K3Jwt9w59C9RMAt/vffAxz.3adIy', 'User'),
(7, 'LightningLord', 'fake@email.com', '', '$2y$10$lzvmsatLnk70pdqCsXTyeuultM0BeWGZUKBNTphOXQDa1xMwaP3eC', 'User'),
(8, 'liloldman4', 'fake2@email.com', '', '$2y$10$81jy2BsESwW9T/oZwSoBCuqIz1dQIkHT1c3aP96e2gURZ4eIxp9hy', 'User'),
(9, 'standarduser5', 'fake2@email.com', '', '$2y$10$Nx2AEn5FYyvbce.IDnVKUeFhmMaHUUQoU9ZM/iVg5OFt1DRRC21Qq', 'User'),
(10, 'biggestfan', 'fake3@email.com', '', '$2y$10$br8CyuQEroRzW2jAW.Gj4OSrSe5Upqw0c48Yu2IJriBgOORW4AOFC', 'User');

-- --------------------------------------------------------

--
-- Table structure for table `weapons`
--

CREATE TABLE `weapons` (
  `weapon_id` int(11) NOT NULL,
  `weapon_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `weapons`
--

INSERT INTO `weapons` (`weapon_id`, `weapon_name`) VALUES
(1, 'Skyward Blade'),
(2, 'Skyrider Sword'),
(3, 'Dull Blade'),
(4, 'Silver Sword'),
(5, 'Primordial Jade Cutter'),
(6, 'Serpent Spine'),
(7, 'Rainslasher'),
(8, 'Royal Greatsword'),
(9, 'Redhorn Stonethresher'),
(10, 'Wolf\'s Gravestone'),
(11, 'Staff of Homa'),
(12, 'Halberd'),
(13, 'Crescent Pike'),
(14, 'Gradivus'),
(15, 'Staff of the Scarlet Sands'),
(16, 'Recurve Bow'),
(17, 'Royal Bow'),
(18, 'Blackcliff Warbox'),
(19, 'Thundering Pulse'),
(20, 'Amos\' Bow'),
(21, 'Pocket Grimoire'),
(22, 'Memory of Dust'),
(23, 'Tome of the Eternal Flow'),
(24, 'A Thousand Floating Dreams'),
(25, 'Everlasting Moonglow'),
(26, 'Serrated Shiver'),
(27, 'Duskblade of Draktharr'),
(28, 'Atma\'s Impaler'),
(29, 'Galeforce'),
(30, 'Morellonomicon'),
(33, 'Baseball Bat');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `armors`
--
ALTER TABLE `armors`
  ADD PRIMARY KEY (`armor_id`),
  ADD KEY `armor_type_id` (`armor_type_id`);

--
-- Indexes for table `armortypes`
--
ALTER TABLE `armortypes`
  ADD PRIMARY KEY (`armor_type_id`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `characterarmors`
--
ALTER TABLE `characterarmors`
  ADD PRIMARY KEY (`character_armor_id`),
  ADD UNIQUE KEY `unique_character_armor` (`character_id`,`armor_id`),
  ADD KEY `armor_id` (`armor_id`);

--
-- Indexes for table `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`character_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `characters_ibfk_2` (`class_id`),
  ADD KEY `characters_ibfk_3` (`weapon_id`),
  ADD KEY `characters_ibfk_4` (`element_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `elements`
--
ALTER TABLE `elements`
  ADD PRIMARY KEY (`element_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `character_id` (`character_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`skill_id`),
  ADD KEY `skills_ibfk_1` (`class_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `weapons`
--
ALTER TABLE `weapons`
  ADD PRIMARY KEY (`weapon_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `armors`
--
ALTER TABLE `armors`
  MODIFY `armor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `armortypes`
--
ALTER TABLE `armortypes`
  MODIFY `armor_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `characterarmors`
--
ALTER TABLE `characterarmors`
  MODIFY `character_armor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `characters`
--
ALTER TABLE `characters`
  MODIFY `character_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `elements`
--
ALTER TABLE `elements`
  MODIFY `element_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `skill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `weapons`
--
ALTER TABLE `weapons`
  MODIFY `weapon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `armors`
--
ALTER TABLE `armors`
  ADD CONSTRAINT `fk_armor_type_id` FOREIGN KEY (`armor_type_id`) REFERENCES `armortypes` (`armor_type_id`) ON DELETE NO ACTION;

--
-- Constraints for table `characterarmors`
--
ALTER TABLE `characterarmors`
  ADD CONSTRAINT `characterarmors_ibfk_1` FOREIGN KEY (`character_id`) REFERENCES `characters` (`character_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `characterarmors_ibfk_2` FOREIGN KEY (`armor_id`) REFERENCES `armors` (`armor_id`) ON DELETE CASCADE;

--
-- Constraints for table `characters`
--
ALTER TABLE `characters`
  ADD CONSTRAINT `characters_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `characters_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `characters_ibfk_3` FOREIGN KEY (`weapon_id`) REFERENCES `weapons` (`weapon_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `characters_ibfk_4` FOREIGN KEY (`element_id`) REFERENCES `elements` (`element_id`) ON DELETE SET NULL;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`character_id`) REFERENCES `characters` (`character_id`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `skills_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
