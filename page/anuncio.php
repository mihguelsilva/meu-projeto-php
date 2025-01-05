<?php
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'global.php';
require_once CONNECT;
if (isset($_SESSION['LOGIN']) && isset($_SESSION['NAME'])) {
	$ARRAY = explode(' ', $_SESSION['NAME']);
	$PRIMEIRO = explode(' ', $_SESSION['NAME'])[0];
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
if (!empty($_GET['id'])) $_GET['id'] = addslashes($_GET['id']);
require_once CL_USER;
require_once CL_ANNOUNCEMENT;
require_once CL_CATEGORY;
$ANUNCIO = new Anuncio();
$COMMENT = new Comentario();
$COMENTARIOS = $COMMENT->consultarComentarios($_GET['id']);
$VER_ANUNCIO = $ANUNCIO->VerAnuncio($_GET['id']);
$ANUNCIO_FOTOS = $ANUNCIO->consultarFotos('FK_PHOTOS_ANNOUNCEMENT_ID', $_GET['id']);
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
				<kbd>Anúncio criado em <?php echo $VER_ANUNCIO['ANNOUNCEMENT_DATE'] ?></kbd>
			</div>
			<div class="col-xl-8 col-sm-12 mx-auto mt-5">
				<h3 class="mb-5">Dados do Produto</h3>
				<div class="container mb-5 ">
					<?php
					if (count($ANUNCIO_FOTOS) > 0) {
						foreach ($ANUNCIO_FOTOS as $ft) {
							if ($ft['FK_PHOTOS_COMMENT_ID'] == NULL) {
								$ANUNCIO_FOTO = '/img/ads/' . $_GET['id'] . '/' . $ft['URL'];
					?>

								<img src="<?php echo $ANUNCIO_FOTO ?>" class="img-thumbnail" alt="Cinque Terre" width="200px">
						<?php
							}
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
						<td class="col"><?php echo $VER_ANUNCIO['TITLE']; ?></td>
					</tr>
					<tr>
						<th class="col">Estado do produto</th>
						<td class="col"><?php echo $VER_ANUNCIO['STATUS'] ?></td>

					</tr>
					<tr>
						<th class="col">Descrição</th>
						<td class="col"><?php echo $VER_ANUNCIO['DESCRIPTION']; ?></td>
					</tr>
					<tr>
						<th class="col">Quantidade</th>
						<td class="col"><?php echo $VER_ANUNCIO['QUANTITY'] ?>
							<?php
							if ($VER_ANUNCIO['QUANTITY'] == NULL || $VER_ANUNCIO['QUANTITY'] == 0) {
								echo '<span class="bagde rounded-pill p-1 fw-bolder g-danger" style="font-size:12pt;">Sem estoque</span>';
							} else {
								echo '<span class="bagde rounded-pill p-1 fw-bolder bg-success" style="font-size:12pt;">Em estoque</span>';
							}
							?>
						</td>
					</tr>
					<tr>
						<th class="col">Valor do Produto</th>
						<td class="col">R$ <?php echo number_format($VER_ANUNCIO['ANNOUNCEMENT_VALUE'], 2); ?></td>
					</tr>
					<tr>
						<th class="col">Ficha Técnica</th>
						<td class="col"><?php echo $VER_ANUNCIO['TECHNICAL_SHEET'] ?></td>
					</tr>
				</table>
			</div>
			<div class="col-xl-8 col-sm-12 mx-auto mt-5 overflow-auto">
				<h4 class="mb-5">Contato do Anunciante</h4>
				<table class="table table-dark">
					<tr>
						<th class="col">Nome</th>
						<td class="col"><?php echo $VER_ANUNCIO['NAME'] ?></td>
					</tr>
					<tr>
						<th class="col">Email</th>
						<td class="col"><?php echo $VER_ANUNCIO['EMAIL'] ?></td>
					</tr>
					<tr>
						<th class="col">Telefone</th>
						<?php
						if (count($VER_ANUNCIO['PHONE']) > 0) {
							echo '<td class="col">';
							for ($a = 0; $a < count($VER_ANUNCIO['PHONE']); $a++) {
								foreach ($VER_ANUNCIO['PHONE'][$a] as $chave => $telefone) {
									if ($telefone != NULL) {
										if ($chave == 'BUSINESS' || $chave == 'HOME') {
											echo '<div><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
  <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
</svg> ';
										} else {
											echo '<div><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-phone" viewBox="0 0 16 16">
  <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
  <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
</svg> ';
										}
										echo $telefone . '&nbsp;&nbsp;</div>';
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
				<form method="POST" class="was-validated" action="/ops/comentario.php" enctype="multipart/form-data">
					<input type="text" name="id" value="<?php echo $_GET['id']; ?>" readonly style="display:none;">
					<div class="form-group">
						<label for="comment">Deixe seu Comentário</label>
						<textarea class="form-control mt-3" id="comment" name="ctt" rows="3" minlength="20" required></textarea>
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
						<input class="form-control" type="file" name="fotos-comentario[]" multiple>
						<button class="btn btn-outline-light mt-3" type="submit" name="action" value="comment">Comentar</button>
					<?php
					}
					?>
				</form>
			</div>
			<?php /*
			echo '<pre>';
			print_r($COMENTARIOS);
			echo '</pre>';*/
			foreach ($COMENTARIOS as $COMENTARIO) {
			?>
				<div class="col-xl-8 col-sm-4 mx-auto mb-3 border text-break" style="padding: 20px;">
					<span class="fs-6 fw-bold"><?php echo $COMENTARIO['USERNAME'] ?></span> &nbsp;<span class="badge bg-secondary text-wrap" style="font-size:10pt;">2025-01-02</span> <br>
					<?php
						foreach($ANUNCIO_FOTOS as $FOTO) {
							if ($FOTO['FK_PHOTOS_COMMENT_ID'] == $COMENTARIO['ID_COMMENT']) {
								$FOTO_COMENTARIO = '/img/comment/'.$COMENTARIO['ID_COMMENT'].'/'.$FOTO['URL'];
								?>
								<img src="<?php echo $FOTO_COMENTARIO; ?>" class="img_fluid img-thumbnail">
								<?php
							}
						}
					?>
					<p style="font-size:14pt;"><?php echo $COMENTARIO['CONTENT']?></p>
					<div class="btn-group">
						<?php
						if (isset($_SESSION['LOGIN'])) {
						if (
							$_SESSION['LOGIN'] == $COMENTARIO['FK_COMMENTS_USER_ID'] || 
							$SESSION['LOGIN'] == $VER_ANUNCIO['ID_USER']
							) {
						?>
						<a href="/opt/comentario.php" class="btn btn-sm btn-outline-light">Editar</a>
						<a href="/ops/comentario.php?action=deletar&id=<?php echo $COMENTARIO['ID_COMMENT'] ?>&an=<?php echo $_GET['id']; ?>" class="btn btn-sm btn-outline-danger">Deletar</a>
						<?php } } ?>
					</div>
				</div>
			<?php
			}
			?>
		</div>
	</section>
</body>

</html>