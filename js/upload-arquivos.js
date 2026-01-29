
$(document).ready(function(){
	
	uploadCPF();

    uploadCPFResponsavelAdicional();

    uploadCNPJ();

    uploadContratoSocial();

    uploadResidencia();

    uploadCPFDependente();
		
});

function uploadCPF(){
	
	if($("#UploadCPF").length > 0){
		
		var objCPF = $(".box-upload-imagem-cpf");
	
		var diretorioUpload = objCPF.find('#UploadCPF').attr("diretorioUpload");
		
		objCPF.find('#UploadCPF').uploadifive({
	
			//---------------------------------------------------
		
			// uploadifive options..
		
			//---------------------------------------------------
			
			'checkScript'     : '../frameworks/uploadifive/check-exists.php',
		
			'uploadScript'    : '../frameworks/uploadifive/uploadifive.php',
			
			'multi'           : false,
            
            'fileType'        : 'image/*,application/pdf',
			
			'buttonText'      : 'Selecione um arquivo',
			
			'removeCompleted' : true,
			
			'formData'        : {								
								'timestamp'      : objCPF.find(".btUpload").attr("timestamp"),
								'token'          : objCPF.find(".btUpload").attr("token"),
								'folder'         : diretorioUpload
							  },
			
			'onUploadComplete':function (file, data) {
				
				objCPF.find('.divImg').find(".visualizar-arquivo").attr("href","../"+diretorioUpload+"/"+data);

                objCPF.find('.divImg').find(".excluir-arquivo").attr("arquivo","../"+diretorioUpload+"/"+data);

                objCPF.find(".upImg").val(data);
				
				objCPF.find('.divImg').show();
				
				objCPF.find(".btUpload").hide();
			}
			
			
		});
	
	
		//################################# EXCLUIR IMAGEM ##################################
		
		objCPF.find(".excluir-arquivo").click(function(){
            
            var id = $(this).attr("id");
            
            var img = $(this).attr("arquivo");
            
            var modulo = $(this).parents(".conteudoInterno").attr("modulo");
            
            $.post(		
                'action.php',
                {id:id, tipo:"anexo_cpf", img:img, action:"excluirImg"},
                function(response){
                    
                    
                    if(!response.erro && response.salvo){
                    
                        objCPF.find(".divImg").hide();
                        
                        objCPF.find(".upImg").val("");
                        
                        objCPF.find(".btUpload").show();
                        
                    }
                    
                },"json"
            
            );
            
        });	
	
	}
	
}

function uploadCPFResponsavelAdicional(){
	
	if($(".box-anexo-responsavel-adicional input[name='UploadCPFadicional[]']").length > 0){

        $(".box-anexo-responsavel-adicional input[name='UploadCPFadicional[]']").each(function(){

            var objCPFAdicional = $(this).parents(".box-upload-imagem-cpf-responsavel-adicional");
	
            var diretorioUpload = $(this).attr("diretorioUpload");

            var id = $(this).attr("id");
                        
            $("#"+id).uploadifive({
        
                //---------------------------------------------------
            
                // uploadifive options..
            
                //---------------------------------------------------
                
                'checkScript'     : '../frameworks/uploadifive/check-exists.php',
            
                'uploadScript'    : '../frameworks/uploadifive/uploadifive.php',
                
                'multi'           : false,
                
                'fileType'        : 'image/*,application/pdf',
                
                'buttonText'      : 'Selecione um arquivo',
                
                'removeCompleted' : true,
                
                'formData'        : {								
                                    'timestamp'      : objCPFAdicional.find(".btUpload").attr("timestamp"),
                                    'token'          : objCPFAdicional.find(".btUpload").attr("token"),
                                    'folder'         : diretorioUpload
                                },
                
                'onUploadComplete':function (file, data) {
                    
                    objCPFAdicional.find('.divImg').find(".visualizar-arquivo").attr("href","../"+diretorioUpload+"/"+data);

                    objCPFAdicional.find('.divImg').find(".excluir-arquivo").attr("arquivo","../"+diretorioUpload+"/"+data);

                    objCPFAdicional.find(".upImg").val(data);
                    
                    objCPFAdicional.find('.divImg').show();
                    
                    objCPFAdicional.find(".btUpload").hide();
                }
                
                
            });
        
        
            //################################# EXCLUIR IMAGEM ##################################
            
            objCPFAdicional.find(".excluir-arquivo").click(function(){
                
                var id = $(this).attr("id");
                
                var img = $(this).attr("arquivo");
                
                var modulo = $(this).parents(".conteudoInterno").attr("modulo");
                
                $.post(		
                    'action.php',
                    {id:id, tipo:"anexo_cpf", img:img, action:"excluirImgResponsavelAdicional"},
                    function(response){
                        
                        
                        if(!response.erro && response.salvo){
                        
                            objCPFAdicional.find(".divImg").hide();
                            
                            objCPFAdicional.find(".upImg").val("");
                            
                            objCPFAdicional.find(".btUpload").show();
                            
                        }
                        
                    },"json"
                
                );
                
            });


        });
	
	}
	
}

