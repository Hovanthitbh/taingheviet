$(document).ready(function(){
	$(".city").change(function(){
		var idtp = $(".city").val();
		// alert(idtp);
		$.post("data.php", {idtp: idtp}, function(data){
			$(".district").html(data);
		});
	});
	$(".district").change(function(){
		var idqh = $(".district").val();
		// alert(idqh);
		$.post("data.php", {idqh: idqh}, function(data){
			$(".wards").html(data);
		});
	});
});