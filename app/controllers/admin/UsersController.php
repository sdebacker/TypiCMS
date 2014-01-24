<?php namespace App\Controllers\Admin;

use TypiCMS\Repositories\User\UserInterface;
use TypiCMS\Services\Form\User\UserForm;
use View;
use Config;
use Former;
use Input;
use Redirect;
use Request;
use Exception;
use Notification;

class UsersController extends BaseController {

	/**
	 * __construct
	 *
	 * @param UserInterface $user
	 * @param UserForm $userform
	 */
	public function __construct(UserInterface $user, UserForm $userform)
	{
		parent::__construct($user, $userform);
		$this->title['parent'] = trans_choice('modules.users.users', 2);
	}


	public function getLogin()
	{
		$this->title['child'] = trans('modules.users.Log in');
		$this->layout->content = View::make('admin.users.login');
	}


	public function postLogin()
	{
		$credentials = array(
			'email'	=> Input::get('email'),
			'password' => Input::get('password')
		);

		try {
			$this->repository->authenticate($credentials, false);
			Notification::success(trans('modules.users.Welcome'));
			return Redirect::intended(route('dashboard'));
		} catch (Exception $e) {
			Notification::error($e->getMessage());
			return Redirect::route('login')->withInput();
		}
	}


	public function getLogout()
	{
		$this->repository->logout();
		Notification::success(trans('modules.users.You are logged out'));
		return Redirect::back();
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$models = $this->repository->getAll(true)->buildList($this->repository->getListProperties());
		$this->title['h1'] = $models->getTotal().' '.trans_choice('modules.users.users', $models->getTotal());
		$this->layout->content = View::make('admin.users.index')->withModels($models);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->title['child'] = trans('modules.users.New');

		$this->layout->content = View::make('admin.users.create')
			->with('selectedGroups', array())
			->with('groups', $this->repository->getGroups());
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$this->title['child'] = trans('modules.users.Edit');

		$user = $this->repository->byId($id);

		Former::populate($user);

		$this->layout->content = View::make('admin.users.edit')
			->with('user', $user)
			->with('groups', $this->repository->getGroups())
			->with('selectedGroups', $this->repository->getGroups($user));

	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		if ( $this->form->save( Input::all() ) ) {
			return Redirect::route('admin.users.index');
		}

		return Redirect::route('admin.users.create')
			->withInput(Input::except('groups'))
			->withErrors($this->form->errors());

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

		if ( ! Request::ajax()) {
			if ( $this->form->update( Input::all() ) ) {
				return Redirect::route('admin.users.index');
			}
		} else {
			$this->repository->update( Input::all() );
		}

		if ( ! Request::ajax()) {
			return Redirect::route( 'admin.users.edit', $id )
				->withInput()
				->withErrors($this->form->errors());
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if( $this->repository->destroy($id) ) {
			if ( ! Request::ajax()) {
				return Redirect::back();
			}
		}
	}


	/**
	 * Get registration form. 
	 *
	 * @return Response
	 */
	public function getRegister()
	{
		// Show the register form
		$this->title['child'] = trans('modules.users.Register');
		$this->layout->content = View::make('admin.users.register');
	}


	/**
	 * Register a new user. 
	 *
	 * @return Response
	 */
	public function postRegister() 
	{

		if ( ! $this->form->valid( Input::all() ) ) {
			return Redirect::route('register')
				->withInput()
				->withErrors($this->form->errors());
		}

		// confirmation
		$noConfirmation = false;

		try {

			$input = Input::except('password_confirmation');
			$user = $this->repository->register( $input, $noConfirmation );
			$message = 'Your account has been created, ';
			$message .= $noConfirmation ? 'you can now log in' : 'check your email for the confirmation link' ;
			Notification::success(trans('modules.users.'.$message));
			return Redirect::route('login');

		} catch (Exception $e) {

			Notification::error($e->getMessage());
			return Redirect::route('register')->withInput();
			
		}

	}

	/**
	 * Activate a new User
	 */
	public function getActivate($userId = null, $activationCode = null) {

		try {
			$this->repository->activate($userId, $activationCode);
			Notification::success(trans('modules.users.Your account has been activated, you can now log in'));
		} catch (Exception $e) {
			Notification::error($e->getMessage());
		}

		return Redirect::route('login');

	}

	/**
	 * Forgot Password / Reset
	 */
	public function getResetpassword() {
		// Show the reset password form
		$this->title['child'] = trans('modules.users.Reset password');
		$this->layout->content = View::make('admin.users.reset');
	}

	public function postResetpassword () {

		if ( ! $this->form->resetPasswordValid( Input::all() ) ) {
			return Redirect::route('resetpassword')
				->withInput()
				->withErrors($this->form->errors());
		}

		try {
			$email = Input::get('email');
			$user = $this->repository->findUserByLogin($email);
			$data['resetCode'] = $this->repository->getResetPasswordCode($user);
			$data['userId'] = $this->repository->getId($user);
			$data['email'] = $email;

			// Email the reset code to the user
			\Mail::send('emails.auth.reset', $data, function($m) use($data)
			{
				$m->to($data['email'])->subject('[' . Config::get('typicms.websiteTitle') . '] ' . trans('modules.users.Password Reset Confirmation'));
			});

			Notification::success(trans('modules.users.An email was sent with password reset information'));
			return Redirect::route('login');

		} catch (Exception $e) {
			Notification::error($e->getMessage());
			return Redirect::route('resetpassword')->withInput();
		}

	}


	/**
	 * Change User's password
	 */
	public function getChangepassword($userId = null, $resetCode = null) {

		$this->title['child'] = trans('modules.users.New password');

		try {
			// Find the user
			$user = $this->repository->byId($userId);
			if ( ! $this->repository->checkResetPasswordCode($user, $resetCode) ) {
				Notification::error(trans('modules.users.This password reset token is invalid'));
				return Redirect::route('login');
			}
			$data['id'] = $userId;
			$data['resetCode'] = $resetCode;

			$this->layout->content = View::make('admin.users.newpassword')
				->with($data);

		} catch (Exception $e) {
			exit('modules.users.User does not exist');
		}

	}


	/**
	 * Change User's password
	 */
	public function postChangepassword() {

		$input = Input::all();

		if ( ! $this->form->changePasswordValid( $input ) ) {
			return Redirect::route('changepassword', array($input['id'], $input['resetCode']))
				->withInput()
				->withErrors($this->form->errors());
		}


		try {

			// Find the user
			$user = $this->repository->byId($input['id']);

			if ($this->repository->checkResetPasswordCode($user, $input['resetCode'])) {
				// Attempt to reset the user password
				if ($this->repository->attemptResetPassword($user, $input['resetCode'], $input['password'])) {

					Notification::success(trans('modules.users.Your password has been changed'));

					try {
						$credentials = array(
							'email' => $user->getLogin(),
							'password' => $input['password']
						);
						$this->repository->authenticate($credentials, false);
						return Redirect::route('dashboard');
					} catch (Exception $e) {
						Notification::error($e->getMessage());
						return Redirect::route('login')->withInput();
					}

				} else {
					// Password reset failed
					Notification::success(trans('modules.users.There was a problem, please contact the system administrator'));
				}
			} else {
				Notification::error(trans('modules.users.This password reset token is invalid'));
			}
		} catch (Exception $e) {
			Notification::error($e->getMessage());
		}

		return Redirect::route('login');

	}


}