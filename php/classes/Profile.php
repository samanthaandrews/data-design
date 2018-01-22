<?php
namespace Edu\Cnm\DataDesign;

require_once("autoload.php");
require_once(dirname(__DIR__) . "autoload.php");

use Ramsey\Uuid\Uuid;
use UnexpectedValueException;

/**
 * Cross Section of a Medium profile
 *
 * This Profile can be considered an example of what Medium stores when users create a Profile. This is a strong, top-level entity that will store data for other entities such as Story and Clap.
 *
 *@author Samantha Andrews <samantharaeandrews@gmail.com>
 *@author Dylan McDonald <dmcdonald21@cnm.edu>
 *
 */

class Profile {
	use ValidateUuid;

	/**
	 * id for this Profile; this is the primary key
	 * @var Uuid $profileId
	 */
	private $profileId;
	/**
	 * token to verify account is not malicious
	 * @var string $profileActivationToken
	 */
	private $profileActivationToken;
	/**
	 * email associated with this Profile; this is a unique index
	 * @var string $profileEmail
	 */
	private $profileEmail;
	/**
	 * unique handle associated with this profile
	 * @var string $profileHandle
	 */
	private $profileHandle;
	/**
	 * hash for profile password
	 * @var string $profileHash
	 */
	private $profileHash;
	/**
	 * salt stored for this profile password
	 * @var string $profileSalt
	 */
	private $profileSalt;
	/**
	 * accessor method for profile id
	 *
	 * @return Uuid value of profileId
	 */
	public function getProfileId() : Uuid {
		return ($this->profileId);
	}
	/**
	 * mutator method for profile id
	 *
	 * @param Uuid/string $newProfileId new value of profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newTweetId is not a uuid or string
	 */
	public function setProfileId( $newProfileId) : void {
		try {
			$uuid = self::validateUuid($newTweetId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception)
		{
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

	}
	// convert and store the profile id
	$this->profileId = $uuid;

	/**
	 * accessor method for account activation token
	 *
	 * @return string value of activation token
	 */
	public function getProfileActivationToken() : string {
		return ($this->profileActivationToken);
	}
	/**
	 * mutator method for account activation token
	 *
	 * @param string $newProfileActivationToken
	 * @throws \InvalidArgumentException if the token is not a string or insecure
	 * @throws \RangeException if the token is not 32 characters
	 * @throws \TypeError if the token is not a string
	 */
	public function setProfileActivationToken (?string $newProfileActivationToken) : void {
		$if($newProfileActivationToken === null){
		$this->profileActivationToken = null;
		return;
	}
	$newProfileActivationToken = strtolower(trim($newProfileActivationToken));
		if(ctype_xdigit($newProfileActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}
		//make sure activation token is only 32 characters
		if(strlen($newProfileActivationToken) !== 32) {
			throw(new\RangeException("user activation token has to be 32 characters"));
		}
		$this->profileActivationToken = $newProfileActivationToken
	}
	/** accessor method for profile handle
	 *
	 * @return string value of profile handle
	 */
}
?>