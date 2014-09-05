<?php
namespace TypiCMS\Modules\Users\Controllers;

use App;
use Config;
use Exception;
use Illuminate\Mail\Message;
use Input;
use Mail;
use Notification;
use Redirect;
use Request;
use TypiCMS\Controllers\BaseAdminController;
use TypiCMS\Modules\Users\Repositories\UserInterface;
use TypiCMS\Modules\Users\Services\Form\UserForm;
use View;

class AdminController extends BaseAdminController
{

    /**
     * __construct
     *
     * @param UserInterface $user
     * @param UserForm      $userform
     */
    public function __construct(UserInterface $user, UserForm $userform)
    {
        parent::__construct($user, $userform);
        $this->title['parent'] = trans_choice('users::global.users', 2);
    }

    public function getLogin()
    {
        $this->layout->content = View::make('admin.users.login');
    }

    public function postLogin()
    {
        $credentials = array(
            'email'    => Input::get('email'),
            'password' => Input::get('password')
        );

        try {
            $user = $this->repository->authenticate($credentials, false);
            Notification::success(
                trans('users::global.Welcome', array('name' => $user->first_name))
            );

            return Redirect::intended('/');
        } catch (Exception $e) {
            Notification::error($e->getMessage());

            return Redirect::route('login')->withInput();
        }
    }

    public function getLogout()
    {
        $this->repository->logout();
        Notification::success(trans('users::global.You are logged out'));

        return Redirect::back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Grab all the users
        $models = $this->repository->getAll(array(), true);

        $this->layout->content = View::make('admin.users.index')->withModels($models);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->title['child'] = trans('users::global.New');
        $model = $this->repository->getModel();
        $this->layout->content = View::make('admin.users.create')
            ->withModel($model)
            ->with('selectedGroups', array())
            ->with('groups', $this->repository->getGroups());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int      $id
     * @return Response
     */
    public function edit($id)
    {
        $this->title['child'] = trans('users::global.Edit');
        $model = $this->repository->byId($id);
        $this->layout->content = View::make('admin.users.edit')
            ->withModel($model)
            ->withPermissions($model->getPermissions())
            ->withGroups($this->repository->getGroups())
            ->with('selectedGroups', $this->repository->getGroups($model));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

        if ($model = $this->form->save(Input::all())) {
            return Input::get('exit') ?
                Redirect::route('admin.users.index') :
                Redirect::route('admin.users.edit', $model->id) ;
        }

        return Redirect::route('admin.users.create')
            ->withInput(Input::except('groups'))
            ->withErrors($this->form->errors());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int      $id
     * @return Response
     */
    public function update($id)
    {

        if ($this->form->update(Input::all())) {
            return Input::get('exit') ?
                Redirect::route('admin.users.index') :
                Redirect::route('admin.users.edit', $id) ;
        }

        return Redirect::route('admin.users.edit', $id)
            ->withInput()
            ->withErrors($this->form->errors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int      $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->repository->destroy($id)) {
            if (! Request::ajax()) {
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
        $this->layout->content = View::make('admin.users.register');
    }

    /**
     * Register a new user.
     *
     * @return Response
     */
    public function postRegister()
    {

        if (! $this->form->valid(Input::all())) {
            return Redirect::route('register')
                ->withInput()
                ->withErrors($this->form->errors());
        }
        // confirmation
        $noConfirmation = null;

        try {

            $input = Input::except('password_confirmation');
            $this->repository->register($input, $noConfirmation);
            $message = 'Your account has been created, ';
            $message .= $noConfirmation ? 'you can now log in' : 'check your email for the confirmation link' ;
            Notification::success(trans('users::global.'.$message));

            return Redirect::route('login');

        } catch (Exception $e) {

            Notification::error($e->getMessage());

            return Redirect::route('register')->withInput();

        }

    }

    /**
     * Activate a new User
     */
    public function getActivate($userId = null, $activationCode = null)
    {
        try {
            $this->repository->activate($userId, $activationCode);
            Notification::success(trans('users::global.Your account has been activated, you can now log in'));
        } catch (Exception $e) {
            Notification::error($e->getMessage());
        }

        return Redirect::route('login');

    }

    /**
     * Forgot Password / Reset
     */
    public function getResetpassword()
    {
        // Show the reset password form
        $this->layout->content = View::make('admin.users.reset');
    }

    public function postResetpassword()
    {
        if (! $this->form->resetPasswordValid(Input::all())) {
            return Redirect::route('resetpassword')
                ->withInput()
                ->withErrors($this->form->errors());
        }

        try {
            $email = Input::get('email');
            $user = $this->repository->findUserByLogin($email);
            $data = array();
            $data['resetCode'] = $this->repository->getResetPasswordCode($user);
            $data['userId'] = $this->repository->getId($user);
            $data['email'] = $email;

            // Email the reset code to the user
            Mail::send('emails.auth.reset', $data, function (Message $message) use ($data) {
                $subject  = '[' . Config::get('typicms.' . App::getLocale() . '.websiteTitle') . '] ';
                $subject .= trans('users::global.Password Reset Confirmation');
                $message->to($data['email'])->subject($subject);
            });

            Notification::success(trans('users::global.An email was sent with password reset information'));

            return Redirect::route('login');

        } catch (Exception $e) {
            Notification::error($e->getMessage());

            return Redirect::route('resetpassword')->withInput();
        }

    }

    /**
     * Change User's password
     */
    public function getChangepassword($userId = null, $resetCode = null)
    {
        try {
            // Find the user
            $user = $this->repository->byId($userId);
            if (! $this->repository->checkResetPasswordCode($user, $resetCode)) {
                Notification::error(trans('users::global.This password reset token is invalid'));
                return Redirect::route('login');
            }
            $data = array();
            $data['id'] = $userId;
            $data['resetCode'] = $resetCode;

            $this->layout->content = View::make('admin.users.newpassword')
                ->with($data);

        } catch (Exception $e) {
            Notification::error(trans('users::global.User does not exist'));
            return Redirect::route('login');
        }

    }


    /**
     * Change User's password
     */
    public function postChangepassword()
    {
        $input = Input::all();

        if (! $this->form->changePasswordValid($input)) {
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

                    Notification::success(trans('users::global.Your password has been changed'));

                    try {
                        $credentials = array(
                            'email' => $user->getLogin(),
                            'password' => $input['password']
                        );
                        $this->repository->authenticate($credentials, false);

                        return Redirect::to('/');
                    } catch (Exception $e) {
                        Notification::error($e->getMessage());

                        return Redirect::route('login')->withInput();
                    }

                } else {
                    // Password reset failed
                    $msg = trans('users::global.There was a problem, please contact the system administrator');
                    Notification::success($msg);
                }
            } else {
                Notification::error(trans('users::global.This password reset token is invalid'));
            }
        } catch (Exception $e) {
            Notification::error($e->getMessage());
        }

        return Redirect::route('login');

    }

    /**
     * Update User's preferences
     */
    public function postUpdatePreferences()
    {
        $input = Input::all();
        $this->repository->updatePreferences($input);
    }
}