function uploadCNPJ(){
	
	if($("#UploadCNPJ").length > 0){
		
		var objCNPJ = $(".box-upload-imagem-cnpj");
	
		var diretorioUpload = objCNPJ.find('#UploadCNPJ').attr("diretorioUpload");
		
		objCNPJ.find('#UploadCNPJ').uploadifive({
	
			//---------------------------------------------------
		
			// uploadifive options..
		
			//---------------------------------------------------
			
			'checkScript'     : '../frameworks/uploadifive/check-exists.php',
		
			'uploadScript'    : '../frameworks/uploadifive/uploadifive.php',
			
			'multi'           : false,
            
            'fileType'        : 'image/*,application/pdf',
			
			'buttonText'      : 'Selecione um arquivo',
			
			'removeCompleted' : true,
			
			'formData'        : {								
								'timestamp'      : objCNPJ.find(".btUpload").attr("timestamp"),
								'token'          : objCNPJ.find(".btUpload").attr("token"),
								'folder'         : diretorioUpload
							  },
			
			'onUploadComplete':function (file, data) {
				
				objCNPJ.find('.divImg').find(".visualizar-arquivo").attr("href","../"+diretorioUpload+"/"+data);

                objCNPJ.find('.divImg').find(".excluir-arquivo").attr("arquivo","../"+diretorioUpload+"/"+data);

                objCNPJ.find(".upImg").val(data);
				
				objCNPJ.find('.divImg').show();
				
				objCNPJ.find(".btUpload").hide();
			}
			
			
		});
	
	
		//################################# EXCLUIR IMAGEM ##################################
		
		objCNPJ.find(".excluir-arquivo").click(function(){
            
            var id = $(this).attr("id");
            
            var img = $(this).attr("arquivo");
            
            var modulo = $(this).parents(".conteudoInterno").attr("modulo");
            
            $.post(		
                'action.php',
                {id:id, tipo:"anexo_cnpj", img:img, action:"excluirImg"},
                function(response){
                    
                    
                    if(!response.erro && response.salvo){
                    
                        objCNPJ.find(".divImg").hide();
                        
                        objCNPJ.find(".upImg").val("");
                        
                        objCNPJ.find(".btUpload").show();
                        
                    }
                    
                },"json"
            
            );
            
        });	
	
	}
	
}

function uploadContratoSocial(){
	
	if($("#UploadContratoSocial").length > 0){
		
		var objContratoSocial = $(".box-upload-imagem-contratosocial");
	
		var diretorioUpload = objContratoSocial.find('#UploadContratoSocial').attr("diretorioUpload");
		
		objContratoSocial.find('#UploadContratoSocial').uploadifive({
	
			//---------------------------------------------------
		
			// uploadifive options..
		
			//---------------------------------------------------
			
			'checkScript'     : '../frameworks/uploadifive/check-exists.php',
		
			'uploadScript'    : '../frameworks/uploadifive/uploadifive.php',
			
			'multi'           : false,
            
            'fileType'        : 'image/*,application/pdf',
			
			'buttonText'      : 'Selecione um arquivo',
			
			'removeCompleted' : true,
			
			'formData'        : {								
								'timestamp'      : objContratoSocial.find(".btUpload").attr("timestamp"),
								'token'          : objContratoSocial.find(".btUpload").attr("token"),
								'folder'         : diretorioUpload
							  },
			
			'onUploadComplete':function (file, data) {
				
				objContratoSocial.find('.divImg').find(".visualizar-arquivo").attr("href","../"+diretorioUpload+"/"+data);

                objContratoSocial.find('.divImg').find(".excluir-arquivo").attr("arquivo","../"+diretorioUpload+"/"+data);

                objContratoSocial.find(".upImg").val(data);
				
				objContratoSocial.find('.divImg').show();
				
				objContratoSocial.find(".btUpload").hide();
			}
			
			
		});
	
	
		//################################# EXCLUIR IMAGEM ##################################
		
		objContratoSocial.find(".excluir-arquivo").click(function(){
            
            var id = $(this).attr("id");
            
            var img = $(this).attr("arquivo");
            
            var modulo = $(this).parents(".conteudoInterno").attr("modulo");
            
            $.post(		
                'action.php',
                {id:id, tipo:"anexo_contratosocial", img:img, action:"excluirImg"},
                function(response){
                    
                    
                    if(!response.erro && response.salvo){
                    
                        objContratoSocial.find(".divImg").hide();
                        
                        objContratoSocial.find(".upImg").val("");
                        
                        objContratoSocial.find(".btUpload").show();
                        
                    }
                    
                },"json"
            
            );
            
        });	
	
	}
	
}

