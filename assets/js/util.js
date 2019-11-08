const URL = "http://localhost/littleThoughts/";

function clearErrors(){
	$(".has-error").removeClass("has-error");
	$(".help-block").html("");
}

function showErrors(error_list){
	clearErrors();

	$.each(error_list, function(id, message){
		console.log(id);
		$("#"+id).addClass("has-error");
		$("#"+id).html(message+ "<br>")
	})
}