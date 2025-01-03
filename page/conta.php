<?php
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'global.php';
require_once CONNECT;
require_once CL_USER;
if (!isset($_SESSION['LOGIN']) && !isset($_SESSION['NAME'])) {
    header('location: /login');
    exit();
} else {
    $ARRAY = explode(' ', $_SESSION['NAME']);
    $PRIMEIRO = explode(' ',$_SESSION['NAME'])[0];
    $ULTIMO = end($ARRAY);
    $NOME = $PRIMEIRO . ' ' . $ULTIMO;
    if (!isset($_SESSION['PHOTO'])) {
	if ($_SESSION['GENDER'] == 'mulher-cisgenero' || $_SESSION['GENDER'] == 'mulher-transgenero') {
	    $FOTO = '/img/female-person.jpg';
	} else {
	    $FOTO = '/img/person.png';
	}
    } else {
	$FOTO = '/img/perfil/' . $_SESSION['LOGIN'] . '/' . $_SESSION['PHOTO'];
    }
}
$GENERO = ucfirst(explode('-', $_SESSION['GENDER'])[0]) . ' ' . ucfirst(explode('-', $_SESSION['GENDER'])[1]);
$USER = new Usuario();
$dados = $USER->ConsultarTudo($_SESSION['LOGIN']);
$telefones = $USER->ConsultarTodosTelefones($_SESSION['LOGIN']);
?>
<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">
    <head>
	<meta charset='utf-8'>
	<title>Minha Conta</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="/js/conta.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body>
	<header class="container-fluid p-3 bg-secondary text-center">
            <h1 class="display-1">Mihgara</h1>
            <h2>Minha conta</h2>
	</header>
	<nav class="navbar navbar-expand-sm navbar-dark bg-dark bg-gradient border">
	    <div class="container-fluid">
		<a class="navbar-brand" href="/">Logo</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
		    <span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="mynavbar">
		    <ul class="navbar-nav me-auto">
			<li class="nav-item dropdown">
			    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><img class="rounded-pill" alt="Avatar Logo" src="<?php echo $FOTO; ?>" width="40px" height="40px"> <?php echo $NOME; ?></a>
			    <ul class="dropdown-menu">
				<li><a class="dropdown-item" href="/page/criar-anuncio.php">Criar anúncio</a></li>
				<li><a class="dropdown-item" href="/page/meus-anuncios.php">Meus anúncios</a></li>
				<li><a class="dropdown-item" href="/page/conta.php">Minha conta</a></li>
				<li><a class="dropdown-item" href="/logout">Logout</a></li>
			    </ul>
			</li>
		    </ul>
		    <form class="d-flex" method="POST">
			<button class="btn btn-outline-secondary bg-gradient">Desativar Conta</button>
		    </form>
		</div>
	    </div>
	</nav>

	<section class="container-fluid p-3 mt-3 mb-3">
            <div class="row">
		<div class="col-sm-12 col-xl-10 mx-auto">
                    <div class="mt-3 overflow-auto">
			<h2 class="mb-3">Dados Pessoais</h2>
			<table class="table table-dark table-striped">
                            <tr>
				<th class="col">Foto de Perfil</th>
				<?php
				if ($dados['PHOTO'] == NULL) { ?>
                                    <td class="col"><img class="img-fluid img-thumbnail" src="/img/no-image.jpg" width="120px">
					<form method='POST' class='was-validated' enctype='multipart/form-data' action="/ops/usuario.php">
                                            <div class="input-group">
						<input type="file" class="form-control" id="perfil" aria-describedby="perfil" aria-label="Upload" name="perfil" required>
						<button class="btn btn-outline-secondary" type="submit" id="botao-perfil" name="action" value="botao-perfil">Button</button>
                                            </div>
					</form>
                                    </td>
				<?php
				} else {
                                    echo '<td class="col"><img class="img-fluid img-thumbnail" src="/img/perfil/' . $dados['ID'] . DIRECTORY_SEPARATOR . $dados['PHOTO'] . '" width="120px">
<div>
<a href="/ops/usuario.php?id='.$dados['ID'].'&ctt='.$dados['PHOTO'].'&fld=foto&action=deletar">
<button class="btn btn-outline-danger btn-sm" type="button" style="width:120px;" id="button-delete">Apagar</button>
</a></div></td>';
				}
				?>
                            </tr>
                            <tr>
				<th class="col">Nome</th>
				<td class="col"><?php echo $dados['NAME']; ?></td>
                            </tr>
			    <tr>
				<th class="col" id="td-cpf-cnpj"></th>
				<td class="col" id="cpf-cnpj"><?php echo $dados['SSN_EIN'];?></td>
			    </tr>
			    <tr>
				<th class="col">Gênero</th>
				<td class="col"><?php echo $GENERO; ?></td>
			    </tr>
                            <tr>
				<th class="col">Email</th>
				<td class="col"><?php echo $dados['EMAIL']; ?></td>
                            </tr>
			</table>
			<button class="btn btn-outline-light" data-bs-toggle="collapse" data-bs-target="#editarPessoais" aria-expanded="false" aria-controls="collapseExample">Editar</button>
			<div class="collapse" id="editarPessoais">
			    <div class="card card-body">
				<form method="POST" class="was-validated" action="/ops/usuario.php">
				    <div class="mb-3">
					<label class="form-label" for="nome">Nome</label>
					<input type="text" class="form-control" id="nome" name="nome" placeholder="Insira seu nome completo" autocomplete="off" required>
				    </div>
				    <div class="mb-3">
					<label class="form-label" for="email">Email</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="usuario@dominio" autocomplete="off" required>
				    </div>
				    <div class="input-group mb-3 mt-4">
					<button type="button" class="btn btn-primary dropdown-toggle" id="cpf-cnpj" data-bs-toggle="dropdown">CPF</button>
					<ul class="dropdown-menu">
					    <li class="dropdown-item cpf-cnpj">CPF</li>
					    <li class="dropdown-item cpf-cnpj">CNPJ</li>
					</ul>
					<input type="text" class="form-control" id="cpf-cnpj" name="cpf-cnpj" placeholder="Insira seu CPF" maxlength="14" required autocomplete="off">
				    </div>
				    <div class="mb-3">
					<label class="form-label" for="genero">Gênero</label>
					<select class="form-control" id="genero" name="genero" required>
					    <option value="homem-cisgenero">Homem Cisgênero</option>
					    <option value="mulher-cisgenero">Mulher Cisgênero</option>
					    <option value="homem-transgenero">Homem Trangênero</option>
					    <option value="mulher-transgenero">Mulher Trangênero</option>
					    <option value="nao-binarie">Não Binárie</option>
					</select>
				    </div>
				    <button class="btn btn-outline-primary" type="submit" id="alterar" name="action" value="pessoais">Alterar Dados Pessoais</button>
				</form>
			    </div>
			</div>
                    </div>
                    <div class="mt-5">
			<h2 class="mb-3">Dados de Acesso</h2>
			<table class="table table-dark table-striped">
                            <tr>
				<th class="col">Usuário</th>
				<td class="col"><?php echo $dados['USERNAME'] ?></td>
                            </tr>
                            <tr>
				<th class="col">Senha</th>
				<td class="col"><?php echo "**************" ?></td>
                            </tr>
			</table>
			<button class="btn btn-outline-light" data-bs-toggle="collapse" data-bs-target="#editarAcesso" aria-expanded="false" aria-controls="collapseExample">Editar</button>
			<div class="collapse" id="editarAcesso">
			    <div class="card card-body">
				<form method="POST" class="was-validated" action="/ops/usuario.php">
				    <div class="mb-3">
					<label class="form-label" for="usuario">Nome do Usuario</label>
					<input type="text" class="form-control" id="usuario" name="usuario" maxlength="20" placeholder="user.name" autocomplete="off" required>
				    </div>
				    <div class="mb-3 has-validation">
					<label class="form-label" for="senha">Senha</label>
					<input type="password" class="form-control is-invalid" id="senha" name="senha" placeholder="Insira sua senha" maxlength="30" autocomplete="off" required>

				    </div>
				    <div class="mb-3">
					<label class="form-label" for="repetir-senha">Repetir Senha</label>
					<input type="password" class="form-control is-invalid" id="repetir-senha" name="repetir-senha" placeholder="Repita sua senha" maxlength="30" autocomplete="off" required>
					<div class="invalid-feedback" id="mensagem">Senhas não coindicem</div>
				    </div>
				    <button class="btn btn-outline-primary" type="submit" name="action" value="acesso" id="alterar-acesso">Alterar Dados de Acesso</button>
				</form>
			    </div>
			</div>
                    </div>
                    <div class="mt-5">
			<h2 class="mb-3">Endereço</h2>
			<table class="table table-dark table-striped">
                            <tr>
				<th class="col">Rua</th>
				<td class="col"><?php echo $dados['STREET'] ?></td>
                            </tr>
                            <tr>
				<th class="col">Número</th>
				<td class="col"><?php echo $dados['NUMBER'] ?></td>
                            </tr>
                            <tr>
				<th class="col">Bairro</th>
				<td class="col"><?php echo $dados['NEIGHBORHOOD'] ?></td>
                            </tr>
                            <tr>
				<th class="col">Cidade</th>
				<td class="col"><?php echo $dados['CITY'] ?></td>
                            </tr>
                            <tr>
				<th class="col">Estado</th>
				<td class="col"><?php echo $dados['STATE'] ?></td>
                            </tr>
                            <tr>
				<th class="col">CEP</th>
				<td class="col"><?php echo $dados['ZIP_CODE'] ?></td>
                            </tr>
			</table>
			<button type="button" class="btn btn-outline-light" data-bs-toggle="collapse" data-bs-target="#editarEndereco" aria-expanded="false" aria-controls="collapseExample">Editar</button>
			<div class="collapse" id="editarEndereco">
			    <div class="card card-body">
				<form method="POST" action="/ops/usuario.php" class="was-validated">
				    <div class="mb-3 has-validation">
					<label class="form-label" for="cep">CEP</label>
					<input type="text" class="form-control is-invalid" id="cep" name="cep" maxlength="8" placeholder="00000000" autocomplete="off" required>
					<div class="invalid-feedback" id="mensagem-cep">Você precisa preencher os 8 números do CEP!</div>
					</div>
				    <div class="mb-3">
					<label class="form-label" for="numero">Numero</label>
					<input type="text" class="form-control" id="numero" name="numero" maxlength="10" placeholder="20" autocomplete="off" required>
				    </div>
				    <div class="mb-3">
					<label class="form-label" for="rua">Rua</label>
					<input type="text" class="form-control" id="rua" name="rua" readonly required>
				    </div>
				    <div class="mb-3">
					<label class="form-label" for="bairro">Bairro</label>
					<input type="text" class="form-control" id="bairro" name="bairro" readonly required>
				    </div>
				    <div class="mb-3">
					<label class="form-label" for="cidade">Cidade</label>
					<input type="text" class="form-control" id="cidade" name="cidade" readonly required>
				    </div>
				    <div class="mb-3">
					<label class="form-label" for="estado">Estado</label>
					<input type="text" class="form-control" id="estado" name="estado" readonly required>
				    </div>
				    <button class="btn btn-outline-primary" type="submit" id="alterar" name="action" value="endereco">Alterar Endereço</button>
				</form>
			    </div>
			</div>
                    </div>
                    <?php
                    if (count($telefones) > 0) {
			echo '<div class="mt-5 overflow-auto table-responsive">';
			echo '<h2 class="mt-3">Telefones</h2>';
			echo '<table class="table table-dark table-striped">';
			echo '<tr>';
			echo '<th class="col">Residencial</th><th class="col">Comercial</th><th class="col">Celular</th>';
			for ($a = 0; $a < count($telefones); $a++) {
                            echo '<tr>';
                            foreach ($telefones[$a] as $chave => $telefone) {
				if ($chave == 'ID_PHONE') $TEL_ID = $telefone;
				if ($chave != 'FK_PHONE_USER_ID' && $chave != 'ID_PHONE') {
                                    if ($telefone == NULL) {
					echo '<td class="col pe-auto telefone" id="'.$TEL_ID.'" name="'.$chave.'">Não definido <button class="btn btn-sm btn-outline-light alterar-telefone"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
  <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
</svg></button></td> ';
                                    } else {
					echo '<td class="col pe-auto telefone" " id="'.$TEL_ID.'" name="'.$chave.'">' . $telefone . ' <button class="btn btn-sm btn-outline-light alterar-telefone"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
  <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
</svg></button> <a href="/ops/usuario.php?id=' . $TEL_ID . '&type=' . $chave . '&action=deletar&fld=telefone"><button type="button" class="btn btn-sm btn-outline-danger" aria-label="Close">X</button></a></td>';
                                    }
				}
                            }
                            echo '</tr>';
			}
			echo '</tr>';
			echo '</table>';
			echo '</div>';
                    }
                    ?>
		</div>
            </div>
	</section>
    </body>

</html>
