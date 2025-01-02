<?php
require_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'var'.DIRECTORY_SEPARATOR.'global.php';
require_once CONNECT;
require_once CL_USER;
if (isset($_SESSION['LOGIN']) && isset($_SESSION['NAME']) && isset($_SESSION['PHOTO'])) {
    header('Location: /');
}
$USER = new Usuario();
?>
<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">
    <head>
	<meta charset='utf-8'>
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
	<header class="container-fluid p-2 bg-secondary text-center">
	    <h1 class="display-1">Mihgara</h1>
	    <h2>Acesso</h2>
	</header>
	<section class="container mt-3 mb-3">
	    <div class="row">
		<div class="col-sm-12 col-xl-6 border border-light mx-auto p-5">
		    <form method="POST" class="was-validated">
			<h2>Login</h2>
			<div class="mb-3 mt-3">
			    <label class="form-label" for="user">Usuário</label>
			    <input type="text" class="form-control" id="user" name="usuario" placeholder="user.name" required>
			</div>
			<div class="mb-3 mt-3">
			    <label class="form-label" for="senha">Senha</label>
			    <input type="password" class="form-control" id="senha" name="senha" placeholder="Insira sua senha aqui" required>
			</div>
			<p><a href="/alterar/senha.php" class="link-danger link-offset-2 link-underline-opacity-25 link-underline-opacity-100-">Esqueci minha senha</a></p>
			<p><a href="/cadastro" class="link-success link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Criar minha conta</a></p>
			<button type="submit" class="btn btn-light" value="Login" name="login">Login</button>
		    </form>
		</div>
	    </div>
	</section>
    </body>
</html>
<?php
if(isset($_POST['login'])) {
    $LOGIN_USER = addslashes($_POST['usuario']);
    $LOGIN_PASS = addslashes($_POST['senha']);
    if ($USER->login($LOGIN_USER, $LOGIN_PASS)) {
		echo '<script>window.location.href = \'/\';</script>';
	} else {
		echo '<script>
			Swal.fire({
  			icon: "error",
  			title: "Login inválido",
  			text: "As credenciais fornecidas são inválidas!",
  			footer: \'<a href="/cadastro">Deseja cadastrar sua conta?</a>\'
		});
		</script>';
	}
}
?>
