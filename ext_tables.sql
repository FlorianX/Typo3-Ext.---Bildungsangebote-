#
# Table structure for table 'tx_txbildungsangebote_cat'
#
CREATE TABLE tx_txbildungsangebote_cat (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sorting int(10) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	title tinytext,
	parent_category text,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);




#
# Table structure for table 'tx_txbildungsangebote_angebot_category_mm'
# 
#
CREATE TABLE tx_txbildungsangebote_angebot_category_mm (
  uid_local int(11) DEFAULT '0' NOT NULL,
  uid_foreign int(11) DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting int(11) DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_txbildungsangebote_angebot'
#
CREATE TABLE tx_txbildungsangebote_angebot (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sorting int(10) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	title tinytext,
	description text,
	duration tinytext,
	start int(11) DEFAULT '0' NOT NULL,
	category int(11) DEFAULT '0' NOT NULL,
	pdf tinytext,
	number tinytext,
	dayly_repeat tinyint(3) DEFAULT '0' NOT NULL,
	image text,
	events text,
	color tinytext,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);