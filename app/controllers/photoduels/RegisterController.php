<?php

use Wintner\Repository\PhotoDuels\User\UserInterface;
use Wintner\Exception\ValidatorException;

class RegisterController extends BaseController {

	protected $layout = 'photoduels.layout.two_columns';
	protected $user = null;

	public function __construct(UserInterface $user)
	{
		$this->user = $user;
	}

	public function main()
	{
		$this->layout->content = View::make('photoduels.page.register');
	}

	public function register()
	{
		$input = Input::all();
		$validator = null;
		if ( isset($input['email'])
			&& isset($input['username'])
			&& isset($input['password'])
			&& isset($input['password_confirmation']) )
		{
			try
			{
				$this->user->register($input['email'],
					$input['username'], $input['password'],
						$input['password_confirmation']);
				return Redirect::route('your-account')->with(
					'successMessage', 'registration_successful');
			} catch (ValidatorException $e)
			{
				$validator = $e->getValidator();
			}
		}
		$this->layout->content = View::make('photoduels.page.register',
			array('validator' => $validator));
	}
}