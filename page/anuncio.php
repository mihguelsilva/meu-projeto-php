<?php
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'global.php';
require_once CONNECT;
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
} else if (!isset($_GET['id'])) {
    header('Location: /');
}
require_once CL_USER;
require_once CL_ANNOUNCEMENT;
require_once CL_CATEGORY;
$USER = new Usuario();
$ANN = new Anuncio();
$CAT = new Categoria();
if (!empty($_GET['id'])) $_GET['id'] = addslashes($_GET['id']);
$VER = $ANN->VerAnuncio($_GET['id']);
?>
<!DOCTYPE html>
<html lang='pt-br' data-bs-theme='dark'>
    <head>
	<meta charset='utf-8'>
	<title>Anúncio</title>
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
		    <h2>Anúncio</h2>
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
	<section class="container-fluid mb-3">
	    <div class="row mt-3">
		<div class="col-xl-8 col-sm-12 mx-auto mt-3">
		    <kbd>Anúncio criado em <?php echo $VER['ANNOUNCEMENT_DATE']?></kbd>
		</div>
		<div class="col-xl-8 col-sm-12 mx-auto mt-5">
		    <h3 class="mb-5">Dados do Produto</h3>
		    <div class="container mb-5 ">
			<?php
			if (count($VER['PHOTOS']) > 0) {
			    foreach($VER['PHOTOS'] as $ft) {
				$AN_IMG = '/img/ads/'.$VER['ID_USER'].'/'.$ft['URL'];
			?>

			    <img src="<?php echo $AN_IMG ?>" class="img-thumbnail" alt="Cinque Terre" width="200px">
			<?php
			}
			} else {
			?>
			    <img src="/img/no-image.jpg" class="img-thumbnail" alt="Cinque Terre" width="200px">
			<?php
			}
			?>
		    </div>
		    <table class="table table-dark overflow-auto">
			<tr>
			    <th class="col">Título</th>
			    <td class="col"><?php echo $VER['TITLE']; ?></td>
			</tr>
			<tr>
			    <th class="col">Estado do produto</th>
			    <td class="col"><?php echo $VER['STATUS'] ?></td>

			</tr>
			<tr>
			    <th class="col">Descrição</th>
			    <td class="col"><?php echo $VER['DESCRIPTION'];?></td>
			</tr>
			<tr>
			    <th class="col">Quantidade</th>
			    <td class="col"><?php echo $VER['QUANTITY'] ?></td>
			</tr>
			<tr>
			    <th class="col">Valor do Produto</th>
			    <td class="col">R$ <?php echo number_format($VER['ANNOUNCEMENT_VALUE'], 2); ?></td>
			</tr>
			<tr>
			    <th class="col">Ficha Técnica</th>
			    <td class="col"><?php echo $VER['TECHNICAL_SHEET'] ?></td>
			</tr>
		    </table>
		</div>
		<div class="col-xl-8 col-sm-12 mx-auto mt-5 overflow-auto">
		    <h4 class="mb-5">Contato do Anunciante</h4>
		    <table class="table table-dark">
			<tr>
			    <th class="col">Nome</th>
			    <td class="col"><?php echo $VER['NAME'] ?></td>
			</tr>
			<tr>
			    <th class="col">Email</th>
			    <td class="col"><?php echo $VER['EMAIL'] ?></td>
			</tr>
			<tr>
			    <th class="col">Telefone</th>
			    <?php
			    if (count($VER['PHONE']) > 0) {
				echo '<td class="col">';
				for($a = 0; $a < count($VER['PHONE']); $a++) {
				    foreach($VER['PHONE'][$a] as $telefone) {
					if ($telefone != NULL) {
					    echo $telefone . '&nbsp;&nbsp;';
					}
				    }
				}
				echo '</td>';
			    } else {
				echo '<td class="col">Sem contato por telefone</td>';
			    }
			    ?>
			</tr>
		    </table>
		</div>
		<div class="col-xl-8 mx-auto mb-5">
		    <form method="POST" class="was-validated" action="/ops/comentario.php">
			<div class="form-group">
			    <label for="comment">Deixe seu Comentário</label>
			    <textarea class="form-control mt-3" id="comment" rows="3" minlength="20" required></textarea>
			</div>
			<?php
			if (!isset($_SESSION['NAME']) && !isset($_SESSION['LOGIN'])) {
			?>
			    <button type="button" class="btn btn-outline-light mt-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
				Comentar
			    </button>
			    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
				<div class="modal-dialog">
				    <div class="modal-content">
					<div class="modal-header">
					    <h5 class="modal-title" id="staticBackdropLabel">Faça Login!</h5>
					    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
					    Você ter uma conta e estar logado para deixar seu comentário.
					</div>
					<div class="modal-footer">
					    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					</div>
				    </div>
				</div>
			    </div>
			<?php
			} else {
			?>
			    <button class="btn btn-outline-light mt-3" type="submit" name="action" value="comment">Comentar</button>
			<?php
			}
			?>
		    </form>
		</div>
		<div class="col-xl-8 col-sm-4 mx-auto mb-3 border text-break" style="padding: 20px;">
		    <span class="fs-6 fw-bold">nome.usuario</span> &nbsp;<span class="badge bg-secondary text-wrap" style="font-size:10pt;">2025-01-02</span> <br>
		    <p style="font-size:14pt;">asdfasdf</p>
		    <div class="btn-group">
			<a href="/opt/comentario.php" class="btn btn-sm btn-outline-light">Editar</a>
			<a href="/ops/comentario.php" class="btn btn-sm btn-outline-danger">Deletar</a>
		    </div>
		</div>
	    </div>
	</section>
    </body>
</html>
