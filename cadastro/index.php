<?php
require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'var'.DIRECTORY_SEPARATOR.'global.php';
require_once CONNECT;
require_once CL_USER;
$USER = new Usuario();
?>
<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">
    <head>
	<meta charset='utf-8'>
	<script src='/js/cadastro.js'></script>
	<title>Registrando Usuário</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
	<header class="container-fluid p-3 bg-secondary text-center">
	    <h1 class="display-1">Mihgara</h1>
	    <h2>Registrando Usuários</h2>
	</header>
	<section class='container p-5 mx-auto'>
	    <div class="row">
		<div class="col-xl-6 col-sm-12 mx-auto">
		    <form method="POST" class="was-validated" enctype="multipart/form-data">
			<h2>Dados Pessoais</h2>
			<div class="mb-3">
			    <label class="form-label" for="foto-perfil">Foto de Perfil</label>
			    <input type="file" class="form-control-file" id="foto-perfil" name="foto-perfil">
			</div>
			<div class="mb-3">
			    <label class="form-label" for="nome">Nome Completo</label>
			    <input type="text" class="form-control" id="nome" name="nome" placeholder="Fulano Cicrano Deltrano da Silva" maxlength="50" required autocomplete="off">
			</div>
			<div class="mb-3">
			    <label class="form-label" for="email">Email</label>
			    <input type="email" class="form-control" id="email" name="email" placeholder="meuemail@dominio" maxlength="50" required autocomplete="off">
			</div>
			<div class="input-group mb-3">
			    <button type="button" class="btn btn-primary dropdown-toggle" id="cpf-cnpj" data-bs-toggle="dropdown">CPF</button>
			    <ul class="dropdown-menu">
				<li class="dropdown-item cpf-cnpj">CPF</li>
				<li class="dropdown-item cpf-cnpj">CNPJ</li>
			    </ul>
			    <input type="text" class="form-control" id="cpf-cnpj" name="cpf-cnpj" placeholder="Insira seu CPF" maxlength="14" required autocomplete="off">
			</div>
			<div class="mb-3">
			    <label class="form-label" for="genero">Gênero</label>
			    <select class="form-control" id="genero" required>
				<option value="homem-cisgenero">Homem Cisgênero</option>
				<option value="mulher-cisgenero">Mulher Cisgênero</option>
				<option value="homem-transgenero">Homem Trangênero</option>
				<option value="mulher-transgenero">Mulher Trangênero</option>
				<option value="nao-binarie">Não Binárie</option>
			    </select>
			</div>
			<h2>Dados de Acesso</h2>
			<div class="mb-3">
			    <label class="form-label" for="usuario">Usuario</label>
			    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="user.name" maxlength="20" required autocomplete="off">
			</div>
			<div class="mb-3 has-validation">
			    <label class="form-label" for="senha">Senha</label>
			    <input type="password" class="form-control is-invalid" id="senha" name="senha" placeholder="Insira sua senha" required autocomplete="off">
			</div>
			<div class="mb-3 has-validation">
			    <label class="form-label" for="repetir-senha">Repetir Senha</label>
			    <input type="password" class="form-control is-invalid" id="repetir-senha" name="repetir-senha" placeholder="Insira sua senha novamente" required autocomplete="off">
			    <div id="mensagem" class="invalid-feedback">Senhas não coindicem</div>
			</div>
			<h2>Endereço</h2>
			<div class="mb-3 has-validation">
			    <label for="cep" class="form-label">CEP</label>
			    <input type="text" class="form-control is-invalid" id="cep" aria-describedby="CEP" name="cep" maxlength="8" placeholder="00000000" required autocomplete="off">
			    <div id="mensagem-cep" class="invalid-feedback">Preencha o CEP corretamente</div>
			</div>
			<div class="mb-3 has-validation">
			    <label for="numero" class="form-label">Numero</label>
			    <input type="text" class="form-control is-invalid" id="numero" name="numero" manlength="10" placeholder="25" required autocomplete="off">
			    <div id="mensagem-numero" class="invalid-feedback">Preencha apenas com números!</div>
			</div>
			<div class="mb-3">
			    <label for="rua" class="form-label">Rua</label>
			    <input type="text" class="form-control" id="rua" name="rua" readonly required>
			</div>
			<div class="mb-3">
			    <label for="bairro" class="form-label">Bairro</label>
			    <input type="text" class="form-control" id="bairro" name="bairro" readonly required>
			</div>
			<div class="mb-3">
			    <label class="form-label" for="cidade">Cidade</label>
			    <input class="form-control" type='text' name='cidade' id='cidade' readonly required>
			</div>
			<div class="mb-3">
			    <label class="form-label" for="estado">Estado</label>
			    <input class="form-control" type='text' name='estado' id='estado' readonly required>
			</div>
			<h2 id="contato">Contato</h2>
			<div class="mb-3">
			    <button type="button" id="residencial" class="btn btn-primary telefone w-100">Adicionar Telefone Residencial</button>
			</div>
			<div class="mb-3">
			    <button type="button" id="comercial" class="btn btn-secondary telefone w-100">Adicionar Telefone Comercial</button>
			</div>
			<div class="mb-3">
			    <button type="button" id="celular" class="btn btn-success telefone w-100">Adicionar Telefone Celular</button>
			</div>
			<button type="submit" class="btn btn-light" value="Registrar" name="registrar"  id="registrar">Registrar</button>
		    </form>
		</div>
	    </div>
	</section>
    </body>
</html>
<?php
if (isset($_FILES['foto-perfil']) && !empty($_FILES['foto-perfil'])) {
    $foto = $_FILES['foto-perfil'];
} else {
    $foto = null;
}
if (isset($_POST['registrar'])) {
    $REG_NOME = addslashes($_POST['nome']);
    $REG_EMAIL = addslashes($_POST['email']);
    $REG_CPF_CNPJ = addslashes($_POST['cpf-cnpj']);
    $REG_CPF_CNPJ = preg_replace('/(\.){0,}(\-){0,}(\/){0,}/i', "", $REG_CPF_CNPJ);
    $REG_GENERO = addslashes($_POST['genero']);
    $REG_USER = addslashes($_POST['usuario']);
    $REG_SENHA = addslashes($_POST['senha']);
    $REG_CEP = addslashes($_POST['cep']);
    $REG_NUMERO = addslashes($_POST['numero']);
    $REG_RUA = addslashes($_POST['rua']);
    $REG_BAIRRO = addslashes($_POST['bairro']);
    $REG_CIDADE = addslashes($_POST['cidade']);
    $REG_ESTADO = addslashes($_POST['estado']);
    if (isset($_POST['residencial'])) {
	foreach($_POST['residencial'] as $KEY=>$VALUE) {
	    $REG_RESIDENCIAL[$KEY] = addslashes($VALUE);
	}
    } else {
	$REG_RESIDENCIAL = array();
    }
    if (isset($_POST['comercial'])) {
	foreach($_POST['comercial'] as $KEY=>$VALUE) {
	    $REG_COMERCIAL[$KEY] = addslashes($VALUE);
	}
    } else {
	$REG_COMERCIAL = array();
    }
    if (isset($_POST['celular'])) {
	foreach($_POST['celular'] as $KEY=>$VALUE) {
	    $REG_CELULAR[$KEY] = addslashes($VALUE);
	}
    } else {
	$REG_CELULAR = array();
    }
    
    // header('location: /login');
    }
?>
