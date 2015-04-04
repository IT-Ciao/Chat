 <?php
	session_start();
	if(!isset($_SESSION["chat_auth"]))	header("Location:login.php");
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<title>Chat</title>
		<link rel="icon" href="">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
		<script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script><!-- bootstrap -->
		<script src="js/action.js"></script>
		<script>
		$(function(){
			var socket = io.connect("http://localhost:8080");
			socket.on("connect",function(){});
			var getUser = $("#user").val();
			
			function getTime(){
				var t = new Date();
				var y = t.getFullYear() , m = t.getMonth()+1 , d = t.getDate();
				var h = t.getHours() , i = t.getMinutes() , s = t.getSeconds();
				if(m < 10)	m = "0"+m;
				if(d < 10)	d = "0"+d;
				if(h < 10)	h = "0"+h;
				if(i < 10)	i = "0"+i;
				if(s < 10)	s = "0"+s;
				var time = y+"-"+m+"-"+d+" "+h+":"+i+":"+s;
				return time;
			}

			function log(msg){
				$("#console").append("<div class='msg_container'>"+msg+"</div><br>");
			}

			function scroll(){
				var $console = $("#console");
				$console.animate({
					scrollTop:$("#console")[0].scrollHeight
					//$("#console")[0].scrollHeight為實際console內部的高度
				},300);
			}

			socket.emit("addUser",getUser);//新增使用者到socket

			socket.on("UserState",function(server_msg){
				log("<span class='server_msg'>伺服器</span>:"+server_msg);
				if(server_msg.match("歡迎") == null){
					scroll();
				}
			});

			socket.on("broadcastMsg",function (user,msg,time){//接收訊息再廣播
				log(user+":"+msg+" <span class='time'>"+time+"</span>");
				scroll();
			});//接收訊息再廣播

			$.ajax({//取得聊天記錄
				url:"option.php?opt=get_chat_log",type:"POST",dataType:"json",
				data:{
					Room:$("#getRoom").val()
				},
				success:function(data){					
					for(i=0;i<data.length;i++){
						var user = data[i]["User"];
						var msg = data[i]["Msg"];
						var time = data[i]["Time"];

						log("<span class='user_msg'>"+user+"</span>:"+msg+" <span class='time'>"+time+"</span>");						
					}
					scroll();
				},
				error:function(data){}
			});//取得聊天記錄


			$("#content").keypress(function (e){//按下Enter傳送訊息
				var msg = $(this).val();

				if(e.which == "13" && msg != ""){
					var time = getTime();
					log("<span class='user_msg'>"+getUser+"</span>:"+msg+" <span class='time'>"+time+"</span>");
					socket.emit("sendMsg",getUser,msg,time);
					$(this).val("");

					scroll();

					$.ajax({
						url:"option.php?opt=addMsg",type:"POST",dataType:"json",
						data:{
							User:$("#user").val(),
							Room:$("#getRoom").val(),
							Msg:msg,
							Time:time
						},
						success:function(data){},
						error:function(data){}
					});
				}
			});//按下Enter傳送訊息

			$("#goIndex").click(function(){
				location.assign("index.php");
			});

		});
		</script>

		<style>
		#console{
			background-color: white;
			width: 100%;	height: 400px;
			overflow: auto;		padding: 10px;
			background-image: url("img/bk.jpg");
			background-repeat: repeat;
		}
		
		.server_msg{
			color: red;	
		}
		.user_msg{
			color: blue;
		}
		.time{
			font-size: 8px;		color: gray;
			float: right;
		}

		#control tr td{
			border-top: none;
			vertical-align: bottom;
			vertical-align:text-bottom;
		}

		#changePW_btn{
			color:red;
		}
		#changePW_btn:hover{
			color: orange;
		}
		</style>
	</head>

	<body>
		<input id="user" value="<?php echo $_SESSION["chat_auth"];?>" type="hidden"/>
		<input id="getRoom" value="<?php echo $_GET["room"]; ?>" type="hidden"/>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">

					<div class="row">
						<div class="col-sm-6">
							<table class="table" id="control">
								<tr>
									<td>
										<h1>
											<label class="label label-warning">
												<?php echo $_SESSION["chat_auth"];?>
											</label>
										</h1>
									</td>

									<td>
										<button class="btn btn-info" data-toggle="modal" data-target="#logout_confirm">
											登出
										</button>
									</td>

									<td>
										<button id="goIndex" class="btn btn-success">
											回主頁
										</button>
									</td>

									<td>										
										<div class="form-inline">
											<h3 class="text-danger">
												聊天室:
												<?php echo $_GET["room"]; ?>
											</h3>
										</div>
									</td>
								</tr>
							</table>
						</div>
					</div><br>
				</div>

				<div class="col-sm-6">
					<div id="console"></div><br>

					<input id="content" class="form-control" placeholder="輸入聊天內容"/>
				</div>

				<br><br><br>			
			</div>
		</div>

		<?php include("include/logout.php"); ?>
	</body>
</html>