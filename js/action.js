$(function(){
	$("#logout_now").click(function(){
		$.ajax({
			url:"option.php?opt=logout",type:"POST",dataType:"json",
			data:{},
			success:function(data){
				location.reload();
			},
			error:function(data){}
		});
	});
});