<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">
    <head>
	<meta charset='utf-8'>
	<script src='./cep.js'></script>
	<title>Registrando Usuário</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
	<header class="container-fluid p-5 bg-secondary text-center">
	    <h1>Registrando Usuários</h1>
	</header>
	<section class='container p-5 mx-auto'>
	    <div class="row">
		<div class="col-xl-6 col-sm-12 mx-auto">
		    <form method="POST">
			<h2>Dados Pessoais</h2>
			<div class="mb-3">
			    <label class="form-label" for="foto-perfil">Foto de Perfil</label>
			    <input type="file" class="form-control-file" id="foto-perfil" name="foto-perfil" required>
			</div>
			<div class="mb-3">
			    <label class="form-label" for="nome">Nome Completo</label>
			    <input type="text" class="form-control" id="nome" name="nome" placeholder="Fulano Cicrano Deltrano da Silva" maxlength="50" required>
			</div>
			<div class="mb-3">
			    <label class="form-label" for="email">Email</label>
			    <input type="email" class="form-control" id="email" name="email" placeholder="meuemail@dominio" maxlength="50" required>
			</div>
			<div class="input-group mb-3">
			    <button type="button" class="btn btn-primary dropdown-toggle" id="cpf-cnpj" data-bs-toggle="dropdown">CPF</button>
			    <ul class="dropdown-menu">
				<li class="dropdown-item cpf-cnpj">CPF</li>
				<li class="dropdown-item cpf-cnpj">CNPJ</li>
			    </ul>
			    <input type="text" class="form-control" id="cpf-cnpj" name="cpf-cnpj" placeholder="Insira seu CPF" maxlength="14" required>
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
			    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="user.name" maxlength="20" required>
			</div>
			<div class="mb-3">
			    <label class="form-label" for="senha">Senha</label>
			    <input type="password" class="form-control" id="senha" name="senha" placeholder="Insira sua senha">
			</div>
			<div class="mb-3">
			    <label class="form-label" for="repetir-senha">Repetir Senha</label>
			    <input type="password" class="form-control" id="repetir-senha" name="repetir-senha" placeholder="Insira sua senha novamente">
			</div>
			<h2>Endereço</h2>
			<div class="mb-3">
			    <label for="cep" class="form-label">CEP</label>
			    <input type="text" class="form-control" id="cep" aria-describedby="CEP" name="cep" maxlength="8" placeholder="00000000">
			</div>
			<div class="mb-3">
			    <label for="numero" class="form-label">Numero</label>
			    <input type="text" class="form-control" id="numero" name="numero" manlength="10" placeholder="25" required>
			</div>
			<div class="mb-3">
			    <label for="rua" class="form-label">Rua</label>
			    <input type="text" class="form-control" id="rua" name="rua" disabled>
			</div>
			<div class="mb-3">
			    <label for="bairro" class="form-label">Bairro</label>
			    <input type="text" class="form-control" id="bairro" name="bairro" disabled>
			</div>
			<div class="mb-3">
			    <label class="form-label" for="cidade">Cidade</label>
			    <input class="form-control" type='text' name='cidade' disabled id='cidade'>
			</div>
			<div class="mb-3">
			    <label class="form-label" for="estado">Estado</label>
			    <input class="form-control" type='text' name='estado' disabled id='estado'>
			</div>
			<h2 id="contato">Contato</h2>
			<div class="mb-3">
			    <button type="button" id="residencial" class="btn btn-primary">Adicionar Telefone Residencial</button>
			</div>
			<div class="mb-3">
			    <button type="button" id="comercial" class="btn btn-secondary">Adicionar Telefone Comercial</button>
			</div>
			<div class="mb-3">
			    <button type="button" id="celular" class="btn btn-success">Adicionar Telefone Celular</button>
			</div>
			<button type="submit" class="btn btn-light" value="Registrar" name="registrar">Registrar</button>
		    </form>
		</div>
	    </div>
	</section>
    </body>
</html>
