<?php namespace TypiCMS\Repositories\User;

interface UserInterface
{

	/**
	 * Retrieve user by id
	 * regardless of status
	 *
	 * @param  int $id user ID
	 * @return User object
	 */
	public function byId($id);

	/**
	 * Retrieve user by login
	 * regardless of status
	 *
	 * @param  int $login
	 * @return User object
	 */
	public function findUserByLogin($login);

	/**
	 * Get reset password code for user
	 *
	 * @param  User $user
	 * @return string
	 */
	public function getResetPasswordCode($user);

	/**
	 * Check reset password code for user
	 *
	 * @param  User $user
	 * @param  String $resetCode
	 * @return bool
	 */
	public function checkResetPasswordCode($user, $resetCode);

	/**
	 * Attempt reset password for user
	 *
	 * @param  User $user
	 * @param  String $resetCode
	 * @param  String $password
	 * @return bool
	 */
	public function attemptResetPassword($user, $resetCode, $password);

	/**
	 * Get id of user
	 *
	 * @param  User $user
	 * @return string
	 */
	public function getId($user);

	/**
	 * Get all pages
	 *
	 * @param boolean $all Show published or all
	 * @return StdClass Object with $items
	 */
	public function getAll($all = false);

	/**
	 * Retrieve all groups or user groups
	 *
	 * @param  User $user
	 * @return array
	 */
	public function getGroups($user = null);

	/**
	 * Build html list
	 *
	 * @param array
	 * @return string
	 */
	public function buildList(array $array = array());

	/**
	 * Create a new User
	 *
	 * @param array  Data to create a new object
	 * @return boolean
	 */
	public function create(array $data);

	/**
	 * Update an existing user
	 *
	 * @param array  Data to update an user
	 * @return boolean
	 */
	public function update(array $data);

	/**
	 * Authenticate a user
	 *
	 * @param array $credentials
	 * @param boolean $id
	 * @return boolean
	 */
	public function authenticate($credentials, $remember = false);

	/**
	 * Register a new user
	 *
	 * @param array $input
	 * @return boolean
	 */
	public function register(array $input, $noConfirmation = null);

	/**
	 * Activate a user registration
	 *
	 * @param int $userId
	 * @param string $activationCode
	 * @return boolean
	 */
	public function activate($userId = null, $activationCode = null);

	/**
	 * Logout a user
	 *
	 * @return null
	 */
	public function logout();

	/**
	 * Update a user
	 *
	 * @param int $id
	 * @return boolean
	 */
	public function destroy($id);


}