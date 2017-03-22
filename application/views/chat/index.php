<div class="container" style="margin-top: 150px;" >
	<div class="row">
		
		<div class="col-md-4">
            <div class="panel panel-success">
			    <div class="panel-heading"><span class="glyphicon glyphicon-user"></span> Users Online</div>
			    <div class="panel-body">
			        <ul class="list-group" id="listaOnline">
			            
			        </ul>
			    </div>
			</div>
        </div>

        <div class="col-md-8">
        	
        	<div class="chat_window">
			    <div class="top_menu">
			        <div class="buttons">
			            <div class="button close"></div>
			            <div class="button minimize"></div>
			            <div class="button maximize"></div>
			        </div>
			        <div class="title">Chat</div>
			    </div>
			    <ul class="messages"></ul>
			    <div class="bottom_wrapper clearfix">
			        <div class="message_input_wrapper">
			            <input class="message_input" placeholder="Type your message here..." />
			        </div>
			        <div class="send_message">
			            <div class="icon"></div>
			            <div class="text">Send</div>
			        </div>
			    </div>
			</div>
			<div class="message_template">
			    <li class="message">
			        <div class="avatar"></div>
			        <div class="text_wrapper">
			            <div class="text"></div>
			        </div>
			    </li>
			</div>

        </div>

	</div>
</div>


<script type="text/javascript">
	
	var url 		= '<?php echo app_url(); ?>';
	var users_id 	= '<?php echo get_users('id'); ?>';
	var email 		= '<?php echo get_users('email'); ?>';
	var surl        = '<?php echo $this->config->item('socker_url'); ?>';
	var room        = 'public';

	var socket  = io.connect(surl);
    socket.emit('join:room', {'room_name' : room, 'email' : email});

    socket.on('message', function(data){

		var $message;
		var message_side = 'left';

        $message = $($('.message_template').clone().html());
        $message.addClass(message_side).find('.text').html(data.content);
        $message.addClass('appeared');
        $message.find('.avatar').css('background-image', 'url(' + data.avatar + ')');
        $('.messages').append($message);
        $('.messages').animate({ scrollTop: $('.messages').prop('scrollHeight') }, 300);

    });

    socket.on('get users',function(data){
		var html = "";
		for(i=0; i<data.length; i++ ){
			html += '<li class="list-group-item"><span class="label label-success">●</span> - '+data[i]+'</li>';
		}
		$('#listaOnline').html(html);

		console.log(data);
	});

	$(window).on('load', function(){
		get_chats(room);
	});

	function get_chats(group)
    {
        $.ajax({
	        url 	: url+'chat/get_chats',
	        data    : 'group='+group,
	        type 	: 'POST',
	        dataType: 'JSON',
	        beforeSend: function()
	        {
	        	
	        },
	        success: function(message)
	        {	
	        	$.each( message.data, function( key, value ) {
	        		var $message;
	        		var message_side = users_id == value.users_id ? 'right' : 'left';

	                $message = $($('.message_template').clone().html());
	                $message.addClass(message_side).find('.text').html(value.content);
	                $message.addClass('appeared');
	                $message.find('.avatar').css('background-image', 'url(' + value.avatar + ')');
	                $('.messages').append($message);
	        	});	
	        	
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            alert('Error adding / update data');
	        }         
	    });
	    return false;
    }

    function send_message(text, group)
    {
    	$.ajax({
	        url 	: url+'chat/send',
	        data    : 'group='+group+'&content='+text,
	        type 	: 'POST',
	        dataType: 'JSON',
	        beforeSend: function()
	        {
	        	
	        },
	        success: function(message)
	        {	
        		if(message.status)
        		{

        			socket.emit('send:message', message);

        			$('.message_input').val('');
        			var $message;
	        		var message_side = 'right';

	                $message = $($('.message_template').clone().html());
	                $message.addClass(message_side).find('.text').html(message.content);
	                $message.addClass('appeared');
	                $message.find('.avatar').css('background-image', 'url(' + message.avatar + ')');
	                $('.messages').append($message);
	                $('.messages').animate({ scrollTop: $('.messages').prop('scrollHeight') }, 300);
        		}
        		
	        	
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            alert('Error adding / update data');
	        }         
	    });
	    return false;
    }

    $(document).on('click', '.send_message', function(e){
    	e.preventDefault();
    	send_message($('.message_input').val(), room)
    });

     $('.message_input').keyup(function (e) {
        if (e.which === 13) {
            send_message($('.message_input').val(), room)
        }
    });




</script>