<?php

session_start();

require_once("../controller/controller_class.php");

$resultado["erro"] = false;

$resultado["salvo"] = false;

if(
	isset($_POST["action"]) && $_POST["action"] == "verificarAssinatura" &&
	isset($_POST["id"]) && is_numeric($_POST["id"]) && $_POST["id"] > 0
){
	
	$assinatura = $controller->assinatura();

	if($assinatura > 0){

		$autocontratacao = $controller->res["autocontratacao"];

		$autocontratacao_concluido = $controller->res["autocontratacao_concluido"];

		if($autocontratacao == 1 && $autocontratacao_concluido == 0){

			$id_assinatura = $controller->res["idView"];

			$id_cliente = $controller->res["id_cliente"];

			$url_conclusao_cadastral = APP_URL_BASE."/contratacao/finalizar-cadastro.php?chave=".$controller->util->gerar_senha(9, false, false, true, false).$id_assinatura.$controller->util->gerar_senha(10, false, false, true, false)."_".$controller->util->gerar_senha(9, false, false, true, false).$id_cliente.$controller->util->gerar_senha(10, false, false, true, false);
    
			$resultado["concluir_cadastro"] = true;

			$resultado["url_conclusao_cadastral"] = $url_conclusao_cadastral;

			$atributo= "?chave=".$controller->util->gerar_senha(9, false, false, true, false).$id_assinatura.$controller->util->gerar_senha(10, false, false, true, false)."_".$controller->util->gerar_senha(9, false, false, true, false).$id_cliente.$controller->util->gerar_senha(10, false, false, true, false);

			$controller->dispararNotificacao(1,$id_assinatura,$id_cliente, $atributo);

		}else{

			$resultado["concluir_cadastro"] = false;

		}
		
	}else{

		$resultado["erro"] = true;
	
		$resultado["mensagem"] = "Assinatura não existe";	
		
		$resultado["classe"] = "alert-danger";

	}

}else{
	
	$resultado["erro"] = true;
	
	$resultado["mensagem"] = "Ocorreu um erro na sua solicitação.";	
	
	$resultado["classe"] = "alert-danger";
	
}

echo json_encode($resultado);

?>