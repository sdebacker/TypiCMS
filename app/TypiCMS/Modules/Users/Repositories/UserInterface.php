<?php
namespace TypiCMS\Modules\Users\Repositories;

interface UserInterface
{

    /**
     * Get all models
     *
     * @param  boolean  $all  Show published or all
     * @param  array    $with Eager load related models
     * @return \Illuminate\Support\Collection Object with $items
     */
    public function getAll(array $with = array(), $all = false);

    /**
     * Retrieve user by id
     * regardless of status
     *
     * @param  int  $id user ID
     * @return \Cartalyst\Sentry\Users\UserInterface object
     */
    public function byId($id, array $with = array());

    /**
     * Retrieve user by login
     * regardless of status
     *
     * @param  int  $login
     * @return \Cartalyst\Sentry\Users\UserInterface object
     */
    public function findUserByLogin($login);

    /**
     * Retrieve all groups or user groups
     *
     * @param  User  $user
     * @return array
     */
    public function getGroups($user = null);

    /**
     * Get reset password code for user
     *
     * @param  User   $user
     * @return string
     */
    public function getResetPasswordCode($user);

    /**
     * Check reset password code for user
     *
     * @param  User   $user
     * @param  String $resetCode
     * @return bool
     */
    public function checkResetPasswordCode($user, $resetCode);

    /**
     * Attempt reset password for user
     *
     * @param  User   $user
     * @param  String $resetCode
     * @param  String $password
     * @return bool
     */
    public function attemptResetPassword($user, $resetCode, $password);

    /**
     * Get id of user
     *
     * @param  User   $user
     * @return string
     */
    public function getId($user);

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
     * @param  array   $credentials
     * @return boolean
     */
    public function authenticate($credentials, $remember = false);

    /**
     * Log a user in
     *
     * @return boolean  User
     */
    public function login($user, $remember = false);

    /**
     * Register a new user
     *
     * @param  array   $input
     * @return boolean
     */
    public function register(array $input, $noConfirmation = null);

    /**
     * Activate a user registration
     *
     * @param  int     $userId
     * @param  string  $activationCode
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
     * Update current user preferences
     *
     * @return mixed
     */
    public function updatePreferences(array $data);

    /**
     * Get current user preferences
     *
     * @return array
     */
    public function getPreferences();

    /**
     * Update a user
     *
     * @param  int     $id
     * @return boolean
     */
    public function destroy($id);
}
