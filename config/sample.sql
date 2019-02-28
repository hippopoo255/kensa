-- MySQL dump 10.16  Distrib 10.1.33-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: sample
-- ------------------------------------------------------
-- Server version	10.1.33-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `m_c_cate`
--

DROP TABLE IF EXISTS `m_c_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_c_cate` (
  `id` int(2) unsigned zerofill NOT NULL COMMENT '番号',
  `name` varchar(10) NOT NULL COMMENT '検査名',
  `background-color` varchar(10) DEFAULT NULL COMMENT 'ボタンの背景色',
  `img` varchar(50) DEFAULT NULL,
  `tableName` varchar(50) DEFAULT NULL COMMENT 'テーブル名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='アイコンファイル名';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_c_cate`
--

LOCK TABLES `m_c_cate` WRITE;
/*!40000 ALTER TABLE `m_c_cate` DISABLE KEYS */;
INSERT INTO `m_c_cate` VALUES (01,'防災','#b22222','<i class=\"fas fa-fire-extinguisher\"></i>','t_total_bousai'),(02,'食品','#556b2f','<i class=\"fab fa-apple\"></i>','t_total_shokuhin'),(03,'販売期限','#2f4f4f','<i class=\"far fa-calendar-alt\"></i>','t_total_hanbaikigen'),(04,'産業廃棄物','#996600','<i class=\"fas fa-smile\"></i>','t_total_sanpai');
/*!40000 ALTER TABLE `m_c_cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_c_comment`
--

DROP TABLE IF EXISTS `m_c_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_c_comment` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `comment` varchar(50) NOT NULL COMMENT '指摘内容',
  `headNum` int(2) unsigned zerofill NOT NULL COMMENT '設問番号',
  `cateId` int(2) unsigned zerofill NOT NULL COMMENT '検査カテゴリー番号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_c_comment`
--

LOCK TABLES `m_c_comment` WRITE;
/*!40000 ALTER TABLE `m_c_comment` DISABLE KEYS */;
INSERT INTO `m_c_comment` VALUES (00001,'非常扉前物品',01,01),(00002,'防火シャッター降下',01,01),(00003,'竪穴区画内物品',01,01),(00004,'防火扉前物品',01,01),(00005,'避難器具前物品',01,01),(00006,'階段室内物品',01,01),(00007,'幅員不足（はみ出し陳列）',02,01),(00008,'幅員不足（長時間物品存置）',02,01),(00009,'視認障害',03,01),(00010,'不点灯',03,01),(00011,'散水障害',04,01),(00012,'消火器前物品',05,01),(00013,'散水栓前物品',05,01),(00014,'消火栓前物品',05,01),(00015,'排煙窓前物品',05,01),(00016,'排煙装置操作障害',05,01),(00017,'排煙口下物品存置',05,01),(00018,'タコ足配線',06,01),(00019,'電力超過',06,01),(00020,'コード損傷/劣化',06,01),(00022,'警笛未携帯',07,01),(00023,'自主検査チェック表に未記載箇所あり',07,01),(00024,'温度管理プレート未貼付',01,02),(00025,'冷ケースが不適切な温度表示',01,02),(00026,'温度管理の必要な商品に温度計未設置',01,02),(00027,'温度管理表に記載漏れあり',01,02),(00028,'プレート記載の温度が不適切',01,02),(00029,'原材料表示漏れ',02,02),(00030,'防ばい剤使用のPOPもれ',02,02),(00031,'原産地表記もれ',02,02),(00032,'POPの原産地表記に相違',02,02),(00033,'床が汚い',03,02),(00034,'棚が汚い',03,02),(00035,'冷ケースが汚い',03,02),(00036,'冷ケースのフィルターが汚い',03,02),(00037,'賞味期限切れ',04,02),(00038,'消費期限切れ',04,02),(00039,'値引きルール違反',04,02),(00040,'衛生責任者プレート未掲示',05,02),(00041,'衛生責任者プレート未更新',05,02),(00042,'営業許可証有効期限切れ',05,02),(00043,'酒類販売表示のPOP不足',05,02),(00044,'レジPOP未掲示',05,02),(00045,'レジPOPの記載が未更新',05,02),(00046,'懐中電灯未携帯',07,01);
/*!40000 ALTER TABLE `m_c_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_c_head`
--

DROP TABLE IF EXISTS `m_c_head`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_c_head` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `num` int(2) unsigned zerofill NOT NULL COMMENT '番号',
  `hline` varchar(50) NOT NULL COMMENT '表題',
  `cateId` int(2) unsigned zerofill NOT NULL COMMENT '検査カテゴリー番号',
  `rank` enum('A','B','C','D') NOT NULL COMMENT 'ランク',
  PRIMARY KEY (`id`),
  KEY `fk-cateId` (`cateId`),
  KEY `fk-rank` (`rank`),
  CONSTRAINT `fk-cateId` FOREIGN KEY (`cateId`) REFERENCES `m_c_cate` (`id`),
  CONSTRAINT `fk-rank` FOREIGN KEY (`rank`) REFERENCES `m_c_point` (`rank`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_c_head`
--

LOCK TABLES `m_c_head` WRITE;
/*!40000 ALTER TABLE `m_c_head` DISABLE KEYS */;
INSERT INTO `m_c_head` VALUES (00001,01,'最重要項目',01,'A'),(00002,02,'幅員不足',01,'B'),(00003,03,'誘導灯',01,'B'),(00004,04,'スプリンクラー',01,'B'),(00005,05,'その他設備',01,'B'),(00006,06,'電気系統',01,'B'),(00007,07,'自衛消防組織',01,'C'),(00008,01,'温度管理',02,'A'),(00009,05,'許認可',02,'B'),(00010,03,'クリンネス',02,'B'),(00011,04,'賞味期限',02,'B'),(00012,02,'食品表示',02,'A');
/*!40000 ALTER TABLE `m_c_head` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_c_point`
--

DROP TABLE IF EXISTS `m_c_point`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_c_point` (
  `rank` enum('A','B','C','D') NOT NULL COMMENT 'ランク',
  `point` int(2) NOT NULL COMMENT '減点',
  PRIMARY KEY (`rank`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_c_point`
--

LOCK TABLES `m_c_point` WRITE;
/*!40000 ALTER TABLE `m_c_point` DISABLE KEYS */;
INSERT INTO `m_c_point` VALUES ('A',-10),('B',-5),('C',-3),('D',-1);
/*!40000 ALTER TABLE `m_c_point` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_daterule`
--

DROP TABLE IF EXISTS `m_daterule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_daterule` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT 'id',
  `categoryCode` int(6) NOT NULL COMMENT '分類コード',
  `nebikiPoint` varchar(15) DEFAULT NULL COMMENT '値引き開始起算点',
  `kyoyasuPoint` varchar(15) DEFAULT NULL COMMENT '驚安開始起算点',
  `tekkyoPoint` varchar(15) DEFAULT NULL COMMENT '撤去開始起算点',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_daterule`
--

LOCK TABLES `m_daterule` WRITE;
/*!40000 ALTER TABLE `m_daterule` DISABLE KEYS */;
INSERT INTO `m_daterule` VALUES (00001,1001,'-1 month','-10 day','-3 day'),(00002,1002,'-2 month','','-1 month');
/*!40000 ALTER TABLE `m_daterule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_dep`
--

DROP TABLE IF EXISTS `m_dep`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_dep` (
  `id` int(4) unsigned zerofill NOT NULL COMMENT '部署ID',
  `name` varchar(50) NOT NULL COMMENT '部署名',
  `comId` int(2) unsigned zerofill NOT NULL COMMENT '企業ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_dep`
--

LOCK TABLES `m_dep` WRITE;
/*!40000 ALTER TABLE `m_dep` DISABLE KEYS */;
INSERT INTO `m_dep` VALUES (0205,'検査部',00),(0305,'改善部',00);
/*!40000 ALTER TABLE `m_dep` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_honbu`
--

DROP TABLE IF EXISTS `m_honbu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_honbu` (
  `id` int(3) unsigned zerofill NOT NULL,
  `name` varchar(50) NOT NULL,
  `marketStyle` enum('PDQ','NM','ドイト','ライラック') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_honbu`
--

LOCK TABLES `m_honbu` WRITE;
/*!40000 ALTER TABLE `m_honbu` DISABLE KEYS */;
INSERT INTO `m_honbu` VALUES (001,'西日本営業本部',''),(002,'中日本営業本部',''),(003,'東日本営業本部','');
/*!40000 ALTER TABLE `m_honbu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_i_cate`
--

DROP TABLE IF EXISTS `m_i_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_i_cate` (
  `code` int(6) NOT NULL COMMENT '分類コード',
  `name` varchar(80) NOT NULL COMMENT '分類名',
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_i_cate`
--

LOCK TABLES `m_i_cate` WRITE;
/*!40000 ALTER TABLE `m_i_cate` DISABLE KEYS */;
INSERT INTO `m_i_cate` VALUES (1001,'お菓子'),(1002,'健康食品');
/*!40000 ALTER TABLE `m_i_cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_item`
--

DROP TABLE IF EXISTS `m_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_item` (
  `janCode` varchar(20) NOT NULL COMMENT 'JANコード',
  `name` varchar(80) NOT NULL COMMENT '商品名',
  `categoryCode` int(6) DEFAULT NULL COMMENT '分類コード',
  PRIMARY KEY (`janCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_item`
--

LOCK TABLES `m_item` WRITE;
/*!40000 ALTER TABLE `m_item` DISABLE KEYS */;
INSERT INTO `m_item` VALUES ('4912345678904','ポテトチップス',1001),('49968712','チアシード',1002);
/*!40000 ALTER TABLE `m_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_shisya`
--

DROP TABLE IF EXISTS `m_shisya`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_shisya` (
  `id` int(5) unsigned zerofill NOT NULL,
  `name` varchar(50) NOT NULL,
  `honbuId` int(3) unsigned zerofill NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-honbuId` (`honbuId`),
  CONSTRAINT `fk-honbuId` FOREIGN KEY (`honbuId`) REFERENCES `m_honbu` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_shisya`
--

LOCK TABLES `m_shisya` WRITE;
/*!40000 ALTER TABLE `m_shisya` DISABLE KEYS */;
INSERT INTO `m_shisya` VALUES (00001,'沖縄・九州支社',001),(00002,'中国・四国支社',001),(00003,'関西・東海支社',001),(00004,'東海支社',002),(00005,'北陸・甲信越支社',002),(00006,'南関東支社',003),(00007,'北関東支社',003),(00008,'東北支社',003),(00009,'北海道',003);
/*!40000 ALTER TABLE `m_shisya` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_store`
--

DROP TABLE IF EXISTS `m_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_store` (
  `id` int(5) unsigned zerofill NOT NULL,
  `name` varchar(80) DEFAULT NULL,
  `shisyaId` int(5) unsigned zerofill NOT NULL,
  `score` int(4) NOT NULL,
  `rank` varchar(1) NOT NULL COMMENT 'ランク',
  `tentyoName` varchar(50) DEFAULT NULL COMMENT '店長氏名',
  PRIMARY KEY (`id`),
  KEY `fk-shisyaId` (`shisyaId`),
  CONSTRAINT `fk-shisyaId` FOREIGN KEY (`shisyaId`) REFERENCES `m_shisya` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_store`
--

LOCK TABLES `m_store` WRITE;
/*!40000 ALTER TABLE `m_store` DISABLE KEYS */;
INSERT INTO `m_store` VALUES (00001,'テスト１号店',00001,0,'',NULL),(00002,'テスト２号店',00002,0,'',NULL),(00003,'テスト３号店',00003,0,'',NULL),(00004,'テスト４号店',00004,0,'',NULL),(00005,'テスト５号店',00005,0,'',NULL),(00006,'テスト６号店',00006,0,'',NULL),(00007,'テスト７号店',00007,0,'',NULL),(00008,'テスト８号店',00008,0,'',NULL),(00009,'テスト９号店テスト９号店駅前店',00009,0,'',NULL);
/*!40000 ALTER TABLE `m_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_user`
--

DROP TABLE IF EXISTS `m_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_user` (
  `id` int(7) unsigned zerofill NOT NULL COMMENT '社員ID',
  `name` varchar(50) NOT NULL COMMENT '社員氏名',
  `duRank` varchar(5) DEFAULT NULL COMMENT '職位',
  `depId` int(4) unsigned zerofill DEFAULT NULL COMMENT '所属部署ID',
  `area` enum('東日本','西日本') DEFAULT NULL COMMENT '所属エリア',
  `block` enum('北日本','西関東','東関東','東海','関西','九州') DEFAULT NULL COMMENT '所属ブロック',
  `post` varchar(30) DEFAULT NULL COMMENT 'ポスト',
  `pass` varchar(256) NOT NULL COMMENT '暗号化',
  PRIMARY KEY (`id`),
  KEY `fk-depId` (`depId`),
  CONSTRAINT `fk-depId` FOREIGN KEY (`depId`) REFERENCES `m_dep` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_user`
--

LOCK TABLES `m_user` WRITE;
/*!40000 ALTER TABLE `m_user` DISABLE KEYS */;
INSERT INTO `m_user` VALUES (1111111,'木村良太','SC',0205,'','','開発者','2B6C49749B0AA2255E20B3AF31E91022'),(2222222,'スタッフ二郎','SC',0305,'','','スタッフ','2B6C49749B0AA2255E20B3AF31E91022');
/*!40000 ALTER TABLE `m_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_results`
--

DROP TABLE IF EXISTS `t_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_results` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cateId` int(3) unsigned zerofill NOT NULL COMMENT '検査カテゴリーid',
  `category` varchar(10) NOT NULL COMMENT '検査名',
  `hNum` int(2) unsigned zerofill NOT NULL COMMENT '項目番号',
  `hline` varchar(50) NOT NULL COMMENT '項目',
  `comment` varchar(50) NOT NULL COMMENT '指摘内容',
  `memo` text COMMENT '備考欄',
  `point` int(2) NOT NULL COMMENT '減点数',
  `storeId` int(5) unsigned zerofill NOT NULL COMMENT '店舗番号',
  `storeName` varchar(80) NOT NULL COMMENT '店舗名',
  `shisyaId` int(5) unsigned zerofill NOT NULL COMMENT '支社番号',
  `shisyaName` varchar(50) NOT NULL COMMENT '支社名',
  `userId` int(7) unsigned zerofill NOT NULL,
  `userName` varchar(50) NOT NULL COMMENT '検査者',
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '検査時間',
  `fname` varchar(255) NOT NULL,
  `fname2` varchar(255) NOT NULL,
  `fname3` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_results`
--

LOCK TABLES `t_results` WRITE;
/*!40000 ALTER TABLE `t_results` DISABLE KEYS */;
INSERT INTO `t_results` VALUES (187,001,'防災',03,'誘導灯','視認障害','',-5,00001,'テスト１号店',00001,'沖縄・九州支社',1111111,'木村良太','2018-09-23 19:45:10','moved/00001-01-1111111-1-20180923194500.jpg','moved/00001-01-1111111-2-20180923194504.jpg','');
/*!40000 ALTER TABLE `t_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_results_dc`
--

DROP TABLE IF EXISTS `t_results_dc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_results_dc` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cateId` int(3) unsigned zerofill NOT NULL COMMENT '検査カテゴリーid',
  `category` varchar(10) NOT NULL COMMENT '検査名',
  `janCode` int(20) NOT NULL COMMENT 'JANコード',
  `itemName` varchar(80) NOT NULL COMMENT '商品名',
  `categoryCode` int(6) NOT NULL COMMENT '分類コード',
  `categoryName` varchar(80) NOT NULL COMMENT '分類名',
  `itemDate` date NOT NULL COMMENT '商品日付',
  `nebikiDate` date DEFAULT NULL COMMENT '値引開始日',
  `kyoyasuDate` date DEFAULT NULL COMMENT '驚安開始日',
  `tekkyoDate` date DEFAULT NULL COMMENT '撤去日',
  `status` varchar(10) NOT NULL COMMENT '状態',
  `count` int(4) DEFAULT NULL COMMENT '個数',
  `memo` text COMMENT '備考欄',
  `storeId` int(5) unsigned zerofill NOT NULL COMMENT '店舗番号',
  `storeName` varchar(80) NOT NULL COMMENT '店舗名',
  `shisyaId` int(5) unsigned zerofill NOT NULL COMMENT '支社番号',
  `shisyaName` varchar(50) NOT NULL COMMENT '支社名',
  `userId` int(7) unsigned zerofill NOT NULL,
  `userName` varchar(50) NOT NULL COMMENT '検査者',
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '検査時間',
  `fname` varchar(255) NOT NULL,
  `fname2` varchar(255) NOT NULL,
  `fname3` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_results_dc`
--

LOCK TABLES `t_results_dc` WRITE;
/*!40000 ALTER TABLE `t_results_dc` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_results_dc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_total_bousai`
--

DROP TABLE IF EXISTS `t_total_bousai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_total_bousai` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT 'id',
  `ytom` varchar(7) NOT NULL COMMENT '年月',
  `cateName` varchar(10) NOT NULL COMMENT '検査名',
  `storeId` int(5) unsigned zerofill NOT NULL COMMENT '店番',
  `storeName` varchar(80) NOT NULL COMMENT '店名',
  `shisyaId` int(5) unsigned zerofill NOT NULL COMMENT '支社ID',
  `shisyaName` varchar(50) NOT NULL COMMENT '支社名',
  `date` date NOT NULL COMMENT '検査日',
  `userName` varchar(50) NOT NULL COMMENT '検査者氏名',
  `totalPoint` int(5) NOT NULL COMMENT '失点;',
  `totalCount` int(5) NOT NULL COMMENT '指摘数',
  `count01` int(3) unsigned NOT NULL COMMENT '指摘数01',
  `count02` int(3) unsigned NOT NULL COMMENT '指摘数02',
  `count03` int(3) unsigned NOT NULL COMMENT '指摘数03',
  `count04` int(3) unsigned NOT NULL COMMENT '指摘数04',
  `count05` int(3) unsigned NOT NULL COMMENT '指摘数05',
  `count06` int(3) unsigned NOT NULL COMMENT '指摘数06',
  `count07` int(3) unsigned NOT NULL COMMENT '指摘数07',
  `judge01` varchar(20) NOT NULL COMMENT '判定01',
  `judge02` varchar(20) NOT NULL COMMENT '判定02',
  `judge03` varchar(20) NOT NULL COMMENT '判定02',
  `judge04` varchar(20) NOT NULL COMMENT '判定04',
  `judge05` varchar(20) NOT NULL COMMENT '判定05',
  `judge06` varchar(20) NOT NULL COMMENT '判定06',
  `judge07` varchar(20) NOT NULL COMMENT '判定07',
  `compFlag` int(1) DEFAULT NULL COMMENT '完了フラグ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_total_bousai`
--

LOCK TABLES `t_total_bousai` WRITE;
/*!40000 ALTER TABLE `t_total_bousai` DISABLE KEYS */;
INSERT INTO `t_total_bousai` VALUES (00031,'2018-09','防災',00001,'テスト１号店',00001,'沖縄・九州支社','2018-09-23','木村良太',-5,1,0,0,1,0,0,0,0,'○','○','×','○','○','○','○',NULL);
/*!40000 ALTER TABLE `t_total_bousai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_total_hanbaikigen`
--

DROP TABLE IF EXISTS `t_total_hanbaikigen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_total_hanbaikigen` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT 'id',
  `ytom` varchar(7) NOT NULL COMMENT '年月',
  `cateName` varchar(10) NOT NULL COMMENT '検査名',
  `storeId` int(5) unsigned zerofill NOT NULL COMMENT '店番',
  `storeName` varchar(80) NOT NULL COMMENT '店名',
  `shisyaId` int(5) unsigned zerofill NOT NULL COMMENT '支社ID',
  `shisyaName` varchar(50) NOT NULL COMMENT '支社名',
  `date` date NOT NULL COMMENT '検査日',
  `userName` varchar(50) NOT NULL COMMENT '検査者氏名',
  `totalItem` int(5) unsigned NOT NULL COMMENT 'アイテム数合計',
  `totalCount` int(5) NOT NULL COMMENT '指摘数',
  `item_kire` int(3) unsigned NOT NULL COMMENT 'アイテム数（期限切れ）',
  `item_tekkyo` int(3) unsigned NOT NULL COMMENT 'アイテム数（撤去ルール不備）',
  `item_kyoyasu` int(3) unsigned NOT NULL COMMENT 'アイテム数（驚安ルール不備）',
  `item_nebiki` int(3) unsigned NOT NULL COMMENT 'アイテム数（値引ルール不備）',
  `count_kire` int(3) unsigned NOT NULL COMMENT '個数（期限切れ）',
  `count_tekkyo` int(3) unsigned NOT NULL COMMENT '個数（撤去）',
  `count_kyoyasu` int(3) unsigned NOT NULL COMMENT '個数（驚安）',
  `count_nebiki` int(3) unsigned NOT NULL COMMENT '個数（値引）',
  `compFlag` int(1) DEFAULT NULL COMMENT '完了フラグ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_total_hanbaikigen`
--

LOCK TABLES `t_total_hanbaikigen` WRITE;
/*!40000 ALTER TABLE `t_total_hanbaikigen` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_total_hanbaikigen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_total_sanpai`
--

DROP TABLE IF EXISTS `t_total_sanpai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_total_sanpai` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT 'id',
  `ytom` varchar(7) NOT NULL COMMENT '年月',
  `cateName` varchar(10) NOT NULL COMMENT '検査名',
  `storeId` int(5) unsigned zerofill NOT NULL COMMENT '店番',
  `storeName` varchar(80) NOT NULL COMMENT '店名',
  `shisyaId` int(5) unsigned zerofill NOT NULL COMMENT '支社ID',
  `shisyaName` varchar(50) NOT NULL COMMENT '支社名',
  `date` date NOT NULL COMMENT '検査日',
  `userName` varchar(50) NOT NULL COMMENT '検査者氏名',
  `totalPoint` int(5) NOT NULL COMMENT '失点;',
  `totalCount` int(5) NOT NULL COMMENT '指摘数',
  `count01` int(3) unsigned NOT NULL COMMENT '指摘数01',
  `count02` int(3) unsigned NOT NULL COMMENT '指摘数02',
  `count03` int(3) unsigned NOT NULL COMMENT '指摘数03',
  `count04` int(3) unsigned NOT NULL COMMENT '指摘数04',
  `count05` int(3) unsigned NOT NULL COMMENT '指摘数05',
  `count06` int(3) unsigned NOT NULL COMMENT '指摘数06',
  `count07` int(3) unsigned NOT NULL COMMENT '指摘数07',
  `judge01` varchar(20) NOT NULL COMMENT '判定01',
  `judge02` varchar(20) NOT NULL COMMENT '判定02',
  `judge03` varchar(20) NOT NULL COMMENT '判定02',
  `judge04` varchar(20) NOT NULL COMMENT '判定04',
  `judge05` varchar(20) NOT NULL COMMENT '判定05',
  `judge06` varchar(20) NOT NULL COMMENT '判定06',
  `judge07` varchar(20) NOT NULL COMMENT '判定07',
  `compFlag` int(1) DEFAULT NULL COMMENT '完了フラグ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_total_sanpai`
--

LOCK TABLES `t_total_sanpai` WRITE;
/*!40000 ALTER TABLE `t_total_sanpai` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_total_sanpai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_total_shokuhin`
--

DROP TABLE IF EXISTS `t_total_shokuhin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_total_shokuhin` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT 'id',
  `ytom` varchar(7) NOT NULL COMMENT '検査年月',
  `cateName` varchar(30) NOT NULL COMMENT '検査名',
  `storeId` int(5) unsigned zerofill NOT NULL COMMENT '店番',
  `storeName` varchar(80) NOT NULL COMMENT '店舗名',
  `shisyaId` int(5) unsigned zerofill NOT NULL COMMENT '支社ID',
  `shisyaName` varchar(50) NOT NULL COMMENT '支社名',
  `date` date NOT NULL COMMENT '検査日',
  `userName` varchar(50) NOT NULL COMMENT '検査者氏名',
  `totalPoint` int(5) NOT NULL COMMENT '失点;',
  `totalCount` int(5) NOT NULL COMMENT '指摘数',
  `count01` int(3) unsigned NOT NULL COMMENT '指摘数01',
  `count02` int(3) unsigned NOT NULL COMMENT '指摘数02',
  `count03` int(3) unsigned NOT NULL COMMENT '指摘数03',
  `count04` int(3) unsigned NOT NULL COMMENT '指摘数04',
  `count05` int(3) unsigned NOT NULL COMMENT '指摘数05',
  `judge01` varchar(20) NOT NULL COMMENT '判定01',
  `judge02` varchar(20) NOT NULL COMMENT '判定02',
  `judge03` varchar(20) NOT NULL COMMENT '判定03',
  `judge04` varchar(20) NOT NULL COMMENT '判定04',
  `judge05` varchar(20) NOT NULL COMMENT '判定05',
  `compFlag` int(1) DEFAULT NULL COMMENT '完了フラグ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_total_shokuhin`
--

LOCK TABLES `t_total_shokuhin` WRITE;
/*!40000 ALTER TABLE `t_total_shokuhin` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_total_shokuhin` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-09-23 23:52:04
