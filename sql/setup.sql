--
-- Database and user
--

DROP DATABASE IF EXISTS evservices;

CREATE DATABASE IF NOT EXISTS evservices;

GRANT ALL PRIVILEGES ON Anmeldungen.* TO 'evservices'@'localhost' IDENTIFIED BY '2Secure4U!';

--
-- Table structure for table `eventgroup`
--

USE evservices;

DROP TABLE IF EXISTS `seats`;

DROP TABLE IF EXISTS `tickets`;
DROP TABLE IF EXISTS `events`;
DROP TABLE IF EXISTS `eventgroups`;
DROP TABLE IF EXISTS `contacts`;

CREATE TABLE `eventgroups` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` char(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Import data for table `eventgroups`
--

LOCK TABLES `eventgroups` WRITE;
INSERT INTO `eventgroups` VALUES (1,'Sonntags-Gottesdienste');
UNLOCK TABLES;

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `gid` bigint(20) DEFAULT NULL,
  `Starttime` datetime DEFAULT NULL,
  `Endtime` datetime DEFAULT NULL,
  `Title` char(64) DEFAULT NULL,
  `Subtitle` char(64) DEFAULT NULL,
  `Place` char(32) DEFAULT NULL,
  `SeatCapacity` int(11) DEFAULT 10,
  `ReservedSeats` int(11) DEFAULT 0,
  `MaxGroups` int(11) DEFAULT 2,
  PRIMARY KEY (`id`),
  KEY `gid` (`gid`),
  KEY `Starttime` (`Starttime`),
  KEY `Endtime` (`Endtime`),
  KEY `Title` (`Title`),
  KEY `Subtitle` (`Subtitle`),
  KEY `Place` (`Place`),
  CONSTRAINT `events_ibfk_1` FOREIGN KEY (`gid`) REFERENCES `eventgroups` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Import data for table `events`
--

LOCK TABLES `events` WRITE;
INSERT INTO `events` VALUES 
(1,1,'2020-01-05 10:00:00','2020-01-05 10:45:00','Gottesdienst','Trinitatis','Gnadenkirche',60,3,40);
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `PIN` bigint(20) DEFAUlT NULL,
  `Firstname` char(64) DEFAULT NULL,
  `Name` char(64) DEFAULT NULL,
  `Street` char(64) DEFAULT NULL,
  `PostalCode` char(16) DEFAULT '53359',
  `City` char(64) DEFAULT 'Rheinbach',
  `EMail` char(128) DEFAULT NULL,
  `Phone` char(16) DEFAULT '02226-',
  `Konfirmand` boolean DEFAULT 0,
  `DonotDelete` boolean DEFAULT 0,
  `ts` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
  PRIMARY KEY (`id`),
  KEY `PIN` (`PIN`),
  KEY `Firstname` (`Firstname`),
  KEY `Name` (`Name`),
  KEY `Street` (`Street`),
  KEY `PostalCode` (`PostalCode`),
  KEY `City` (`City`),
  KEY `Phone` (`Phone`),
  KEY `EMail` (`EMail`),
  KEY `Konfirmand` (`Konfirmand`),
  CONSTRAINT `person` UNIQUE (`Firstname`,`Name`,`Street`,`PostalCode`,`City`,`Phone`,`EMail`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Import data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `eid` bigint(20) DEFAULT NULL,
  `cid` bigint(20) DEFAULT NULL,
  `reserved` tinyint(1) DEFAULT 0,
  `confirmed` tinyint(1) DEFAULT 0,
  `confirmtoken` char(32) DEFAULT NULL,
  `ts` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `eid` (`eid`),
  KEY `cid` (`cid`),
  KEY `ts` (`ts`),
  KEY `confirmtoken` (`confirmtoken`),
  CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`eid`) REFERENCES `events` (`id`),
  CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`cid`) REFERENCES `contacts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Import data for table `tickets`
--

LOCK TABLES `tickets` WRITE;

UNLOCK TABLES;

--
-- Stored procedures 
--

delimiter //

drop procedure if exists add_sunday_services //

create procedure add_sunday_services (n INT)
begin
  set @i=0;
  set @offset = 8 - dayofweek(CURRENT_DATE);

  repeat

    set @datum =convert(adddate(CURRENT_DATE, @offset + @i * 7),datetime);
    insert into events values
        (NULL,1,addtime(@datum,'10:00:00'),addtime(@datum,'10:45:00'),'Gottesdienst','Trinitatis','Gnadenkirche',60,3,40);
    set @i=@i+1; 

  until @i > (n + 1) end repeat; 

end
//
delimiter ;

--
-- Define next 20 sunday services 
--

call add_sunday_services(20);
