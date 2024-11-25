<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use App\Models\Chats;
use App\Events\WebRTCSignalEvent;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Str;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Messanger

Route::get('/', 'HomeController@index')->name('home');

Route::get('/test', 'HomeController@test')->name('home');

// Если пользователь гость
Route::middleware('guest')->namespace('\App\Http\Controllers')->group(function() {
	Route::get('/login', 'AuthController@index')->name('login');
	
	Route::post('/login', 'AuthController@postSignin')->name('post_signin');

	Route::get('/reg', 'RegistrationController@index')->name('reg');
	
	Route::post('/reg', 'RegistrationController@submit')->name('registration_submit');
});


// Если пользователь авторизирован
Route::middleware('auth')->namespace('\App\Http\Controllers')->group(function() {
	Route::get('/chat', 'ChatsController@index')->name('chat');

	Route::post('/chat/send_message', 'ChatsController@send_message')->name('send_message');

	Route::get('images/{filename}', function ($filename) {
		return response()->file(storage_path('app/images/' . $filename));
	});

	Route::get('chat/images/{filename}', function ($filename) {
		return response()->file(storage_path('app/images/' . $filename));
	});

	Route::get('/clear-images', function () {
		$files = \Storage::files('images');
		foreach ($files as $file) {
			\Storage::delete($file);
		}
		return response()->json(['success' => true, 'message' => 'All images cleared.']);
	});

	Route::get('/chat/{id}', 'ChatsController@index_with_id')->name('chat_with_id');

	Route::get('/switch_language/{language}', 'LanguageController@switchLanguage')->name('switchLanguage');

	Route::post('/logout', 'AuthController@logout')->name('logout');

	Route::post('/chat/remove_messages', 'MessageController@remove_messages')->name('remove_messages');

	Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
        return Chats::has_access($chatId,$user->id) ? true : false;
    });

	Broadcast::channel('user.{user_id}', function ($user_id) {
        return true;
    });


	Route::post('/chat_top_bar/{user_id}', function($user_id){
		$user_details = UserDetails::where('user_id', '=', $user_id)->first();

		$chat_details = (object)[
			'details' => (object)[
				'username' => $user_details->nickname
			]
		];

		return view('include.chat_topbar', ['chat_details' => $chat_details]);
	});

	Route::post('/chat_messages_bar/{chat_id}', function($chat_id){
		$chat_details = [
			'details' => (object)[
				'chat_id' => $chat_id
			],
			'messages' => null
		];
		return view('include.chat_messages', ['chat_details' => $chat_details]);
	});

	Route::post('/chat_bottom_bar', function(){
		return view('include.chat_bottom_bar');
	});

	// Модальные окна
	Route::get('/modal_settings', function () {
		$locale = session('locale', 'ru');
		$user = User::get();
        $user_details = UserDetails::where('user_id', '=', $user->id)->first();
		return view('modals.settings_modal', ['user' => $user, 'user_details' => $user_details, 'locale' => $locale]);
	})->name('modal_settings');

	Route::get('/modal_crop', function () {
		return view('modals.crop_modal');
	})->name('modal_crop');

	Route::get('/account_settings_page', function () {
		return view('modals.modal_settings_pages.account_settings_page');
	})->name('account_settings_page');

	Route::get('/chats_settings_page', function () {
		return view('modals.modal_settings_pages.chats_settings_page');
	})->name('chats_settings_page');

	Route::get('/confidentiality_settings_page', function () {
		return view('modals.modal_settings_pages.confidentiality_settings_page');
	})->name('confidentiality_settings_page');

	Route::get('/folders_settings_page', function () {
		return view('modals.modal_settings_pages.folders_settings_page');
	})->name('folders_settings_page');

	Route::get('/notification_settings_page', function () {
		return view('modals.modal_settings_pages.notification_settings_page');
	})->name('notification_settings_page');

	Route::get('/modal_language', function () {
		$locale = session('locale', 'ru');
		$user = User::get();
        $user_details = UserDetails::where('user_id', '=', $user->id)->first();
		return view('modals.settings.modal_language', ['user_details' => $user_details, 'locale' => $locale]);
	})->name('modal_language');

	Route::get('/message_context_menu', function () {
		return view('include.context_menu.message_context_menu');
	})->name('message_context_menu');

	Route::get('/modal_username_settings', function () {
		$user = User::get();
		$userDetails = UserDetails::where('user_id', '=', $user->id)->first();
		return view('modals.modal_settings_pages.account_settings.modal_username_settings', ['nickname' => $userDetails->nickname]);
	})->name('modal_username_settings');

	Route::get('/modal_tag_settings', function () {
		$user = User::get();
		$userDetails = UserDetails::where('user_id', '=', $user->id)->first();
		return view('modals.modal_settings_pages.account_settings.modal_tag_settings', ['tag' => $userDetails->tag]);
	})->name('modal_tag_settings');


	Route::get('/update_user_nickname/{nickname}', function($nickname){
		UserDetails::createOrUpdate(['nickname' => $nickname]);
	});

	Route::get('/update_user_tag/{tag}', function($tag){
		$newTag = Str::remove('@', $tag);
		UserDetails::createOrUpdate(['tag' => '@' . $newTag]);
	});
});   

Route::middleware('auth')->get('/chat/{id}', 'ChatsController@index_with_id')->name('chat_with_id');
// Anime

Route::get('/anime', 'AnimeController@index')->name('anime');