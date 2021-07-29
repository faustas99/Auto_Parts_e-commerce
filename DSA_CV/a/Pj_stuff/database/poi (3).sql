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
-- Table structure for table `poi`
--

CREATE TABLE `poi` (
  `city_id_fk` int(11) NOT NULL,
  `poi_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `lat` float NOT NULL,
  `lng` float NOT NULL,
  `description` text NOT NULL,
  `tags` text NOT NULL,
  `wiki_url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `poi`
--

INSERT INTO `poi` (`city_id_fk`, `poi_id`, `name`, `lat`, `lng`, `description`, `tags`, `wiki_url`) VALUES
(2, 1, 'World Museum', 53.41, -2.98132, 'A large museum containing extensive collections covering archaeology, ethnology and the natural and physical sciences. Special attractions include the Natural History Centre and a planetarium. The museum is part of National Museums Liverpool ', '#WorldMuseum #NationalMuseumsofLiverpool #LiverpoolMuseum #MuseumofLiverpool', 'https://en.wikipedia.org/wiki/World_Museum'),
(2, 2, 'Liverpool Football Club', 53.4308, -2.9608, 'A professional football club in Liverpool that competes in the Premier League, the top tier of English football. ', '#Anfield #LFC #AnfieldLFC #AnfieldRoad #TheKop #LiverpoolFC #TheReds #Redmen', 'https://en.wikipedia.org/wiki/Liverpool_F.C.'),
(2, 3, 'Sefton Park', 53.3831, -2.9332, 'A public park in south Liverpool in a district of the same name and located roughly within the historic bounds of the large area of Toxteth Park. The park is 235 acres in area and designated by the English Heritage.', '#Sefton #SeftonPark', 'https://en.wikipedia.org/wiki/Sefton_Park'),
(2, 4, 'The Royal Albert Dock', 53.3996, -2.9925, 'A complex of dock buildings and warehouses. The Docks dominated global trade in the 19th century, with the Albert Dock at their heart. Opened in 1846 and changed the way the docks worked here forever. ', '#RoyalAlbertDock #AlbertDock #LiverpoolDock #LiverpoolDocks #TheRoyalAlbertDock', 'https://en.wikipedia.org/wiki/The_Royal_Albert_Dock_Liverpool'),
(2, 5, 'Liverpool Cathedral', 53.3975, -2.9733, 'Church of England Cathedral built on St James Mount and is the seat of the Bishop of Liverpool. 5th largest in Europe. The cathedral is free to enter and is a world-class visitor attraction with a full programme of events.  ', '#LiverpoolCathedral #StJamesMount #LiverpoolAnglicanCathedral', 'https://en.wikipedia.org/wiki/Liverpool_Cathedral'),
(2, 6, 'The Beatles Story Exhibition', 53.399, -2.992, 'This award-winning attraction tells the story of  The Beatles and their history.  It is located on the historical Albert Dock. The Beatles Story was opened on 1 May 1990.', '#TheBeatles #BeatlesStory #TheBeatlesStoryExhibition #BeatlesStoryExhibition', 'https://en.wikipedia.org/wiki/The_Beatles_Story '),
(1, 7, 'The Bund', 31.2403, 121.491, 'The Bund or Waitan is a waterfront area in central Shanghai. The area centers on a section of Zhongshan Road within the former Shanghai International Settlement, which runs along the western bank of the Huangpu River.', '#Bund #TheBund #BundWaterfront ', 'https://en.wikipedia.org/wiki/The_Bund'),
(1, 8, 'Propaganda Poster Art Centre', 31.2121, 121.438, 'The Propaganda Poster Art Centre is a museum located in Shanghai which exhibits posters from the Maoist period of communist China, especially from the Cultural Revolution period. ', '#PropagandaArts #PropagandaArtCentre #PropagandaCentre', 'https://en.wikipedia.org/wiki/Propaganda_Poster_Art_Centre'),
(1, 9, 'Qibao', 31.1577, 121.351, 'Qibao is a water town in Shanghais Minhang District. Two broad waterways, lined with houses and gardens, run through the town center. Qibao Temple has an elaborate pagoda. ', '#Qibao #QibaoShanghai #QibaoWatertown', 'https://en.wikipedia.org/wiki/Qibao '),
(1, 10, 'Yu Garden', 31.2272, 121.492, 'Yu Garden or Yuyuan Garden is an extensive Chinese garden located beside the City God Temple in the northeast of ', '#YuGarden #YuGardens #YuGardenShanghai', 'https://en.wikipedia.org/wiki/Yu_Garden '),
(1, 11, 'Nanjing Road', 31.2348, 121.475, 'Nanjing Road is a road in Shanghai. The eastern part of Nanjing Road is the main shopping streets of Shanghai, China, and is one of the world\'s busiest shopping streets along with Bukit Bintang. ', '#Nanjing #NanjingRoad #NanjingShanghai #NanjingJiangsu', 'https://en.wikipedia.org/wiki/Nanjing_Road '),
(1, 12, 'Shanghai SIPG F.C.', 31.1815, 121.438, 'Shanghai SIPG F.C. or SIPG FC is a professional football club that participates in the Chinese Super League under licence from the Chinese Football Association. The team is based in Xuhui, Shanghai, and their home stadium is the Shanghai Stadium.', '#ShanghaiFC #ShanghaiSIPGFC #SIPGFC #ShanghaiFootball', 'https://en.wikipedia.org/wiki/Shanghai_SIPG_F.C. ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `poi`
--
ALTER TABLE `poi`
  ADD PRIMARY KEY (`poi_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
