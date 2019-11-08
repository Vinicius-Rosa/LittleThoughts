$(function(){

	$("#form_login").submit(function(){
		$.ajax({
			type: "post",
			url: URL+"login/exeLoginAjax",
			dataType: "json",
			data:  $(this).serialize(),

			beforeSend: function(){
				clearErrors();
				$("#error").html("Verificando...");
			},

			success: function(dataResponse){
				if(dataResponse["status"] == 1){
					$("#error").html("Logando...");
					window.location.href = URL+"home/index";
				}else{
					showErrors(dataResponse["errorList"]);
				}
			}
		})

		return false;
	})
})