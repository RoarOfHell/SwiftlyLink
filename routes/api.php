<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Events\UserTyping;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('checkAppToken')->post('/login', 'AuthController@login');

Route::middleware('checkAppToken')->post('/download_vp', 'FileController@download_vp');

Route::middleware('checkToken')->post('/get_keys', 'PersonalKeys@get');

Route::middleware('checkToken')->get('/user', function (Request $request) {
    $user = Auth::guard('api')->user();
    return $user;
});

Route::middleware('checkToken')->post('/upload_avatar', 'ImageUploadController@upload')->name('upload_avatar');

Route::middleware('checkToken')->get('/search_users', function (Request $request) {
    $search_text = $request->query('search');
    $user = Auth::guard('api')->user();

    $chat_users = DB::table('users')
    ->join('chat_members as cm1', 'users.id', '=', 'cm1.user_id')
    ->join('chats', 'cm1.chat_id', '=', 'chats.id')
    ->join('chat_members as cm2', 'chats.id', '=', 'cm2.chat_id')
    ->leftJoin(DB::raw('(SELECT chat_id, MAX(created_at) as last_message_time FROM messages GROUP BY chat_id) as latest_messages'), 'chats.id', '=', 'latest_messages.chat_id')
    ->leftJoin('messages', function($join) {
        $join->on('messages.chat_id', '=', 'chats.id')
             ->on('messages.created_at', '=', 'latest_messages.last_message_time');
    })
    ->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')
    ->where('chats.chat_type_id', 1) // Личные чаты
    ->where('cm2.user_id', $user->id) // Чат должен содержать текущего пользователя
    ->where('users.id', '!=', $user->id) // Исключаем самого пользователя
    ->where('user_details.nickname', 'LIKE', '%'.$search_text.'%')
    ->select(
        'users.id',
        'user_details.nickname as username',
        'users.status',
        'users.created_at',
        'users.last_login_at',
        'users.updated_at',
        'latest_messages.last_message_time', // Время последнего сообщения
        'messages.encrypted_content as last_message', // Последнее сообщение
        'user_details.avatar_path as avatar_path',
        DB::raw("SUM(CASE WHEN messages.status_id = 2 AND messages.sender_id != '$user->id' THEN 1 ELSE 0 END) as unread_messages") // Непрочитанные сообщения
    )
    ->groupBy(
        'users.id',
        'user_details.nickname',
        'users.status',
        'users.created_at',
        'users.last_login_at',
        'users.updated_at',
        'messages.encrypted_content',
        'latest_messages.last_message_time',
        'user_details.avatar_path'
    )
    ->orderBy('latest_messages.last_message_time', 'desc')
    ->get();

    $searched_users = DB::table('users')
    ->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')
    ->where('users.id', '!=', $user->id) // Исключаем текущего пользователя
    ->where('user_details.nickname', 'LIKE', '%' . $search_text . '%') // Ищем пользователей по частичному совпадению никнейма
    ->select('users.id', 'user_details.nickname as username', 'users.status', 'users.created_at', 'users.last_login_at','users.updated_at')
    ->distinct()
    ->get();

    $search_result = (object)[
        'chat_users' => $chat_users,
        'searched_users' => $searched_users
    ];

    return $search_result;
});

Route::middleware('checkToken')->get('/user-typing', function (Request $request) {
    $chatId = $request->input('chat_id');
    $userId = $request->input('user_id');
    $isTyping = $request->input('is_typing');
    // Вызовите событие только если статус изменился
    broadcast(new UserTyping($chatId, $userId, $isTyping));

    return response()->json(['success' => true, 'typing' => $isTyping]);
});


Route::middleware('checkToken')->get('/set_offline', function (Request $request) {
    $user = Auth::guard('api')->user();

    if ($user) {
        $user->update([
            'status' => 'offline',
            'last_login_at' => now(),
        ]);
    }
    return json_encode('seccess');
});

Route::middleware('checkToken')->get('/set_online', function (Request $request) {
    $user = Auth::guard('api')->user();

    if ($user) {
        $user->update([
            'status' => 'online',
            'last_login_at' => now(),
        ]);
    }
    return json_encode('seccess');
});

Route::middleware('checkToken')->get('/get_new_chat_id', 'ChatsController@get_new_temp_chat_id');