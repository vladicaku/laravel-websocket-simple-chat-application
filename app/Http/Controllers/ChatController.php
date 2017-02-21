<?php

namespace App\Http\Controllers;

use App\Events\PrivateMessageEvent;
use App\Events\PublicMessageEvent;
use App\User;
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

	public function sendMessage(Request $request) {

		$message = $request->input('message', 'Blank message');
		$exploded = explode(' ', trim($message));
		$receiver = $exploded[0];

		$model = [
			'user' => $this->convertUser($request),
			'time' => date('H:i'),
		];

		if (substr($receiver, 0, 2) === '##') {
			$model['to'] = User::where('email', substr($receiver, 2))->first()->id;
			$model['message'] = substr($message, strlen($receiver));
			broadcast(new PrivateMessageEvent($model))->toOthers();

		} else {
			$model['message'] = $message;
			broadcast(new PublicMessageEvent($model))->toOthers();
		}

		return response()->json([
			'status' => 'ok'
		]);
	}

//	public function sendPublicMessage(Request $request) {
//		$message = $request->input('message', 'Blank message');
//		$model = [
//			'user' => $this->convertUser($request),
//			'message' => $message,
//			'time' => date('H:i')
//		];
//		broadcast(new PublicMessageEvent($model))->toOthers();
//
//		return response()->json([
//			'status' => 'ok'
//		]);
//	}
//
//	public function sendPrivateMessage(Request $request) {
//		$message = $request->input('message', 'Blank message');
//		$to = $request->input('to');
//
//		if ($to == null) {
//			response()->json([
//				'status' => 'error',
//			], 422);
//		}
//
//		$model = [
//			'user' => $this->convertUser($request),
//			'to' => $to,
//			'message' => $message,
//			'time' => date('H:i')
//		];
//		broadcast(new PrivateMessageEvent($model))->toOthers();
//
//		return response()->json([
//			'status' => 'ok'
//		]);
//	}

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