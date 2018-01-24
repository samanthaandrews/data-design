<?php
namespace Edu\Cnm\Sandrews20\DataDesign;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "../vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Cross Section of a story or article written on Medium
 *
 * This Story class can be considered an example of what data Medium stores when users create a Story.
 *
 *@author Samantha Andrews <samantharaeandrews@gmail.com>
 *@author Dylan McDonald <dmcdonald21@cnm.edu>
 *
 **/

class Story implements \JsonSerializable {
	use ValidateUuid;
	use ValidateDate;
	/**
	 * id for this story; this is the primary key
	 * @var Uuid $storyId
	 **/
	private $storyId;
	/**
	 * id of the Profile that wrote this Story; this is a foreign key
	 * @var Uuid $storyProfileId
	 **/
	private $storyProfileId;
	/**
	 * actual textual context of this Story
	 * @var string $storyContent
	 **/
	private $storyContent;
	/**
	 * date and time this story was published, in a PHP DateTime object
	 * @var \DateTime $storyDateTime
	 **/
	private $storyDateTime;

	/**constructor for this Story
	 *
	 * @param Uuid $newStoryId new story id
	 * @param Uuid $newStoryProfileId new story profile id
	 * @param string $newStoryContent new story content
	 * @param string $newStoryDateTime new story date time
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct(uuid $newStoryId, uuid $newStoryProfileId, string $newStoryContent, $newStoryDateTime = null) {
		try {
			$this->setStoryId($newStoryId);
			$this->setStoryProfileId($newStoryProfileId);
			$this->setStoryContent($newStoryContent);
			$this->setStoryDateTime($newStoryDateTime);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for story id
	 *
	 * @return Uuid value of story id
	 **/
	public function getStoryId() : Uuid {
		return ($this->storyId);
	}
	/**clap
	 * mutator method for story id
	 *
	 * @param Uuid/string $newStoryId new value of story id
	 * @throws \RangeException if $newStoryId is not 16 characters
	 * @throws \TypeError if $newStoryId is not a uuid
	 **/
	public function setStoryId( $newStoryId) : void {
		try {
			$uuid = self::validateUuid($newStoryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the story id
		$this->storyId = $uuid;
	}
	/**
	 * accessor method for story profile id
	 *
	 * @return Uuid value for story profile id
	 **/
	public function getStoryProfileId() : Uuid {
		return($this->storyProfileId);
	}

	/**
	 * mutator method for story profile id
	 *
	 * @param string | Uuid $newStoryProfileId new value of story profile id
	 * @throws \RangeException if $newProfileId is not 16 characters
	 * @throws \TypeError if $newStoryProfileId is not a uuid
	 **/
	public function setStoryProfileId( $newStoryProfileId) : void {
		try {
			$uuid = self::validateUuid($newStoryProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->storyProfileId = $uuid;
	}
	/**
	 * accessor method for story content
	 *
	 * @return string value of story content
	 **/
	public function getStoryContent() :string {
		return($this->storyContent);
	}
	/**
	 * mutator method for story content
	 *
	 * @param string $newStoryContent new value of story content
	 * @throws \InvalidArgumentException if $newStoryContent is not a string or insecure
	 * @throws \RangeException if $newStoryContent is > 60000 characters
	 * @throws \TypeError if $newStoryContent is not a string
	 **/
	public function setStoryContent(string $newStoryContent) : void {
		// verify the story content is secure
		$newStoryContent = trim($newStoryContent);
		$newStoryContent = filter_var($newStoryContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newStoryContent) === true) {
			throw(new \InvalidArgumentException("story content is empty or insecure"));
		}
		// verify the story content will fit in the database
		if(strlen($newStoryContent) > 60000) {
			throw(new \RangeException("story content too large"));
		}
		// store the story content
		$this->storyContent = $newStoryContent;
	}
	/**
	 * accessor method for story date time
	 *
	 * @return \DateTime value of story date time
	 **/
	public function getStoryDateTime() : \DateTime {
		return($this->storyDateTime);
	}
	/**
	 * mutator method for story date time
	 *
	 * @param \DateTime|string|null $newStoryDateTime story date as a DateTime object or string (or null to load the current date time)
	 * @throws \InvalidArgumentException if $newStoryDateTime is not a valid object or string
	 * @throws \RangeException if $newStoryDateTime is a date time that does not exist
	 * @throws \TypeError if $newStoryDateTime is not a \DateTime
	 **/
	public function setStoryDateTime($newStoryDateTime = null) : void {
		// base case: if the date is null, use the current date and time
		if($newStoryDateTime === null) {
			$this->storyDateTime = new \DateTime();
			return;
		}
		// store the like date using the ValidateDate trait
		try {
			$newStoryDateTime = self::validateDate($newStoryDateTime);
		} catch(\InvalidArgumentException | \RangeException | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->storyDateTime = $newStoryDateTime;
	}

	/**
	 * inserts this Story into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		// create query template
		$query = "INSERT INTO story(storyId, storyProfileId, storyContent, storyDateTime) VALUES(:storyId, :storyProfileId, :storyContent, :storyDateTime)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->storyDateTime->format("Y-m-d H:i:s.u");
		$parameters = ["tweetId" => $this->storyId->getBytes(), "storyProfileId" => $this->storyProfileId->getBytes(), "tweetContent" => $this->storyContent, "storyDateTime" => $formattedDate];
		$statement->execute($parameters);
	}
	/**
	 * deletes this Story from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// create query template
		$query = "DELETE FROM story WHERE storyId = :storyId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["storyId" => $this->storyId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * updates this Story in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		// create query template
		$query = "UPDATE story SET storyProfileId = :storyProfileId, storyContent = :storyContent, storyDateTime = :storyDateTime WHERE storyId = :storyId";
		$statement = $pdo->prepare($query);
		$formattedDate = $this->storyDateTime->format("Y-m-d H:i:s.u");
		$parameters = ["storyId" => $this->storyId->getBytes(),"storyProfileId" => $this->storyProfileId->getBytes(), "storyContent" => $this->storyContent, "storyDateTime" => $formattedDate];
		$statement->execute($parameters);
	}
	/**
	 * gets the Story by storyId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $storyId tweet id to search for
	 * @return Story|null Story found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getStoryByStoryId(\PDO $pdo, string $storyId) : ?Story {
		// sanitize the storyId before searching
		try {
			$storyId = self::validateUuid($storyId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT storyId, storyProfileId, storyContent, storyDateTime FROM story WHERE storyId = :storyId";
		$statement = $pdo->prepare($query);
		// bind the tweet id to the place holder in the template
		$parameters = ["storyId" => $storyId->getBytes()];
		$statement->execute($parameters);
		// grab the story from mySQL
		try {
			$story = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$story = new Story($row["storyId"], $row["storyProfileId"], $row["storyContent"], $row["storyDateTime"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($story);
	}
	/**
	 * gets the Story by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $tweetProfileId profile id to search by
	 * @return \SplFixedArray SplFixedArray of Tweets found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getStoryByStoryProfileId(\PDO $pdo, string  $storyProfileId) : \SPLFixedArray {
		try {
			$storyProfileId = self::validateUuid($storyProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT storyId, storyProfileId, storyContent, storyDateTime FROM story WHERE storyProfileId = :storyProfileId";
		$statement = $pdo->prepare($query);
		// bind the story profile id to the place holder in the template
		$parameters = ["storyProfileId" => $storyProfileId->getBytes()];
		$statement->execute($parameters);
		// build an array of stories
		$stories = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$stories = new Story($row["storyId"], $row["storyProfileId"], $row["storyContent"], $row["storyDateTime"]);
				$stories[$stories->key()] = $stories;
				$stories->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($stories);
	}
	/**
	 * gets the Story by content
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $storyContent story content to search for
	 * @return \SplFixedArray SplFixedArray of Tweets found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getStoryByStoryContent(\PDO $pdo, string $storyContent) : \SPLFixedArray {
		// sanitize the description before searching
		$storyContent = trim($storyContent);
		$storyContent = filter_var($storyContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($storyContent) === true) {
			throw(new \PDOException("story content is invalid"));
		}
		// escape any mySQL wild cards
		$storyContent = str_replace("_", "\\_", str_replace("%", "\\%", $storyContent));
		// create query template
		$query = "SELECT storyId, storyProfileId, storyContent, storyDateTime FROM story WHERE storyContent LIKE :storyContent";
		$statement = $pdo->prepare($query);
		// bind the story content to the place holder in the template
		$storyContent = "%$storyContent%";
		$parameters = ["storyContent" => $storyContent];
		$statement->execute($parameters);
		// build an array of tweets
		$stories = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$story = new Story($row["storyId"], $row["storyProfileId"], $row["storyContent"], $row["storyDateTime"]);
				$stories[$stories->key()] = $story;
				$stories->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($stories);
	}
	/**
	 * gets all Stories
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Tweets found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllStories(\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT storyId, storyProfileId, storyContent, storyDateTime FROM story";
		$statement = $pdo->prepare($query);
		$statement->execute();
		// build an array of stories
		$stories = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$story = new Story($row["storyId"], $row["storyProfileId"], $row["storyContent"], $row["storyDateTime"]);
				$stories[$stories->key()] = $story;
				$stories->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($stories);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["storyId"] = $this->storyId;
		$fields["storyProfileId"] = $this->storyProfileId;
		$fields["storyContent"] = $this->storyContent;
		//format the date so that the front end can consume it
		$fields["storyDateTime"] = round(floatval($this->storyDateTime->format("U.u")) * 1000);
		return($fields);
	}
}