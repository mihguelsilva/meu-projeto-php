<?php
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'global.php';
require_once CONNECT;
require_once CL_CATEGORY;
$CAT = new Categoria();
$CATEGORIAS = $CAT->verTodasCategorias();
require_once CL_ANNOUNCEMENT;
if (isset($_SESSION['LOGIN']) && isset($_SESSION['NAME'])) {
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
} else {
    header('Location: /');
}
?>
<!DOCTYPE html>
<html lang='pt-br' data-bs-theme='dark'>
    <head>
	<meta charset='utf-8'>
	<title>Criar Anúncio</title>
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
		    <h2>Criar Anúncio</h2>
		</div>
	    </div>
	</header>
	<nav class="navbar navbar-expand-sm navbar-dark bg-dark bg-gradient border text-white-50">
	    <div class="container-fluid">
		<a class="navbar-brand" href="/">Logo</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
		    <span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="mynavbar">
		    <ul class="navbar-nav me-auto">
			<li class="nav-item dropdown">
			    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><img class="rounded-pill" alt="Avatar Logo" src="<?php echo $FOTO; ?>" width="40px" width="40px"> <?php echo $NOME; ?></a>
			    <ul class="dropdown-menu">
				<li><a class="dropdown-item" href="/page/criar-anuncio.php">Criar anúncio</a></li>
				<li><a class="dropdown-item" href="/page/meus-anuncios.php">Meus anúncios</a></li>
				<li><a class="dropdown-item" href="/page/conta.php">Minha conta</a></li>
				<li><a class="dropdown-item" href="/logout">Logout</a></li>
			    </ul>
			</li>
		    </ul>
		    <form class="d-flex" method="GET">
			<input class="form-control me-1" type="text" placeholder="Região" size="10">
			<input class="form-control me-1" type="text" placeholder="Pesquisar" size="10">
			<button class="btn btn-primary" type="button">Pesquisar</button>
		    </form>
		</div>
	    </div>
	</nav>
	<section class="container-fluid mb-5">
	    <div class="row">
		<div class="col-xl-6 col-xm-12 mx-auto">
		    <form method="POST" class="was-validated" action="/ops/anuncio.php" enctype="multipart/form-data">
			<div class="mt-5">
			    <label class="form-label" for="fotos">Imagens do anúncio</label>
			    <input class="form-control" type="file" name="fotos[]" id="fotos" multiple>
			</div>
			<div class="has-validation mt-3">
			    <label class="form-label" for="titulo">Título</label>
			    <input type="text" maxlength="30" class="form-control" name="titulo" id="titulo" placeholder="Insira um título breve e direto" required>
			    <div class="invalid-feedback">Insira seu título</div>
			</div>
			<div class="has-validation mt-3">
			    <label class="form-label" for="estado">Estado</label>
			    <select class="form-select" name="estado" id="estado" required aria-label="select example">
				<option value="NOVO">NOVO</option>
				<option value="SEMINOVO">SEMINOVO</option>
				<option value="USADO">USADO</option>
			    </select>
			</div>
			<div class="has-validation mt-3">
			    <label class="form-label" for="categoria">Categoria</label>
			    <select class="form-select" name="categoria" id="categoria" required aria-label="select example">
				<?php
				foreach($CATEGORIAS as $CATEGORIA) {
				?>
				    <option value="<?php echo $CATEGORIA['ID_CATEGORY']; ?>"><?php echo utf8_encode($CATEGORIA['NAME']) ?></option>
				<?php
				}
				?>
			    </select>
			</div>
			<div class="has-validation mt-3">
			    <label class="form-label" for="descricao">Descrição do Anúncio</label>
			    <textarea class="form-control" name="descricao" id="descricao" maxlength="2000" placeholder="Descreva o estado do produto, tempo de uso, se está apresentando algum defeito" required></textarea>
			    <div class="invalid-feedback">Escreva a descrição do seu anúncio</div>
			</div>
			<div class="has-validation mt-3">
			    <label class="form-label" for="valor">Valor do anúncio</label>
			    <input class="form-control" type="number" step="any" id="valor" name="valor" required placeholder="10.00 ou 25.50 ou 50,75">
			</div>
			<div class="has-validation mt-3 mb-3">
			    <label class="form-label" for="ficha-tecnica">Ficha Técnica</label>
			    <textarea class="form-control" id="ficha-tecnica" name="ficha-tecnica" maxlength="2000" placeholder="Marca: marca do produto, Ano: ano de fabricação ou ano que foi comprado, Cor: cor do produto..." required></textarea>
			    <div class="invalid-feedback">Preencha a ficha técnica</div>
			</div>
			<button class="btn btn-outline-light" type="submit" name="action" value="criar-anuncio">Criar Anúncio</button>
		    </form>
		</div>
	    </div>
	</section>
    </body>
</html>
