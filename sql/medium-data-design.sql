CREATE TABLE profile (
	-- this creates the attribute for the primary key
	-- not null means the attribute is required!
	profileId BINARY(16) NOT NULL,
	profileActivationToken CHAR(32),
	profileHandle VARCHAR(32) NOT NULL,
	-- to make sure duplicate data cannot exist, create a unique index
	profileEmail VARCHAR(128) NOT NULL,
	-- to make something optional, exclude the not null
	profileHash	CHAR(128) NOT NULL,
	profileSalt CHAR(64) NOT NULL,
	UNIQUE(profileEmail),
	UNIQUE(profileHandle),
	-- this officiates the primary key for the entity
	PRIMARY KEY(profileId)
);

-- create the story entity
CREATE TABLE story (
	-- this is for yet another primary key...
	storyId BINARY(16) NOT NULL,
	-- this is for a foreign key
	storyProfileId BINARY(16) NOT NULL,
	storyContent VARCHAR(140) NOT NULL,
	storyDateTime DATETIME(6) NOT NULL,
	-- this creates an index before making a foreign key
	INDEX(storyProfileId),
	-- this creates the actual foreign key relation
	FOREIGN KEY(storyProfileId) REFERENCES profile(profileId),
	-- and finally create the primary key
	PRIMARY KEY(storyId)
);

-- create the clap entity (a try hard entity from an m-to-n for profile --> story)
CREATE TABLE clap (
	clapId BINARY (16) NOT NULL,
	-- these are still foreign keys
	clapProfileId BINARY(16) NOT NULL,
	clapStoryId BINARY(16) NOT NULL,
	-- index the foreign keys
	INDEX(clapProfileId),
	INDEX(clapStoryId),
	-- create the foreign key relations
	FOREIGN KEY(clapProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(clapStoryId) REFERENCES story (storyId),
	-- finally, create a composite foreign key with the two foreign keys
	PRIMARY KEY(clapId)
);

SHOW TABLES;

DESCRIBE story;

DESCRIBE clap;

DROP TABLE clap;

SHOW TABLES;

ALTER TABLE story MODIFY storyContent VARCHAR(65535);

ALTER TABLE story MODIFY storyContent VARCHAR(65534);

-- create the clap entity (a try hard entity from an m-to-n for profile --> story)
CREATE TABLE clap (
	clapId BINARY (16) NOT NULL,
	-- these are still foreign keys
	clapProfileId BINARY(16) NOT NULL,
	clapStoryId BINARY(16) NOT NULL,
	-- index the foreign keys
	INDEX(clapProfileId),
	INDEX(clapStoryId),
	-- create the foreign key relations
	FOREIGN KEY(clapProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(clapStoryId) REFERENCES story (storyId),
	-- finally, create a composite foreign key with the two foreign keys
	PRIMARY KEY(clapId)
);

SHOW TABLES;

DESCRIBE profile;

SELECT profileId
FROM profile;

SELECT profileEmail, profileHandle, storyContent
FROM profile INNER JOIN story
		ON profile.profileId = story.storyProfileId;

ALTER TABLE story
	MODIFY storyContent VARCHAR(65000) NOT NULL;

DESCRIBE story;

insert into profile
(profileId, profileActivationToken, profileHandle, profileEmail, profileHash, profileSalt)
values (9654854595189126, 65390855621938097825421540366924, '@ilovedoughnuts', 'donut@donutlover.com', 06282617957858715423902309772789542725981779975766144626715655018560391875138276839417574997416327597823383729890871386152019573405702267434783628774252946895891586495037720537526931005140092504738979945002287
	, 6117087345129887346912801045582763207426289743929871164615513243);

select profileId
from profile;

insert into profile
(profileId, profileActivationToken, profileHandle, profileEmail, profileHash, profileSalt)
values (8495039584732123, 49586734567856943345697857432856, '@onecoolcat', 'cat@sunglassesemoji.com', 0166747954782287685783566292084401741500135210863660095966319881483650579283497763203367471183841539810234670227816247364141461734660260798198141366253281645738641392550006169319901672529246703790137948693861445915, 3406059302940694039687104860435687958435687432345869705496875496);

select profileId
from profile;

describe story;

insert into story
(storyId, storyProfileId, storyContent, storyDateTime)
values (4759492039485325, 9654854595189126, 'This is my story content.', 100417);

select storyId
from story;

SELECT profileEmail, profileHandle, storyContent
FROM profile INNER JOIN story
		ON profile.profileId = story.storyProfileId;


