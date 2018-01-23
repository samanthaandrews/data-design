<?php
namespace Edu\Cnm\Sandrews20\DataDesign;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
use UnexpectedValueException;

/**
 * Cross Section of a story or article written on Medium
 *
 * This Story class can be considered an example of what data Medium stores when users create a Story.
 *
 *@author Samantha Andrews <samantharaeandrews@gmail.com>
 *@author Dylan McDonald <dmcdonald21@cnm.edu>
 *
 **/

class Story {
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
	 * @param
	 * @param
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 **/
	public function __construct($newStoryId, $newStoryProfileId, string $newStoryContent, $newStoryDateTime = null) {
		try {
			$this->setStoryId($newStoryId);
			$this->setStoryProfileId($newStoryProfileId);
			$this->setStoryContent($newStoryContent);
			$this->setStoryDateTime($newStoryDateTime);
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
	/**
	 * mutator method for story id
	 *
	 * @param Uuid/string $newStoryId new value of story id
	 * @throws \RangeException if $newStoryId is not positive
	 * @throws \TypeError if $newStoryId is not a uuid or string
	 **/
	public function setStoryId( $newStoryId) : void {
		try {
			$uuid = self::validateUuid($newStoryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception); {
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
	 * @param string
	 * @throws
	 * @throws
	 **/
	/**
	 * accessor method for story content
	 *
	 **/
	/** mutator method for story content
	 *
	 **/
	/**
	 * accessor method for story date time
	 **/
	/**
	 * mutator method for story date time
	 **/
}