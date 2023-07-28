function chat_send(){
		var content = $("#hy-chat-text").val();
        
        if(content.length == 0 )
        	return;

        $("#hy-chat-text").attr('disabled','disabled');
        $(".hy-chat-send-btn").attr('disabled','disabled');
        
		$.ajax({
			url:hy_chat_www+"ajax"+hy_chat_exp+"hy_chat_send",
			type: 'post',
			data:{
				data:content
			},
			dataType : 'json',
			success:function(e){
                $("#hy-chat-text").removeAttr('disabled');
                $(".hy-chat-send-btn").removeAttr('disabled');

				if(e.error){
					hy_chat_add_li(content,'right',new Date().getTime(),hy_chat_md5,hy_chat_user);
                    $("#hy-chat-text").val('');
				}
				else
					swal("失败",e.data,'error');

			},error:function(){
                $("#hy-chat-text").removeAttr('disabled');
                $(".hy-chat-send-btn").removeAttr('disabled');
				swal('服务器端出错.');
			}
		})
	}
	function hy_chat_add_li(content,pos,time,md5,user){
        var d = new Date(time);
		$("#hy-chat-ul").append('<li class="'+pos+'"><a title="'+user+'" href="javascript:void(0)"><img class="avatar" src="'+hy_chat_WWW+'upload/avatar/'+md5+'-b.jpg" onerror="this.onerror=\'\';this.src=\''+hy_chat_WWW+'public/images/user.gif\'"></a><div class="chat-body clearfix"><p>'+content+'</p><span>'+d.getHours()+":"+d.getMinutes()+":"+d.getSeconds()+'</span></div></li>');
		$('.hy-content').scrollTop( $('.hy-content')[0].scrollHeight );
	}
	window.onload = function(){
        $(".hy-chat-box-img").click(function(){
            $(".hy-chat-box").toggleClass('hy-chat-box-a');
            $('.hy-chat-xx').html('0').hide();
        });
        $("#hy-chat-text").keydown(function(e){
            e = e || window.event; 
            var key = e.whick || e.keyCode; 
            ///console.log(e);
            if(key == 13 || (e.altKey)&&(e.keyCode==83)){
                chat_send();
            }
        })
		window.hy_chat_time = 0;
		setInterval(function(){
			$.ajax({
				url : hy_chat_www+ "ajax"+hy_chat_exp+"hy_chat_get_list",
				type: 'post',
				dataType : 'json',
				data:{
					time:window.hy_chat_time
				},
				success : function(e){
					
					if(e.error){
						window.hy_chat_time = e.atime;
						var chat_mun = 0;
						for(var o in e.data){
							hy_chat_add_li(e.data[o].content,(e.data[o].uid == hy_chat_uid ? 'right' : 'left'),e.data[o].atime*1000,e.data[o].md5,e.data[o].user);
							chat_mun++;
						}
						if(!$(".hy-chat-box").hasClass("hy-chat-box-a")){
							$('.hy-chat-xx').html(parseInt($('.hy-chat-xx').html()) + chat_mun).show() ;
						}
						
					}else{

					}
					
				}
			})
		},1000);
	};