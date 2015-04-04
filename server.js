var app = require("http").createServer().listen(8080,function(){
	console.log("server start on port 8080\n");
});

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

var io = require("socket.io").listen(app);
io.sockets.on("connect",function (socket){
	var username;

	socket.on("addUser",function (user){//登入
		console.log(user+" connect success!\n");
		username = user;

		socket.emit("UserState",user+",歡迎登入!");
		socket.broadcast.emit("UserState",user+"上線!");//全體廣播
	});//登入

	socket.on("sendMsg",function (getUser,msg,time){//傳送訊息
		socket.broadcast.emit("broadcastMsg",getUser,msg,time);
		console.log(getUser+":"+msg+"\ts("+time+")\n");
	});//傳送訊息

	socket.on("disconnect",function(){
		var msg = "已離線";
		var time = getTime();
		socket.broadcast.emit("UserState",username+"已離線");//全體廣播
		console.log(username+" disconnect\n");
	});

});
