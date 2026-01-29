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

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<title><?php echo APP_TITULO;?></title>

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

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#2563eb',
                    'primary-dark': '#1d4ed8',
                    secondary: '#10b981',
                    'secondary-dark': '#059669',
                    accent: '#f59e0b',
                    danger: '#ef4444',
                    dark: '#1f2937',
                    light: '#f9fafb'
                }
            }
        }
    }
</script>
<style>
    .input-field {
        transition: all 0.3s ease;
    }
    
    .input-field:focus {
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
    }
    
    .btn-primary {
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    }
    
    .trust-badge {
        transition: transform 0.2s ease;
    }
    
    .trust-badge:hover {
        transform: scale(1.05);
    }
    
    .countdown-timer {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }
    
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .tooltip {
        position: relative;
    }
    
    .tooltip:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: #1f2937;
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 12px;
        white-space: nowrap;
        z-index: 10;
    }
    
    .shake {
        animation: shake 0.5s ease-in-out;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    .product-highlight {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    }
</style>
</head>

<body class="bg-gray-50 antialiased min-h-screen">

<div id="geral" class="min-h-screen">
    <header class="bg-white border-b border-gray-200 py-4 px-4 lg:px-8">
        <div class="max-w-5xl mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="#" class="text-2xl font-bold text-primary flex items-center">
                    <img src="../imagens/logo.png" alt="AZO Benefícios" class="h-8 w-auto mr-2">
                    <span>AZO Benefícios</span>
                </a>
            </div>
            <div class="flex items-center space-x-4">
                <div class="hidden md:flex items-center text-sm text-gray-600">
                    <i class="fas fa-lock text-secondary mr-2"></i>
                    <span>Checkout 100% Seguro</span>
                </div>
            </div>
        </div>
    </header>

    <div class="bg-gradient-to-r from-amber-500 to-orange-500 text-white py-3 px-4">
        <div class="max-w-5xl mx-auto flex items-center justify-center text-sm font-medium">
            <i class="fas fa-bolt mr-2 countdown-timer"></i>
            <span>Oferta especial! <strong id="countdown">14:59</strong> restantes para garantir este preço</span>
        </div>
    </div>

    <main class="py-8 px-4 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-7 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 fade-in">

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

            <?php echo $id;?>

			<?php echo $id_cliente;?>

            <div class="box-campos box-selecao-titular"  box="titular">

                <?php if($termo_adesao != 1){ ?>
            
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
                        
                        Dados do pagador

                        <small>É importante o preenchimento correto de todos os campos.</small>

                    </div>

                    <div class="box-lista-planos row" style="display:none;">

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

                    </div>

                    <input type="hidden" name="assinatura-responsavel"  class="campo" value="<?php echo $id_usuario; ?>">

                    <input type="hidden" name="assinatura-forma_pagamento"  class="campo" value="1">

                    <input type="hidden" class="campo" name="assinatura-vidas_max" value="<?php echo $vidas_max; ?>">

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

                    <input name='assinatura-termo_adesao' class='validar campo'  type='hidden'value="1"/>

                    <input name='assinatura-autocontratacao' class='validar campo'  type='hidden' value="1"/>

                    <input class="validar campo" value="ok" type="hidden">
                    
                    <div class="form-group">
                    
                        <div class="col-sm-6">
                        
                            <label class="control-label">Nome</label>
                            
                            <input class="form-control validar input-sm campo" name="cliente-nome"  tipo="texto" type="text" value="<?php echo $nome;?>"> 
                        
                        </div>

                        <div class="col-sm-6">
                        
                            <label class="control-label">E-mail</label>
                            
                            <input class="form-control validar input-sm campo" name="cliente-email"  tipo="email" type="email" value="<?php echo $email;?>"> 
                        
                        </div>
                        
                    </div>
                    
                    <div class="form-group">

                        <div class="col-sm-6">
                        
                            <label class="control-label">CPF</label>
                            
                            <input class="form-control validar campo input-sm cpf" name="cliente-cpf" maxlength="14"  tipo="texto" type="text" value="<?php echo $cpf;?>"> 
                        
                        </div>
                    
                        <div class="col-sm-4">
                        
                            <label class="control-label">Telefone</label>
                            
                            <input class="form-control validar campo input-sm telefone" name="cliente-telefone"  tipo="texto" type="text" value="<?php echo $telefone;?>"> 

                            <input class="campo ddi" name="cliente-telefone_ddi" type="hidden" value="<?php echo $telefone_ddi;?>"> 
                        
                        </div>
                        
                    </div>

                </div>

                <div class="box-conteudo box-selecao-titular">

                    <div class="title-page">

                        <span>

                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-grid" viewBox="0 0 16 16">
                                <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z"/>
                            </svg>

                        </span> 
                        
                        Endereço de cobrança

                    </div>
                    
                    <div class="form-group">
                    
                        <div class="col-sm-3">
                        
                            <label class="control-label">CEP</label>
                            
                            <input class="form-control validar campo input-sm cep" name="cliente-cep"  tipo="texto" type="text" value="<?php echo $cep;?>"> 
                        
                        </div>

                        <div class="col-sm-7">
                        
                            <label class="control-label">Endereço</label>
                            
                            <input class="form-control validar input-sm campo" name="cliente-endereco"  tipo="texto" type="text" value="<?php echo $endereco;?>"> 
                        
                        </div>

                        <div class="col-sm-2">
                        
                            <label class="control-label">Número</label>
                            
                            <input class="form-control validar campo input-sm inteiro" name="cliente-numero"  tipo="texto" type="text" value="<?php echo $numero;?>" maxlength="10"> 
                        
                        </div>
                        
                    </div>

                    <div class="form-group">

                        <div class="col-sm-4">
                            
                            <label class="control-label">Bairro</label>
                            
                            <input class="form-control validar input-sm campo" name="cliente-bairro"  tipo="texto" type="text" value="<?php echo $bairro;?>"> 
                        
                        </div>

                        <div class="col-sm-5">
                        
                            <label class="control-label">Cidade</label>
                            
                            <input class="form-control validar input-sm campo" name="cliente-cidade"  tipo="texto" type="text" value="<?php echo $cidade;?>"> 
                        
                        </div>

                        <div class="col-sm-3">
                        
                            <label class="control-label">Estado</label>
                            
                            <select name="cliente-estado"  class="form-control validar input-sm campo">
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

                <div align="center">

                    <a href="javascript:void(0);" class="salvar finalizar-cadastro effect-transition-element">Salvar e inserir dados do pagamento</a>

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
                <aside class="lg:col-span-5 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 fade-in">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            <i class="fas fa-receipt text-primary mr-2"></i>
                            Resumo do Plano
                        </h3>
                        <div class="space-y-3 text-sm text-gray-600">
                            <div class="flex items-center justify-between">
                                <span>Plano selecionado</span>
                                <span class="font-medium text-gray-900">
                                    <?php echo $plano != "" ? $plano : "Selecione um plano"; ?>
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>Valor mensal</span>
                                <span class="font-medium text-gray-900">
                                    <?php echo $valor != "" ? $valor : "—"; ?>
                                </span>
                            </div>
                            <?php if($valor_adesao != ""){ ?>
                                <div class="flex items-center justify-between">
                                    <span>Taxa de adesão</span>
                                    <span class="font-medium text-gray-900"><?php echo $valor_adesao; ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 fade-in">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            <i class="fas fa-shield-halved text-secondary mr-2"></i>
                            Garantias e Segurança
                        </h3>
                        <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                            <div class="flex items-center space-x-2 trust-badge">
                                <i class="fas fa-lock text-secondary"></i>
                                <span>Dados criptografados</span>
                            </div>
                            <div class="flex items-center space-x-2 trust-badge">
                                <i class="fas fa-credit-card text-secondary"></i>
                                <span>Pagamentos seguros</span>
                            </div>
                            <div class="flex items-center space-x-2 trust-badge">
                                <i class="fas fa-headset text-secondary"></i>
                                <span>Suporte dedicado</span>
                            </div>
                            <div class="flex items-center space-x-2 trust-badge">
                                <i class="fas fa-thumbs-up text-secondary"></i>
                                <span>Compra confiável</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 fade-in product-highlight">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            <i class="fas fa-star text-accent mr-2"></i>
                            Benefícios inclusos
                        </h3>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-center">
                                <i class="fas fa-check text-secondary mr-2"></i>
                                Assistência completa para sua família
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-secondary mr-2"></i>
                                Rede de atendimento nacional
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-secondary mr-2"></i>
                                Ativação rápida e sem burocracia
                            </li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </main>
</div>

<script>
    (function () {
        var countdown = document.getElementById('countdown');
        if (!countdown) {
            return;
        }
        var totalSeconds = 14 * 60 + 59;
        var interval = setInterval(function () {
            if (totalSeconds <= 0) {
                clearInterval(interval);
                return;
            }
            totalSeconds -= 1;
            var minutes = String(Math.floor(totalSeconds / 60)).padStart(2, '0');
            var seconds = String(totalSeconds % 60).padStart(2, '0');
            countdown.textContent = minutes + ':' + seconds;
        }, 1000);
    })();
</script>

</body>
</html>
