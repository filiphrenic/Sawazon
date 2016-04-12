-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 12, 2016 at 09:07 AM
-- Server version: 5.6.28-0ubuntu0.14.04.1
-- PHP Version: 5.6.19-1+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Sawazon`
--

-- --------------------------------------------------------

--
-- Table structure for table `Address`
--

CREATE TABLE `Address` (
  `address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `street` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Address`
--

INSERT INTO `Address` (`address_id`, `user_id`, `street`, `city`, `country_id`) VALUES
(1, 1, 'Folnegovićeva 6f', 'Zagreb', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE `Category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`category_id`, `name`, `description`) VALUES
(1, 'Auti', 'Luti automobili');

-- --------------------------------------------------------

--
-- Table structure for table `Country`
--

CREATE TABLE `Country` (
  `country_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Country`
--

INSERT INTO `Country` (`country_id`, `name`, `code`) VALUES
(1, 'Afghanistan', 'AF'),
(2, 'Albania', 'AL'),
(3, 'Algeria', 'DZ'),
(4, 'American Samoa', 'AS'),
(5, 'Andorra', 'AD'),
(6, 'Angola', 'AO'),
(7, 'Anguilla', 'AI'),
(8, 'Antarctica', 'AQ'),
(9, 'Antigua and Barbuda', 'AG'),
(10, 'Argentina', 'AR'),
(11, 'Armenia', 'AM'),
(12, 'Aruba', 'AW'),
(13, 'Australia', 'AU'),
(14, 'Austria', 'AT'),
(15, 'Azerbaijan', 'AZ'),
(16, 'Bahamas', 'BS'),
(17, 'Bahrain', 'BH'),
(18, 'Bangladesh', 'BD'),
(19, 'Barbados', 'BB'),
(20, 'Belarus', 'BY'),
(21, 'Belgium', 'BE'),
(22, 'Belize', 'BZ'),
(23, 'Benin', 'BJ'),
(24, 'Bermuda', 'BM'),
(25, 'Bhutan', 'BT'),
(26, 'Bolivia', 'BO'),
(27, 'Bosnia and Herzegovina', 'BA'),
(28, 'Botswana', 'BW'),
(29, 'Bouvet Island', 'BV'),
(30, 'Brazil', 'BR'),
(31, 'British Antarctic Territory', 'BQ'),
(32, 'British Indian Ocean Territory', 'IO'),
(33, 'British Virgin Islands', 'VG'),
(34, 'Brunei', 'BN'),
(35, 'Bulgaria', 'BG'),
(36, 'Burkina Faso', 'BF'),
(37, 'Burundi', 'BI'),
(38, 'Cambodia', 'KH'),
(39, 'Cameroon', 'CM'),
(40, 'Canada', 'CA'),
(41, 'Canton and Enderbury Islands', 'CT'),
(42, 'Cape Verde', 'CV'),
(43, 'Cayman Islands', 'KY'),
(44, 'Central African Republic', 'CF'),
(45, 'Chad', 'TD'),
(46, 'Chile', 'CL'),
(47, 'China', 'CN'),
(48, 'Christmas Island', 'CX'),
(49, 'Cocos [Keeling] Islands', 'CC'),
(50, 'Colombia', 'CO'),
(51, 'Comoros', 'KM'),
(52, 'Congo - Brazzaville', 'CG'),
(53, 'Congo - Kinshasa', 'CD'),
(54, 'Cook Islands', 'CK'),
(55, 'Costa Rica', 'CR'),
(56, 'Croatia', 'HR'),
(57, 'Cuba', 'CU'),
(58, 'Cyprus', 'CY'),
(59, 'Czech Republic', 'CZ'),
(60, 'Côte d’Ivoire', 'CI'),
(61, 'Denmark', 'DK'),
(62, 'Djibouti', 'DJ'),
(63, 'Dominica', 'DM'),
(64, 'Dominican Republic', 'DO'),
(65, 'Dronning Maud Land', 'NQ'),
(66, 'East Germany', 'DD'),
(67, 'Ecuador', 'EC'),
(68, 'Egypt', 'EG'),
(69, 'El Salvador', 'SV'),
(70, 'Equatorial Guinea', 'GQ'),
(71, 'Eritrea', 'ER'),
(72, 'Estonia', 'EE'),
(73, 'Ethiopia', 'ET'),
(74, 'Falkland Islands', 'FK'),
(75, 'Faroe Islands', 'FO'),
(76, 'Fiji', 'FJ'),
(77, 'Finland', 'FI'),
(78, 'France', 'FR'),
(79, 'French Guiana', 'GF'),
(80, 'French Polynesia', 'PF'),
(81, 'French Southern Territories', 'TF'),
(82, 'French Southern and Antarctic Territories', 'FQ'),
(83, 'Gabon', 'GA'),
(84, 'Gambia', 'GM'),
(85, 'Georgia', 'GE'),
(86, 'Germany', 'DE'),
(87, 'Ghana', 'GH'),
(88, 'Gibraltar', 'GI'),
(89, 'Greece', 'GR'),
(90, 'Greenland', 'GL'),
(91, 'Grenada', 'GD'),
(92, 'Guadeloupe', 'GP'),
(93, 'Guam', 'GU'),
(94, 'Guatemala', 'GT'),
(95, 'Guernsey', 'GG'),
(96, 'Guinea', 'GN'),
(97, 'Guinea-Bissau', 'GW'),
(98, 'Guyana', 'GY'),
(99, 'Haiti', 'HT'),
(100, 'Heard Island and McDonald Islands', 'HM'),
(101, 'Honduras', 'HN'),
(102, 'Hong Kong SAR China', 'HK'),
(103, 'Hungary', 'HU'),
(104, 'Iceland', 'IS'),
(105, 'India', 'IN'),
(106, 'Indonesia', 'ID'),
(107, 'Iran', 'IR'),
(108, 'Iraq', 'IQ'),
(109, 'Ireland', 'IE'),
(110, 'Isle of Man', 'IM'),
(111, 'Israel', 'IL'),
(112, 'Italy', 'IT'),
(113, 'Jamaica', 'JM'),
(114, 'Japan', 'JP'),
(115, 'Jersey', 'JE'),
(116, 'Johnston Island', 'JT'),
(117, 'Jordan', 'JO'),
(118, 'Kazakhstan', 'KZ'),
(119, 'Kenya', 'KE'),
(120, 'Kiribati', 'KI'),
(121, 'Kuwait', 'KW'),
(122, 'Kyrgyzstan', 'KG'),
(123, 'Laos', 'LA'),
(124, 'Latvia', 'LV'),
(125, 'Lebanon', 'LB'),
(126, 'Lesotho', 'LS'),
(127, 'Liberia', 'LR'),
(128, 'Libya', 'LY'),
(129, 'Liechtenstein', 'LI'),
(130, 'Lithuania', 'LT'),
(131, 'Luxembourg', 'LU'),
(132, 'Macau SAR China', 'MO'),
(133, 'Macedonia', 'MK'),
(134, 'Madagascar', 'MG'),
(135, 'Malawi', 'MW'),
(136, 'Malaysia', 'MY'),
(137, 'Maldives', 'MV'),
(138, 'Mali', 'ML'),
(139, 'Malta', 'MT'),
(140, 'Marshall Islands', 'MH'),
(141, 'Martinique', 'MQ'),
(142, 'Mauritania', 'MR'),
(143, 'Mauritius', 'MU'),
(144, 'Mayotte', 'YT'),
(145, 'Metropolitan France', 'FX'),
(146, 'Mexico', 'MX'),
(147, 'Micronesia', 'FM'),
(148, 'Midway Islands', 'MI'),
(149, 'Moldova', 'MD'),
(150, 'Monaco', 'MC'),
(151, 'Mongolia', 'MN'),
(152, 'Montenegro', 'ME'),
(153, 'Montserrat', 'MS'),
(154, 'Morocco', 'MA'),
(155, 'Mozambique', 'MZ'),
(156, 'Myanmar [Burma]', 'MM'),
(157, 'Namibia', 'NA'),
(158, 'Nauru', 'NR'),
(159, 'Nepal', 'NP'),
(160, 'Netherlands', 'NL'),
(161, 'Netherlands Antilles', 'AN'),
(162, 'Neutral Zone', 'NT'),
(163, 'New Caledonia', 'NC'),
(164, 'New Zealand', 'NZ'),
(165, 'Nicaragua', 'NI'),
(166, 'Niger', 'NE'),
(167, 'Nigeria', 'NG'),
(168, 'Niue', 'NU'),
(169, 'Norfolk Island', 'NF'),
(170, 'North Korea', 'KP'),
(171, 'North Vietnam', 'VD'),
(172, 'Northern Mariana Islands', 'MP'),
(173, 'Norway', 'NO'),
(174, 'Oman', 'OM'),
(175, 'Pacific Islands Trust Territory', 'PC'),
(176, 'Pakistan', 'PK'),
(177, 'Palau', 'PW'),
(178, 'Palestinian Territories', 'PS'),
(179, 'Panama', 'PA'),
(180, 'Panama Canal Zone', 'PZ'),
(181, 'Papua New Guinea', 'PG'),
(182, 'Paraguay', 'PY'),
(183, 'People\'s Democratic Republic of Yemen', 'YD'),
(184, 'Peru', 'PE'),
(185, 'Philippines', 'PH'),
(186, 'Pitcairn Islands', 'PN'),
(187, 'Poland', 'PL'),
(188, 'Portugal', 'PT'),
(189, 'Puerto Rico', 'PR'),
(190, 'Qatar', 'QA'),
(191, 'Romania', 'RO'),
(192, 'Russia', 'RU'),
(193, 'Rwanda', 'RW'),
(194, 'Réunion', 'RE'),
(195, 'Saint Barthélemy', 'BL'),
(196, 'Saint Helena', 'SH'),
(197, 'Saint Kitts and Nevis', 'KN'),
(198, 'Saint Lucia', 'LC'),
(199, 'Saint Martin', 'MF'),
(200, 'Saint Pierre and Miquelon', 'PM'),
(201, 'Saint Vincent and the Grenadines', 'VC'),
(202, 'Samoa', 'WS'),
(203, 'San Marino', 'SM'),
(204, 'Saudi Arabia', 'SA'),
(205, 'Senegal', 'SN'),
(206, 'Serbia', 'RS'),
(207, 'Serbia and Montenegro', 'CS'),
(208, 'Seychelles', 'SC'),
(209, 'Sierra Leone', 'SL'),
(210, 'Singapore', 'SG'),
(211, 'Slovakia', 'SK'),
(212, 'Slovenia', 'SI'),
(213, 'Solomon Islands', 'SB'),
(214, 'Somalia', 'SO'),
(215, 'South Africa', 'ZA'),
(216, 'South Georgia and the South Sandwich Islands', 'GS'),
(217, 'South Korea', 'KR'),
(218, 'Spain', 'ES'),
(219, 'Sri Lanka', 'LK'),
(220, 'Sudan', 'SD'),
(221, 'Suriname', 'SR'),
(222, 'Svalbard and Jan Mayen', 'SJ'),
(223, 'Swaziland', 'SZ'),
(224, 'Sweden', 'SE'),
(225, 'Switzerland', 'CH'),
(226, 'Syria', 'SY'),
(227, 'São Tomé and Príncipe', 'ST'),
(228, 'Taiwan', 'TW'),
(229, 'Tajikistan', 'TJ'),
(230, 'Tanzania', 'TZ'),
(231, 'Thailand', 'TH'),
(232, 'Timor-Leste', 'TL'),
(233, 'Togo', 'TG'),
(234, 'Tokelau', 'TK'),
(235, 'Tonga', 'TO'),
(236, 'Trinidad and Tobago', 'TT'),
(237, 'Tunisia', 'TN'),
(238, 'Turkey', 'TR'),
(239, 'Turkmenistan', 'TM'),
(240, 'Turks and Caicos Islands', 'TC'),
(241, 'Tuvalu', 'TV'),
(242, 'U.S. Minor Outlying Islands', 'UM'),
(243, 'U.S. Miscellaneous Pacific Islands', 'PU'),
(244, 'U.S. Virgin Islands', 'VI'),
(245, 'Uganda', 'UG'),
(246, 'Ukraine', 'UA'),
(247, 'Union of Soviet Socialist Republics', 'SU'),
(248, 'United Arab Emirates', 'AE'),
(249, 'United Kingdom', 'GB'),
(250, 'United States', 'US'),
(251, 'Unknown or Invalid Region', 'ZZ'),
(252, 'Uruguay', 'UY'),
(253, 'Uzbekistan', 'UZ'),
(254, 'Vanuatu', 'VU'),
(255, 'Vatican City', 'VA'),
(256, 'Venezuela', 'VE'),
(257, 'Vietnam', 'VN'),
(258, 'Wake Island', 'WK'),
(259, 'Wallis and Futuna', 'WF'),
(260, 'Western Sahara', 'EH'),
(261, 'Yemen', 'YE'),
(262, 'Zambia', 'ZM'),
(263, 'Zimbabwe', 'ZW'),
(264, 'Åland Islands', 'AX');

-- --------------------------------------------------------

--
-- Table structure for table `Follower`
--

CREATE TABLE `Follower` (
  `follower` int(11) NOT NULL,
  `followee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Post`
--

CREATE TABLE `Post` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `heading` varchar(100) NOT NULL,
  `content` varchar(512) NOT NULL,
  `published_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Post`
--

INSERT INTO `Post` (`post_id`, `user_id`, `heading`, `content`, `published_on`) VALUES
(1, 1, 'Pozz ljudi', 'Ovo je moj prvi post', '2016-03-31 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `Product`
--

CREATE TABLE `Product` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(2048) NOT NULL,
  `allow_review` tinyint(1) NOT NULL DEFAULT '1',
  `published_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `view_count` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Product`
--

INSERT INTO `Product` (`product_id`, `user_id`, `category_id`, `name`, `description`, `allow_review`, `published_on`, `view_count`) VALUES
(1, 1, 1, 'Porše', 'Brm Brm Brm 1000km/s', 1, '2016-03-31 00:00:00', 1),
(2, 1, 1, 'Mercedes', 'Najbrza makina na cesti, 10000 konja, 0-100 za 3 mikro sekunde', 1, '2016-04-11 21:38:13', 4);

-- --------------------------------------------------------

--
-- Table structure for table `ProductPrice`
--

CREATE TABLE `ProductPrice` (
  `product_id` int(11) NOT NULL,
  `date_changed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ProductPrice`
--

INSERT INTO `ProductPrice` (`product_id`, `date_changed`, `price`) VALUES
(1, '2016-03-31 15:54:31', 1000000.00),
(1, '2016-04-11 21:20:16', 12301.00),
(2, '2016-04-11 21:38:37', 49999.00);

-- --------------------------------------------------------

--
-- Table structure for table `Review`
--

CREATE TABLE `Review` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'reviewer',
  `content` varchar(256) NOT NULL,
  `rating` enum('1','2','3','4','5') NOT NULL DEFAULT '5',
  `published_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Review`
--

INSERT INTO `Review` (`review_id`, `product_id`, `user_id`, `content`, `rating`, `published_on`) VALUES
(1, 1, 1, 'Predobar auto, kupujem cim dignem hipoteku', '5', '2016-03-31 16:00:04'),
(2, 1, 1, 'Je, slazem se. Ja sam ga kupil, luti je totalno', '5', '2016-04-08 21:26:02'),
(3, 1, 1, 'Auspuh se prejako cuje', '5', '2016-04-08 21:26:24'),
(4, 1, 1, 'Jeste', '5', '2016-04-08 21:26:54'),
(5, 1, 1, 'rating 3, solidarka', '3', '2016-04-08 21:27:44'),
(6, 1, 1, '&lt;b&gt; yolo &lt;/b&gt;', '5', '2016-04-09 11:45:31'),
(7, 1, 1, '); DROP TABLE ProductCategory;', '5', '2016-04-09 11:46:30');

-- --------------------------------------------------------

--
-- Table structure for table `Tag`
--

CREATE TABLE `Tag` (
  `content_id` int(11) NOT NULL,
  `content_type` enum('PRODUCT','POST') NOT NULL,
  `tag` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Tag`
--

INSERT INTO `Tag` (`content_id`, `content_type`, `tag`) VALUES
(1, 'PRODUCT', 'makina');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(65) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `user_role` int(11) NOT NULL DEFAULT '0',
  `background_color` varchar(10) DEFAULT '#FFFFFF',
  `currency` varchar(3) DEFAULT 'HRK'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`user_id`, `username`, `password`, `first_name`, `last_name`, `email`, `telephone`, `date_of_birth`, `user_role`, `background_color`, `currency`) VALUES
(1, 'nichre', 'sifra', 'Filip', 'Hrenić', 'hrenic.filip@gmail.com', '0917304227', '1994-10-10', 0, '#FFFFFF', 'HRK');

-- --------------------------------------------------------

--
-- Table structure for table `UserCategory`
--

CREATE TABLE `UserCategory` (
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Address`
--
ALTER TABLE `Address`
  ADD PRIMARY KEY (`address_id`,`user_id`),
  ADD KEY `Address__user_index` (`user_id`),
  ADD KEY `Address_Country_country_id_fk` (`country_id`);

--
-- Indexes for table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `Category_category_id_uindex` (`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `Country`
--
ALTER TABLE `Country`
  ADD PRIMARY KEY (`country_id`),
  ADD UNIQUE KEY `Country_country_id_uindex` (`country_id`);

--
-- Indexes for table `Follower`
--
ALTER TABLE `Follower`
  ADD PRIMARY KEY (`follower`,`followee`),
  ADD KEY `Follower_User_user_id_fk2` (`followee`);

--
-- Indexes for table `Post`
--
ALTER TABLE `Post`
  ADD PRIMARY KEY (`post_id`),
  ADD UNIQUE KEY `Post_post_id_uindex` (`post_id`),
  ADD KEY `Post_User_user_id_fk` (`user_id`);

--
-- Indexes for table `Product`
--
ALTER TABLE `Product`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `Article_article_id_uindex` (`product_id`),
  ADD KEY `Product_Category_category_id_fk` (`category_id`),
  ADD KEY `Product_User_user_id_fk` (`user_id`);

--
-- Indexes for table `ProductPrice`
--
ALTER TABLE `ProductPrice`
  ADD PRIMARY KEY (`product_id`,`date_changed`);

--
-- Indexes for table `Review`
--
ALTER TABLE `Review`
  ADD PRIMARY KEY (`review_id`),
  ADD UNIQUE KEY `Review_review_id_uindex` (`review_id`),
  ADD KEY `Review_Product_product_id_fk` (`product_id`),
  ADD KEY `Review_User_user_id_fk` (`user_id`);

--
-- Indexes for table `Tag`
--
ALTER TABLE `Tag`
  ADD PRIMARY KEY (`content_id`,`content_type`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `User_user_id_uindex` (`user_id`),
  ADD UNIQUE KEY `User_username_uindex` (`username`);

--
-- Indexes for table `UserCategory`
--
ALTER TABLE `UserCategory`
  ADD PRIMARY KEY (`user_id`,`category_id`),
  ADD KEY `UserCategory_Category_category_id_fk` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Address`
--
ALTER TABLE `Address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Category`
--
ALTER TABLE `Category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Country`
--
ALTER TABLE `Country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;
--
-- AUTO_INCREMENT for table `Post`
--
ALTER TABLE `Post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Product`
--
ALTER TABLE `Product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Review`
--
ALTER TABLE `Review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Address`
--
ALTER TABLE `Address`
  ADD CONSTRAINT `Address_Country_country_id_fk` FOREIGN KEY (`country_id`) REFERENCES `Country` (`country_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Address_User_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `Follower`
--
ALTER TABLE `Follower`
  ADD CONSTRAINT `Follower_User_user_id_fk` FOREIGN KEY (`follower`) REFERENCES `User` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Follower_User_user_id_fk2` FOREIGN KEY (`followee`) REFERENCES `User` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Post`
--
ALTER TABLE `Post`
  ADD CONSTRAINT `Post_User_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Product`
--
ALTER TABLE `Product`
  ADD CONSTRAINT `Product_Category_category_id_fk` FOREIGN KEY (`category_id`) REFERENCES `Category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Product_User_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ProductPrice`
--
ALTER TABLE `ProductPrice`
  ADD CONSTRAINT `ProductPrice_Product_product_id_fk` FOREIGN KEY (`product_id`) REFERENCES `Product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Review`
--
ALTER TABLE `Review`
  ADD CONSTRAINT `Review_Product_product_id_fk` FOREIGN KEY (`product_id`) REFERENCES `Product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Review_User_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `UserCategory`
--
ALTER TABLE `UserCategory`
  ADD CONSTRAINT `UserCategory_Category_category_id_fk` FOREIGN KEY (`category_id`) REFERENCES `Category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `UserCategory_User_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
