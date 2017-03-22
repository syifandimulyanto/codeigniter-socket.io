var io = require('socket.io')(889);
users = [];
io.on('connection', function(socket){

	socket.on('join:room', function(data){
		var room_name = data.room_name;
		socket.join(room_name);

		socket.username = data.email ;
		if ( users.indexOf(socket.username) > -1 ){
			console.log("username sudah ada");
		}else{
			users.push(socket.username);
			socket.in(room_name).emit('get users', users);
		}

	});

	socket.on('send:message', function(msg){
		socket.in(msg.room).emit('message', msg);
	});

	socket.on('disconnect',function(data){
		users.splice(users.indexOf(socket.username),1);
		socket.in('public').emit('get users', users);
	});

});

