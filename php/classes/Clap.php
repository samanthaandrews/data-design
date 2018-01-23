<?php
namespace Edu\Cnm\Sandrews20\DataDesign;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "../vendor/autoload.php");

use Ramsey\Uuid\Uuid;

class Clap implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
	/**
	 * id of the story that this clap is for; this is a foreign key
	 * @var Uuid $clapStoryId
	 **/
	private $clapStoryId;
	/**
	 * id of the Profile that sent this clap; this is a foreign key
	 * @var Uuid $clapProfilId
	 **/
	private $clapProfileId;
	/**
	 * date and time this clap was sent, in a PHP DateTime object
	 * @var \DateTime $clapDateTime
	 **/
	private $clapDateTime;


/**
 * accessor method for clap article id
 *
 * @return Uuid value of clap article id
 **/
public function getClapStoryId() : Uuid{
	return($this->clapStoryId);
}
/**
 * mutator method for clap article id
 *
 * @param string | Uuid $newClapStoryId new value of clap article id
 * @throws \RangeException if $newClapStoryId is not positive
 * @throws \TypeError if $newClapStoryId is not an integer
 **/
public function setClapStoryId($newClapStoryId) : void {
	try {
		$uuid = self::validateUuid($newClapStoryId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
	// convert and store the profile id
	$this->clapStoryId= $uuid;
}
/**
 * accessor method for clap profile id
 *
 * @return Uuid value of clap profile id
 **/
public function getClapProfileId() : Uuid{
	return($this->clapProfileId);
}
/**
 * mutator method for clap profile id
 *
 * @param string | Uuid $newClapProfileId new value of clap profile id
 * @throws \RangeException if $newClapProfileId is not positive
 * @throws \TypeError if $newClapProfileId is not an integer
 **/
public function setClapProfileId($newClapProfileId) : void {
	try {
		$uuid = self::validateUuid($newClapProfileId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
	// convert and store the profile id
	$this->clapProfileId = $uuid;
}
/**
 * accessor method for clap date time
 *
 * @return \DateTime value of clap date time
 **/
public function getClapDateTime() : \DateTime {
	return($this->clapDateTime);
}
/**
 * mutator method for clap date time
 *
 * @param \DateTime|string|null $newClapDateTime clap date as a DateTime object or string (or null to load the current time)
 * @throws \InvalidArgumentException if $newClapDateTime is not a valid object or string
 * @throws \RangeException if $newClapDateTime is a date that does not exist
 **/
public function setClapDateTime($newClapDateTime = null) : void {
	// base case: if the date is null, use the current date and time
	if($newClapDateTime === null) {
		$this->clapDateTime = new \DateTime();
		return;
	}
	// store the like date using the ValidateDate trait
	try {
		$newClapDate = self::validateDateTime($newClapDate);
	} catch(\InvalidArgumentException | \RangeException $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
	$this->clapDateTime = $newClapDateTime;
}