<?php

use Wintner\Repository\PhotoDuels\Picture\PictureInterface;
use Wintner\Repository\PhotoDuels\User\UserInterface;
use Wintner\Exception\ValidatorException;

class LoginController extends BaseController {

	protected $layout = 'photoduels.layout.two_columns';
	protected $user = null;

	public function __construct(UserInterface $user)
	{
		$this->user = $user;
	}

	public function showLogin()
	{
		$this->layout->content = View::make('photoduels.page.login');
	}

	public function login()
	{
		$email = Input::get('email');
		$password = Input::get('password');
		$validator = null;
		try
		{
			$this->user->login($email, $password);
			return Redirect::route('your-account');
		} catch (ValidatorException $e)
		{
			$validator = $e->getValidator();
		}
		$this->layout->content = View::make('photoduels.page.login',
			array('validator' => $validator));
	}

	public function logout()
	{
		$this->user->logout();
		return Redirect::route('home');
	}

	public function showForgotPassword()
	{
		$this->layout->content = View::make(
			'photoduels.page.forgot_password');
	}

	public function showResetPassword()
	{
		$this->layout->content = View::make(
			'photoduels.page.reset_password',
			array('token' => Input::get('token')));
	}

	public function resetPassword()
	{
		$status = Password::reset(
			array('email' => Input::get('email'),
				'password' => Input::get('password'),
				'password_confirmation' => Input::get('password_confirmation'),
				'token' => Input::get('token')),
			function($user, $password)
			{
				$user->password = Hash::make($password);
    			$user->save();
			});
		$arrSuccessMsg = array();
		$arrErrorMsg = array();
		if ($status == 'reminders.reset')
		{
			$arrSuccessMsg[] = 'password_reset';
		} else
		{
			switch ($status)
			{
				case 'reminders.user':
					$status = 'email_invalid';
					break;
				case 'reminders.password':
					$status = 'password_between';
					if ( Input::get('password')
						!= Input::get('password_confirmation') )
					{
						$status = 'password_confirmation';
					}
					break;
				case 'reminders.token':
					$status = 'token_invalid';
					break;
			}
			$arrErrorMsg[] = $status;
		}
		$this->layout->content = View::make(
			'photoduels.page.reset_password',
			array('token' => Input::get('token'),
				'arrSuccessMsg' => $arrSuccessMsg,
				'arrErrorMsg' => $arrErrorMsg,
				'email' => Input::get('email')));
	}

	public function forgotPassword()
	{
		$arrSuccessMsg = null;
		$arrErrorMsg = null;
		$result = Password::remind(array(
			'email' => Input::get('email')), function($message)
		{
			$message->subject('Password reset');
		});
		if ($result == 'reminders.sent')
		{
			$arrSuccessMsg[] = 'reminder_sent';
		} else
		{
			$arrErrorMsg[] = 'email_invalid';
		}
		$this->layout->content = View::make(
			'photoduels.page.forgot_password',
			array('arrErrorMsg' => $arrErrorMsg,
				'arrSuccessMsg' => $arrSuccessMsg));
	}

}