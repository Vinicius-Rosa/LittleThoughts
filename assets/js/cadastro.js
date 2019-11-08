$(function(){

	$("#form_cad").submit(function(){
		$.ajax({
			type: "post",
			url: URL+"cadastro/exeCadastroAjax",
			dataType: "json",
			data:  $(this).serialize(),

			beforeSend: function(){
				clearErrors();
				$("#error").html("Verificando...");
			},

			success: function(dataResponse){
				if(dataResponse["status"] == 1){
					$("#error").html("Cadastrando...");
					window.location.href = URL+"login/index";
				}else{
					showErrors(dataResponse["errorList"]);
				}
			}
		})

		return false;
	})
})