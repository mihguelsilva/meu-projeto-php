<?php
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'global.php';
require_once CONNECT;
require_once CL_CATEGORY;
require_once CL_ANNOUNCEMENT;
$CATEGORY = new Categoria();
$ANUNCIO = new Anuncio();
$ANUNCIOS = $ANUNCIO->meusAnuncios($_SESSION['LOGIN']);
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
	<title>Meus Anúncios</title>
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
		    <h2>Meus Anúncios</h2>
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
	<section class="container-fluid mt-3">
	    <?php
	    if (count($ANUNCIOS) > 0) {
		foreach($ANUNCIOS as $AN) {
	    ?>
		<div class="row border mb-3">
		    <div class="col-xl-2 col-sm-12">
			<?php
			if ($AN['PHOTO'] != NULL) {
			    $IMG = '/img/ads/'.$AN['ID_ANNOUNCEMENT'].'/'.$AN['PHOTO'];
			?>
			    <img src="<?php echo $IMG; ?>" class="img-fluid img-thumbnail card-img-top" width="120px">
			<?php
			} else {
			    echo '<img src="/img/no-image.jpg" class="img-fluid img-thumbnail" width="120px">';
			}
			?>
		    </div>
		    <div class="col-xl-2 col-sm-12">
			<h4 class="">Título</h4>
			<p><?php echo $AN['TITLE']; ?></p>
		    </div>
		    <div class="col-xl-1 col-sm-12">
			<h4>Itens</h4>
			<p><?php echo utf8_encode($AN['QUANTITY']); ?></p>
		    </div>
		    <div class="col-xl-2 col-xm-12">
			<h4>Preço</h4>
			<p>R$ <?php echo number_format($AN['ANNOUNCEMENT_VALUE'], 2); ?></p>
		    </div>
		    <div class="col-xl-2 col-xm-12">
			<h4>Categoria</h4>
			<p><?php echo utf8_encode($AN['CATEGORY']); ?>
		    </div>
		    <div class="col-xl-2 col-xm-12 mt-4 mb-3 mx-auto">
			<div class="btn-group">
			    <a href="/page/anuncio.php?id=<?php echo $AN['ID_ANNOUNCEMENT']; ?>" class="btn btn-sm btn-outline-light" aria-current="page">Ver</a>
			    <a href="/alterar/anuncio.php?id=<?php echo $AN['ID_ANNOUNCEMENT'] ?>" class="btn btn-sm btn-outline-warning">Editar</a>
			    <a href="/ops/anuncio.php?id=<?php echo $AN['ID_ANNOUNCEMENT']; ?>&fld=anuncio&action=deletar" class="btn btn-sm btn-outline-danger">Deletar</a>
			</div>
		    </div>
		</div>
	    <?php
	    }
	    }
	    ?>
	</section>
    </body>
</html>
