<?php
namespace Edu\Cnm\DataDesign;

require_once("autoload.php");
require_once(dirname(__DIR__) . "autoload.php");

use Ramsey\Uuid\Uuid;

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
	 * accessor method for getting profileId
	 */
}