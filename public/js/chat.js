import Echo from "laravel-echo"

var avatarUrl = 'http://bootdey.com/img/Content/avatar/';

$(document).ready(function () {

	var chatDiv = $("#messages");
	var usersDiv = $("#active-users");

	var messageReceived = function (data) {
		let element = `<div class="answer left">
					<div class="avatar">
						<img src="${avatarUrl}/${data.user.avatar}.png" alt="User name">
						<!--<div class="status offline"></div>-->
					</div>
					<div class="name">${data.user.name}</div>
					<div class="text">
						${data.message}
					</div>
					<div class="time">${data.time}</div>
				</div>`;
		$(element).appendTo(chatDiv);
		chatDiv.scrollTop(chatDiv.prop("scrollHeight"));
	};

	var sendMessage = function (message) {
		let currentDate = new Date();
		let currentTime = currentDate.getHours() + ":" + currentDate.getMinutes();
		let element = `<div class="answer right">
					<div class="avatar">
						<img src="${avatarUrl}/${me.avatar}.png" alt="User name">
						<!--<div class="status offline"></div>-->
					</div>
					<div class="name">${me.name}</div>
					<div class="text">
						${message}
					</div>
					<div class="time">${currentTime}</div>
				</div>`;

		$.ajax({
			url: "/chat/send-public-message",
			type: "get",
			data: {
				'message': message
			},
			beforeSend: function (request) {
				request.setRequestHeader("X-Socket-ID", window.Echo.socketId());
			},
			success: function (response) {
				$(element).appendTo(chatDiv);
				chatDiv.scrollTop(chatDiv.prop("scrollHeight"));
			},
			error: function (xhr) {
			}
		});
	};

	var leaving = function (user) {
		$("#user-"+user.id).remove();
	};

	var joining = function (user) {
		let element = `<div class="user" id="user-${user.id}">
						<div class="avatar">
						<img src="${avatarUrl}/${user.avatar}.png" alt="User name">
							<div class="status online"></div>
						</div>
						<div class="name">${user.name}</div>
						<div class="mood">${user.email}</div>
					</div>`;
		$(element).appendTo(usersDiv);
	};

	/* Setup Echo and join canals */
	window.Echo = new Echo({
		broadcaster: 'pusher',
		key: '6d65a89a5dfca1979c22',
		cluster: 'eu'
	});

	window.Echo.channel('public').listen('PublicMessageEvent', (e) => {
		messageReceived(e.data);
	});

	window.Echo.join('public')
		.here((users) => {
			users.forEach( u => joining(u));
		})
		.joining((user) => {
			joining(user);
		})
		.leaving((user) => {
			leaving(user);
		});

	/* Button click and input on Enter key press */
	$("#send-button").click(function () {
		sendMessage($("#message-input").val());
		$("#message-input").val('');
	});

	$("#message-input").keypress(function (e) {
		if (e.which == 13) {
			sendMessage($("#message-input").val());
			$("#message-input").val('');
			return false;
		}
	});
});