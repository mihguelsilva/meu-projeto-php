<?php
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'global.php';
require_once CONNECT;
require_once CL_USER;
?>
<!DOCTYPE html>
<html lang='pt-br' data-bs-theme='dark'>
    <head>
	<meta charset='utf-8'>
	<title>Página Principal</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
	<header class="container-fluid bg-secondary p-3 text-center">
	    <div class="row">
		<div class="col">
		    <h1 class="display-1">Mihgara</h1>
		    <h2>Página Principal</h2>
		</div>
	    </div>
	</header>
	<nav class="navbar navbar-expand-sm navbar-dark bg-dark bg-gradient border text-white-50">
	    <div class="container-fluid">
		<a class="navbar-brand" href="javascript:void(0)">Logo</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
		    <span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="mynavbar">
		    <ul class="navbar-nav me-auto">
			<li class="nav-item">
			    <?php
			    if (isset($_SESSION['LOGIN']) && isset($_SESSION['NAME'])) {
				echo '<a class="nav-link" href="/page/criar-anuncio.php">Criar anúncio</a>';
			    } else {
				echo '<a class="nav-link" href="/login">Criar anúncio</a>';
			    }
			    ?>
			</li>
			<li class="nav-item">
			    <?php
			    if (isset($_SESSION['LOGIN']) && isset($_SESSION['NAME'])) {
				echo '<a class="nav-link" href="/page/conta.php">Minha conta</a>';
			    } else {
				echo '<a class="nav-link" href="/cadastro">Criar cadastro</a>';
			    }
			    ?>
			</li>
			<li class="nav-item">
			    <?php
			    if (isset($_SESSION['LOGIN']) && isset($_SESSION['NAME'])) {
				echo '<a class="nav-link" href="/page/meus-anuncios.php">Meus anúncios</a>';
			    } else {
				echo '<a class="nav-link" href="/login">Fazer login</a>';
			    }
			    ?>
			</li>
			<?php
			if (isset($_SESSION['LOGIN']) && isset($_SESSION['NAME'])) {
			?>
			    <li class="nav-item">
				<a class="nav-link" href="/logout">Logout</a>
			    </li>
			<?php
			}
			?>

		    </ul>
		    <form class="d-flex" method="GET">
			<input class="form-control me-1" type="text" placeholder="Pesquisar">
			<button class="btn btn-primary" type="button">Pesquisar</button>
		    </form>
		</div>
	    </div>
	</nav>
    </body>
</html>
