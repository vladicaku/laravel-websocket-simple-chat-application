import Echo from "laravel-echo"

var avatarUrl = 'http://bootdey.com/img/Content/avatar/';

$(document).ready(function () {

	var chatDiv = $("#messages");
	var usersDiv = $("#active-users");

	var messageReceived = function (data, isPrivate = false) {
		let clazz = isPrivate == true ? 'private-message' : '';
		let from = (isPrivate == true ? 'Private message from ' : '') + data.user.name;

		let element = `<div class="answer left ${clazz}">
					<div class="avatar">
						<img src="${avatarUrl}/${data.user.avatar}.png" alt="User name">
						<!--<div class="status offline"></div>-->
					</div>
					<div class="name">${from}</div>
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
		let currentTime = ('0' + currentDate.getHours()).slice(-2) + ":" + ('0' + currentDate.getMinutes()).slice(-2);

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
			url: "/chat/send-message",
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

	/* Setup Echo */
	window.Echo = new Echo({
		broadcaster: 'pusher',
		key: '6d65a89a5dfca1979c22',
		cluster: 'eu'
	});

	/* Join public channel */
	window.Echo.join('public')
		.here((users) => {
			$('.user').remove();
			users.forEach( u => joining(u));
		})
		.joining((user) => {
			joining(user);
		})
		.leaving((user) => {
			leaving(user);
		}).listen('PublicMessageEvent', (e) => {
		messageReceived(e.data);
	});

	/* Join my private channel */
	window.Echo.private('user-' + me.id).listen('PrivateMessageEvent', (e) => {
		messageReceived(e.data, true);
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