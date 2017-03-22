var io = require('socket.io')(889);
io.on('connection', function(socket){
	console.log('connection');
	socket.on('join:room', function(data){
		var room_name = data.room_name;
		socket.join(room_name);
		console.log(data);
	});

	socket.on('leave:room', function(msg){
		msg.text = msg.user + ' has left the room';
		socket.leave(msg.room);
		socket.in(msg.room).emit('message', msg);
	});

	socket.on('send:message', function(msg){
		socket.in(msg.room).emit('message', msg);
	});

	socket.on('send:notification', function(notif){
		socket.in(notif.room).emit('notification', notif);
	});

	socket.on("typing", function(data) {
		socket.in(data.room).emit("isTyping", data);
	});
});

