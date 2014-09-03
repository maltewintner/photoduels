<?php

use Wintner\Repository\PhotoDuels\User\UserInterface;
use Wintner\Exception\ValidatorException;

class ProfileController extends BaseController {

	protected $layout = 'photoduels.layout.two_columns';
	protected $user = null;

	public function __construct(UserInterface $user)
	{
		$this->user = $user;
	}

	public function main()
	{
		$dataUser = array('username' => $this->user->getUsername(),
			'email' => $this->user->getEmail());
		$this->layout->content =
			View::make('photoduels.page.profile',
				array('dataUser' => $dataUser));
	}

	public function update()
	{
		$dataUser = array('username' => $this->user->getUsername(),
			'email' => $this->user->getEmail());
		$input = Input::all();
		$validator = null;
		$arrSuccessMsg = array();
		if ( isset($input['email']) && isset($input['password'])
			&& isset($input['password_confirmation']) )
		{
			try
			{
				$this->user->updateProfile($input['email'],
					$input['password'],
					$input['password_confirmation']);
				$arrSuccessMsg[] = 'update_profile_success';
			} catch (ValidatorException $e)
			{
				$validator = $e->getValidator();
			}
		}
		$this->layout->content =
			View::make('photoduels.page.profile',
				array('dataUser' => $dataUser,
					'validator' => $validator,
					'arrSuccessMsg' => $arrSuccessMsg));
	}
}