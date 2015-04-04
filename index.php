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

			$.ajax({
				url:"file/city.json",type:"GET",dataType:"json",
				data:{},
				success:function(data){
					$("#city").html("");
					for(i=0;i<data.length;i++){
						$("#city").append(
							"<option>"+data[i]["city"]+"</option>"
						);
					}
				},
				error:function(data){
					console.log("json error");
				}
			});

			$("#info_btn").click(function(){//點下個人資訊按鈕
				$.ajax({
					url:"option.php?opt=getInfo",type:"POST",dataType:"json",
					data:{},
					success:function(data){
						$("#Username").text(data[0]["Username"]);
						$("#Nickname").val(data[0]["Nickname"]);
						$("#Sex").val(data[0]["Sex"]);
						$("#Birth").val(data[0]["Birth"]);
						$("#city").val(data[0]["City"]);

						var getTown = data[0]["Town"];

						$.ajax({
							url:"file/town.json",type:"GET",dataType:"json",
							data:{},
							success:function(data){
								$("#town").html("");
								for(i=0;i<data.length;i++){
									if($("#city").val() == data[i]["city"]){
										$("#town").append(
											"<option>"+data[i]["town"]+"</option>"
										);
									}
								}
								$("#town").val(getTown);
							},
							error:function(data){
								console.log("json error");
							}
						});
					},
					error:function(data){}
				});
			});//點下個人資訊按鈕

			$("#city").change(function(){//更變縣市選項時，抓出鄉鎮資料
				var getCity = $(this).val();

				$.ajax({
					url:"file/town.json",type:"GET",dataType:"json",
					data:{},
					success:function(data){
						$("#town").html("");
						for(i=0;i<data.length;i++){
							if(data[i]["city"] == getCity){
								$("#town").append(
									"<option>"+data[i]["town"]+"</option>"
								);
							}
						}
					},
					error:function(data){
						console.log("json error");
					}
				});
			});//更變縣市選項時，抓出鄉鎮資料

			$("#update_info_btn").click(function(){//更新個人資訊
				$.ajax({
					url:"option.php?opt=update_info",type:"POST",dataType:"json",
					data:{
						Username:$("#Username").text(),
						Nickname:$("#Nickname").val(),
						Sex:$("#Sex").val(),
						Birth:$("#Birth").val(),
						City:$("#city").val(),
						Town:$("#town").val()
					},
					success:function(data){
						$("#update_info_success").fadeIn(300).delay(1000).fadeOut(300);
					},
					error:function(data){}
				});
			});//更新個人資訊

			function join_chat_room(){
				var room_id = $("#room").val();
				if((/^(\+|-)?\d+$/.test( room_id )) && room_id>0){
					location.assign("chat.php?room="+room_id);
				}
				else{
					$("#error>span").text("請輸入正整數");
					$("#error").fadeIn(300).delay(1000).fadeOut(300);
				}
			}

			$("#join_room_btn").bind("click",function(){
				join_chat_room();				
			});

			$("#room").bind("keypress",function(e){
				if(e.which == 13){
					join_chat_room();
					$(this).val("");
				}
			});
		});
		</script>

		<style>
		#control tr td{
			border-top: none;
			vertical-align: bottom;
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
										<button id="info_btn" class="btn btn-success" data-toggle="modal" data-target="#info">
											個人資訊
										</button>
									</td>
								</tr>
							</table>
						</div>
					</div><br>
				</div>

				<div class="col-sm-6">
					<h3>
						<span class="text-info">
							登入聊天室(若聊天室不存在則建立新聊天室)
						</span>
					</h3>
					<div class="form-inline">
						<input id="room" placeholder="聊天室ID" class="form-control"/>
						&nbsp;&nbsp;
						<button id="join_room_btn" class="btn btn-success">進入</button>
					</div>
					<br><br>

					<div id="error" class="alert alert-danger" style="display:none;">
						<span></span>
					</div>
				</div>
			</div>
		</div>

		<?php include("include/logout.php"); ?>
		<?php include("include/info.php"); ?>
	</body>
</html>