<?php

session_start();

require_once("../controller/controller_class.php"); 

$id = $idView = $id_clienteView = $id_cliente = $tipo_pessoa = $nome = $sexo = $email =  $telefone = $telefone_ddi = $nascimento = $nome_mae = $rg = $cpf = $razao_social = $cnpj = $nome_fantasia = $cargo = $email_responsavel = $telefone_responsavel = $telefone_ddi_responsavel = "";

$cep = $endereco = $numero = $complemento = $bairro = $cidade = $estado = "";

$valor = $valor_vida_adicional = $plano = $desconto = $id_plano = $descricao_plano = $tipo_plano = $vidas_min = $pontos = $parcelas = $vidas_max =  $pagamento = $tipo_cobranca_cartao = $pendencias = $tipo_plano_empresa = $adesao = $valor_adesao = $degustacao = $forma_pagamento = $vencimento = $responsavel = $status = $termo_adesao = $assinatura_digital_titular = $dependentes_concluido = "";

$id_contrato = $id_contrato_eletivo = $data_assinatura = "";

$anexo_cpf = "";

$anexo_cnpj = "";

$anexo_comprovanteresidencia = "";

$viewImagem_cpf = "style='display:none;'";
		
$viewBotao_cpf = "";

$viewImagem_comprovanteresidencia = "style='display:none;'";
		
$viewBotao_comprovanteresidencia = "";

$viewImagem_cnpj= "style='display:none;'";
		
$viewBotao_cnpj = "";

$viewImagem_contratosocial= "style='display:none;'";
		
$viewBotao_contratosocial = "";

$box_plano = $box_titular = $box_dependentes = $box_assinatura = "";

if(isset($_GET["chave"])){

    $separarChave = explode("_",$_GET["chave"]);

    $id_usuario = substr($separarChave[0], 9, -10);

    $id_plano = substr($separarChave[1], 9, -10);

}

if(isset($_SESSION["cadastro_iniciado"])){

    $id_usuario = $_SESSION["id_usuario_cadastro"];

    if(isset($_SESSION["id_plano_cadastro"])){

        $id_plano = $_SESSION["id_plano_cadastro"];

    }

    if(isset($_SESSION["box_ativo"])){

        if($_SESSION["box_ativo"] == "plano"){

            $box_plano = "marcado";

            $box_titular = "ativo";

        }else if($_SESSION["box_ativo"] == "titular"){

            $box_plano = "marcado";

            $box_titular = "marcado";

            $box_dependentes = "ativo";

        }else if($_SESSION["box_ativo"] == "dependentes"){

            $box_plano = "ativo";

            $box_titular = "ativo";

            $box_dependentes = "ativo";

            $box_assinatura = "marcado";

        }else if($_SESSION["box_ativo"] == "assinatura"){

            $box_plano = "ativo";

            $box_titular = "ativo";

            $box_dependentes = "ativo";

            $box_assinatura = "marcado ativo";

        }

    }else{

        $box_plano = "ativo";

    }

    if(isset($_SESSION["plano_concluido"])){

        $box_plano = "marcado";

    }

    if(isset($_SESSION["titular_concluido"])){

        $box_titular = "marcado";

    }

    if(isset($_SESSION["dependentes_concluido"])){

        $box_dependentes = "marcado";

    }

    if(isset($_SESSION["assinatura_concluido"])){

        $box_assinatura = "marcado";

    }

    if(isset($_SESSION["id_assinatura"]) && isset($_SESSION["id_cliente"])){

        $assinatura = $controller->assinatura();
	
        $id = $controller->res["id"];

        $idView = $controller->res["idView"];

        //DADOS CLIENTE

        $id_cliente = '<input type="hidden" class="campo" name="cliente-id_cliente" value="'.$controller->res["id_cliente"].'">';

        $id_clienteView =  $controller->res["id_cliente"];

        $tipo_pessoa = $controller->res["tipo_pessoa"];
        
        $nome = $controller->res["nome"];

        $sexo = $controller->res["sexo"];

        $email = $controller->res["email"];

        $telefone = $controller->res["telefone"];

        $telefone_ddi = $controller->res["telefone_ddi"];

        $nascimento = $controller->res["nascimento"];

        $nome_mae = $controller->res["nome_mae"];

        $rg = $controller->res["rg"];

        $cpf = $controller->res["cpf"];

        $razao_social = $controller->res["razao_social"];

        $cnpj = $controller->res["cnpj"];

        $nome_fantasia = $controller->res["nome_fantasia"];

        $cargo = $controller->res["cargo"];

        $email_responsavel = $controller->res["email_responsavel"];

        $telefone_responsavel = $controller->res["telefone_responsavel"];

        $telefone_ddi_responsavel = $controller->res["telefone_ddi_responsavel"];

        //DADOS ENDERECO

        $cep = $controller->res["cep"];

        $endereco = $controller->res["endereco"];

        $numero = $controller->res["numero"];

        $complemento = $controller->res["complemento"];

        $bairro = $controller->res["bairro"];

        $cidade = $controller->res["cidade"];

        $estado = $controller->res["estado"];

        //DADOS PLANO
        
        $valor = $controller->res["valor"];

        $desconto = $controller->res["desconto"];

        $plano = $controller->res["plano"];

        $id_plano = $controller->res["id_plano"];

        $parcelas = $controller->res["parcelas"];

        $pontos = $controller->res["pontos"];

        $descricao_plano = $controller->res["descricao_plano"];

        $tipo_plano = $controller->res["tipo_plano"];

        $vidas_min = $controller->res["vidas_min"];

        $vidas_max = $controller->res["vidas_max"];

        $tipo_plano_empresa = $controller->res["tipo_plano_empresa"];

        $adesao = $controller->res["adesao"];

        $valor_adesao = $controller->res["valor_adesao"];

        $valor_vida_adicional = $controller->res["valor_vida_adicionalView"];

        $degustacao = $controller->res["degustacao"];

        $forma_pagamento = $controller->res["forma_pagamento"];

        $vencimento = $controller->res["vencimento"];

        $tipo_cobranca_cartao = $controller->res["tipo_cobranca_cartao"];

        $responsavel = $controller->res["responsavel"];

        $dependentes_concluido = $controller->res["dependentes_concluido"];

        $id_contrato = $controller->res["id_contrato"];

        $id_contrato_eletivo = $controller->res["id_contrato_eletivo"];

        $termo_adesao = $controller->res["termo_adesao"];

        $anexo_cpf = $controller->res["anexo_cpf"];

        if($anexo_cpf != ""){

            $viewImagem_cpf = "";
            
            $viewBotao_cpf = "style='display:none;'";   
            
        }	

        $anexo_comprovanteresidencia = $controller->res["anexo_comprovanteresidencia"];

        if($anexo_comprovanteresidencia != ""){

            $viewImagem_comprovanteresidencia = "";
            
            $viewBotao_comprovanteresidencia = "style='display:none;'";   
            
        }

        $anexo_cnpj = $controller->res["anexo_cnpj"];

        if($anexo_cnpj != ""){

            $viewImagem_cnpj = "";
            
            $viewBotao_cnpj = "style='display:none;'";   
            
        }

        $anexo_contratosocial = $controller->res["anexo_contratosocial"];

        if($anexo_contratosocial != ""){

            $viewImagem_contratosocial = "";
            
            $viewBotao_contratosocial = "style='display:none;'";   
            
        }

        $assinatura_digital_titular = $controller->res["assinatura_digital_titular"];

        $data_assinatura = $controller->res["data_assinatura"];

        $status = $controller->res["status"];

        $pagamento = $controller->res["pagamento"];

    }

}

