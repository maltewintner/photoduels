<?php
/**
 * PhotoDuels Service Provider
 *
 * @author    Malte Wintner
 * @copyright 2014 Malte Wintner (http://malte.wintner.ch)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://malte.wintner.ch
 */

namespace Wintner\ServiceProvider;

use Picture;
use PictureCategory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Wintner\Repository\PhotoDuels\Picture\PictureLaravelValidator;
use User;
use DuelLog;
use Visitor;
use InvertedIndex;
use Word;
use Wintner\Repository\PhotoDuels\Picture\PictureEloquent;
use Wintner\Repository\PhotoDuels\User\UserEloquent;
use Wintner\Repository\PhotoDuels\User\UserLaravelValidator;
use Wintner\Repository\PhotoDuels\Visitor\VisitorEloquent;
use Wintner\Repository\PhotoDuels\Visitor\VisitorLaravelValidator;
use Wintner\Repository\PhotoDuels\Duel\DuelEloquent;
use Wintner\Repository\PhotoDuels\Search\IndexerLaravel;
use Wintner\Repository\PhotoDuels\Search\SearcherEloquent;
use Wintner\Repository\PhotoDuels\Search\StopWordsEnglish;
use Wintner\Repository\PhotoDuels\Search\SimpleWordExtractor;
use Intervention\Image\Exception\InvalidArgumentException;

/**
 * Class representing a PhotoDuels Service Provider
 */
class PhotoDuelsServiceProvider extends ServiceProvider {

    /**
     * Registers the service provider.
     *
     * @return void
     */
	public function register()
	{
		$this->app->bind(
			'Wintner\Repository\PhotoDuels\Picture\PictureInterface',
			function($app)
		{
			return new PictureEloquent(
				new Picture(),
				$app->make(
					'Wintner\Repository\PhotoDuels\Search\IndexerInterface'),
				new PictureLaravelValidator($app['validator']));
		});

		$this->app->bind('Wintner\Repository\PhotoDuels\User\UserInterface',
			function($app)
		{
			return new UserEloquent(
				new User(),
				new UserLaravelValidator($app['validator']),
				$app['auth']->driver());
		});

		$this->app->bind('Wintner\Repository\PhotoDuels\Visitor\VisitorInterface',
			function($app)
		{
			return new VisitorEloquent(
				new Visitor(),
				new VisitorLaravelValidator($app['validator']));
		});

		$this->app->bind('Wintner\Repository\PhotoDuels\Duel\DuelInterface',
			function($app)
		{
			return new DuelEloquent(
				$app->make(
					'Wintner\Repository\PhotoDuels\Picture\PictureInterface'),
				$app->make(
					'Wintner\Repository\PhotoDuels\Visitor\VisitorInterface'),
				new DuelLog());
        });

		$this->app->bind('Wintner\Repository\PhotoDuels\Search\IndexerInterface',
			function($app)
		{
			return new IndexerLaravel(new StopWordsEnglish(),
				new SimpleWordExtractor());
        });

		$this->app->bind('Wintner\Repository\PhotoDuels\Search\SearcherInterface',
			function($app)
		{
			return new SearcherEloquent(
				$app->make(
					'Wintner\Repository\PhotoDuels\Picture\PictureInterface'));
        });

		// define error page
		$this->app->error(function($exception)
		{
			if ($exception instanceof \InvalidArgumentException)
			{
				return Response::view('photoduels.page.404', array(), 404);
			}
			return Response::view('photoduels.page.503', array(), 503);
		});

		// define missing page
		$this->app->missing(function($exception)
		{
			return Response::view('photoduels.page.404', array(), 404);
		});
    }

}