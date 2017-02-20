<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/


use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Request;


Broadcast::channel('App.User.{id}', function ($user, $id) {
	return (int)$user->id === (int)$id;
});

Broadcast::channel('public', function ($user) {
	if (!Request::session()->has("avatar")) {
		Request::session()->put("avatar", 'avatar' . rand(1, 7));
	}

	return [
		'id' => $user->id,
		'name' => $user->name,
		'email' => $user->email,
		'avatar' => Request::session()->get("avatar"),
	];
});

Broadcast::channel('user-{userId}', function ($user, $userId) {
    return $user->id === $userId;
});