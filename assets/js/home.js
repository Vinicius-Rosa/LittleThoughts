window.onload = function()  {
            CKEDITOR.replace( 'editor1' );
        };

function setCKEditorToTextarea() {
	for(var instanceName in CKEDITOR.instances)
	CKEDITOR.instances[instanceName].updateElement('.thoughts');            
}

function excluir(id){
	var id = id;

	$.ajax({
		type: "post",
		url: URL+"home/delHistoryAjax",
		dataType: "json",
		data: {id : id},
		success: function(data){
			if(data["error"] == 1){
				$("#"+id).remove();
			}else{
				alert("Algo deu errado!");
			}
		}
	})
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
					$("#teste").prepend('<div id="'+data["history"][0]["id_history"]+'" class="thoughts">'
						+'<a class="excluir" onclick="excluir('+data["history"][0]["id_history"]+')"><i class="fas fa-trash"></i></a>'
						+data["history"][0]["codigo_fonte"]+"</div>");
				}else{
					alert("Algo deu errado!");
				}
			}
		})

		return false;
	})

	

})

$('li a').click(function(e){
	e.preventDefault;

	var id = $(this).attr('href');
		targetOffset = $(id).offset().top;

	$('html, body').animate({
		scrollTop: targetOffset
	}, 500);
});