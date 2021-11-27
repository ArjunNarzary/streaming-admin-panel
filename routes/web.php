<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('index')->middleware('customRedirect');

Auth::routes();

//Home Page
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin/revenue/movies', 'HomeController@revenueChartMovies')->middleware('role:admin');
Route::get('/admin/revenue/seasons', 'HomeController@revenueChartSeasons')->middleware('role:admin');

//Cast
Route::get('/casts', 'CastController@index')->name('cast');
Route::post('/casts', 'CastController@addCast')->name('add.cast');
Route::post('/cast/view', 'CastController@viewCast')->name('view.cast');
Route::post('/cast/edit', 'CastController@editCast')->name('edit.cast');
Route::get('/cast/delete/{cast}', 'CastController@deleteCast')->name('cast.delete');

//Crew
Route::get('/crew', 'CrewController@index')->name('crew');
Route::post('/crew', 'CrewController@addCrew')->name('add.crew');
Route::post('/crew/view', 'CrewController@viewCrew')->name('view.crew');
Route::post('/crew/edit', 'CrewController@editCrew')->name('edit.crew');
Route::get('/crew/delete/{crew}', 'CrewController@deleteCrew')->name('crew.delete');

//Genre
Route::get('/genres', 'GenreController@index')->name('genre');
Route::post('/genre', 'GenreController@store')->name('genre.save');
Route::post('/genre/edit', 'GenreController@editView')->name('genre.edit');
Route::post('/genre/edit/store', 'GenreController@editStore')->name('genre.edit.store');
Route::get('/genre/delete/{genre}', 'GenreController@delete')->name('genre.delete');

//Subscription Plan
Route::get('subscriptions', 'SubscriptionPlanController@index')->name('subscription.plan');
Route::get('subscriptions/create', 'SubscriptionPlanController@create')->name('subscription.plan.add');
Route::post('subscriptions/create', 'SubscriptionPlanController@store')->name('subscription.plan.store');
Route::get('subscriptions/edit/{id}', 'SubscriptionPlanController@edit')->name('subscription.plan.edit');
Route::post('subscriptions/edit/{id}', 'SubscriptionPlanController@update')->name('subscription.plan.update');
Route::post('subscriptions/view', 'SubscriptionPlanController@view')->name('subscription.plan.view');
Route::get('subscriptions/delete/{id}', 'SubscriptionPlanController@delete')->name('subscription.plan.delete');

//Movies
Route::get('/movies', 'MovieController@movies')->name('movies');
Route::get('/movies/add', 'MovieController@addMovie')->name('add.movies');
Route::post('/movies/add', 'MovieController@store')->name('movies.post');
Route::get('/movies/manage/{id}', 'MovieController@view')->name('movie.view');
Route::post('/movies/manage', 'MovieController@update')->name('movie.update');
Route::get('/movies/edit/{id}', 'MovieController@edit')->name('movie.edit');
//Movie Cast
Route::post('/movie/cast', 'MovieController@movieCast');
Route::post('/movie/cast/add', 'MovieController@movieCastAdd');
Route::post('/movie/cast/remove', 'MovieController@movieCastRemove');
//Movie Crew
Route::post('/movie/crew', 'MovieController@movieCrew');
Route::post('/movie/crew/add', 'MovieController@movieCrewAdd');
Route::post('/movie/crew/remove', 'MovieController@movieCrewRemove');
//Movie Genre
Route::post('/movie/genre/add', 'MovieController@movieGenre');
Route::post('/movie/genre/remove', 'MovieController@movieGenreRemove');
//Movie Posters
Route::post('/movie/poster', 'MovieController@moviePoster');
Route::post('/movie/remove/poster', 'MovieController@moviePosterRemove');
// Movie Activation
Route::get('/movie/activate/{movie}', 'MovieController@movieActivate')->name('movie.activate');
Route::get('/movie/deactivate/{movie}', 'MovieController@movieDeactivate')->name('movie.deactivate');
// Movie Iframe
Route::post('/movie/iframe', 'MovieController@addIframe');
Route::post('/movie/remove/iframe', 'MovieController@removeIframe');

//Movie Videos
Route::get('/movies/video/{movie}', 'VideoController@index')->name('movies.videos');
Route::post('/movies/video/upload/{id}', 'VideoController@upload')->name('movie.upload');
Route::get('/movies/video/delete/{movie}', 'VideoController@delete')->name('movie.video.delete');

