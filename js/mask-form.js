$(document).ready(function(){	

	$(".valor").mask('000.000.000.000.000,00', {reverse: true});

	$(".pontos").mask('000,00', {reverse: true});

	$(".percentual").mask('000,00', {reverse: true});

	$(".inteiro").mask('000000000000000000000000000', {reverse: true});

	$(".numero_minmax").mask('000', {reverse: true});

	$(".cep").mask('00000-000', {reverse: true});

	$(".data").mask('00/00/0000');

	$('.date-picker').datepicker();

	$("input.cep").blur(function(){

		var obj = $(this).parents(".box-conteudo");

		var valor = $(this).val();

		if(valor != ""){

			$.post(
				"../php/listarCidadesBairros.php",
				{cep:valor, action: "listarEnderecoCep"},
				function(response){

					if(!response.erro){

						var campo = obj.find("input.cep").attr("name");

						campo = campo.split("-");

						if(campo.length > 1){

							var campoView = campo[0]+"-";

						}else{

							var campoView = "";

						}

						obj.find("input[name='"+campoView+"endereco']").val(response.endereco);

						obj.find("input[name='"+campoView+"bairro']").val(response.bairro);

						obj.find("input[name='"+campoView+"cidade']").val(response.cidade);

						obj.find("select[name='"+campoView+"estado'] option:selected").prop("selected", false);

						obj.find("select[name='"+campoView+"estado'] option[value='"+response.uf+"']").prop("selected", true);

					}

				},"json"

			);

		}

	});

	checkboxTL();

	$(".conteudoInterno .box-conteudo form select[name='id_estado']").change(function(){
		
		var id_estado = $(this).val();
		
		var modulo = $(this).parents(".conteudoInterno").attr("modulo");

		var box = $(this).parents("form");
		
		$.post(
			'modulos/'+modulo+'/action.php',
			{id_estado:id_estado, action:"listarCidades"},
			function(response){
				
				if(!response.erro){
				
					box.find("select[name='id_cidade']").html(response.listaCidades);
					
					box.find("select[name='id_cidade']").prop("disabled", false);
				
				}
				
			},"json"
		);	
		
	});

	var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
	},
	spOptions = {
		onKeyPress: function(val, e, field, options) {
						  field.mask(SPMaskBehavior.apply({}, arguments), options);
						}
	};
	
	$('.telefone').mask(SPMaskBehavior, spOptions);

	$("body form input.telefone").each(function () {

		var input = this;

		window.intlTelInput(input, {
			initialCountry: "br",
			nationalMode: true, // mostra o número sem o DDI
			separateDialCode: true, // separa o DDI visualmente
			preferredCountries: ["br", "us", "pt", "gb", "es"],
			utilsScript: "../../frameworks/js/utils.js",
			autoPlaceholder: "aggressive",
			customPlaceholder: function(placeholder, countryData) {
				if (countryData.iso2 === "br") {
				return "(82) 98878-0989"; // <-- Aqui você define o placeholder personalizado
				}
				return placeholder; // Para outros países, usa o padrão
			}
		});

	});

	$("body").off("click","form .iti .iti__flag-container ul li");

	$("body").on("click","form .iti .iti__flag-container ul li", function(evt){

		evt.stopImmediatePropagation();

		var ddi = $(this).find(".iti__dial-code").html();

		var campo = $(this).closest(".iti").parent().find("input").attr("name");

		var destino = campo.replace("telefone", "telefone_ddi");

		$(this).closest("form").find("input[name='"+destino+"']").val(ddi);

	});

	//CARREGAR DDI DO FORM
	$("body form input.ddi").each(function () {

		var $ddiInput = $(this);
		var ddi = $ddiInput.val().replace(/\D/g, ''); // limpa DDI
		var telefone = $ddiInput.parent().find(".telefone").val().replace(/\D/g, '');

		var input = $ddiInput.parent().find(".telefone");

		
		// Pega o input telefone relacionado (onde foi iniciado o intl-tel-input)
		var telefoneInput = $ddiInput.parent().find(".telefone")[0];

		if (window.intlTelInputGlobals && telefoneInput) {
			var iti = window.intlTelInputGlobals.getInstance(telefoneInput);
			if (iti) {
				iti.setNumber("+" + ddi + telefone);

				$(input).trigger("input");
				
			}
		}
	});

	$("body").on("click","input.cpf",function(){
		
		var valor = $.trim($(this).val());
		
		$(this).val(removeAcento(valor));
		
		$(this).parent().children("span.erro").remove();
				
		$(this).parent().removeClass("has-error");
		
	});

	$("body").on("click","input.cnpj",function(){
		
		var valor = $.trim($(this).val());
		
		$(this).val(removeAcento(valor));
		
		$(this).parent().children("span.erro").remove();
				
		$(this).parent().removeClass("has-error");
		
	});
	
	function removeAcento(strToReplace) {
		str_acento= ".-/";
		str_sem_acento = "";
		var nova="";
		for (var i = 0; i < strToReplace.length; i++) {
			if (str_acento.indexOf(strToReplace.charAt(i)) != -1) {
				nova+=str_sem_acento.substr(str_acento.search(strToReplace.substr(i,1)),1);
			} else {
				nova+=strToReplace.substr(i,1);
			}
		}
		return nova;
	}
	
	
	$("body").on('keyup blur focus',"input.cpf", soNums); // o "#input" é o input que vc quer aplicar a funcionalidade

	$("body").on('keyup blur focus',"input.cnpj",soNums); // o "#input" é o input que vc quer aplicar a funcionalidade
	
	 
	function soNums(e){
	 
		var expre = /[^0-9]/g;
        // REMOVE OS CARACTERES DA EXPRESSAO ACIMA
        if ($(this).val().match(expre))
            $(this).val($(this).val().replace(expre,''));
	}
	
	
	$("body").on("blur","input.cpf",function(evt){//MACARAR CPF, VALIDAR NO BANCO SE JÁ  EXISTE VERIFICAR SE É Válido

		evt.stopImmediatePropagation();
		
		var valor = $.trim($(this).val());
		
		if(valor.length == 11){
			
			var cpf = valor.substr(0,3)+"."+valor.substr(3,3)+"."+valor.substr(6,3)+"-"+valor.substr(9,2);
			
			if(validarCPF(cpf)){
				
				$(this).val(cpf);
			
			}else{
				
				$(this).val("");
				
				$(this).parent().append("<span class='erro'>CPF inválido</span>");
				
				$(this).parent().addClass("has-error");
				
			}
			
		}else{
			
			$(this).val("");
			
			$(this).parent().append("<span class='erro'>CPF inválido</span>");
			
			$(this).parent().addClass("has-error");
			
		}
		
	});

	$("body").on("blur","input.cnpj",function(evt){//MACARAR CNPJ, VALIDAR NO BANCO SE JÁ  EXISTE VERIFICAR SE É Válido

		evt.stopImmediatePropagation();
		
		var valor = $.trim($(this).val());
		
		if(valor.length >= 14){
			
			var cnpj = valor.substr(0,2)+"."+valor.substr(2,3)+"."+valor.substr(5,3)+"/"+valor.substr(8,4)+"-"+valor.substr(12,2);
			
			if(validarCNPJ(cnpj)){
				
				$(this).val(cnpj);
			
			}else{
				
				$(this).val("");
				
				$(this).parent().append("<span class='erro'>CNPJ inválido</span>");
				
				$(this).parent().addClass("has-error");
				
			}
			
		}else{
			
			$(this).val("");
			
			$(this).parent().append("<span class='erro'>CNPJ inválido</span>");
			
			$(this).parent().addClass("has-error");
			
		}
		
	});
	
	///////////////////// VALIDAR CPF ///////////////////////////
	
	function validarCPF(value){
		
		value = $.trim(value);
		
		value = value.replace('.','');
		value = value.replace('.','');
		cpf = value.replace('-','');
		while(cpf.length < 11) cpf = "0"+ cpf;
		var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
		var a = [];
		var b = new Number;
		var c = 11;
		for (i=0; i<11; i++){
			a[i] = cpf.charAt(i);
			if (i < 9) b += (a[i] * --c);
		}
		if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
		b = 0;
		c = 11;
		for (y=0; y<10; y++) b += (a[y] * c--);
		if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }
		if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) return false;
		return true;
	}
	
	
	
	///////////////////// VALIDAR CNPJ ///////////////////////////
	
	function validarCNPJ(cnpj){
		
		cnpj = jQuery.trim(cnpj);
	
		// DEIXA APENAS OS NÚMEROS
	   cnpj = cnpj.replace('/','');
	   cnpj = cnpj.replace('.','');
	   cnpj = cnpj.replace('.','');
	   cnpj = cnpj.replace('-','');
	
	   var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
	   digitos_iguais = 1;
	
	   if (cnpj.length < 14 && cnpj.length < 15){
		  return false;
	   }
	   for (i = 0; i < cnpj.length - 1; i++){
		  if (cnpj.charAt(i) != cnpj.charAt(i + 1)){
			 digitos_iguais = 0;
			 break;
		  }
	   }
	
	   if (!digitos_iguais){
		  tamanho = cnpj.length - 2
		  numeros = cnpj.substring(0,tamanho);
		  digitos = cnpj.substring(tamanho);
		  soma = 0;
		  pos = tamanho - 7;
	
		  for (i = tamanho; i >= 1; i--){
			 soma += numeros.charAt(tamanho - i) * pos--;
			 if (pos < 2){
				pos = 9;
			 }
		  }
		  resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
		  if (resultado != digitos.charAt(0)){
			 return false;
		  }
		  tamanho = tamanho + 1;
		  numeros = cnpj.substring(0,tamanho);
		  soma = 0;
		  pos = tamanho - 7;
		  for (i = tamanho; i >= 1; i--){
			 soma += numeros.charAt(tamanho - i) * pos--;
			 if (pos < 2){
				pos = 9;
			 }
		  }
		  resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
		  if (resultado != digitos.charAt(1)){
			 return false;
		  }
		  return true;
	   }else{
		  return false;
	   }	
		
	}

});

function checkboxTL(){


	$(".checkbox-tl input[type='checkbox']").each(function(){

		var obj = $(this);

		if(obj.is(":checked")){

			obj.parents(".checkbox-tl").addClass("ativo");

		} 

	});


	$(".conteudoInterno").on("click", "form .checkbox-tl:not('.checkbox-tl-disabled') a", function(evt){

		evt.stopImmediatePropagation();

		if($(this).parents(".checkbox-tl").hasClass("ativo")){

			$(this).parents(".checkbox-tl").removeClass("ativo");

			$(this).parents(".checkbox-tl").find("input[type='hidden']").prop("disabled",false);

			$(this).parents(".checkbox-tl").find("input[type='checkbox']").prop("checked",false);

		}else{

			$(this).parents(".checkbox-tl").addClass("ativo");

			$(this).parents(".checkbox-tl").find("input[type='hidden']").prop("disabled",true);

			$(this).parents(".checkbox-tl").find("input[type='checkbox']").prop("checked",true);

		}

	});

}