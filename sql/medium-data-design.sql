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
