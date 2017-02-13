<?php

namespace App\Http\Controllers;

use App\Events\PublicMessageEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChatController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index(Request $request) {
		$user = $this->convertUser($request);
		return view('chat.index', compact('user'));
	}

	public function sendPublicMessage(Request $request) {
		$message = $request->input('message', 'Blank message');
		$model = [
			'user' => $this->convertUser($request),
			'message' => $message,
			'time' => date('H:i')
		];
		broadcast(new PublicMessageEvent($model))->toOthers();
	}

	public function convertUser(Request $request) {
		$user = Auth::user();
		if (!$request->session()->has("avatar")) {
			$request->session()->put("avatar", 'avatar' . rand(1, 7));
		}

		$model = new \stdClass();
		$model->id = $user->id;
		$model->name = $user->name;
		$model->email = $user->email;
		$model->avatar = $request->session()->get("avatar");

		return $model;
	}


}