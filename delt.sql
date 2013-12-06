-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 24, 2013 at 11:56 AM
-- Server version: 5.1.68-cll
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `delt`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE IF NOT EXISTS `album` (
  `pic_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `core_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` char(255) DEFAULT NULL,
  `uploaded` datetime DEFAULT NULL,
  PRIMARY KEY (`pic_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1678 ;

-- --------------------------------------------------------

--
-- Table structure for table `battle_info`
--

CREATE TABLE IF NOT EXISTS `battle_info` (
  `BattleID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `X` int(10) unsigned NOT NULL DEFAULT '0',
  `Y` int(10) unsigned NOT NULL DEFAULT '0',
  `MapID` int(10) unsigned NOT NULL DEFAULT '0',
  `Active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `BattleText` longtext,
  `ActionDate` datetime DEFAULT NULL,
  PRIMARY KEY (`BattleID`),
  KEY `Location` (`X`,`Y`,`MapID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7137621 ;

-- --------------------------------------------------------

--
-- Table structure for table `battle_user`
--

CREATE TABLE IF NOT EXISTS `battle_user` (
  `DBID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `BattleID` int(10) unsigned NOT NULL DEFAULT '0',
  `CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  `ItemUses` tinyint(3) unsigned NOT NULL DEFAULT '20',
  `Flee` enum('Yes','No') DEFAULT 'No',
  `ActionDate` datetime DEFAULT NULL,
  `Amount` int(10) unsigned NOT NULL DEFAULT '0',
  `PK_Flee` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`DBID`),
  KEY `BattleID` (`BattleID`),
  KEY `CoreID` (`CoreID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3043870 ;

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE IF NOT EXISTS `buildings` (
  `BID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(25) DEFAULT NULL,
  `ModCode` text,
  `Cost` int(10) unsigned NOT NULL DEFAULT '0',
  `BaseMaint` int(10) unsigned NOT NULL DEFAULT '0',
  `MaintPerFlag` int(10) unsigned NOT NULL DEFAULT '0',
  `TileID` int(10) unsigned NOT NULL DEFAULT '0',
  `MaxArmor` int(10) unsigned NOT NULL DEFAULT '0',
  `Description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`BID`),
  KEY `Name` (`Name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `chatter`
--

CREATE TABLE IF NOT EXISTS `chatter` (
  `CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  `ClanID` int(10) unsigned NOT NULL DEFAULT '0',
  `TS` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Message` char(255) DEFAULT NULL,
  `ChatID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TargetID` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ChatID`),
  KEY `TS` (`TS`),
  KEY `Message` (`Message`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=242845 ;

-- --------------------------------------------------------

--
-- Table structure for table `clans`
--

CREATE TABLE IF NOT EXISTS `clans` (
  `ClanID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(25) NOT NULL DEFAULT '',
  `Letters` char(3) NOT NULL DEFAULT '',
  `Founder` int(11) unsigned NOT NULL DEFAULT '0',
  `Password` varchar(255) NOT NULL DEFAULT '',
  `CreationDate` date NOT NULL DEFAULT '0000-00-00',
  `Description` varchar(50) NOT NULL DEFAULT '',
  `ClanBank` bigint(20) unsigned NOT NULL DEFAULT '0',
  `HomeX` int(10) unsigned NOT NULL DEFAULT '0',
  `HomeY` int(10) unsigned NOT NULL DEFAULT '0',
  `HomeMapID` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ClanID`),
  KEY `ClanID` (`ClanID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=892 ;

-- --------------------------------------------------------

--
-- Table structure for table `clan_buildings`
--

CREATE TABLE IF NOT EXISTS `clan_buildings` (
  `ClanID` int(10) unsigned NOT NULL DEFAULT '0',
  `BID` int(10) unsigned NOT NULL DEFAULT '0',
  `KeyID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(25) DEFAULT NULL,
  `Flags` varchar(255) DEFAULT NULL,
  `X` int(10) unsigned NOT NULL DEFAULT '0',
  `Y` int(10) unsigned NOT NULL DEFAULT '0',
  `MapID` int(10) unsigned NOT NULL DEFAULT '0',
  `Armor` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`KeyID`),
  KEY `Location` (`X`,`Y`,`MapID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7574 ;

-- --------------------------------------------------------

--
-- Table structure for table `clan_pins`
--

CREATE TABLE IF NOT EXISTS `clan_pins` (
  `LocID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ClanID` int(10) unsigned NOT NULL DEFAULT '0',
  `X` int(10) unsigned NOT NULL DEFAULT '0',
  `Y` int(10) unsigned NOT NULL DEFAULT '0',
  `MapID` int(10) unsigned NOT NULL DEFAULT '0',
  `PinX` int(10) unsigned NOT NULL DEFAULT '0',
  `PinY` int(10) unsigned NOT NULL DEFAULT '0',
  `Username` varchar(25) NOT NULL DEFAULT '',
  `Description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`LocID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `clan_warriors`
--

CREATE TABLE IF NOT EXISTS `clan_warriors` (
  `WID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `WarriorID` int(10) unsigned NOT NULL DEFAULT '0',
  `ClanID` int(10) unsigned NOT NULL DEFAULT '0',
  `X` int(10) unsigned NOT NULL DEFAULT '0',
  `Y` int(10) unsigned NOT NULL DEFAULT '0',
  `MapID` int(10) unsigned NOT NULL DEFAULT '0',
  `Turns` int(10) unsigned NOT NULL DEFAULT '0',
  `Amount` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`WID`),
  KEY `Location` (`X`,`Y`,`MapID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6995 ;

-- --------------------------------------------------------

--
-- Table structure for table `fellowdata`
--

CREATE TABLE IF NOT EXISTS `fellowdata` (
  `FellowID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` char(25) DEFAULT NULL,
  `Leader` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`FellowID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `filters`
--

CREATE TABLE IF NOT EXISTS `filters` (
  `FilterID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`FilterID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- Table structure for table `forums_index`
--

CREATE TABLE IF NOT EXISTS `forums_index` (
  `ForumID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ParentID` int(10) unsigned NOT NULL DEFAULT '0',
  `Topic` varchar(80) DEFAULT NULL,
  `Last_Time` datetime DEFAULT NULL,
  `ClanID` int(10) unsigned NOT NULL DEFAULT '0',
  `CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  `Last_CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  `ReadFlags` varchar(10) DEFAULT NULL,
  `Total` int(10) unsigned NOT NULL DEFAULT '0',
  `Sticky` enum('Y','N') NOT NULL DEFAULT 'N',
  `Locked` enum('Y','N') NOT NULL DEFAULT 'N',
  `Poll` enum('Y','N') NOT NULL DEFAULT 'N',
  `Poll_Q0` varchar(80) NOT NULL DEFAULT '',
  `Poll_Q1` varchar(80) NOT NULL DEFAULT '',
  `Poll_Q2` varchar(80) NOT NULL DEFAULT '',
  `Poll_Q3` varchar(80) NOT NULL DEFAULT '',
  `Poll_Q4` varchar(80) NOT NULL DEFAULT '',
  `Poll_Q5` varchar(80) NOT NULL DEFAULT '',
  `Poll_Q6` varchar(80) NOT NULL DEFAULT '',
  `Poll_Q7` varchar(80) NOT NULL DEFAULT '',
  `Poll_Q8` varchar(80) NOT NULL DEFAULT '',
  `Poll_Q9` varchar(80) NOT NULL DEFAULT '',
  `Last_Username` varchar(25) NOT NULL DEFAULT '',
  `Username` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`ForumID`),
  KEY `ForumID` (`ForumID`),
  KEY `ParentID` (`ParentID`),
  KEY `ClanID` (`ClanID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8113 ;

-- --------------------------------------------------------

--
-- Table structure for table `forums_poll`
--

CREATE TABLE IF NOT EXISTS `forums_poll` (
  `AID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `AnswerID` int(10) unsigned NOT NULL DEFAULT '0',
  `CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  `ForumID` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`AID`),
  KEY `ForumID` (`ForumID`),
  KEY `CoreID` (`CoreID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5611 ;

-- --------------------------------------------------------

--
-- Table structure for table `forums_posts`
--

CREATE TABLE IF NOT EXISTS `forums_posts` (
  `ForumID` int(10) unsigned NOT NULL DEFAULT '0',
  `ClanID` int(10) unsigned NOT NULL DEFAULT '0',
  `CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  `Time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Body` blob,
  `PostID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `IP_Addr` varchar(30) NOT NULL DEFAULT '',
  `Username` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`PostID`),
  KEY `ForumID` (`ForumID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26904 ;

-- --------------------------------------------------------

--
-- Table structure for table `frontnews`
--

CREATE TABLE IF NOT EXISTS `frontnews` (
  `FrontID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL DEFAULT '',
  `Body` text NOT NULL,
  `NewsDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`FrontID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `heartbeat`
--

CREATE TABLE IF NOT EXISTS `heartbeat` (
  `HeartID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(25) DEFAULT NULL,
  `RunEvery` int(10) unsigned NOT NULL DEFAULT '0',
  `RunTime` int(10) unsigned NOT NULL DEFAULT '0',
  `ModCode` text,
  `Enabled` enum('Y','N') DEFAULT 'Y',
  PRIMARY KEY (`HeartID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `help`
--

CREATE TABLE IF NOT EXISTS `help` (
  `TopicID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TopicHeader` varchar(80) DEFAULT NULL,
  `ParentTopic` int(10) unsigned NOT NULL DEFAULT '1',
  `Body` text,
  PRIMARY KEY (`TopicID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `ObjectID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ItemID` int(10) unsigned NOT NULL DEFAULT '0',
  `ItemStack` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `AL` int(10) unsigned NOT NULL DEFAULT '0',
  `DamageMod` int(10) unsigned NOT NULL DEFAULT '0',
  `AttackBonus` int(10) unsigned NOT NULL DEFAULT '0',
  `MeleeBonus` int(10) unsigned NOT NULL DEFAULT '0',
  `MinDam` int(10) unsigned NOT NULL DEFAULT '0',
  `MaxDam` int(10) unsigned NOT NULL DEFAULT '0',
  `AttunementReq` int(10) unsigned NOT NULL DEFAULT '0',
  `SkillReq` int(10) unsigned NOT NULL DEFAULT '0',
  `Value` int(10) unsigned NOT NULL DEFAULT '0',
  `DecayTime` datetime DEFAULT NULL,
  `X` int(10) unsigned NOT NULL DEFAULT '0',
  `Y` int(10) unsigned NOT NULL DEFAULT '0',
  `MapID` int(10) unsigned NOT NULL DEFAULT '0',
  `CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  `Equiped` enum('Y','N') NOT NULL DEFAULT 'N',
  `Use_SkillReq` int(10) unsigned NOT NULL DEFAULT '0',
  `Inscription` varchar(255) DEFAULT NULL,
  `Inscriber_CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  `Banked` enum('Y','N') NOT NULL DEFAULT 'N',
  `Pack` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ObjectID`),
  KEY `Location` (`X`,`Y`,`MapID`),
  KEY `CoreID` (`CoreID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7448319 ;

-- --------------------------------------------------------

--
-- Table structure for table `itemspells`
--

CREATE TABLE IF NOT EXISTS `itemspells` (
  `ISID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ObjectID` int(10) unsigned NOT NULL DEFAULT '0',
  `SpellID` int(10) unsigned NOT NULL DEFAULT '0',
  `Adjustment` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ISID`),
  KEY `ObjectID` (`ObjectID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=304856 ;

-- --------------------------------------------------------

--
-- Table structure for table `items_base`
--

CREATE TABLE IF NOT EXISTS `items_base` (
  `ItemID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(75) NOT NULL DEFAULT '',
  `ItemType` enum('Armor','Weapon','Usable','Misc','Jewlery','Tool') DEFAULT NULL,
  `TileID` int(11) NOT NULL DEFAULT '0',
  `SkillID` int(11) unsigned NOT NULL DEFAULT '0',
  `Use_Effect` text NOT NULL,
  `WearSlot` varchar(50) NOT NULL DEFAULT '',
  `MaxAL` int(10) unsigned NOT NULL DEFAULT '0',
  `Description` varchar(255) NOT NULL DEFAULT '',
  `Defined` enum('Y','N') NOT NULL DEFAULT 'N',
  `Defined_AL` int(10) unsigned NOT NULL DEFAULT '0',
  `Defined_DamageMod` int(10) unsigned NOT NULL DEFAULT '0',
  `Defined_AttackBonus` int(10) unsigned NOT NULL DEFAULT '0',
  `Defined_MeleeBonus` int(10) unsigned NOT NULL DEFAULT '0',
  `Defined_Value` int(11) NOT NULL DEFAULT '0',
  `Defined_MinDam` int(10) unsigned NOT NULL DEFAULT '0',
  `Defined_MaxDam` int(10) unsigned NOT NULL DEFAULT '0',
  `DropRate` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `Droppable` enum('Y','N') NOT NULL DEFAULT 'Y',
  `Enchantable` enum('Y','N') NOT NULL DEFAULT 'Y',
  `Battle_Use` enum('Y','N') NOT NULL DEFAULT 'N',
  `Defined_LevelReq` int(10) unsigned NOT NULL DEFAULT '0',
  `Stackable` enum('Y','N') NOT NULL DEFAULT 'N',
  `MultiStep` enum('Y','N') NOT NULL DEFAULT 'N',
  `Subscriber` enum('Y','N') NOT NULL DEFAULT 'N',
  `CreateDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Admin` enum('Y','N') NOT NULL DEFAULT 'N',
  `Wear_Head` enum('Y','N') NOT NULL DEFAULT 'N',
  `Wear_Torso` enum('Y','N') NOT NULL DEFAULT 'N',
  `Wear_Arms` enum('Y','N') NOT NULL DEFAULT 'N',
  `Wear_Feet` enum('Y','N') NOT NULL DEFAULT 'N',
  `Wear_Legs` enum('Y','N') NOT NULL DEFAULT 'N',
  `Wear_Necklace` enum('Y','N') NOT NULL DEFAULT 'N',
  `Wear_Ring` enum('Y','N') NOT NULL DEFAULT 'N',
  `Wear_Bracelet` enum('Y','N') NOT NULL DEFAULT 'N',
  `Wear_Wielded` enum('Y','N') NOT NULL DEFAULT 'N',
  `Wear_Hands` enum('Y','N') NOT NULL DEFAULT 'N',
  `Buyable` enum('Y','N') NOT NULL DEFAULT 'N',
  `Price` double NOT NULL DEFAULT '0',
  `Salvage_Price` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`ItemID`),
  KEY `ItemID` (`ItemID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1973 ;

-- --------------------------------------------------------

--
-- Table structure for table `items_base_spells`
--

CREATE TABLE IF NOT EXISTS `items_base_spells` (
  `RowID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ItemID` int(10) unsigned NOT NULL DEFAULT '0',
  `SpellID` int(10) unsigned NOT NULL DEFAULT '0',
  `Adjustment` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`RowID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5989 ;

-- --------------------------------------------------------

--
-- Table structure for table `items_filter`
--

CREATE TABLE IF NOT EXISTS `items_filter` (
  `RowID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FilterID` int(10) unsigned NOT NULL DEFAULT '0',
  `ItemID` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`RowID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=441 ;

-- --------------------------------------------------------

--
-- Table structure for table `items_merge`
--

CREATE TABLE IF NOT EXISTS `items_merge` (
  `MergeID` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `ItemA` int(10) unsigned NOT NULL DEFAULT '0',
  `ItemB` int(10) unsigned NOT NULL DEFAULT '0',
  `ResultID` int(10) unsigned NOT NULL DEFAULT '0',
  `SkillID` int(10) unsigned NOT NULL DEFAULT '0',
  `SkillLevel` int(10) unsigned NOT NULL DEFAULT '0',
  `PreserveItemA` enum('Y','N') NOT NULL DEFAULT 'N',
  `PreserveItemB` enum('Y','N') NOT NULL DEFAULT 'N',
  `OptItem` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`MergeID`),
  KEY `MergeItems` (`ItemA`,`ItemB`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=643 ;

-- --------------------------------------------------------

--
-- Table structure for table `item_defined_spells`
--

CREATE TABLE IF NOT EXISTS `item_defined_spells` (
  `IDS` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SpellID` int(10) unsigned NOT NULL DEFAULT '0',
  `ItemID` int(10) unsigned NOT NULL DEFAULT '0',
  `Adjustment` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDS`),
  KEY `ItemID` (`ItemID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `level_curve`
--

CREATE TABLE IF NOT EXISTS `level_curve` (
  `Level` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `XP` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Level`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=478 ;

-- --------------------------------------------------------

--
-- Table structure for table `lootgroup`
--

CREATE TABLE IF NOT EXISTS `lootgroup` (
  `GroupID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` char(80) DEFAULT NULL,
  PRIMARY KEY (`GroupID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=506 ;

-- --------------------------------------------------------

--
-- Table structure for table `lootgroupmap`
--

CREATE TABLE IF NOT EXISTS `lootgroupmap` (
  `MapID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `GroupID` int(10) unsigned NOT NULL DEFAULT '0',
  `ItemID` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`MapID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4053 ;

-- --------------------------------------------------------

--
-- Table structure for table `mail`
--

CREATE TABLE IF NOT EXISTS `mail` (
  `MailID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  `Status` enum('Read','Unread') DEFAULT 'Unread',
  `Time` datetime DEFAULT NULL,
  `From_CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  `From_Username` varchar(25) NOT NULL DEFAULT '',
  `Subject` varchar(80) NOT NULL DEFAULT '',
  `Body` text,
  `FolderID` int(11) NOT NULL DEFAULT '0',
  `Deleted` enum('Y','N') DEFAULT 'N',
  `ToString` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`MailID`),
  KEY `CoreID` (`CoreID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=192758 ;

-- --------------------------------------------------------

--
-- Table structure for table `mail_folder`
--

CREATE TABLE IF NOT EXISTS `mail_folder` (
  `FolderID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CoreID` int(11) NOT NULL DEFAULT '0',
  `Name` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`FolderID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=830 ;

-- --------------------------------------------------------

--
-- Table structure for table `map`
--

CREATE TABLE IF NOT EXISTS `map` (
  `RowID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `X` int(10) NOT NULL DEFAULT '0',
  `Y` int(10) NOT NULL DEFAULT '0',
  `MapID` int(10) unsigned NOT NULL DEFAULT '0',
  `DangerLevel` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `TileID` int(10) unsigned NOT NULL DEFAULT '1',
  `GroupID` int(10) unsigned NOT NULL DEFAULT '0',
  `PortalID` int(10) unsigned DEFAULT NULL,
  `Danger` tinyint(3) DEFAULT NULL,
  `ModCode` text NOT NULL,
  `NewTile` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`RowID`),
  KEY `GroupID` (`GroupID`),
  KEY `Location` (`X`,`Y`,`MapID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=657874 ;

-- --------------------------------------------------------

--
-- Table structure for table `mapdata`
--

CREATE TABLE IF NOT EXISTS `mapdata` (
  `id` varchar(10) NOT NULL DEFAULT '',
  `x` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `y` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `mapid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `background_tileid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `foreground_tileid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `spawnid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `portalid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `dager` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mapid_background`
--

CREATE TABLE IF NOT EXISTS `mapid_background` (
  `MapID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Image` char(25) DEFAULT NULL,
  `Name` char(150) DEFAULT NULL,
  `Scale` tinyint(3) unsigned NOT NULL DEFAULT '4',
  `Version` bigint(20) unsigned NOT NULL DEFAULT '0',
  `TileID` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`MapID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

-- --------------------------------------------------------

--
-- Table structure for table `merchant`
--

CREATE TABLE IF NOT EXISTS `merchant` (
  `MerchantID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` char(25) DEFAULT NULL,
  PRIMARY KEY (`MerchantID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=281 ;

-- --------------------------------------------------------

--
-- Table structure for table `merchantdata`
--

CREATE TABLE IF NOT EXISTS `merchantdata` (
  `LinkID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `MerchantID` int(10) unsigned NOT NULL DEFAULT '0',
  `ItemID` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`LinkID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=781 ;

-- --------------------------------------------------------

--
-- Table structure for table `merge_filter`
--

CREATE TABLE IF NOT EXISTS `merge_filter` (
  `RowID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `MergeID` int(10) unsigned NOT NULL DEFAULT '0',
  `FilterID` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`RowID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `mondefault`
--

CREATE TABLE IF NOT EXISTS `mondefault` (
  `Level` bigint(4) NOT NULL AUTO_INCREMENT,
  `Experience` bigint(15) DEFAULT NULL,
  `AL` bigint(5) DEFAULT NULL,
  `Min` bigint(5) DEFAULT NULL,
  `Max` bigint(5) DEFAULT NULL,
  `Health` bigint(5) DEFAULT NULL,
  `Attack Skill` bigint(4) DEFAULT NULL,
  `Defence Skill` bigint(4) DEFAULT NULL,
  `Items` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`Level`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=551 ;

-- --------------------------------------------------------

--
-- Table structure for table `monster`
--

CREATE TABLE IF NOT EXISTS `monster` (
  `SpawnID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `MonsterID` int(10) unsigned NOT NULL DEFAULT '0',
  `AgressorID` int(10) unsigned NOT NULL DEFAULT '0',
  `AgressorTimeout` datetime DEFAULT NULL,
  `HealthCur` int(10) unsigned NOT NULL DEFAULT '0',
  `X` int(10) unsigned NOT NULL DEFAULT '0',
  `Y` int(10) unsigned NOT NULL DEFAULT '0',
  `MapID` int(10) unsigned NOT NULL DEFAULT '0',
  `BattleText` blob,
  `SpawnTime` datetime DEFAULT NULL,
  `DecayTime` datetime DEFAULT NULL,
  `Killer_CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  `CreateDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`SpawnID`),
  KEY `SpawnID` (`SpawnID`),
  KEY `Location` (`X`,`Y`,`MapID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7108037 ;

-- --------------------------------------------------------

--
-- Table structure for table `monsterspell`
--

CREATE TABLE IF NOT EXISTS `monsterspell` (
  `MSID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Expire` datetime DEFAULT NULL,
  `SourceType` enum('Monster','Player','Item') DEFAULT NULL,
  `SourceID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `SpellID` int(10) unsigned NOT NULL DEFAULT '0',
  `SpawnID` int(10) unsigned NOT NULL DEFAULT '0',
  `Adjustment` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`MSID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `monster_base`
--

CREATE TABLE IF NOT EXISTS `monster_base` (
  `MonsterID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(25) NOT NULL DEFAULT '',
  `LootGroup` int(10) unsigned NOT NULL DEFAULT '0',
  `WeaponMin` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `WeaponMax` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `WeaponSkill` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `AL` mediumint(3) unsigned NOT NULL DEFAULT '0',
  `BaseHealth` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `WeaponType` varchar(25) NOT NULL DEFAULT '',
  `Level` mediumint(8) unsigned zerofill NOT NULL DEFAULT '00000000',
  `TileID` int(11) NOT NULL DEFAULT '0',
  `MaxItems` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `XP` bigint(20) NOT NULL DEFAULT '0',
  `Hostile` enum('Y','N') NOT NULL DEFAULT 'Y',
  `TELL_EnterArea` text NOT NULL,
  `MOD_EnterArea` text NOT NULL,
  `AdminNote` varchar(255) NOT NULL DEFAULT '',
  `QuestID` int(10) unsigned NOT NULL DEFAULT '0',
  `MeleeD` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `MerchantID` int(10) unsigned NOT NULL DEFAULT '0',
  `Family` varchar(15) NOT NULL DEFAULT '',
  `CreateDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Poison` enum('Y','N') NOT NULL DEFAULT 'N',
  `PsnTurns` int(2) NOT NULL DEFAULT '0',
  `PsnDmg` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`MonsterID`),
  KEY `MonsterID` (`MonsterID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1237 ;

-- --------------------------------------------------------

--
-- Table structure for table `monster_filter`
--

CREATE TABLE IF NOT EXISTS `monster_filter` (
  `RowID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FilterID` int(10) unsigned NOT NULL DEFAULT '0',
  `MonsterID` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`RowID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=101 ;

-- --------------------------------------------------------

--
-- Table structure for table `monster_groupdata`
--

CREATE TABLE IF NOT EXISTS `monster_groupdata` (
  `GroupID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` char(30) NOT NULL DEFAULT '',
  `Hostile` enum('Y','N') NOT NULL DEFAULT 'Y',
  `MaxSpawn` int(10) unsigned NOT NULL DEFAULT '1',
  `CreateDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`GroupID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=915 ;

-- --------------------------------------------------------

--
-- Table structure for table `monster_groups`
--

CREATE TABLE IF NOT EXISTS `monster_groups` (
  `GroupID` int(10) unsigned NOT NULL DEFAULT '0',
  `MonsterID` int(10) unsigned NOT NULL DEFAULT '0',
  `Name` char(30) DEFAULT NULL,
  KEY `MonLookup` (`GroupID`,`MonsterID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `NewsID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Text` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`NewsID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6394 ;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `NoteID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ShortNote` varchar(255) NOT NULL DEFAULT '',
  `LongNote` text NOT NULL,
  PRIMARY KEY (`NoteID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

--
-- Table structure for table `overlay`
--

CREATE TABLE IF NOT EXISTS `overlay` (
  `RowID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `X` int(10) unsigned NOT NULL DEFAULT '0',
  `Y` int(10) unsigned NOT NULL DEFAULT '0',
  `MapID` int(10) unsigned NOT NULL DEFAULT '0',
  `DangerLevel` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `TileID` int(10) unsigned NOT NULL DEFAULT '1',
  `GroupID` int(10) unsigned NOT NULL DEFAULT '0',
  `PortalID` int(10) unsigned NOT NULL DEFAULT '0',
  `Description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`RowID`),
  KEY `GroupID` (`GroupID`),
  KEY `Location` (`X`,`Y`,`MapID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=85527 ;

-- --------------------------------------------------------

--
-- Table structure for table `overlay_clan`
--

CREATE TABLE IF NOT EXISTS `overlay_clan` (
  `RowID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `X` int(10) unsigned NOT NULL DEFAULT '0',
  `Y` int(10) unsigned NOT NULL DEFAULT '0',
  `MapID` int(10) unsigned NOT NULL DEFAULT '0',
  `TileID` int(10) unsigned NOT NULL DEFAULT '1',
  `PortalID` int(10) unsigned NOT NULL DEFAULT '0',
  `Description` char(255) NOT NULL DEFAULT '',
  `ClanID` int(11) NOT NULL DEFAULT '0',
  `Armor` int(10) unsigned NOT NULL DEFAULT '250',
  PRIMARY KEY (`RowID`),
  KEY `Location` (`X`,`Y`,`MapID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12173 ;

-- --------------------------------------------------------

--
-- Table structure for table `overlay_corpse`
--

CREATE TABLE IF NOT EXISTS `overlay_corpse` (
  `CorpseID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  `CreateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `X` int(10) unsigned NOT NULL DEFAULT '0',
  `Y` int(10) unsigned NOT NULL DEFAULT '0',
  `MapID` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`CorpseID`),
  KEY `Location` (`X`,`Y`,`MapID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38933 ;

-- --------------------------------------------------------

--
-- Table structure for table `pk_battledata`
--

CREATE TABLE IF NOT EXISTS `pk_battledata` (
  `BattleID` int(10) unsigned NOT NULL DEFAULT '0',
  `CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  `TargetID` int(10) unsigned NOT NULL DEFAULT '0',
  `Damage` int(10) unsigned NOT NULL DEFAULT '0',
  `Actions` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `Engaged` enum('Y','N') DEFAULT 'Y',
  `ActionTime` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pk_data`
--

CREATE TABLE IF NOT EXISTS `pk_data` (
  `PKBID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `BattleID` int(10) unsigned NOT NULL DEFAULT '0',
  `X` int(10) unsigned NOT NULL DEFAULT '0',
  `Y` int(10) unsigned NOT NULL DEFAULT '0',
  `MapID` int(10) unsigned NOT NULL DEFAULT '0',
  `BattleText` text,
  PRIMARY KEY (`PKBID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `portals`
--

CREATE TABLE IF NOT EXISTS `portals` (
  `PortalID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` char(50) DEFAULT NULL,
  `TargetX` int(10) unsigned NOT NULL DEFAULT '0',
  `TargetY` int(10) unsigned NOT NULL DEFAULT '0',
  `TargetMapID` int(10) unsigned NOT NULL DEFAULT '0',
  `Level` int(10) unsigned NOT NULL DEFAULT '0',
  `Subscriber` enum('Y','N') NOT NULL DEFAULT 'N',
  `Comments` char(255) DEFAULT NULL,
  PRIMARY KEY (`PortalID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=667 ;

-- --------------------------------------------------------

--
-- Table structure for table `questdata`
--

CREATE TABLE IF NOT EXISTS `questdata` (
  `QuestID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL DEFAULT '',
  `MOD_ItemGive` text NOT NULL,
  `TELL_ItemGive` text NOT NULL,
  `TELL_QuestGive` text NOT NULL,
  `Take_ItemID` int(10) unsigned NOT NULL DEFAULT '0',
  `Return_ItemID` int(10) unsigned NOT NULL DEFAULT '0',
  `MerchantID` int(10) unsigned NOT NULL DEFAULT '0',
  `Givable` enum('Y','N') NOT NULL DEFAULT 'N',
  `QuestTimer` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `CreateDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `MinLevel` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `MaxLevel` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`QuestID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=577 ;

-- --------------------------------------------------------

--
-- Table structure for table `quest_filter`
--

CREATE TABLE IF NOT EXISTS `quest_filter` (
  `RowID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FilterID` int(10) unsigned NOT NULL DEFAULT '0',
  `QuestID` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`RowID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `races`
--

CREATE TABLE IF NOT EXISTS `races` (
  `RaceID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` char(25) DEFAULT NULL,
  `Image` char(25) DEFAULT 'char.gif',
  `Description` char(255) DEFAULT NULL,
  PRIMARY KEY (`RaceID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE IF NOT EXISTS `skills` (
  `SkillID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(25) NOT NULL DEFAULT '',
  `ParentID` int(10) unsigned NOT NULL DEFAULT '0',
  `Cost` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`SkillID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

-- --------------------------------------------------------

--
-- Table structure for table `skill_curve`
--

CREATE TABLE IF NOT EXISTS `skill_curve` (
  `Inc` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `XP` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Inc`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `spawns`
--

CREATE TABLE IF NOT EXISTS `spawns` (
  `SpawnID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `X` int(10) unsigned NOT NULL DEFAULT '0',
  `Y` int(10) unsigned NOT NULL DEFAULT '0',
  `MapID` int(10) unsigned NOT NULL DEFAULT '0',
  `GroupID` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`SpawnID`),
  KEY `X` (`X`),
  KEY `Y` (`Y`),
  KEY `MapID` (`MapID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `spawn_filter`
--

CREATE TABLE IF NOT EXISTS `spawn_filter` (
  `RowID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FilterID` int(10) unsigned NOT NULL DEFAULT '0',
  `SpawnID` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`RowID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

-- --------------------------------------------------------

--
-- Table structure for table `spellbook`
--

CREATE TABLE IF NOT EXISTS `spellbook` (
  `SBID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SpellID` int(10) unsigned NOT NULL DEFAULT '0',
  `CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`SBID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `spells`
--

CREATE TABLE IF NOT EXISTS `spells` (
  `SpellID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `ModCode` text,
  PRIMARY KEY (`SpellID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=305 ;

-- --------------------------------------------------------

--
-- Table structure for table `storyline`
--

CREATE TABLE IF NOT EXISTS `storyline` (
  `StoryID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Date` datetime DEFAULT NULL,
  `Name` varchar(80) DEFAULT NULL,
  `Message` text,
  PRIMARY KEY (`StoryID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `text`
--

CREATE TABLE IF NOT EXISTS `text` (
  `TextID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Keyword` varchar(25) NOT NULL DEFAULT '',
  `Body` text NOT NULL,
  PRIMARY KEY (`TextID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tiledata`
--

CREATE TABLE IF NOT EXISTS `tiledata` (
  `TileID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Image` varchar(100) NOT NULL DEFAULT '',
  `Name` varchar(60) NOT NULL DEFAULT '',
  `Keywords` varchar(255) DEFAULT NULL,
  `Walkable` enum('Y','N') DEFAULT 'Y',
  `CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  `ImageType` varchar(25) NOT NULL DEFAULT '',
  `Clan` enum('Y','N') NOT NULL DEFAULT 'N',
  `Cost` int(10) unsigned NOT NULL DEFAULT '0',
  `ModCode` text NOT NULL,
  `NewTile` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`TileID`),
  KEY `TileID` (`TileID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11856 ;

-- --------------------------------------------------------

--
-- Table structure for table `town`
--

CREATE TABLE IF NOT EXISTS `town` (
  `TownID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` char(25) DEFAULT NULL,
  PRIMARY KEY (`TownID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `CoreID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `Username` varchar(25) DEFAULT NULL,
  `ClanID` int(10) unsigned NOT NULL DEFAULT '0',
  `UnassignedXP` bigint(20) unsigned NOT NULL DEFAULT '0',
  `Coins` bigint(30) unsigned NOT NULL DEFAULT '500',
  `X` int(10) unsigned NOT NULL DEFAULT '289',
  `Y` int(10) unsigned NOT NULL DEFAULT '284',
  `MapID` int(10) unsigned NOT NULL DEFAULT '23',
  `XP` bigint(20) unsigned NOT NULL DEFAULT '0',
  `Level` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `LastAccessed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Death_X` int(10) unsigned NOT NULL DEFAULT '289',
  `Death_Y` int(10) unsigned NOT NULL DEFAULT '284',
  `Death_MapID` int(10) unsigned NOT NULL DEFAULT '23',
  `HealthCur` int(10) unsigned NOT NULL DEFAULT '25',
  `HealthMax` int(10) unsigned NOT NULL DEFAULT '25',
  `FellowID` int(11) unsigned NOT NULL DEFAULT '0',
  `ManaCur` int(10) unsigned NOT NULL DEFAULT '25',
  `ManaMax` int(10) unsigned NOT NULL DEFAULT '25',
  `SkillCredits` tinyint(3) unsigned NOT NULL DEFAULT '5',
  `UserPic` varchar(25) NOT NULL DEFAULT 'razm.gif',
  `BankedCoins` bigint(30) unsigned NOT NULL DEFAULT '0',
  `Confirm` enum('Y','N') NOT NULL DEFAULT 'Y',
  `UserID` int(10) unsigned NOT NULL DEFAULT '0',
  `Age` bigint(20) unsigned NOT NULL DEFAULT '5475',
  `WID` int(11) NOT NULL DEFAULT '0',
  `Turns` int(10) unsigned NOT NULL DEFAULT '750',
  `ChatRows` tinyint(3) unsigned NOT NULL DEFAULT '5',
  `ChatType` enum('public','clan') NOT NULL DEFAULT 'public',
  `ClanFlags` varchar(25) NOT NULL DEFAULT '',
  `ClanPart` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ClanFlag_Change` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Portal_X` int(10) unsigned NOT NULL DEFAULT '289',
  `Portal_Y` int(10) unsigned NOT NULL DEFAULT '284',
  `Portal_MapID` int(10) unsigned NOT NULL DEFAULT '23',
  `Actions` int(10) unsigned NOT NULL DEFAULT '100',
  `Tie_X` int(10) unsigned NOT NULL DEFAULT '289',
  `Tie_Y` int(10) unsigned NOT NULL DEFAULT '284',
  `Tie_MapID` int(10) unsigned NOT NULL DEFAULT '23',
  `ForumType` enum('public','clan') NOT NULL DEFAULT 'public',
  `Deaths` int(10) unsigned NOT NULL DEFAULT '0',
  `Notify_Email` varchar(50) NOT NULL DEFAULT '',
  `DispLog` enum('Y','N') NOT NULL DEFAULT 'Y',
  `Admin` enum('Y','N') NOT NULL DEFAULT 'N',
  `Slay` enum('Y','N') NOT NULL DEFAULT 'Y',
  `LastTell` int(10) unsigned NOT NULL DEFAULT '0',
  `PK` enum('Y','N') NOT NULL DEFAULT 'N',
  `PK_Kills` int(10) unsigned NOT NULL DEFAULT '0',
  `PK_Deaths` int(10) unsigned NOT NULL DEFAULT '0',
  `PK_Hit` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Subscriber` enum('Y','N') NOT NULL DEFAULT 'N',
  `Advertisment` enum('Y','N') NOT NULL DEFAULT 'Y',
  `FundDate` date NOT NULL DEFAULT '0000-00-00',
  `InvenSize` tinyint(3) NOT NULL DEFAULT '40',
  `InvenIncDate` date DEFAULT '0000-00-00',
  `cloak` enum('Y','N') DEFAULT 'N',
  `Stealth` enum('Y','N') DEFAULT 'N',
  `StealthDate` date DEFAULT '0000-00-00',
  `Attract` enum('Y','N') DEFAULT 'N',
  `AttractDate` date DEFAULT '0000-00-00',
  `PsnRemain` int(5) NOT NULL DEFAULT '0',
  `PsnDmg` int(5) NOT NULL DEFAULT '0',
  `Race` varchar(25) DEFAULT 'Human',
  `Strength` bigint(20) NOT NULL DEFAULT '0',
  `Intelligence` bigint(20) NOT NULL DEFAULT '0',
  `Dexterity` bigint(20) NOT NULL DEFAULT '0',
  `Agility` bigint(20) NOT NULL DEFAULT '0',
  `Wisdom` bigint(20) NOT NULL DEFAULT '0',
  `Constitution` bigint(20) NOT NULL DEFAULT '0',
  `Luck` bigint(20) NOT NULL DEFAULT '0',
  `CreateDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`CoreID`),
  KEY `MapID` (`MapID`),
  KEY `X` (`X`),
  KEY `Y` (`Y`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11961 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL DEFAULT '',
  `passhash` varchar(40) NOT NULL DEFAULT '',
  `privelages` int(4) NOT NULL DEFAULT '0',
  `sessname` varchar(10) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `userspell`
--

CREATE TABLE IF NOT EXISTS `userspell` (
  `USID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Expire` datetime DEFAULT NULL,
  `SourceType` enum('Monster','Player','Item') DEFAULT NULL,
  `SourceID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `SpellID` int(10) unsigned NOT NULL DEFAULT '0',
  `CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  `Adjustment` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`USID`),
  KEY `CoreID` (`CoreID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_base`
--

CREATE TABLE IF NOT EXISTS `user_base` (
  `UserID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Email` varchar(50) DEFAULT NULL,
  `Password` varchar(50) DEFAULT NULL,
  `Subscriber` enum('Y','N') NOT NULL DEFAULT 'N',
  `FundDate` date NOT NULL DEFAULT '0000-00-00',
  `Locked` varchar(255) DEFAULT NULL,
  `AdminAuth` enum('Y','N') NOT NULL DEFAULT 'N',
  `Verify` varchar(25) NOT NULL DEFAULT '',
  `LastAccessed` datetime DEFAULT NULL,
  `IP_Number_Full` varchar(15) DEFAULT NULL,
  `IP_Number_Part` varchar(11) DEFAULT NULL,
  `Administrator` enum('Y','N') NOT NULL DEFAULT 'N',
  `DeltoriaID` int(10) unsigned NOT NULL DEFAULT '0',
  `Manager` enum('Y','N') NOT NULL DEFAULT 'N',
  `TileBase` varchar(255) NOT NULL DEFAULT './images/tiles',
  `CreateDate` datetime DEFAULT NULL,
  `Referrer` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`UserID`),
  KEY `UserID` (`UserID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32363 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_block`
--

CREATE TABLE IF NOT EXISTS `user_block` (
  `CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  `BlockID` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_deaths`
--

CREATE TABLE IF NOT EXISTS `user_deaths` (
  `DeathID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  `MonsterID` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`DeathID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=214762 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_kills`
--

CREATE TABLE IF NOT EXISTS `user_kills` (
  `LogID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `MonsterID` int(11) NOT NULL DEFAULT '0',
  `CoreID` int(11) NOT NULL DEFAULT '0',
  `Counter` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`LogID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=132713 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE IF NOT EXISTS `user_log` (
  `CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  `TS` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Type` varchar(25) DEFAULT NULL,
  `Message` text,
  `LogID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`LogID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=147661 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_map`
--

CREATE TABLE IF NOT EXISTS `user_map` (
  `UserMapID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `BaseMapID` int(10) unsigned NOT NULL DEFAULT '0',
  `MapImage` varchar(64) NOT NULL DEFAULT '',
  `MinX` int(10) unsigned NOT NULL DEFAULT '0',
  `MinY` int(10) unsigned NOT NULL DEFAULT '0',
  `MaxX` int(10) unsigned NOT NULL DEFAULT '0',
  `MaxY` int(10) unsigned NOT NULL DEFAULT '0',
  `MapDescription` varchar(128) DEFAULT NULL,
  `Scale` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserMapID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_pin`
--

CREATE TABLE IF NOT EXISTS `user_pin` (
  `PinID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  `ClanID` int(11) DEFAULT NULL,
  `X` int(10) unsigned NOT NULL DEFAULT '0',
  `Y` int(10) unsigned NOT NULL DEFAULT '0',
  `MapID` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `Description` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`PinID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4852 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_quest`
--

CREATE TABLE IF NOT EXISTS `user_quest` (
  `UQID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  `Quest` varchar(25) NOT NULL DEFAULT '',
  `QuestTimer` datetime DEFAULT NULL,
  PRIMARY KEY (`UQID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=140866 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_security`
--

CREATE TABLE IF NOT EXISTS `user_security` (
  `sec_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `coreid` int(10) unsigned NOT NULL DEFAULT '0',
  `page` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`sec_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=281 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_skills`
--

CREATE TABLE IF NOT EXISTS `user_skills` (
  `RowID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SkillID` int(10) unsigned NOT NULL DEFAULT '0',
  `CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  `Level` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`RowID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=84208 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_values`
--

CREATE TABLE IF NOT EXISTS `user_values` (
  `uvid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `CoreID` int(10) unsigned NOT NULL DEFAULT '0',
  `Keyword` char(15) DEFAULT NULL,
  `Value` char(255) DEFAULT NULL,
  PRIMARY KEY (`uvid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `warriors`
--

CREATE TABLE IF NOT EXISTS `warriors` (
  `WarriorID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(25) NOT NULL DEFAULT '0',
  `Strength` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `Armor` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `TrainCost` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `TileID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`WarriorID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=4 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
