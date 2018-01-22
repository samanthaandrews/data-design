CREATE TABLE profile (
	profileId BINARY(16) NOT NULL,
	profileActivationToken CHAR(32),
	profileHandle VARCHAR(32) NOT NULL,
	profileEmail VARCHAR(128) NOT NULL,
	profileHash CHAR(128) NOT NULL,
	profileSalt CHAR(64) NOT NULL,
	UNIQUE(profileEmail),
	UNIQUE(profileHandle),
	PRIMARY KEY(profileId)
);

CREATE TABLE story (
	storyId BINARY(16) NOT NULL,
	storyProfileId BINARY(16) NOT NULL,
	storyContent VARCHAR(30000) NOT NULL,
	storyDateTime DATETIME(6) NOT NULL,
	INDEX(storyProfileId),
	FOREIGN KEY(storyProfileId) REFERENCES profile(profileId),
	PRIMARY KEY(storyId)
);

CREATE TABLE clap (
	clapId BINARY (16) NOT NULL,
	clapProfileId BINARY(16) NOT NULL,
	clapStoryId BINARY(16) NOT NULL,
	INDEX(clapProfileId),
	INDEX(clapStoryId),
	FOREIGN KEY(clapProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(clapStoryId) REFERENCES story (storyId),
	PRIMARY KEY(clapId)
);

insert into profile(profileId, profileActivationToken, profileHandle, profileEmail, profileHash, profileSalt)
values(UNHEX(REPLACE(“b9f45031-2423-44d0-8086-325399acadb1”, “-“, “”)), 49586734567856943345697857432856, '@onecoolcat', 'cat@sunglassesemoji.com', 01667479547822876857835662920844017415001352108636600959663198814836505792834977632033674711838415398102346702278162473641414617, 3406059302940694039687104860435687958435687432345869705496875496);






