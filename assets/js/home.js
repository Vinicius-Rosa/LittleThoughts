function setCKEditorToTextarea() {
	for(var instanceName in CKEDITOR.instances)
	CKEDITOR.instances[instanceName].updateElement('.thoughts');            
}



$(function(){

	$("#form-thoughts").submit(function(){

		$.ajax({
			type: "post",
			url: URL+"home/addHistoryAjax",
			dataType: "json",
			data: { 
				codigo : CKEDITOR.instances.editor1.getData()
			},

			success: function(data){
				if(data["error"] == 1){
					CKEDITOR.instances.editor1.setData( '', function() { this.updateElement(); });
					$("#teste").html('');
					for(i = 0; i<data["qtd"]; i++){
						$("#teste").append("<div class='thoughts'>"+data["historys"][i]["codigo_fonte"]+"</div>");
					}
					//window.location.href = URL+"home/index";
				}else{
					alert("deu ruim");
				}
			}
		})

		return false;
	})


})

$('li a').click(function(e){
	e.preventDefault;

	var id = $(this).attr('href'),
		targetOffset = $(id).offset().top;

	$('html, body').animate({
		scrollTop: targetOffset
	}, 500);
});