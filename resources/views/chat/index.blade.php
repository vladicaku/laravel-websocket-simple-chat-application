<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<!--<link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">-->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
		  crossorigin="anonymous">
	<link href="css/style.css" rel="stylesheet">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Laravel Websocket Showcase</title>
	<!-- Scripts -->
	<script>
		window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
	</script>
</head>
<body>
<div class="">
	<div class="">
		<div id="active-users" class="">
			<h6>Online</h6>

		</div>

		<div id="chat" class="">
			<div id="messages">

			</div>

			<div id="controls" class="">
				<div id="buttons" class="">
					<a id="send-button" class="btn btn-success">Send</a>
				</div>
				<div id="message">
					<input id="message-input" type="text" placeholder="Type a message...">
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Scripts -->
<script>
	var me = {
		'id': '{{$user->id}}',
		'name': '{{$user->name}}',
		'email': '{{$user->email}}',
		'avatar': '{{$user->avatar}}'
	}
</script>
<script src="/js/chat-bundle.js"></script>
</body>
</html>