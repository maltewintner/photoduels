<?php

use Wintner\Repository\PhotoDuels\Picture\PictureInterface;
use Wintner\Repository\PhotoDuels\Search\IndexerInterface;
use Wintner\Exception\ValidatorException;
use Wintner\Repository\Core\LaravelValidator;

class UploadController extends BaseController
{
	const NUMBER_PICTURES_PER_PAGE = 5;

	protected $layout = 'photoduels.layout.two_columns';
	protected $picture = null;

	public function __construct(PictureInterface $picture)
	{
		$this->picture = $picture;
	}

	public function main()
	{
		$successMessage = Session::get('successMessage');
		Session::forget('successMessage');
		$arrSuccessMsg = array();
		if ( !empty($successMessage) )
		{
			$arrSuccessMsg[] = $successMessage;
		}
		$page = Input::get('page', 1);
		$message = Session::pull('message');
		$dataPictures = $this->picture->getAccountPictures(
			Auth::user()->id, $page, self::NUMBER_PICTURES_PER_PAGE);
		$pictures = Paginator::make(
			$dataPictures['items'],
			$dataPictures['total'],
			self::NUMBER_PICTURES_PER_PAGE
		);

		$this->layout->content =
			View::make('photoduels.page.uploads',
				array('message' => $message,
					'pictures' => $pictures,
					'arrSuccessMsg' => $arrSuccessMsg));
	}

	public function showAdd()
	{
		$this->layout->content =
			View::make('photoduels.page.uploads-add',
				array('arrPictureCategory'
					=> $this->getArrayPictureCategoryTranslated()));
	}

	private function getArrayPictureCategoryTranslated()
	{
		$arrPictureCategory = $this->picture->getArrayPictureCategory();
		foreach ($arrPictureCategory as $key => $value)
		{
			$arrPictureCategory[$key] = Lang::get('photoduels.' . $value);
		}
		return $arrPictureCategory;
	}

	public function add()
	{
		$validator = null;
		$input = Input::all();
		if ( isset($input['picture_category'])
			&& isset($input['title'])
			&& isset($input['short_description'])
			&& isset($input['description']) )
		{
			try
			{
				$file = Input::file('picture');
				$this->picture->addPicture(
					Auth::user()->id,
					$input['picture_category'],
					$input['title'],
					$input['short_description'],
					$input['description'],
					$file);
				$pictureId = $this->picture->getLastInsertId();
				$filename = $file->getClientOriginalName();
				$file = $file->move(public_path('upload/large'),
					$pictureId . '_' . $filename);
				$img = Image::make(public_path('upload/large') . '/'
					. $pictureId . '_' . $filename);
				$img->resize(300, null, function ($constraint) {
    				$constraint->aspectRatio();
    				$constraint->upsize();
				});
				$img->save(public_path('upload/small') . '/'
					. $pictureId . '_' . $filename);
				return Redirect::route('your-account-uploads')
					->with('successMessage', 'upload_success');
			} catch (ValidatorException $e)
			{
				$validator = $e->getValidator();
			}
		}
		$this->layout->content =
			View::make('photoduels.page.uploads-add',
				array(
					'arrPictureCategory'
						=> $this->getArrayPictureCategoryTranslated(),
					'validator' => $validator));
	}

	public function showEdit()
	{
		$input = Input::all();
		$dataPicture = array();
		if ( isset($input['id']) )
		{
			$dataPicture = $this->picture->getAccountPicture(
				Auth::user()->id, $input['id']);
		}
		$this->layout->content =
			View::make('photoduels.page.uploads-edit',
			array('dataPicture' => $dataPicture));
	}

	public function edit()
	{
		$validator = null;
		$dataPicture = array();
		$input = Input::all();
		if ( isset($input['id'])
			&& isset($input['title'])
			&& isset($input['short_description'])
			&& isset($input['description']) )
		{
			try
			{
				$this->picture->updatePicture(
					Auth::user()->id,
					$input['id'],
					$input['title'],
					$input['short_description'],
					$input['description']);
				return Redirect::route('your-account-uploads')
					->with('successMessage', 'edit_picture_success');
			} catch (ValidatorException $e)
			{
				$validator = $e->getValidator();
			}
			$dataPicture = $this->picture->getAccountPicture(
				Auth::user()->id, $input['id']);
		}
		$this->layout->content =
			View::make('photoduels.page.uploads-edit',
				array('dataPicture' => $dataPicture,
					'validator' => $validator));
	}

	public function showDelete()
	{
		$input = Input::all();
		$dataPicture = array();
		if ( isset($input['id']) )
		{
			$dataPicture = $this->picture->getAccountPicture(
				Auth::user()->id, $input['id']);
		}
		$this->layout->content =
			View::make('photoduels.page.uploads-delete',
			array('dataPicture' => $dataPicture));
	}

	public function delete()
	{
		$input = Input::all();
		if ( isset($input['yes']) && isset($input['id']) )
		{
			$this->picture->deletePicture(Auth::user()->id, $input['id']);
			return Redirect::route('your-account-uploads')
				->with('successMessage', 'delete_success');
		}
		return Redirect::route('your-account-uploads');
	}

}