if(isset($_GET["nome"]) && $_GET["nome"] != "" && $nome == ""){

    $nome = $_GET["nome"];

}

if(isset($_GET["email"]) && $_GET["email"] != "" && $email == ""){

    $email = $_GET["email"];

}

if(isset($_GET["telefone"]) && $_GET["telefone"] != "" && $telefone == ""){

    $telefone = $_GET["telefone"];

}

if(isset($_GET["telefone_ddi"]) && $_GET["telefone_ddi"] != "" && $telefone_ddi == ""){

    $telefone_ddi = $_GET["telefone_ddi"];

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo APP_TITULO;?></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="../imagens/logo-icon.png" rel="shortcut icon" type="image/x-icon" />

<script language="javascript" type="text/javascript" src="../frameworks/jquery.js"></script>

<script language="javascript" type="text/javascript" src="../frameworks/jquery.mask.js"></script>

<link href="../frameworks/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<script language="javascript" type="text/javascript" src="../frameworks/bootstrap/js/bootstrap.min.js"></script>

<link href="../frameworks/slim_update_imagem/slim/slim.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="../frameworks/bootstrap-datepicker/css/datepicker.css">

<script type="text/javascript" src="../frameworks/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<link href="../frameworks/uploadifive/uploadifive.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../frameworks/uploadifive/jquery.uploadifive.js"></script>

<link href="../frameworks/jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../frameworks/jquery-ui/jquery-ui.js"></script>

<link href="../frameworks/intlTelInput/css/intlTelInput.min.css" rel="stylesheet" type="text/css" />

<script language="javascript" type="text/javascript" src="../frameworks/intlTelInput/js/intlTelInput.min.js"></script>

<script language="javascript" type="text/javascript" src="../frameworks/intlTelInput/js/utils.js"></script>

<link href="css/geral.css" rel="stylesheet">

<link href="css/conteudo.css?v=<?php echo time(); ?>" rel="stylesheet">

</head>

<body>

<!-- [INICIO :: DIV GERAL]#########################################################################-->

<div id="geral">

    <div class="menugeral"></div>

    <!-- [FIM :: MENU]#########################################################################-->
    
<div class="container-fluid">

<div class="conteudoInterno" modulo="assinaturas">

    <div class="container">

        <script src='js/mask-form.js?v=<?php echo time();?>'></script>

        <script src='js/upload-arquivos.js?v=<?php echo time();?>'></script>

        <script type="text/javascript" src="../frameworks/signature.js?v=<?php echo time();?>"></script>

        <script src='js/assinatura.js?v=<?php echo time();?>'></script>

        <?php 
        
        if(!isset($_SESSION["cadastro_iniciado"])){

            //$controller->trafegoFunil($email,"preencheu-trial");
            
        ?>

        <!--<div class="box-conteudo boas-vindas">

            <div align="center"><img src="../imagens/logo.png" class="img-responsive" width="200px"></div>

            <div class="separador"></div>

            <p align="center"><strong>Bem-vindo(a) à AZO Benefícios!</strong></p> 

            <p align="justify">Felizes em tê-lo(a) conosco nesta jornada em direção a uma vida mais saudável e protegida. Aqui, você encontrará uma variedade de planos de serviços de saúde cuidadosamente pensados para atender às suas necessidades e proporcionar mais tranquilidade no seu dia a dia.</p>

            <p align="justify">Faça seu cadastro e descubra como podemos cuidar de você e da sua família com a qualidade e confiança que você merece. A AZO Benefícios está aqui para oferecer o melhor em saúde e bem-estar.</p> 
            <p align="center">Bem-vindo(a) à nossa comunidade!</p>

        </div>-->

        <div align="center">

            <a href="javascript:void(0);" class="iniciar-cadastro effect-transition-element" id_usuario="<?php echo $id_usuario; ?>" id_plano="<?php echo $id_plano; ?>">Iniciando formulário de cadastro</a>

        </div>

        <?php }else{?>

        <form class="form-horizontal" id="form-cadastro" acao="reload" info_destino ="assinaturas/form" info_registro="<?php echo $idView;?>">

            <div class="row">

                <div class="col-sm-12">

                    <div class="box-navegacao-cadastro-assinatura">

                        <div class="item-area effect-transition-element <?php echo $box_plano; ?>">

								<div class="conexao-item"></div>

								<a href="javascript:void(0)" box="box-selecao-plano" class="effect-transition-element">

									<span>

										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
											<path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73z"/>
										</svg>

									</span>

									<span class="info">Seleção de Plano</span>

								</a>

							</div>

							<div class="item-area effect-transition-element <?php echo $box_titular; ?>">

								<div class="conexao-item"></div>

								<a href="javascript:void(0)" box="box-selecao-titular" class="effect-transition-element">

									<span>

										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
											<path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z"/>
										</svg>

									</span>

									<?php if($tipo_plano == 3){ //PLANO EMPRESA?>

									<span class="info">Dados Empresa</span>

									<?php }else{ //PLANO Individual OU FAMILIAR?>

									<span class="info">Dados Titular</span>

									<?php } ?>
									
								</a>

							</div>

							<?php /* if($tipo_plano > 1){ //PLANO EMPRESA OU FAMILIAR?>

							<div class="item-area effect-transition-element <?php echo $box_dependentes; ?>">

								<div class="conexao-item"></div>

								<a href="javascript:void(0)" box="box-selecao-dependentes" class="effect-transition-element">

									<span>

										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
											<path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
										</svg>

									</span>

									<span class="info">Vincular Vidas</span>
									
								</a>

							</div>

							<?php } */ ?>

							<div class="item-area effect-transition-element  <?php echo $box_assinatura; ?>">

								<div class="conexao-item"></div>

								<a href="javascript:void(0)" box="box-selecao-contrato" class="effect-transition-element">

									<span>

										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
											<path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5"></path>
											<path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"></path>
										</svg>

									</span>

									<span class="info">Finalizar Contrato</span>
									
								</a>

							</div>

                    </div>

                </div>

            </div>

            <?php echo $id;?>

			<?php echo $id_cliente;?>

            
            <div class="box-campos box-selecao-plano" box="plano">

                <div class="box-conteudo">

                    <div align="center">

                        <?php if($id_plano == 55){ ?>

                            <img src="../imagens/logo.png" class="img-responsive" width="200px" style="display:inline-block;">

                            <img src="../imagens/logo-aesp.png" class="img-responsive" width="200px" style="display:inline-block;">

                        <?php }else{ ?>

                            <img src="../imagens/logo.png" class="img-responsive" width="200px">

                        <?php } ?>
                
                    </div>

                    <div class="separador"></div>

                    <div class="title-page">

                        <span>

                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-grid" viewBox="0 0 16 16">
                                <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z"/>
                            </svg>

                        </span> 
                        
                        Seleção de planos
                        
                    </div>

                    <input type="hidden" name="assinatura-responsavel"  class="campo" value="<?php echo $id_usuario; ?>">
                        
                    <div class="box-lista-planos row">

                        <?php

                        $planoSelecionadoContratacao = $controller->planoSelecionadoContratacao($id_plano);

                        if($planoSelecionadoContratacao > 0){

                            if($controller->res["valor_vida_adicionalView"] > 0){

                                $infoVidaAdicional = "+ <small>R$ ".$controller->res["valor_vida_adicionalView"]."/ mensal (para cada vida adicional)</small><br>"; 


                            }else{

                                $infoVidaAdicional = "";

                            }

                            echo '<div class="col-sm-12">';

                            echo '
                                <div 
                                    class="botao-plano" 
                                    id_plano="'.$controller->res["id"].'" 
                                    parcelas="'.$controller->res["parcelas"].'" 
                                    pontos="'.$controller->res["pontos"].'"
                                    adesao="'.$controller->res["adesaoView"].'"
                                    degustacao="'.$controller->res["degustacaoView"].'"
                                    valor_adesao="'.$controller->res["valor_adesao"].'"
                                    tipo_plano="'.$controller->res["tipo_plano"].'"
                                    vidas_min="'.$controller->res["vidas_min"].'"
                                    vidas_max="'.$controller->res["vidas_max"].'"
                                    tipo_cobranca_cartao="'.$controller->res["tipo_cobranca_cartao"].'"
                                    valor_vida_adicional="'.$controller->res["valor_vida_adicionalView"].'"
                                >

                                    <div class="botao-plano-titulo">'.$controller->res["nome"].'</div>

                                    <div>

                                        <small>'.$controller->res["tipo_plano_view"].'</small><br>
                                        <small>'.$controller->res["vidas"].'</small>

                                    </div>

                                    <div class="botao-plano-valor" valor="'.$controller->res["valorView"].'">
                                        '.$controller->res["degustacao"].$controller->res["valor"].' <small>/ mensal</small><br>
                                        '.$infoVidaAdicional.'
                                        <small>'.$controller->res["adesao"].'</small>
                                    </div>

                                    <div class="botao-plano-descricao">'.$controller->res["descricao"].'</div>

                                </div>';

                            echo '</div>';
                            
                        }else{

                            echo "<div align='center' style='line-height:300px;'>Não possuí planos disponíveis.</div>";

                        }

                        ?>

                        <div class="col-sm-12">
                            
                            <input type="hidden" class="campo validar" name="assinatura-id_plano" value="<?php echo $id_plano; ?>">

                            <input type="hidden" class="campo" name="assinatura-plano" value="<?php echo $plano; ?>">

                            <input type="hidden" class="campo" name="assinatura-valor" value="<?php echo $controller->util->formatarDoubleBD($valor); ?>">

                            <input type="hidden" class="campo" name="assinatura-valor_vida_adicional" value="<?php echo $valor_vida_adicional; ?>">

                            <input type="hidden" class="campo" name="assinatura-parcelas" value="<?php echo $parcelas; ?>">

                            <input type="hidden" class="campo" name="assinatura-pontos" value="<?php echo $pontos; ?>">

                            <input type="hidden" class="campo" name="assinatura-adesao" value="<?php echo $adesao; ?>">

                            <input type="hidden" class="campo" name="assinatura-degustacao" value="<?php echo $degustacao; ?>">

                            <input type="hidden" class="campo" name="assinatura-valor_adesao" value="<?php echo $valor_adesao; ?>">

                            <input type="hidden" class="campo" name="assinatura-descricao_plano" value="<?php echo $descricao_plano; ?>">

                            <input type="hidden" class="campo" name="assinatura-tipo_plano" value="<?php echo $tipo_plano; ?>">

                            <input type="hidden" class="campo" name="assinatura-vidas_min" value="<?php echo $vidas_min; ?>">

                            <input type="hidden" class="campo" name="cliente-tipo_pessoa" value="<?php echo $tipo_pessoa; ?>">

                            <input type="hidden" class="campo" name="assinatura-tipo_cobranca_cartao" value="<?php echo $tipo_cobranca_cartao; ?>">
                        
                        </div>

                    </div>
                    <?php

                    if($tipo_plano < '3'){

                        $ativarSelecaoEmpresa = "style='display:none;'";

                        $campoEmpresa = "";

                        $campoOutros = "campo validar";

                    }else{

                        $ativarSelecaoEmpresa = "";

                        $campoEmpresa = "campo validar";

                        $campoOutros = "";

                    }

                    ?>

                    <div class="form-group box-selecao-plano-empresa" <?php echo $ativarSelecaoEmpresa; ?>>
                    
                        <div class="col-sm-6">
                        
                            <label class="control-label">Quantidade de vidas</label>
                            
                            <input type="number" class="form-control <?php echo $campoEmpresa; ?> inteiro campo-empresa" name="assinatura-vidas_max" tipo="texto" value="<?php echo $vidas_max; ?>">

                            <input type="hidden" class="<?php echo $campoOutros; ?> campo-outros" name="assinatura-vidas_max" value="<?php echo $vidas_max; ?>">
                        
                        </div>

                        <div class="col-sm-6">
                        
                            <label class="control-label">Tipo de plano empresa</label>
                            
                            <select name="assinatura-tipo_plano_empresa"  class="form-control <?php echo $campoEmpresa; ?> campo-empresa">

                                <option value="0" <?php if($tipo_plano_empresa == 0){echo "selected";} ?>><?php echo $controller->util->tipoPlanoEmpresa(0); ?></option>
                                <option value="1" <?php if($tipo_plano_empresa == 1){echo "selected";} ?>><?php echo $controller->util->tipoPlanoEmpresa(1); ?></option>  

                            </select>

                            <input type="hidden" class="<?php echo $campoOutros; ?> campo-outros" name="assinatura-tipo_plano_empresa" value="0">
                        
                        </div>
                        
                    </div>

                    <div class="form-group">
                    
                        <div class="col-sm-6">
                        
                            <label class="control-label">Forma de pagamento</label>
                            
                            <select name="assinatura-forma_pagamento"  class="form-control validar campo">

                                <?php /*<option value="0" <?php if($forma_pagamento == 0){echo "selected";} ?>>Boleto</option> */?>
                                <option value="1" <?php if($forma_pagamento == 1){echo "selected";} ?>>Cartão de Crédito</option>  

                            </select>
                        
                        </div>
                        
                    </div>

                </div>

                <div align="center">

                    <a href="javascript:void(0);" class="salvar effect-transition-element">Salvar e continuar</a>

                </div>

            </div>

            <div class="box-campos box-selecao-titular" style="display:none;"  box="titular">
            
                <div class="box-conteudo">

                    <div align="center">
                        
                        <?php if($id_plano == 55){ ?>

                            <img src="../imagens/logo.png" class="img-responsive" width="200px" style="display:inline-block;">

                            <img src="../imagens/logo-aesp.png" class="img-responsive" width="200px" style="display:inline-block;">

                        <?php }else{ ?>

                            <img src="../imagens/logo.png" class="img-responsive" width="200px">

                        <?php } ?>

                    </div>

                    <div class="separador"></div>


                    <div class="title-page">

                        <span>

                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-grid" viewBox="0 0 16 16">
                                <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z"/>
                            </svg>

                        </span> 
                        
                        Dados pessoais

                        <small>É importante o preenchimento correto de todos os campos.</small>

                    </div>
                    
                    <div class="form-group">
                    
                        <div class="col-sm-6">
                        
                            <label class="control-label">Nome</label>
                            
                            <input class="form-control validar campo" name="cliente-nome"  tipo="texto" type="text" value="<?php echo $nome;?>"> 
                        
                        </div>

                        <div class="col-sm-6">
                        
                            <label class="control-label">E-mail</label>
                            
                            <input class="form-control validar campo" name="cliente-email"  tipo="email" type="email" value="<?php echo $email;?>"> 
                        
                        </div>
                        
                    </div>
                    
                    <div class="form-group">

                        <div class="col-sm-4">
                            
                            <label class="control-label">Sexo</label>
                            
                            <select class="form-control validar campo" name="cliente-sexo">

                                <option value="0" <?php if($sexo == 0){echo "selected";} ?>><?php echo $controller->util->tipoSexo(0);?></option>
                                <option value="1" <?php if($sexo == 1){echo "selected";} ?>><?php echo $controller->util->tipoSexo(1);?></option>
                                
                            </select>
                        
                        </div>
                    
                        <div class="col-sm-4">
                        
                            <label class="control-label">Telefone</label>
                            
                            <input class="form-control validar campo telefone" name="cliente-telefone"  tipo="texto" type="text" value="<?php echo $telefone;?>"> 

                            <input class="campo ddi" name="cliente-telefone_ddi" type="hidden" value="<?php echo $telefone_ddi;?>"> 
                        
                        </div>

                        <div class="col-sm-4">
                        
                            <label class="control-label">Data de Nascimento</label>
                            
                            <input class="form-control validar campo data" name="cliente-nascimento"  tipo="idade_titular" type="text" value="<?php echo $nascimento;?>"> 
                        
                        </div>
                        
                    </div>
                    
                    <div class="form-group">

                        <?php /*
                    
                        <div class="col-sm-6">
                        
                            <label class="control-label">RG</label>
                            
                            <input class="form-control validar campo inteiro" name="cliente-rg"  tipo="texto" type="text" value="<?php echo $rg;?>"> 
                        
                        </div>

                        */ ?>

                        <div class="col-sm-6">
                        
                            <label class="control-label">CPF</label>
                            
                            <input class="form-control validar campo cpf" name="cliente-cpf" maxlength="14"  tipo="texto" type="text" value="<?php echo $cpf;?>"> 
                        
                        </div>
                        
                    </div>

                    <?php /*

                    <div class="form-group">

                        <div class="col-sm-6">
                            
                            <label class="control-label">Nome da mãe</label>
                            
                            <input class="form-control validar campo" name="cliente-nome_mae"  tipo="texto" type="text" value="<?php echo $nome_mae;?>"> 
                        
                        </div>

                    </div>

                    */ ?>

                </div>

                <div class="box-conteudo box-selecao-titular" style="display:none;">

                    <div class="title-page">

                        <span>

                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-grid" viewBox="0 0 16 16">
                                <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z"/>
                            </svg>

                        </span> 
                        
                        Seu endereço

                    </div>
                    
                    <div class="form-group">
                    
                        <div class="col-sm-3">
                        
                            <label class="control-label">CEP</label>
                            
                            <input class="form-control validar campo cep" name="cliente-cep"  tipo="texto" type="text" value="<?php echo $cep;?>"> 
                        
                        </div>

                        <div class="col-sm-7">
                        
                            <label class="control-label">Endereço</label>
                            
                            <input class="form-control validar campo" name="cliente-endereco"  tipo="texto" type="text" value="<?php echo $endereco;?>"> 
                        
                        </div>

                        <div class="col-sm-2">
                        
                            <label class="control-label">Número</label>
                            
                            <input class="form-control validar campo inteiro" name="cliente-numero"  tipo="texto" type="text" value="<?php echo $numero;?>" maxlength="10"> 
                        
                        </div>
                        
                    </div>

                    <div class="form-group">

                        <div class="col-sm-8">
                            
                            <label class="control-label">Complemento</label>
                            
                            <input class="form-control campo" name="cliente-complemento"  tipo="texto" type="text" value="<?php echo $complemento;?>"> 
                        
                        </div>

                        <div class="col-sm-4">
                            
                            <label class="control-label">Bairro</label>
                            
                            <input class="form-control validar campo" name="cliente-bairro"  tipo="texto" type="text" value="<?php echo $bairro;?>"> 
                        
                        </div>

                    </div>
                    
                    <div class="form-group">
                    
                        <div class="col-sm-5">
                        
                            <label class="control-label">Cidade</label>
                            
                            <input class="form-control validar campo" name="cliente-cidade"  tipo="texto" type="text" value="<?php echo $cidade;?>"> 
                        
                        </div>

                        <div class="col-sm-3">
                        
                            <label class="control-label">Estado</label>
                            
                            <select name="cliente-estado"  class="form-control validar campo">
                                <option value="AC" <?php if($estado == "AC"){echo "selected";} ?>>Acre</option>
                                <option value="AL" <?php if($estado == "AL"){echo "selected";} ?>>Alagoas</option>
                                <option value="AP" <?php if($estado == "AP"){echo "selected";} ?>>Amapá</option>
                                <option value="AM" <?php if($estado == "AM"){echo "selected";} ?>>Amazonas</option>
                                <option value="BA" <?php if($estado == "BA"){echo "selected";} ?>>Bahia</option>
                                <option value="CE" <?php if($estado == "CE"){echo "selected";} ?>>Ceará</option>
                                <option value="DF" <?php if($estado == "DF"){echo "selected";} ?>>Distrito Federal</option>
                                <option value="ES" <?php if($estado == "ES"){echo "selected";} ?>>Espírito Santo</option>
                                <option value="GO" <?php if($estado == "GO"){echo "selected";} ?>>Goiás</option>
                                <option value="MA" <?php if($estado == "MA"){echo "selected";} ?>>Maranhão</option>
                                <option value="MT" <?php if($estado == "MT"){echo "selected";} ?>>Mato Grosso</option>
                                <option value="MS" <?php if($estado == "MS"){echo "selected";} ?>>Mato Grosso do Sul</option>
                                <option value="MG" <?php if($estado == "MG"){echo "selected";} ?>>Minas Gerais</option>
                                <option value="PA" <?php if($estado == "PA"){echo "selected";} ?>>Pará</option>
                                <option value="PB" <?php if($estado == "PB"){echo "selected";} ?>>Paraíba</option>
                                <option value="PR" <?php if($estado == "PR"){echo "selected";} ?>>Paraná</option>
                                <option value="PE" <?php if($estado == "PE"){echo "selected";} ?>>Pernambuco</option>
                                <option value="PI" <?php if($estado == "PI"){echo "selected";} ?>>Piauí</option>
                                <option value="RJ" <?php if($estado == "RJ"){echo "selected";} ?>>Rio de Janeiro</option>
                                <option value="RN" <?php if($estado == "RN"){echo "selected";} ?>>Rio Grande do Norte</option>
                                <option value="RS" <?php if($estado == "RS"){echo "selected";} ?>>Rio Grande do Sul</option>
                                <option value="RO" <?php if($estado == "RO"){echo "selected";} ?>>Rondônia</option>
                                <option value="RR" <?php if($estado == "RR"){echo "selected";} ?>>Roraima</option>
                                <option value="SC" <?php if($estado == "SC"){echo "selected";} ?>>Santa Catarina</option>
                                <option value="SP" <?php if($estado == "SP"){echo "selected";} ?>>São Paulo</option>
                                <option value="SE"  <?php if($estado == "SE"){echo "selected";} ?>>Sergipe</option>
                                <option value="TO"  <?php if($estado == "TO"){echo "selected";} ?>>Tocantins</option>
                            </select> 
                        
                        </div>
                        
                    </div>
                    
                </div>

                <?php /*

                <div class="box-conteudo">

                    <div class="title-page">

                        <span class="glyphicon glyphicon-paperclip"></span> 
                        
                        Documentação

                    </div>

                    <?php if($tipo_plano == 3){ //CAMPO PESSOA JURÍDICA?>
                        
                    <div class="form-group">
                    
                        <div class="col-sm-12 box-upload-imagem box-upload-imagem-cnpj">
                        
                            <label class="control-label">Anexar CNPJ</label> 

                            <?php if($termo_adesao != 1){ ?>

                            <div class='box-upload-imagem-clube'>
                                
                                <span <?php echo $viewImagem_cnpj;?> class='divImg' style="display:block; padding:10px 0;text-align:right;">

                                    <a 
                                        href='<?php echo APP_URL_BASE; ?>/arquivos/assinatura_<?php echo $idView; ?>/<?php echo $anexo_cnpj; ?>' 
                                        class='btn-default btn-sm visualizar-arquivo' 
                                        style="border:1px solid #CCC;" 
                                        title='Visualizar arquivo' 
                                        target="_blank"
                                    >
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                        Visualizar
                                    </a>
                                    
                                    <a 
                                        href='javascript:void(0);' 
                                        arquivo="arquivos/assinatura_<?php echo $idView?>/<?php echo $anexo_cnpj; ?>" 
                                        id="<?php echo $idView; ?>" 
                                        class='btn-default btn-sm excluir-arquivo' 
                                        style="border:1px solid #CCC;"  
                                        title='Excluir arquivo'
                                    >
                                        <span class="glyphicon glyphicon-trash"></span>
                                        Excluir
                                    </a>
                                    
                                </span>

                            </div>

                            <?php } ?>
                            
                            <input type='text' name='assinatura-anexo_cnpj' size='50' maxlength='200'  class='campo form-control upImg' readonly='readonly' value='<?php echo $anexo_cnpj;?>'>
                            
                            <span class='btUpload botaoUpload' <?php echo $viewBotao_cnpj;?> timestamp='<?php echo time();?>' token='<?php echo md5('unique_salt' . time());?>'> 
                                            
                                <input type='file' name='UploadCNPJ' id='UploadCNPJ' modulo='assinaturas' diretorioUpload='arquivos/assinatura_<?php echo $idView;?>' class='form-control'/>
                                    
                            </span>
                        
                        </div>
                        
                    </div>

                    <div class="form-group">
                    
                        <div class="col-sm-12 box-upload-imagem box-upload-imagem-contratosocial">
                        
                            <label class="control-label">Anexar Contrato Social</label> 

                            <?php if($termo_adesao != 1){ ?>

                            <div class='box-upload-imagem-clube'>
                                
                                <span <?php echo $viewImagem_contratosocial;?> class='divImg' style="display:block; padding:10px 0;text-align:right;">

                                    <a 
                                        href='<?php echo APP_URL_BASE; ?>/arquivos/assinatura_<?php echo $idView; ?>/<?php echo $anexo_contratosocial; ?>' 
                                        class='btn-default btn-sm visualizar-arquivo' 
                                        style="border:1px solid #CCC;" 
                                        title='Visualizar arquivo' 
                                        target="_blank"
                                    >
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                        Visualizar
                                    </a>
                                    
                                    <a 
                                        href='javascript:void(0);' 
                                        arquivo="arquivos/assinatura_<?php echo $idView; ?>/<?php echo $anexo_contratosocial; ?>" 
                                        id="<?php echo $idView; ?>" 
                                        class='btn-default btn-sm excluir-arquivo' 
                                        style="border:1px solid #CCC;"  
                                        title='Excluir arquivo'
                                    >
                                        <span class="glyphicon glyphicon-trash"></span>
                                        Excluir
                                    </a>
                                    
                                </span>

                            </div>

                            <?php } ?>
                            
                            <input type='text' name='assinatura-anexo_contratosocial' size='50' maxlength='200'  class='campo form-control upImg' readonly='readonly' value='<?php echo $anexo_contratosocial;?>'>
                            
                            <span class='btUpload botaoUpload' <?php echo $viewBotao_contratosocial;?> timestamp='<?php echo time();?>' token='<?php echo md5('unique_salt' . time());?>'> 
                                            
                                <input type='file' name='UploadContratoSocial' id='UploadContratoSocial' modulo='assinaturas' diretorioUpload='arquivos/assinatura_<?php echo $idView;?>' class='form-control'/>
                                    
                            </span>
                        
                        </div>
                        
                    </div>

                    <?php } ?>

                    <div class="form-group">
                    
                        <div class="col-sm-12 box-upload-imagem box-upload-imagem-cpf">
                        
                            <label class="control-label">Anexar CPF</label> 

                            <?php if($termo_adesao != 1){ ?>

                            <div class='box-upload-imagem-clube'>
                                
                                <span <?php echo $viewImagem_cpf;?> class='divImg' style="display:block; padding:10px 0;text-align:right;">

                                    <a 
                                        href='<?php echo APP_URL_BASE; ?>/arquivos/assinatura_<?php echo $idView; ?>/<?php echo $anexo_cpf; ?>' 
                                        class='btn-default btn-sm visualizar-arquivo' 
                                        style="border:1px solid #CCC;" 
                                        title='Visualizar arquivo' 
                                        target="_blank"
                                    >
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                        Visualizar
                                    </a>
                                    
                                    <a 
                                        href='javascript:void(0);' 
                                        arquivo="arquivos/assinatura_<?php echo $idView?>/<?php echo $anexo_cpf; ?>" 
                                        id="<?php echo $idView; ?>" 
                                        class='btn-default btn-sm excluir-arquivo' 
                                        style="border:1px solid #CCC;"  
                                        title='Excluir arquivo'
                                    >
                                        <span class="glyphicon glyphicon-trash"></span>
                                        Excluir
                                    </a>
                                    
                                </span>

                            </div>

                            <?php } ?>
                            
                            <input type='text' name='assinatura-anexo_cpf' size='50' maxlength='200'  class='campo form-control upImg' readonly='readonly' value='<?php echo $anexo_cpf;?>'>
                            
                            <span class='btUpload botaoUpload' <?php echo $viewBotao_cpf;?> timestamp='<?php echo time();?>' token='<?php echo md5('unique_salt' . time());?>'> 
                                            
                                <input type='file' name='UploadCPF' id='UploadCPF' modulo='assinaturas' diretorioUpload='arquivos/assinatura_<?php echo $idView;?>' class='form-control'/>
                                    
                            </span>
                        
                        </div>
                        
                    </div>

                    <?php

                    $listaResponsavelAdicionalAssinatura = $controller->listaResponsavelAdicionalAssinatura($idView);

                    if($listaResponsavelAdicionalAssinatura > 0){

                        echo "<div class='box-anexo-responsavel-adicional'>";

                        for($i = 0; $i < $listaResponsavelAdicionalAssinatura; $i++){						

                            if($controller->res["responsavel_anexo_cpf"][$i] != ""){

                                $viewImagem_cpf_adicional = "";
                                
                                $viewBotao_cpf_adicional = "style='display:none;'";   
                                
                            }else{

                                $viewImagem_cpf_adicional = "style='display:none;'";
    
                                $viewBotao_cpf_adicional = "";

                            }

                    ?>

                    <div class="form-group">
                    
                        <div class="col-sm-12 box-upload-imagem box-upload-imagem-cpf-responsavel-adicional">
                        
                            <label class="control-label">Anexar CPF <small>(<?php echo $controller->res["responsavel_nome"][$i]; ?>)</small></label> 

                            <?php if($termo_adesao != 1){ ?>

                            <div class='box-upload-imagem-clube'>
                                
                                <span <?php echo $viewImagem_cpf_adicional;?> class='divImg' style="display:block; padding:10px 0;text-align:right;">

                                    <a 
                                        href='<?php echo APP_URL_BASE; ?>/arquivos/assinatura_<?php echo $idView; ?>/<?php echo $controller->res["responsavel_anexo_cpf"][$i]; ?>' 
                                        class='btn-default btn-sm visualizar-arquivo' 
                                        style="border:1px solid #CCC;" 
                                        title='Visualizar arquivo' 
                                        target="_blank"
                                    >
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                        Visualizar
                                    </a>
                                    
                                    <a 
                                        href='javascript:void(0);' 
                                        arquivo="arquivos/assinatura_<?php echo $idView; ?>/<?php echo $controller->res["responsavel_anexo_cpf"][$i]; ?>" 
                                        id="<?php echo $controller->res["responsavel_id"][$i]; ?>" 
                                        class='btn-default btn-sm excluir-arquivo' 
                                        style="border:1px solid #CCC;"  
                                        title='Excluir arquivo'
                                    >
                                        <span class="glyphicon glyphicon-trash"></span>
                                        Excluir
                                    </a>
                                    
                                </span>

                            </div>

                            <?php } ?>

                            <input type='hidden' name='responsavel_anexo-id' class='campo' value='<?php echo  $controller->res["responsavel_id"][$i];?>'>
                            
                            <input type='text' name='responsavel_anexo-anexo_cpf' size='50' maxlength='200'  class='campo form-control upImg' readonly='readonly' value='<?php echo  $controller->res["responsavel_anexo_cpf"][$i];?>'>
                            
                            <span class='btUpload botaoUpload' <?php echo $viewBotao_cpf_adicional;?> timestamp='<?php echo time()*($i+1);?>' token='<?php echo md5('unique_salt' . time()*($i+1));?>'> 
                                            
                                <input type='file' name='UploadCPFadicional[]' id="UploadCPFadicional<?php echo $i; ?>"  modulo='assinaturas' diretorioUpload='arquivos/assinatura_<?php echo $idView;?>' class='form-control'/>
                                    
                            </span>
                        
                        </div>
                        
                    </div>

                    <?php

                        }

                        echo "</div>";

                    }

                    ?>

                    <div class="form-group">
                    
                        <div class="col-sm-12 box-upload-imagem box-upload-imagem-residencia">
                        
                            <label class="control-label">Anexar Comprovante e Residência</label> 

                            <?php if($termo_adesao != 1){ ?>

                            <div class='box-upload-imagem-clube'>
                                
                                <span <?php echo $viewImagem_comprovanteresidencia;?> class='divImg' style="display:block; padding:10px 0;text-align:right;">
                                
                                    <a 
                                        href='<?php echo APP_URL_BASE; ?>/arquivos/assinatura_<?php echo $idView; ?>/<?php echo $anexo_comprovanteresidencia; ?>' 
                                        class='btn-default btn-sm visualizar-arquivo' 
                                        style="border:1px solid #CCC;"  
                                        title='Visualizar arquivo' 
                                        target="_blank"
                                    >
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                        Visualizar
                                    </a>
                                    
                                    <a 
                                        href='javascript:void(0);' 
                                        arquivo="arquivos/assinatura_<?php echo $idView; ?>/<?php echo $anexo_comprovanteresidencia; ?>" 
                                        id="<?php echo $idView; ?>" 
                                        class='btn-default btn-sm excluir-arquivo' 
                                        style="border:1px solid #CCC;"  
                                        title='Excluir arquivo'
                                    >
                                        <span class="glyphicon glyphicon-trash"></span>	
                                        Excluir
                                    </a>
                                    
                                </span>

                            </div>

                            <?php } ?>
                            
                            <input type='text' name='assinatura-anexo_comprovanteresidencia' size='50'  maxlength='200'  class='campo form-control upImg' readonly='readonly' value='<?php echo $anexo_comprovanteresidencia;?>'>
                            
                            <span class='btUpload botaoUpload'  <?php echo $viewBotao_comprovanteresidencia;?> timestamp='<?php echo time();?>' token='<?php echo md5('unique_salt' . time());?>'> 
                                            
                                <input type='file' name='UploadResidencia' id='UploadResidencia' modulo='assinaturas' diretorioUpload='arquivos/assinatura_<?php echo $idView;?>' class='form-control'/>
                                    
                            </span>
                        
                        </div>
                        
                    </div>

                </div>

                */ ?>

                <?php if($termo_adesao != 1){ ?>

                <div align="center">

                    <a href="javascript:void(0);" class="salvar effect-transition-element">Salvar e continuar</a>

                </div>

                <?php } ?>

            </div>

            <?php if($id_clienteView != "" &&  $id_clienteView > 0 && $tipo_plano != "" && $tipo_plano > 1){ ?>

				<div class="box-campos box-selecao-dependentes" style="display:none;" box="dependentes">
										
					<?php 
					
					$listaDependentes = $controller->listaDependentes($id_clienteView, "arquivos/assinatura_".$idView, true);
					
					?>

					<input type="hidden" name="assinatura-dependentes_concluido" class="campo" value="<?php echo $dependentes_concluido; ?>">

					<?php if($termo_adesao != 1){ ?>

										
					<div class="box-conteudo box-cadastro-dependentes individual">

                        <div class="title-page">

                            <span>
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
									<path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"></path>
								</svg>
							</span>

                            Cadastro individual de dependentes

                        </div>
						
						<div class="form-group">
							
							<div class="col-sm-8">
							
								<label class="control-label">Nome</label>
								
								<input class="form-control validar campo" name="dependente-nome"  tipo="texto" type="text"> 
							
							</div>

                            <div class="col-sm-4">
								
								<label class="control-label">Sexo</label>
								
								<select class="form-control validar campo" name="dependente-sexo">

									<option value="0"><?php echo $controller->util->tipoSexo(0);?></option>
									<option value="1"><?php echo $controller->util->tipoSexo(1);?></option>
									
								</select>
							
							</div>

                            <input class="form-control validar campo" name="dependente-email"  tipo="email" type="hidden" value="<?php echo $email; ?>">
                            
                            <input class="form-control validar campo" name="dependente-telefone"  tipo="texto" type="hidden" value="<?php echo $telefone; ?>">

                            <input class="campo" name="dependente-telefone_ddi" type="hidden" value="<?php echo $telefone_ddi; ?>">
							
						</div>
						
						<div class="form-group">

							<div class="col-sm-3">
							
								<label class="control-label">Data de Nascimento</label>
								
								<input class="form-control validar campo data" name="dependente-nascimento"  tipo="texto" type="text"> 
							
							</div>
						
							<div class="col-sm-5">
							
								<label class="control-label">RG</label>
								
								<input class="form-control validar campo inteiro" name="dependente-rg"  tipo="texto" type="text"> 
							
							</div>

							<div class="col-sm-4">
							
								<label class="control-label">CPF</label>
								
								<input class="form-control validar campo cpf" name="dependente-cpf" maxlength="14"  tipo="texto" type="text"> 
							
							</div>
							
						</div>

						<div class="form-group">

							<div class="col-sm-6">
								
								<label class="control-label">Nome da mãe</label>
								
								<input class="form-control validar campo" name="dependente-nome_mae"  tipo="texto" type="text"> 
							
							</div>

						</div>

                        <input class="form-control campo" name="dependente-cep" type="hidden">
                        <input class="form-control campo" name="dependente-endereco" type="hidden">
                        <input class="form-control campo" name="dependente-numero" type="hidden">
                        <input class="form-control campo" name="dependente-complemento" type="hidden">
                        <input class="form-control campo" name="dependente-bairro" type="hidden">
                        <input class="form-control campo" name="dependente-cidade" type="hidden">
                        <input class="form-control campo" name="dependente-estado" type="hidden"> 

						
					</div>

                    <div align="center" style="margin-bottom:20px;" class="box-btn-action-depedentes">

                        <a href="javascript:void(0);" class="cancelar-edicao effect-transition-element" style="display:none;">

                            <span>Cancelar edição</span> 

                        </a>

                        <a href="javascript:void(0);" class="salvar effect-transition-element">
                            
                            <span class="glyphicon glyphicon-floppy-disk"></span> 

							<span class="text-add">Adicionar vida</span>
                        
                        </a>

                    </div>

					<?php } ?>

					<div class="box-conteudo">

						<div class="title-page">

							<span>
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
									<path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"></path>
								</svg>
							</span> 
							
							Vidas vinculadas - 

							<?php 
								
							if($tipo_plano == 2){

								$vidas = $vidas_max - 1;

							}else{

								$vidas = $vidas_max;

							}

							?>

							<span class="vidas-atuais"><?php echo $listaDependentes; ?></span>/<span class="vidas-totais"><?php echo $vidas; ?></span> vidas

							<div class="box-busca-interna box-buscar-dependentes">

								<a href="javascript:void(0)" class="limpar-busca">x</a>

								<div class="input-group">

									<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>

									<input type="text" class="form-control buscar-dependentes" value="<?php if(isset($_GET["busca"])){ echo $_GET["busca"]; } ?>">

								</div>

							</div>

						</div>

						<div class="lista-dependentes table-responsive">

							<table class="table table-hover table-striped" id="export_vidas">

								<thead>

									<tr>
										<th>ID</th>
										<th>Nome</th>
										<th>Nascimento</th>
										<th>Documentos</th>

										<th class="excludeThisClass"><div align="center">Anexos</div></th>

										<?php if($termo_adesao != 1){ ?>

										<th width="10" class="excludeThisClass"><div align="center">Ação</div></th>

										<?php } ?>

									</tr>

								</thead>

								<tbody>

								<?php 
								
								if($listaDependentes > 0){

									for($i = 0; $i < $listaDependentes; $i++){

                                        $adicional = "";

                                        if(($i+1) > $vidas){

                                            $adicional = '<span class="badge badge-danger"><small>Adicional</small></span><br>';

                                        }
										
								?>

									<tr style="position:relative;" id_dependente="<?php echo $controller->res["dependente_id"][$i]; ?>">

										
										<td>
                                            <small><span class="dependente_id"><?php echo $controller->res["dependente_id"][$i]; ?></span></small>
                                        </td>
										<td>
                                            <?php echo $adicional; ?>
											<small><strong><span class="dependente_nome"><?php echo $controller->res["dependente_nome"][$i]; ?></span></strong></small><br>
											<small><strong>Sexo:</strong> <span class="dependente_sexo"><?php echo $controller->res["dependente_sexoView"][$i]; ?></span></small><br>
											<small><strong>Mãe:</strong> <span class="dependente_nome_mae"><?php echo $controller->res["dependente_nome_mae"][$i]; ?></span></small>

                                            <span class="dependente_email" style="display:none;"><?php echo $controller->res["dependente_email"][$i]; ?></span>
                                            <span class="dependente_telefone_ddi" style="display:none;"><?php echo $controller->res["dependente_telefone_ddi"][$i]; ?></span>
                                            <span class="dependente_telefone" style="display:none;"><?php echo $controller->res["dependente_telefone"][$i]; ?></span>
										</td>
										<td>
                                            <small><span class="dependente_nascimento"><?php echo $controller->res["dependente_nascimento"][$i]; ?></span></small>										
										<td>
											<small><strong>RG:</strong> <span class="dependente_rg"><?php echo $controller->res["dependente_rg"][$i]; ?></span></small><br>
											<small><strong>CPF:</strong> <span class="dependente_cpf"><?php echo $controller->res["dependente_cpf"][$i]; ?></span></small>
										</td>

										<td valign="middle" align="center" style="position:relative;" class="excludeThisClass">

											<?php echo $controller->res["dependente_anexo"][$i]; ?>

										</td>

										<?php if($termo_adesao != 1){ ?>

										<td valign="middle" align="center" style="position:relative;" class="excludeThisClass">

											<div class="menu-acao">

												<a href="javascript:void(0);" class="btn-default open-menu-acao" title="Abrir opções"><span class="glyphicon glyphicon-option-vertical"></span></a>

												<div class="lista-itens">
											
													<a href="javascript:void(0);" class="btn btn-default btn-xs editar-dependente"  title="Editar dependente">

														<span class="glyphicon glyphicon-edit"></span> Editar vida

													</a>
													
													<a 
														href="#modalExclusaoDependente" 
														class="modal-confirm excluir-dependente"  
														data-toggle="modal" 
														data-target="#modalExclusaoDependente" 
														title="Confirmar exclusão de vida vinculada"
														id="<?php echo $controller->res["dependente_id"][$i]; ?>"
														nome="<?php echo $controller->res["dependente_nome"][$i]; ?>"
														cpf="<?php echo $controller->res["dependente_cpf"][$i]; ?>" 
													>

														<span class="glyphicon glyphicon-trash"></span> Excluir vida

													</a>

												</div>

											</div>

											<div class="box-confirmar-exclusao-dependente">

												Deseja excluir essa vida? 

												<a href="javascript:void(0);" class="btn btn-default btn-xs confirmar-exclusao-dependente" id="<?php echo $controller->res["dependente_id"][$i];?>">Sim</a>

												<a href="javascript:void(0);" class="btn btn-danger btn-xs cancelar-exclusao-dependente">Não</a>

											</div>
												
										</td>

										<?php } ?>

									</tr>

								<?php

									}

								}

								?>

								</tbody>

							</table>

						</div>

					</div>

                    <?php if($dependentes_concluido == 0 || $dependentes_concluido == ""){ ?>

                    <div align="center" class="box-avancar-dependentes">

                        <a href="javascript:void(0);" class="avancar effect-transition-element">

                            <span>Salvar e continuar</span> 

                        </a>

                    </div>

                    <?php } ?>

				</div>

				<?php } ?>

            <div class="box-campos box-selecao-contrato" style="display:none;" box="assinatura">
					
                <div class="box-conteudo">

                    <div align="center">
                        
                        <?php if($id_plano == 55){ ?>

                            <img src="../imagens/logo.png" class="img-responsive" width="200px" style="display:inline-block;">

                            <img src="../imagens/logo-aesp.png" class="img-responsive" width="200px" style="display:inline-block;">

                        <?php }else{ ?>

                            <img src="../imagens/logo.png" class="img-responsive" width="200px">

                        <?php } ?>

                    </div>

                    <div class="separador"></div>

                    <?php if($termo_adesao != 1){ ?> 

                    <div class="title-page">

                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-vector-pen" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M10.646.646a.5.5 0 0 1 .708 0l4 4a.5.5 0 0 1 0 .708l-1.902 1.902-.829 3.313a1.5 1.5 0 0 1-1.024 1.073L1.254 14.746 4.358 4.4A1.5 1.5 0 0 1 5.43 3.377l3.313-.828zm-1.8 2.908-3.173.793a.5.5 0 0 0-.358.342l-2.57 8.565 8.567-2.57a.5.5 0 0 0 .34-.357l.794-3.174-3.6-3.6z"/>
                                <path fill-rule="evenodd" d="M2.832 13.228 8 9a1 1 0 1 0-1-1l-4.228 5.168-.026.086z"/>
                            </svg>
                        </span> 
                        
                        Assinatura digital

                    </div>

                    <input class="validar campo" value="ok" type="hidden">

                    <div class="assinatura-digital">

                        <?php 

                        if($assinatura_digital_titular != ""){

                            $actionAssinatura = "style='display:none;'";

                            $viewAssinatura = "style='display:block;'";

                        }else{

                            $actionAssinatura = "";

                            $viewAssinatura = "";

                        }
                            
                        ?>
                            
                        <div class="form-group box-gerar-assinatura" <?php echo $actionAssinatura; ?>>
                        
                            <div class="col-sm-12">

                                <label class="control-label">Escreva sua assinatura digital aqui:</label><br>

                                <small>
                                    <strong>Instruções de preenchimento</strong>
                                    
                                    <ul>
                                        <li>No quadro abaixo utilize a linha guia para escrever a assinatura</li>
                                        <li>Clique em limpar, em caso de erro</li>
                                        <li>Escreva novamente a nova assinatura</li>
                                        <li>Clique no botão gerar assinatura digital</li>
                                        <li>Clique no botão Excluir atual e criar nova em caso de incoerência assinatura cadastrada</li>
                                        <li>Clique no botão Cancelar para manter a assinatura cadastrada, anteriormente</li>
                                    </ul>

                                </small>

                                <div id="wrapper" style="width:100%;" align="center">	
                        
                                    <div id="canvas">
                                            Canvas is not supported.
                                    </div>

                                </div>

                                <div class="action-assinatura" align="center">

                                    <a href="javascript:void(0)" class="btn btn-default limpar-assinatura-digital btn-sm">Limpar</a>

                                    <!--<a href="javascript:void(0)" class="btn btn-default salvar-assinatura-digital btn-sm">Gerar assinatura digital</a>
										
										<a href="javascript:void(0)" class="btn btn-default cancelar-alteracao-assinatura btn-sm" style="display:none;">Cancelar</a>-->

                                </div>

                            </div>

                            <div class="col-sm-6 assinatura-atual" <?php $viewAssinatura;?>>

                                <label class="control-label">Assinatura digital atual:</label>

                                <div class="box-assinatura-view">

                                    <img alt="Saved image png" src="<?php echo $assinatura_digital_titular;?>"/>

                                </div>

                            </div>

                        </div>

                        <div class="form-group box-visualizar-assinatura" <?php echo $viewAssinatura; ?>>

                            <div class="col-sm-12">

                                <label class="control-label">Assinatura digital gerada:</label>

                                <div class="box-assinatura-view" align="center">

                                    <img id="saveSignature" alt="Saved image png" src="<?php echo $assinatura_digital_titular;?>" class="img-responsive"/>

                                </div>

                                <?php echo $data_assinatura; ?>

                                <!--<div align="center" class="action-assinatura">

                                    <a href="javascript:void(0)" class="btn btn-default excluir-assinatura-digital btn-sm">Excluir atual e criar nova</a>

                                </div>-->

                            </div>

                            <div class="col-sm-6" style="display:none;">

                                <label class="control-label">Assinatura digital:</label>

                                <textarea class="form-control campo" rows="17" name="assinatura-assinatura_digital_titular" readonly><?php echo $assinatura_digital_titular;?></textarea>

                            </div>

                        </div>

                    </div>

                    <?php }else{ ?>

                        <p align="center"><strong>Parabéns por concluir seu cadastro na AZO Benefícios!</strong></p> 

                        <p align="justify">Estamos muito felizes em tê-lo conosco! Agora, para ativar seu acesso e começar a aproveitar todas as vantagens exclusivas, basta seguir para o checkout e concluir o pagamento.</p>

                        <p align="justify">Assim que o pagamento for confirmado, você terá acesso imediato a todos os benefícios que preparamos para facilitar seu dia a dia e trazer ainda mais bem-estar para você e sua família.</p> 
                        <p align="center">Se precisar de qualquer ajuda ou tiver dúvidas, estamos à disposição!</p>

                        <p align="center">Um abraço,</p>

                        <p align="center"><strong>Equipe AZO Benefícios</strong></p>

                        <div class="form-group">
                        
                            <div class="col-sm-12" align="center">
                            
                                <a href="javascript:void(0);" class="btn btn-lg btn-default open-impressao assinado" id_contrato="<?php  echo $id_contrato; ?>" id_assinatura="<?php echo $idView;?>">Visualizar contrato</a>
                            
                            </div>
                            
                        </div>


                    <?php } ?>

                </div>

                <?php if($termo_adesao != 1){ ?> 

                <div class="box-conteudo">

                    <div class="title-page">

                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                                <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5"></path>
                                <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"></path>
                            </svg>
                        </span> 
                        
                        Gerenciar contrato

                    </div>
                    
                    <?php if($termo_adesao == "1"){ ?>

                        <div class="form-group">
                        
                            <div class="col-sm-12" align="center">
                            
                                <a href="javascript:void(0);" class="btn btn-lg btn-default open-impressao" id_contrato="<?php  echo $id_contrato; ?>" id_assinatura="<?php echo $idView;?>">Visualizar contrato</a>
                            
                            </div>
                            
                        </div>

                    <?php }else{ ?>

                        <div class="form-group">
                        
                            <div class="col-sm-12" align="center">
                            
                                <a href="javascript:void(0);" class="btn btn-lg btn-default open-impressao" id_contrato="<?php  echo $id_contrato; ?>" id_assinatura="<?php echo $idView;?>">Visualizar contrato prévio</a>
                            
                            </div>
                            
                        </div>

                        <div class="form-group">
                        
                            <div class="col-sm-12">
                            
                                <label class="control-label">Termo de adesão</label><br>
                                    
                                <input name='assinatura-termo_adesao' class='validar campo'  type='checkbox'value="1"/>
                                
                                Li, compreendi e aceito todas as condições deste Termo de Adesão ao AZO Benefícios. Após aprovação do cadastro, você estará ingressando na AZO Benefícios com a condição especial no valor da mensalidade do plano escolhido

                                <input name='assinatura-autocontratacao' class='validar campo'  type='hidden' value="1"/>

                            </div>
                            
                        </div>

                    <?php
                
                    } 
                    
                    ?>

                </div>
                <?php } ?>
                    
                <?php if($termo_adesao != 1){ ?>

                <div align="center">

                    <a href="javascript:void(0);" class="salvar finalizar-cadastro effect-transition-element">Finalizar cadastro</a>

                </div>

                <?php }else if($termo_adesao == 1){ ?>

                <?php

                $chave = $controller->util->chaveAutenticacao($idView, $id_clienteView, 0, $cpf);

                if($chave){

                ?>

                <div align="center">

                    <a href="<?php echo APP_URL_BASE."/checkout/?chave=".$chave;?>" class="salvar checkout-pagamento effect-transition-element">Ir para o checkout de pagamento</a>

                </div>

                <?php 
            
                } 
                
                }
                
                ?>

			</div>

        </form>

        <?php }?>

    </div>

</div>

</div>

<!-- [FIM :: DIV GERAL]#########################################################################-->

<!-- Modal -->
<div class="modal fade" id="modalExclusaoDependente" tabindex="-1" role="dialog" aria-labelledby="modalExclusaoDependenteLabel">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title" id="modalExclusaoDependenteLabel">Confirmação de exclusão de  vida vinculada</h4>
      		</div>
      		<div class="modal-body">

				<form class="form-horizontal">

					<div class="form-group">
								
						<div class="col-sm-3">
						
							<label class="control-label">ID Vida</label>

							<input type="text" class="form-control" name="id_dependente" disabled/>

						</div>

						<div class="col-sm-9">

							<label class="control-label">Nome Vida</label>

							<input type="text" class="form-control" name="nome_dependente" disabled/>

						</div>

					</div>

					<div class="form-group">
								
						<div class="col-sm-6">
						
							<label class="control-label">CPF Vida</label>

							<input type="text" class="form-control" name="cpf_dependente" disabled/>

						</div>

					</div>

				</form>
        
      		</div>

      		<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<a href="javascript:void(0);" class="btn btn-success confirmar-exclusao-dependente" >Confirmar exclusão</a>
			</div>
    	</div>
  	</div>
</div>

</body>
</html>