//Series
Route::get('/series/add', 'SeriesController@addSeries')->name('add.series');
Route::post('/series/add', 'SeriesController@store')->name('series.post');
Route::get('/series', 'SeriesController@series')->name('series');
Route::get('/series/{id}', 'SeriesController@edit')->name('series.view');
Route::post('/series/{id}', 'SeriesController@update')->name('series.update');
Route::get('/series/manage/{id}', 'ManageSeriesController@index')->name('series.manage');
//Series Crew
Route::post('/series/crew/add', 'ManageSeriesController@seriesCrew');
Route::post('/series/crew/remove', 'ManageSeriesController@seriesCrewRemove');
//series Genre
Route::post('/series/genre/add', 'ManageSeriesController@addGenre');
Route::post('/series/genre/remove', 'ManageSeriesController@removeGenre');
//series Posters
Route::post('/series/add/poster', 'ManageSeriesController@addPoster');
Route::post('/series/remove/poster', 'ManageSeriesController@removePoster');
//Series Status
Route::get('/series/deactivate/{id}', 'ManageSeriesController@deactivate')->name('series.deactivate');
Route::get('/series/activate/{id}', 'ManageSeriesController@activate')->name('series.activate');

//Seasons
Route::get('/seasons/{id}', 'SeasonsController@index')->name('series.seasons');
Route::get('/seasons/add/{id}', 'SeasonsController@add')->name('add.season');
Route::post('/seasons/add', 'SeasonsController@store')->name('season.post');
Route::get('/seasons/edit/{id}', 'SeasonsController@edit')->name('season.edit');
Route::post('/seasons/update', 'SeasonsController@update')->name('season.update');
Route::get('/seasons/manage/{season}', 'SeasonsController@manage')->name('season.manage');
//Season Cast
Route::post('/season/cast/add', 'SeasonsController@addCast');
Route::post('/season/cast/remove', 'SeasonsController@removeCast');
Route::get('/season/deactivate/{season}', 'SeasonsController@deactivate')->name('season.deactivate');
Route::get('/season/activate/{season}', 'SeasonsController@activate')->name('season.activate');

//Episodes
Route::get('/episodes/{id}', 'EpisodeController@index')->name('season.episodes');
Route::get('/episodes/add/{id}', 'EpisodeController@add')->name('add.episode');
Route::post('/episodes/add', 'EpisodeController@store')->name('episode.store');
Route::get('/episodes/edit/{id}', 'EpisodeController@edit')->name('episode.view');
Route::post('/episodes/edit', 'EpisodeController@update')->name('episode.update');
Route::get('/episodes/deactivate/{episode}', 'EpisodeController@deactivate')->name('episode.deactivate');
Route::get('/episodes/activate/{episode}', 'EpisodeController@activate')->name('episode.activate');

//Distributors
Route::get('/distributors', 'DistributorController@index')->name('distributors');
Route::post('/distributor/store', 'DistributorController@store')->name('distributors.store');
Route::post('/distributor/view', 'DistributorController@view')->name('distributors.view');
Route::post('/distributor/edit', 'DistributorController@edit')->name('distributors.edit');
Route::get('/distributor/delete/{distributor}', 'DistributorController@delete')->name('distributor.delete');
Route::get('/distributor/test', 'DistributorController@test');

//Add Carousal
Route::post('/carousal', 'CarousalController@upload');
Route::get('/carousal/removie/{movie}', 'CarousalController@mRemove')->name('movie.carousal.remove');
Route::get('/carousal/reseason/{season}', 'CarousalController@sRemove')->name('season.carousal.remove');

//Reports
//Movies
Route::get('/reports/movies', 'MovieReportController@index')->name('report.movies');
Route::get('/reports/movies/{id}', 'MovieReportController@detail')->name('report.movie.detail');
Route::post('/reports/movies/montly', 'MovieReportController@montly')->name('report.movie.montly');
//Seasons
Route::get('/reports/seasons', 'SeasonReportController@index')->name('report.seasons');
Route::get('/reports/seasons/{id}', 'SeasonReportController@detail')->name('report.season.detail');
Route::post('/reports/seasons/montly', 'SeasonReportController@montly')->name('report.season.montly');
//User
Route::get('/users/all', 'ReportController@users')->name('users.all');
Route::get('/user/transactions/{user}', 'ReportController@transactions')->name('user.transactions');

//Account Setting
Route::get('/profile', 'AdminController@profile')->name('user.profile');
Route::post('/profile', 'AdminController@profileSave')->name('profile.save');
Route::get('/profile/password', 'AdminController@profilePassword')->name('profile.password');
Route::post('/profile/password', 'AdminController@PasswordChange')->name('profile.password.change');

