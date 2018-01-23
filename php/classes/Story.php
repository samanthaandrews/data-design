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