<?php
namespace Edu\Cnm\Sandrews20\DataDesign;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

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
 **/

class Profile {
	use ValidateUuid;
	/**
	 * id for this Profile; this is the primary key
	 * @var Uuid $profileId
	 **/
	private $profileId;
	/**
	 * token to verify account is not malicious
	 * @var string $profileActivationToken
	 **/
	private $profileActivationToken;
	/**
	 * email associated with this Profile; this is a unique index
	 * @var string $profileEmail
	 **/
	private $profileEmail;
	/**
	 * unique handle associated with this profile
	 * @var string $profileHandle
	 **/
	private $profileHandle;
	/**
	 * hash for profile password
	 * @var string $profileHash
	 **/
	private $profileHash;
	/**
	 * salt stored for this profile password
	 * @var string $profileSalt
	 **/
	private $profileSalt;
	/**
	 * accessor method for profile id
	 *
	 * @return Uuid value of profileId
	 **/
	public function getProfileId() : Uuid {
		return ($this->profileId);
	}

	/**
	 * mutator method for profile id
	 *
	 * @param Uuid/string $newProfileId new value of profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newTweetId is not a uuid or string
	 **/
	public function setProfileId( $newProfileId) : void {
		try {
			$uuid = self::validateUuid($newProfileId);
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
	 **/
	public function getProfileActivationToken() : ?string {
		return ($this->profileActivationToken);
	}

	/**
	 * mutator method for account activation token
	 *
	 * @param string $newProfileActivationToken
	 * @throws \InvalidArgumentException if the token is not a string or insecure
	 * @throws \RangeException if the token is not 32 characters
	 * @throws \TypeError if the token is not a string
	 **/
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
	 **/
	public function getProfileHandle(): string {
		return ($this->profileHandle);
	}

	/**
	 * mutator method for profile handle
	 *
	 * @param string $newProfileHandle new value of handle
	 * @throws \InvalidArgumentException if $newProfileHandle is not a string or insecure
	 * @throws \RangeException if $newProfileHandle is > 32 characters
	 * @throws \typeError if $newProfileHandle is not a string
	 **/
	public function setProfileHandle(string $newProfileHandle) : void {
		// verify the handle is secure
		$newProfileHandle = trim($newProfileHandle);
		$newProfileHandle = filter_var($newProfileHandle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileHandle) === true) {
			throw(new \InvalidArgumentException("profile handle is empty or insecure"));
		}
		// verify the handle will fit in the database
		if(strlen($newProfileAtHandle) > 32) {
			throw(new \RangeException("profile handle is too large"));
		}
		// store the handle
		$this->profileHandle = $newProfileHandle;
	}

	/** accessor method for profile email address
	 *
	 * @return string value of email address
	 **/
	public function getProfileEmail() : string {
		return $this->profileEmail;
	}

	/** mutator method for profile email address
	 *
	 * @param string $newProfileEmail new value of email
	 * @throws \InvalidArgumentException if $newProfileEmail is not valid email or insecure
	 * @throws \RangeException if $newProfileEmail is > 128 characters
	 * @throws \TypeError if $newProfileEmail is not a string
	 **/
	public function setProfileEmail(string $newProfileEmail) : void {
		//verify the email is secure
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("profile email is empty or insecure"));
		}
			// verify the email will fit in the database
			if(strlen($newProfileEmail) > 128) {
				throw(new \RangeException("profile email is too large"));
			}
			// store the email
			$this->profileEmail = $newProfileEmail;
	}

	/**
	 * accessor method for profileHash
	 *
	 * @return string value of hash
	 **/
	public function getProfileHash(): string {
		return $this->profileHash;
	}

	/**
	 * mutator method for profile hash password
	 *
	 * @param string $newProfileHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if profile hash is not a string
	 **/
	public function setProfileHash(string $newProfileHash): void {
		//enforce that the hash is properly formatted
		$newProfileHash = trim($newProfileHash);
		$newProfileHash = strtolower($newProfileHash);
		if(empty($newProfileHash) === true) {
			throw(new \InvalidArgumentException("profile password hash empty or insecure"));
		}
		//enforce that the hash is a string representation of a hexadecimal
		if(!ctype_xdigit($newProfileHash)) {
			throw(new \InvalidArgumentException("profile password hash is empty or insecure"));
		}
		//enforce that the hash is exactly 128 characters.
		if(strlen($newProfileHash) !== 128) {
			throw(new \RangeException("profile hash must be 128 characters"));
		}
		//store the hash
		$this->profileHash = $newProfileHash;
	}

	/**
	 *accessor method for profile salt
	 *
	 * @return string representation of the salt hexadecimal
	 **/
	public function getProfileSalt(): string {
		return $this->profileSalt;
	}

	/**
	 * mutator method for profile salt
	 *
	 * @param string $newProfileSalt
	 * @throws \InvalidArgumentException if the salt is not secure
	 * @throws \RangeException if the salt is not 64 characters
	 * @throws \TypeError if the profile salt is not a string
	 **/
	public function setProfileSalt(string $newProfileSalt): void {
		//enforce that the salt is properly formatted
		$newProfileSalt = trim($newProfileSalt);
		$newProfileSalt = strtolower($newProfileSalt);
		//enforce that the salt is a string representation of a hexadecimal
		if(!ctype_xdigit($newProfileSalt)) {
			throw(new \InvalidArgumentException("profile password hash is empty or insecure"));
		}
		//enforce that the salt is exactly 64 characters.
		if(strlen($newProfileSalt) !== 64) {
			throw(new \RangeException("profile salt must be 128 characters"));
		}
		//store the hash
		$this->profileSalt = $newProfileSalt;
	}
}