function uploadResidencia(){

    if($("#UploadResidencia").length > 0){
            
        var objResidencia = $(".box-upload-imagem-residencia");

        var diretorioUpload = objResidencia.find('#UploadResidencia').attr("diretorioUpload");
        
        objResidencia.find('#UploadResidencia').uploadifive({

            //---------------------------------------------------
        
            // uploadifive options..
        
            //---------------------------------------------------
            
            'checkScript'     : '../frameworks/uploadifive/check-exists.php',
        
            'uploadScript'    : '../frameworks/uploadifive/uploadifive.php',
            
            'multi'           : false,
            
            'fileType'        : 'image/*,application/pdf',
            
            'buttonText'      : 'Selecione um arquivo',
            
            'removeCompleted' : true,
            
            'formData'        : {								
                                'timestamp'      : objResidencia.find(".btUpload").attr("timestamp"),
                                'token'          : objResidencia.find(".btUpload").attr("token"),
                                'folder'         : diretorioUpload
                            },
            
            'onUploadComplete':function (file, data) {
                
                objResidencia.find('.divImg').find(".visualizar-arquivo").attr("href","../"+diretorioUpload+"/"+data);

                objResidencia.find('.divImg').find(".excluir-arquivo").attr("arquivo","../"+diretorioUpload+"/"+data);

                objResidencia.find(".upImg").val(data);
				
				objResidencia.find('.divImg').show();
				
				objResidencia.find(".btUpload").hide();
            }
            
            
        });


        //################################# EXCLUIR IMAGEM ##################################
        
        objResidencia.find(".excluir-arquivo").click(function(){
            
            var id = $(this).attr("id");
            
            var img = $(this).attr("arquivo");
            
            var modulo = $(this).parents(".conteudoInterno").attr("modulo");
            
            $.post(		
                'action.php',
                {id:id, tipo:"anexo_comprovanteresidencia", img:img, action:"excluirImg"},
                function(response){
                    
                    if(!response.erro && response.salvo){
                    
                        objResidencia.find(".divImg").hide();
                        
                        objResidencia.find(".upImg").val("");
                        
                        objResidencia.find(".btUpload").show();
                        
                    }
                    
                },"json"
            
            );
            
        });	

    }

}

function uploadCPFDependente(){
	
	if($("#UploadCPFDependente").length > 0){
		
		var objCPFDependente = $(".box-upload-imagem-cpf-dependente");
	
		var diretorioUpload = objCPFDependente.find('#UploadCPFDependente').attr("diretorioUpload");
		
		objCPFDependente.find('#UploadCPFDependente').uploadifive({
	
			//---------------------------------------------------
		
			// uploadifive options..
		
			//---------------------------------------------------
			
			'checkScript'     : '../frameworks/uploadifive/check-exists.php',
		
			'uploadScript'    : '../frameworks/uploadifive/uploadifive.php',
			
			'multi'           : false,
            
            'fileType'        : 'image/*,application/pdf',
			
			'buttonText'      : 'Selecione um arquivo',
			
			'removeCompleted' : true,
			
			'formData'        : {								
								'timestamp'      : objCPFDependente.find(".btUpload").attr("timestamp"),
								'token'          : objCPFDependente.find(".btUpload").attr("token"),
								'folder'         : diretorioUpload
							  },
			
			'onUploadComplete':function (file, data) {

                var id_dependente = $("#modalDependentes.modal input[name='id_dependente']").val();

                var anexo_cpf = data;

                var diretorio = diretorioUpload;

                $.post(
                    "action.php",
                    {id:id_dependente, anexo:anexo_cpf, diretorio:diretorio, action:"uploadAnexoDependente"},
                    function(response){

                        $("body").prepend("<div class='"+response.classe+" alertaMsg alertaMsg-conteudo'>"+response.mensagem+"</div>").fadeIn();

                        $("#modalDependentes.modal .modal-header .close").click();

                        $("#modalDependentes.modal .modal-body input").val("");

                        if(!response.erro){

                            if($(".conteudo .loading").length == 0){

                                $(".conteudo").prepend("<div class='loading'></div>");
                        
                            }

                            $(".lista-dependentes table tbody tr.ativo td:eq(5)").html(response.botao);

                            $(".lista-dependentes table tbody tr.ativo").removeClass("ativo");

                            setTimeout(
                                function(){

                                    $(".conteudo .loading").fadeOut(function(){

                                        $(".conteudo .loading").remove();
        
                                    });

                                },1000
                            );
                        }

                        setTimeout(
                            function(){
    
                                $(".alertaMsg").fadeOut(function(){
    
                                    $(".alertaMsg").remove();
    
                                });
    
                            },2000
                        );

                    },"json"
                );

                
			}
			
			
		});
	
	}
	
}