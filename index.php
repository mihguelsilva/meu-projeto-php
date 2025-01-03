<?php
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'global.php';
require_once CONNECT;
require_once CL_ANNOUNCEMENT;
$ANUNCIO = new Anuncio();
$TODOS = $ANUNCIO->verTodosAnuncios();
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
}
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
		<a class="navbar-brand" href="/">Logo</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
		    <span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="mynavbar">
		    <ul class="navbar-nav me-auto">
			<li class="nav-item dropdown">
			    <?php
			    if (isset($_SESSION['LOGIN']) && isset($_SESSION['NAME'])) {
			    ?>
				<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><img class="rounded-pill" alt="Avatar Logo" src="<?php echo $FOTO; ?>" width="40px" width="40px"> <?php echo $NOME; ?></a>
				<ul class="dropdown-menu">
				    <li><a class="dropdown-item" href="/page/criar-anuncio.php">Criar anúncio</a></li>
				    <li><a class="dropdown-item" href="/page/meus-anuncios.php">Meus anúncios</a></li>
				    <li><a class="dropdown-item" href="/page/conta.php">Minha conta</a></li>
				    <li><a class="dropdown-item" href="/logout">Logout</a></li>
				</ul>
			</li>
			    <?php
			    } else {
			    ?>
				<li class="nav-item dropdown">
				    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Anúncios</a>
				    <ul class="dropdown-menu">
					<li><a class="dropdown-item" href="/login">Criar anúncio</a></li>
					<li><a class="dropdown-item" href="/cadastro">Criar cadastro</a></li>
					<li><a class="dropdown-item" href="/login">Fazer login</a></li>
				    </ul>
				</li>
			    <?php
			    }
			    ?>
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
	    <div class="row">
		<?php
		if (count($TODOS) > 0) {
		    foreach($TODOS as $t) {
			if ($t['QUANTITY'] == NULL) {
			    $QTD = 0;
			} else {
			    $QTD = $t['QUANTITY'];
			}
		?>
		<div class="col-xl-3 col-sm-12 mb-3">
		    <div class="card p-3">
			<h4 class="card-title"><?php echo $t['TITLE']; ?></h4>
			<?php
			if ($t['PHOTO'] != NULL) {
			    $AN_PHOTO = '/img/ads/'.$t['USER_ID'].'/'.$t['PHOTO'];
			?>
			    <img class="card-img-top" src="<?php echo $AN_PHOTO; ?>" alt="Card image" style="120px">
			<?php
			} else {
			?>
			    <img class="card-img-top" src="/img/no-image.jpg" alt="Card image" style="120px">
			<?php } ?>
			<div class="card-body">
			    <p class="card-text">
				<?php echo $QTD; ?> itens<br>
				R$ <?php echo number_format($t['ANNOUNCEMENT_VALUE'], 2) ?><br>
				<b><?php echo $t['STATE'].'/'.$t['CITY']; ?></b><br>
				<i><?php echo utf8_encode($t['CATEGORY']); ?></i>
			    </p>
			    <a href="/page/anuncio.php?id=<?php echo $t['ID_ANNOUNCEMENT']; ?>" class="btn btn-primary">Ver anúncio</a>
			</div>
		    </div>
		</div>
		<?php
		}
		}
		?>
	    </div>
	</section>
    </body>
</html>
