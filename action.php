<?php

session_start();

require_once("../controller/controller_class.php");

$resultado["erro"] = false;

$resultado["salvo"] = false;

if(
	isset($_POST["action"]) && $_POST["action"] == "add" && isset($_POST["campos"]) ||
	isset($_POST["action"]) && $_POST["action"] == "edit" && isset($_POST["id"]) && is_numeric($_POST["id"]) && isset($_POST["campos"])
){
	
	//SE FOI PARA ADIÇÃO
	
	if($_POST["action"] == "add"){
		
		if($_POST["campos"] != ""){
		
			$totalCampos = explode("%%,%%", $_POST["campos"]);

			$boxCliente = array();

			$boxAssinatura = array();
			
			for($i = 0; $i < count($totalCampos); $i++){
			
				$campo = explode("%%:%%",$totalCampos[$i]);
				
				$coluna = $campo[0];

				$valor  = trim($campo[1]);

				$separarColuna =  explode("-", $coluna);

				if($separarColuna[0] == "cliente"){

					array_push($boxCliente, $separarColuna[1]."%%::%%".$valor);

				}else if($separarColuna[0] == "assinatura"){

					array_push($boxAssinatura, $separarColuna[1]."%%::%%".$valor);

				}
			
			}

			/*VERIFICA DADOS CLIENTES*/

			if(count($boxCliente) > 0){

				$erro = 0;

				$mensagemErro = "";

                $nome = "";

				$email = "";

				$cpf = "";

                $id_cliente = "";

				for($i = 0; $i < count($boxCliente); $i++){

					$separarCliente = explode("%%::%%", $boxCliente[$i]);

					if($separarCliente[0] == "nascimento"){
					
						$arrayCliente[$separarCliente[0]] = $controller->util->dataBD(trim($separarCliente[1]));

					}else{

						$arrayCliente[$separarCliente[0]] = trim($separarCliente[1]);

					}

					if($separarCliente[0] == "email"){
					
						$email = trim($separarCliente[1]);

					}else if($separarCliente[0] == "cpf"){
					
						$cpf = trim($separarCliente[1]);

					}else if($separarCliente[0] == "nome"){
					
						$nome = trim($separarCliente[1]);

					}

				}

				$arrayCliente["status"] = "1";

				$arrayCliente["data"] = date("Y-m-d");

				if($controller->cpf_cliente($cpf) == 0){

					if ($controller->con->inserir("clientes",$arrayCliente)){
		
						$id_cliente = $controller->con->idinsert;

                        $arrayAssinatura["id_cliente"] = $id_cliente;

						$arrayAssinatura["data"] = date("Y-m-d H:i:s");

						$responsavel = "";

						if(count($boxAssinatura) > 0){

							$status = false;

							$statusView = "";

							$termo_adesao = false;

							for($i = 0; $i < count($boxAssinatura); $i++){

								$separarAssinatura = explode("%%::%%", $boxAssinatura[$i]);

								if($separarAssinatura[0] == "status"){

									$status = true;

									$statusView = trim($separarAssinatura[1]);

								}

								if($separarAssinatura[0] == "termo_adesao"){

									$termo_adesao = true;

								}

								if($separarAssinatura[0] == "responsavel"){

									if((int)trim($separarAssinatura[1]) != "" && (int)trim($separarAssinatura[1]) > 0){

										$responsavel = trim($separarAssinatura[1]);

									}

								}else{
								
									$arrayAssinatura[$separarAssinatura[0]] = trim($separarAssinatura[1]);

								}
			
							}

							$arrayAssinatura["responsavel"] = $responsavel;

							if($controller->con->inserir("assinaturas",$arrayAssinatura)){

								$resultado["salvo"] = true;

								$id_assinatura = $controller->con->idinsert;

								$resultado["id"] = $id_assinatura;
                                $resultado["nome"] = $nome;
                                $resultado["id_cliente"] = $id_cliente;

                                $resultado["cpf"] = $cpf;


                                $_SESSION["id_assinatura"] = $id_assinatura;

								$_SESSION["id_cliente"] = $id_cliente;

								if($_POST["box"] == "plano" && !isset($_SESSION["plano_concluido"])){

									$_SESSION["plano_concluido"] = true;

								}else if($_POST["box"] == "titular" && !isset($_SESSION["titular_concluido"])){

									$_SESSION["titular_concluido"] = true;

								}else if($_POST["box"] == "dependentes" && !isset($_SESSION["dependentes_concluido"])){

									$_SESSION["dependentes_concluido"] = true;

								}else if($_POST["box"] == "assinatura" && !isset($_SESSION["assinatura_concluido"])){

									$_SESSION["assinatura_concluido"] = true;

								}
						
								$resultado["mensagem"] = "Cadastro realizado com sucesso!";
						
								$resultado["classe"] = "alert-success";

								/*CRIAR PASTA*/

								$diretorio = "../arquivos";
				
								$pastaAssinatura = "assinatura_".$id_assinatura;
				
								/*DIRETORIO ASSINATURA*/
				
								if(!file_exists($diretorio."/".$pastaAssinatura)){
				
									$controller->util->criarPasta($diretorio, $pastaAssinatura);
				
								}

								if($termo_adesao){

									$email = $controller->recuperarDadosCliente($id_cliente, "email");

									if($email){

										$controller->trafegoFunil($email, "preencheu-trial", "O usuário realizou o preenchimento parcial formulário.");

									}

									$nome_destinatario = "Elayne Gabrielle da Silva Santos";

									$email_destinatario = "atendimento@azobeneficios.com.br";

									$titulo_email = "Chegou uma nova assinatura com ativação imediata com ID: ".$id_assinatura;

									$nome_cliente = $controller->recuperarDadosCliente($id_cliente, "nome");

									$conteudo_email = "
									
													Ol&aacute; ".$nome_destinatario."!<br>
													Chegou uma nova assinatura com ativa&ccedil;&atilde;o imediata, no sistema AZO<br><br>
													<strong>ID da assinatura:</strong> ".$id_assinatura."<br>
													<strong>Cliente:</strong> ".$nome_cliente."<br><br>

													Obs.: A assinatura ser&aacute; ativada e sincronizada com as APIs vinculadas ao plano ap&oacute;s a confirma&ccedil;&atilde;o de pagamento pela institui&ccedil;&atilde;o banc&aacute;ria. 
													";

									$controller->montarEnvioEmail($nome_destinatario, $email_destinatario, $titulo_email, $conteudo_email);

								}

							}else{

								$resultado["erro"] = true;
						
								$resultado["mensagem"] = "Não foi possível realizar o cadastro.";
								
								$resultado["classe"] = "alert-danger";

							}

						}
						
					}else{
						
						$resultado["erro"] = true;
						
						$resultado["mensagem"] = "Não foi possível realizar o cadastro.";
						
						$resultado["classe"] = "alert-danger";
						
					}

				}else{


					$resultado["erro"] = true;

					$mensagem = "";
					
					if($controller->cpf_cliente($cpf) > 0){

						$mensagem .= "<br>O CPF informado ".$cpf." já está cadastrado em nosso sistema.";

					}
						
					$resultado["mensagem"] = "Não foi possível realizar o cadastro.".$mensagem;
					
					$resultado["classe"] = "alert-danger";

				}

			}else{
					
				$resultado["erro"] = true;
				
				$resultado["mensagem"] = "Não foi possível realizar o cadastro.";
				
				$resultado["classe"] = "alert-danger";
				
			}
		
		}else{
			
			$resultado["erro"] = true;
			
			$resultado["mensagem"] = "Não foi possível realizar o cadastro.";
			
			$resultado["classe"] = "alert-danger";
			
		}
		
		
	}
	
	//FIM ADIÇÃO

	//SE FOI PARA EDIÇÃO
	
	if($_POST["action"] == "edit" && isset($_POST["id"]) && is_numeric($_POST["id"])){

		$id = $_POST["id"];

		$id_cliente = "";
		
		if($_POST["campos"] != ""){
		
			$totalCampos = explode("%%,%%", $_POST["campos"]);
			
			$boxCliente = array();

			$boxResponsavelEmpresa = array();

			$boxResponsavelEmpresaAnexos = array();

			$boxAssinatura = array();

			$boxDependente = array();
			
			for($i = 0; $i < count($totalCampos); $i++){
			
				$campo = explode("%%:%%",$totalCampos[$i]);
				
				$coluna = $campo[0];

				$valor  = trim($campo[1]);

				$separarColuna =  explode("-", $coluna);

				if($separarColuna[0] == "cliente"){

					array_push($boxCliente, $separarColuna[1]."%%::%%".$valor);

				}else if($separarColuna[0] == "responsavel"){

					array_push($boxResponsavelEmpresa, $separarColuna[1]."%%::%%".$valor);

				}else if($separarColuna[0] == "responsavel_anexo"){

					array_push($boxResponsavelEmpresaAnexos, $separarColuna[1]."%%::%%".$valor);

				}else if($separarColuna[0] == "assinatura"){

					array_push($boxAssinatura, $separarColuna[1]."%%::%%".$valor);

				}else if($separarColuna[0] == "dependente"){

					array_push($boxDependente, $separarColuna[1]."%%::%%".$valor);

				}
			
			}
			
			/*VERIFICA DADOS CLIENTES*/

			$erro = 0;

			if(count($boxCliente) > 0){				

				$mensagemErro = "";

				$email = "";

				$cpf = "";

				for($i = 0; $i < count($boxCliente); $i++){

					$separarCliente = explode("%%::%%", $boxCliente[$i]);

					if($separarCliente[0] == "nascimento"){
					
						$arrayCliente[$separarCliente[0]] = $controller->util->dataBD(trim($separarCliente[1]));

					}else if($separarCliente[0] == "id_cliente"){

						$id_cliente = trim($separarCliente[1]);

					}else{

						$arrayCliente[$separarCliente[0]] = trim($separarCliente[1]);

					}

					if($separarCliente[0] == "email"){
					
						$email = trim($separarCliente[1]);

					}else if($separarCliente[0] == "cpf"){
					
						$cpf = trim($separarCliente[1]);

					}

				}

				if(isset($arrayCliente)){

					if($controller->cpf_cliente_edit($cpf, $id_cliente) == 0){

						if ($controller->con->update("clientes",$arrayCliente, "id = '$id_cliente'")){

							if(!isset($_SESSION["email_tack"]) && $email != ""){

								$controller->trafegoFunil($email, "preencheu-trial", "O usuário iniciou o preenchimento do formulário.");

								$_SESSION["email_tack"] = "disparado";

							}

							$resultado["salvo"] = true;
						
							$resultado["mensagem"] = "Cadastro atualizado com sucesso!1";
							
							$resultado["classe"] = "alert-success";

							if(isset($_POST["box"])){

								$_SESSION["box_ativo"] = $_POST["box"];

								if($_POST["box"] == "plano" && !isset($_SESSION["plano_concluido"])){

									$_SESSION["plano_concluido"] = true;

								}else if($_POST["box"] == "titular" && !isset($_SESSION["titular_concluido"])){

									$_SESSION["titular_concluido"] = true;

								}else if($_POST["box"] == "dependentes" && !isset($_SESSION["dependentes_concluido"])){

									$_SESSION["dependentes_concluido"] = true;

								}else if($_POST["box"] == "assinatura" && !isset($_SESSION["assinatura_concluido"])){

									$_SESSION["assinatura_concluido"] = true;

								}

							}

						}else{

							$resultado["erro"] = true;
						
							$resultado["mensagem"] = "Não foi possível atualizar o cadastro.";
							
							$resultado["classe"] = "alert-danger";

						}

					}else{

						$erro++;

						$resultado["salvo"] = false;

						$resultado["erro"] = true;

						$mensagem = "";
						
						if($controller->cpf_cliente_edit($cpf, $id_cliente) > 0){

							$mensagem .= "<br>O CPF informado ".$cpf." já está cadastrado em nosso sistema.";

						}
							
						$resultado["mensagem"] = "Não foi possível prosseguir com o cadastro.".$mensagem;
						
						$resultado["classe"] = "alert-danger";

						if($email != ""){

							$controller->trafegoFunil($email, "cpf-existente", "O CPF informado ".$cpf." já está cadastrado em nosso sistema.");

						}

					}

				}

			}

			if(
				count($boxCliente) == 0 ||
				count($boxCliente) > 0 && $erro == 0
			){
			
				if(count($boxAssinatura) > 0){

					$resetar_assinatura = false;

					$status = false;

					$statusView = "";

					$termo_adesao = false;

					for($i = 0; $i < count($boxAssinatura); $i++){

						$separarAssinatura = explode("%%::%%", $boxAssinatura[$i]);

						if($separarAssinatura[0] == "status"){

							$status = true;

							$statusView = trim($separarAssinatura[1]);

						}

						if($separarAssinatura[0] == "termo_adesao"){

							$termo_adesao = true;

						}

						if($separarAssinatura[0] == "responsavel"){

							if((int)trim($separarAssinatura[1]) != "" && (int)trim($separarAssinatura[1]) > 0){

								$arrayAssinatura[$separarAssinatura[0]] = trim($separarAssinatura[1]);

							}else{

								$arrayAssinatura[$separarAssinatura[0]] = $_SESSION["idUsuario_azo"];

							}

						}else if($separarAssinatura[0] == "resetar_aceite"){

							$resetar_assinatura = true;

						}else{
						
							$arrayAssinatura[$separarAssinatura[0]] = trim($separarAssinatura[1]);

						}

					}

					if($status == true && $controller->ultimoStatusAssinatura($id) != "erro" && $controller->ultimoStatusAssinatura($id) != $statusView){

						$arrayAssinatura["data_status"] = date("Y-m-d");

						$arrayAssinatura["responsavel_status"] = $_SESSION["idUsuario_azo"];

					}

					if($resetar_assinatura == true){

						$arrayAssinatura["assinatura_digital_titular"] = "";

						$arrayAssinatura["termo_adesao"] = "0";

						$arrayAssinatura["status"] = "0";

					}

					if ($controller->con->update("assinaturas",$arrayAssinatura, "id = '$id'")){
					
						$resultado["salvo"] = true;
					
						$resultado["mensagem"] = "Cadastro atualizado com sucesso!";
						
						$resultado["classe"] = "alert-success";

						if($termo_adesao){

							$email = $controller->recuperarDadosCliente($id_cliente, "email");

							if($email){

								$controller->trafegoFunil($email, "preencheu-trial", "O usuário realizou o preenchimento completo do formulário.");

							}

							$nome_destinatario = "Elayne Gabrielle da Silva Santos";

							$email_destinatario = "atendimento@azobeneficios.com.br";

							$titulo_email = "Chegou uma nova assinatura com ativação imediata com ID: ".$id;

							$nome_cliente = $controller->recuperarDadosCliente($id_cliente, "nome");

							$conteudo_email = "
							
											Ol&aacute; ".$nome_destinatario."!<br>
											Chegou uma nova assinatura com ativa&ccedil;&atilde;o imediata, no sistema AZO<br><br>
											<strong>ID da assinatura:</strong> ".$id."<br>
											<strong>Cliente:</strong> ".$nome_cliente."<br><br>

											Obs.: A assinatura ser&aacute; ativada e sincronizada com as APIs vinculadas ao plano ap&oacute;s a confirma&ccedil;&atilde;o de pagamento pela institui&ccedil;&atilde;o banc&aacute;ria. 
											";

							$controller->montarEnvioEmail($nome_destinatario, $email_destinatario, $titulo_email, $conteudo_email);

						}

						if(isset($_POST["box"])){

							$_SESSION["box_ativo"] = $_POST["box"];

							if($_POST["box"] == "plano" && !isset($_SESSION["plano_concluido"])){

								$_SESSION["plano_concluido"] = true;

							}else if($_POST["box"] == "titular" && !isset($_SESSION["titular_concluido"])){

								$_SESSION["titular_concluido"] = true;

							}else if($_POST["box"] == "dependentes" && !isset($_SESSION["dependentes_concluido"])){

								$_SESSION["dependentes_concluido"] = true;

							}else if($_POST["box"] == "assinatura" && !isset($_SESSION["assinatura_concluido"])){

								$_SESSION["assinatura_concluido"] = true;

							}

						}

						$assinatura = $controller->assinatura();

						$autocontratacao = $controller->res["autocontratacao"];

						$autocontratacao_concluido = $controller->res["autocontratacao_concluido"];

						if($autocontratacao == 1 && $autocontratacao_concluido == 1){

							$id_assinatura = $controller->res["idView"];

							$id_cliente = $controller->res["id_cliente"];
							
							$controller->dispararNotificacao(2,$id_assinatura,$id_cliente);

						}

					}else{

						$resultado["erro"] = true;
					
						$resultado["mensagem"] = "Não foi possível atualizar o cadastro.";
						
						$resultado["classe"] = "alert-danger";

					}

				}

				if(count($boxResponsavelEmpresa) > 0){

					for($i = 0; $i < count($boxResponsavelEmpresa); $i++){

						$separarResponsavelEmpresa = explode("%%::%%", $boxResponsavelEmpresa[$i]);
						
						if($separarResponsavelEmpresa[0] == "id"){

							$id_responsavel = trim($separarResponsavelEmpresa[1]);

						}else{

							$arrayResponsavelEmpresa[$separarResponsavelEmpresa[0]] = trim($separarResponsavelEmpresa[1]);

							if($separarResponsavelEmpresa[0] == "telefone_responsavel"){

								if(isset($id_responsavel)){ // EDITA CADASTRO RESPONSAVEL  ADICIONAL EMPRESA

									if(!$controller->con->update("assinaturas_responsavel_adicional",$arrayResponsavelEmpresa, "id = '$id_responsavel'")){

										$erro++;

									}

									unset($id_responsavel);

								}else{ // ADICIONA CADASTRO RESPONSAVEL  ADICIONAL EMPRESA

									if(!$controller->con->inserir("assinaturas_responsavel_adicional",$arrayResponsavelEmpresa)){

										$erro++;

									}

								}

							}

						}					

					}

				}

				if(count($boxResponsavelEmpresaAnexos) > 0){

					for($i = 0; $i < count($boxResponsavelEmpresaAnexos); $i++){

						$separarResponsavelEmpresaAnexos = explode("%%::%%", $boxResponsavelEmpresaAnexos[$i]);
						
						if($separarResponsavelEmpresaAnexos[0] == "id"){

							$id_responsavel = trim($separarResponsavelEmpresaAnexos[1]);

						}else{

							$arrayResponsavelEmpresaAnexos[$separarResponsavelEmpresaAnexos[0]] = trim($separarResponsavelEmpresaAnexos[1]);

							if($separarResponsavelEmpresaAnexos[0] == "anexo_cpf"){

								if(isset($id_responsavel)){ // EDITA CADASTRO RESPONSAVEL  ADICIONAL EMPRESA

									if(!$controller->con->update("assinaturas_responsavel_adicional",$arrayResponsavelEmpresaAnexos, "id = '$id_responsavel'")){

										$erro++;

									}

									unset($id_responsavel);

								}

							}

						}					

					}

				}

				if(count($boxDependente) > 0){

					$id_dependente = "";

					$loteDependente = false;

					$arrayLoteDependente = array();

					$indiceLoteDependente = 0;

					$email = "";

					$cpf = "";

					$status = false;

					$statusView = "";

					for($i = 0; $i < count($boxDependente); $i++){

						$separarDependente = explode("%%::%%", $boxDependente[$i]);

						if($separarDependente[0] == "lote"){
					
							$loteDependente  = true;
						
						}

						if($loteDependente == false){ /**CASO NÃO SEJA ENVIADO LOTE TRATA OS CAMPOS DE VERIFICAÇÃO */

							if($separarDependente[0] == "status"){

								$status = true;
		
								$statusView = trim($separarDependente[1]);
		
							}
								
							if($separarDependente[0] == "id"){

								$id_dependente = trim($separarDependente[1]);

							}else if($separarDependente[0] == "nascimento"){
					
								$arrayDependente[$separarDependente[0]] = $controller->util->dataBD(trim($separarDependente[1]));

							}else{

								$arrayDependente[$separarDependente[0]] = trim($separarDependente[1]);

							}

							if($separarDependente[0] == "email"){

								$email = trim($separarDependente[1]);

							}else if($separarDependente[0] == "cpf"){

								$cpf = trim($separarDependente[1]);

							}

						}else{/**CASO SEJA ENVIADO UM LOTE SEPARA LOTE EM GRUPO */

							if($separarDependente[0] != "lote"){
		
								$arrayLoteDependente[$indiceLoteDependente][$separarDependente[0]] = trim($separarDependente[1]);
		
							}

							if($separarDependente[0] == "estado"){
		
								$indiceLoteDependente++;
		
							}
		
						}

					}

					if($id_dependente != ""){

						if($status == true && $controller->ultimoStatusAssinaturaDependente($id_dependente) != "erro" && $controller->ultimoStatusAssinaturaDependente($id_dependente) != $statusView){

							$arrayDependente["data_status"] = date("Y-m-d");
		
							$arrayDependente["responsavel_status"] = $_SESSION["idUsuario_azo"];
		
						}

						if($controller->cpf_cliente_edit($cpf, $id_dependente) == 0){

							if($controller->con->update("clientes_dependentes",$arrayDependente, "id = '$id_dependente'")){

								$resultado["salvo"] = true;
						
								$resultado["mensagem"] = "Cadastro atualizado com sucesso!";
						
								$resultado["classe"] = "alert-success";

							}else{

								$resultado["erro"] = true;
						
								$resultado["mensagem"] = "Não foi possível realizar o cadastro.";
								
								$resultado["classe"] = "alert-danger";

							}

						}else{

							$resultado["erro"] = true;

							$mensagem = "";
							
							if($controller->cpf_cliente_edit($cpf, $id_dependente) > 0){

								$mensagem .= "<br>O CPF informado ".$cpf." já está cadastrado em nosso sistema.";

							}
								
							$resultado["mensagem"] = "Não foi possível atualizar o cadastro.".$mensagem;
							
							$resultado["classe"] = "alert-danger";

						}

					}else{

						$assinatura = $controller->assinatura();

						$vidas_max = $controller->res["vidas_max"];

						$valor_vida_adicional = $controller->res["valor_vida_adicionalView"];

						$listaDependentes = $controller->listaDependentes($id_cliente, false, true);

						if(
							$valor_vida_adicional > 0 ||
							$valor_vida_adicional == 0 && $listaDependentes < ($vidas_max -1)
						){

							$arrayDependente["id_cliente"] = $id_cliente;

							$arrayDependente["data"] = date("Y-m-d");

							if($controller->cpf_cliente($cpf) == 0){

								if($controller->con->inserir("clientes_dependentes",$arrayDependente)){

									$resultado["salvo"] = true;
							
									$resultado["mensagem"] = "Cadastro realizado com sucesso!";
							
									$resultado["classe"] = "alert-success";

								}else{

									$resultado["erro"] = true;
							
									$resultado["mensagem"] = "Não foi possível realizar o cadastro.";
									
									$resultado["classe"] = "alert-danger";

								}

							}else{

								$resultado["erro"] = true;

								$mensagem = "";
								
								if($controller->cpf_cliente($cpf) > 0){
		
									$mensagem .= "<br>O CPF informado ".$cpf." já está cadastrado em nosso sistema.";
		
								}
									
								$resultado["mensagem"] = "Não foi possível atualizar o cadastro.".$mensagem;
								
								$resultado["classe"] = "alert-danger";

							}

						}else{

							$resultado["erro"] = true;
					
							$resultado["mensagem"] = "Limite máximo de dependentes atingido.";
							
							$resultado["classe"] = "alert-danger";

						}

					}

				}

			}

			if(count($boxCliente) == 0 && count($boxAssinatura) == 0 && count($boxDependente) == 0){

				$resultado["erro"] = true;
				
				$resultado["mensagem"] = "Não foi possível atualizar o cadastro.";
				
				$resultado["classe"] = "alert-danger";

			}
		
		}else{
			
			$resultado["erro"] = true;
			
			$resultado["mensagem"] = "Não foi possível atualizar o cadastro.";
			
			$resultado["classe"] = "alert-danger";
			
		}
		
		
	}
	
	//FIM EDIÇÃO

}else if(

	isset($_POST["action"]) && $_POST["action"] == "excluirImg" && 
	isset($_POST["id"]) && is_numeric($_POST["id"]) &&
	isset($_POST["img"]) && $_POST["img"] != "" &&
	isset($_POST["tipo"]) && $_POST["tipo"] != ""
){
	
	$id  = $_POST["id"];
	
	$imgFiles = "../../".$_POST["img"];

	$tipo = $_POST["tipo"];
	
	$erro = 0;
	
	if(file_exists($imgFiles)){
	
		if(!unlink($imgFiles)){
			
			$erro++;
			
		}			
	
	}
	
	if($erro == 0 && $id > 0){
		
		$arrayEdit[$tipo] = "";
	
		if($controller->con->update("assinaturas", $arrayEdit, "id = '$id'")){
		
			$resultado["salvo"] = true;
			
		}else{
			
			$resultado["erro"] = true;
			
		}
	
	}else if($erro == 0 && $id == 0){
		
		$resultado["salvo"] = true;		
		
	}else{
		
		$resultado["erro"] = true;
		
	}

}else if(
	isset($_POST["action"]) && $_POST["action"] == "iniciarCadastro" && !isset($_SESSION["cadastro_iniciado"]) &&
	isset($_POST["id_usuario"]) && $_POST["id_usuario"] != "" && is_numeric($_POST["id_usuario"]) && $_POST["id_usuario"] > 0
){

	$_SESSION["cadastro_iniciado"] = "iniciado";

	$_SESSION["id_usuario_cadastro"] = $_POST["id_usuario"];

	if(isset($_POST["id_plano"]) && $_POST["id_plano"] != "" && is_numeric($_POST["id_plano"]) && $_POST["id_plano"] > 0){

		$_SESSION["id_plano_cadastro"] = $_POST["id_plano"];

	}

	$resultado["salvo"] = true;

}else if(
	isset($_POST["action"]) && $_POST["action"] == "validarIdadeTitular" && 
	isset($_POST["nascimento"]) && $_POST["nascimento"] != "" && preg_match('/^\d{4}-\d{2}-\d{2}$/', $controller->util->dataBD($_POST["nascimento"]))
){

	$nascimento = $controller->util->dataBD($_POST["nascimento"]);
	
	if($controller->util->isAdultByBirthdate($nascimento)){

		$resultado["maior_idade"] = true;

	}else{

		$resultado["maior_idade"] = false;

	}

}else if(
	isset($_POST["action"]) && $_POST["action"] == "excluirdependente" && 
	isset($_POST["id"]) && is_numeric($_POST["id"]) && $_POST["id"] > 0 &&
	isset($_POST["id_assinatura"]) && is_numeric($_POST["id_assinatura"]) && $_POST["id_assinatura"] > 0
){
		
					
	$id = $_POST["id"];	

	$id_assinatura = $_POST["id_assinatura"];	

	$dependenteView = $controller->dependenteView($id, true);

	$anexo = $controller->res["dependente_anexo_cpf"];

	if ($controller->con->delete("clientes_dependentes","id='$id'")){
		
		$resultado["salvo"] = true;
		
		$resultado["mensagem"] = "Vida excluída com sucesso!";
		
		$resultado["classe"] = "alert-success";

		if($anexo != ""){

			if(file_exists("../../arquivos/assinatura_".$id_assinatura."/".$anexo)){

				unlink("../../arquivos/assinatura_".$id_assinatura."/".$anexo);

			}

		}
		
	}else{
		
		$resultado["erro"] = true;
		
		$resultado["mensagem"] = "Não foi possível excluir a vida.";
		
		$resultado["classe"] = "alert-danger";
		
	}

}else{
	
	$resultado["erro"] = true;
	
	$resultado["mensagem"] = "Ocorreu um erro na sua solicitação.";	
	
	$resultado["classe"] = "alert-danger";
	
}

echo json_encode($resultado);

?>