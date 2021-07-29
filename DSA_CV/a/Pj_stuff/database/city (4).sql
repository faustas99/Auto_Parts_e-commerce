-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2020 at 08:51 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fet18012589`
--

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `city_id` int(2) NOT NULL,
  `names` longtext NOT NULL,
  `county` longtext NOT NULL,
  `description` longtext NOT NULL,
  `lat` float NOT NULL,
  `lng` float NOT NULL,
  `population` int(10) NOT NULL,
  `currency` varchar(5) NOT NULL,
  `tags` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`city_id`, `names`, `county`, `description`, `lat`, `lng`, `population`, `currency`, `tags`) VALUES
(1, 'Shanghai', 'Minhang District', 'Shanghai is one of the four municipalities of the People\'s Republic of China. It is located on the southern estuary of the Yangtze, and the Huangpu River flows through it. With a population of 24.2 million as of 2018, it is the most populous urban area in China and the second most populous city proper in the world. Shanghai is a global center for finance, innovation, and transportation, and the Port of Shanghai is the world\'s busiest container port.\r\n\r\nOriginally a fishing village and market town, Shanghai grew in importance in the 19th century due to trade and its favorable port location. The city was one of five treaty ports forced open to foreign trade after the First Opium War. The Shanghai International Settlement and the French Concession were subsequently established. The city then flourished, becoming a primary commercial and financial hub of the Asia-Pacific region in the 1930s. During the Second Sino-Japanese War, the city was the site of the major Battle of Shanghai. After the war, with the CPC takeover of mainland China in 1949, trade was limited to other socialist countries, and the city\'s global influence declined.', 31.2304, 121.474, 24240000, 'CNY', '#wow'),
(2, 'Liverpool', 'Lancashire ', 'Liverpool is a city and metropolitan borough in Merseyside, England. As of 2018. Liverpool is the ninth-largest English district by population, and the largest in Merseyside and the Liverpool City Region. It lies within the United Kingdom\'s sixth-most populous urban area. \r\n\r\nLiverpool is on the eastern side of the Mersey Estuary, and historically lay within the ancient hundred of West Derby in the southwest of the county of Lancashire in North West England. It became a borough in 1207 and a city in 1880. In 1889, it became a county borough independent of Lancashire. Its growth as a major port was paralleled by the expansion of the city throughout the Industrial Revolution. Along with handling general cargo, freight, and raw materials such as coal and cotton, the city merchants were involved in the Atlantic slave trade. In the 19th century, it was a major port of departure for English and Irish emigrants to North America. Liverpool was home to both the Cunard and White Star Line, and was the port of registry of the ocean liners RMS Titanic, RMS Lusitania, RMS Queen Mary, and RMS Olympic.', 53.4084, -2.9916, 494814, 'GBP', '#soccer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`city_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
