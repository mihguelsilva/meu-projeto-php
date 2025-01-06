<?php
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'global.php';
if (isset($_SESSION['LOGIN']) && isset($_SESSION['NAME']) && isset($_GET['id'])) {
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
} else {
    header('Location: /');
}
require_once CONNECT;
require_once CL_CATEGORY;
$CAT = new Categoria();
$CATEGORIAS = $CAT->verTodasCategorias();
require_once CL_ANNOUNCEMENT;
$ANUNCIOS = new Anuncio();
$ANUNCIO = $ANUNCIOS->consultarTabela(
    'ANNOUNCEMENTS',
    'ID_ANNOUNCEMENT',
    $_GET['id']
);
if ($ANUNCIO[0]['FK_ANNOUNCEMENT_USER_ID'] != $_SESSION['LOGIN']) {
    header('Location: /page/meus-anuncios.php');
}
$FOTOS_ANUNCIOS = $ANUNCIOS->consultarTabela(
    'PHOTOS',
    'FK_PHOTOS_ANNOUNCEMENT_ID',
    $_GET['id']
);
?>
<!DOCTYPE html>
<html lang='pt-br' data-bs-theme='dark'>

<head>
    <meta charset='utf-8'>
    <title>Editar Anúncio</title>
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
                <h2>Editar Anúncio</h2>
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
                <?php
                if (count($FOTOS_ANUNCIOS) > 0) {
                    foreach ($FOTOS_ANUNCIOS as $foto) {
                        if ($foto['FK_PHOTOS_COMMENT_ID'] == NULL) {
                ?>
                            <div class=mt-3>
                                <img class="img-fluid img-thumbnail" src="/img/ads/<?php echo $_GET['id'] . '/' . $foto['URL'] ?>" width="120px">
                                <a href="?action=deletar&fld=foto&id=<?php echo $_GET['id']; ?>&name=<?php echo $foto['URL'] ?>&img=<?php echo $foto['ID_IMAGES']; ?>">
                                    <button class="btn btn-outline-danger">Deletar</button>
                                </a>
                            </div>
                <?php
                        }
                    }
                }
                ?>
                <form method="POST" class="was-validated" action="/ops/anuncio.php" enctype="multipart/form-data">
                    <input type="text" name="id" value="<?php echo $_GET['id'] ?>" readonly style="display:none;">
                    <div class="mt-5 ">
                        <?php
                        if (count($FOTOS_ANUNCIOS) > 0) {
                            foreach ($FOTOS_ANUNCIOS as $foto) {
                                if ($foto['FK_PHOTOS_COMMENT_ID'] == NULL) {
                        ?>
                                    <input type='text' name='count[]' value='<?php echo $foto['ID_IMAGES']; ?>' readonly style='display:none;'>
                        <?php
                                }
                            }
                        }
                        ?>
                        <label class="form-label" for="fotos">Imagens do anúncio</label>
                        <input class="form-control is-invalid" type="file" name="fotos[]" id="fotos" multiple>
                        <div class="feedback-invalid">Você só pode carregar duas fotos</div>
                    </div>
                    <div class="has-validation mt-3">
                        <label class="form-label" for="titulo">Título</label>
                        <input type="text" maxlength="30" class="form-control" name="titulo" id="titulo" placeholder="Insira um título breve e direto" value="<?php echo $ANUNCIO[0]['TITLE'] ?>" required>
                        <div class="invalid-feedback">Insira seu título</div>
                    </div>
                    <div class="has-validation mt-3">
                        <label class="form-label" for="estado">Estado</label>
                        <select class="form-select" name="estado" id="estado" required aria-label="select example">
                            <?php
                            $STATUS = array("NOVO", "SEMINOVO", "USADO");
                            foreach ($STATUS as $ST) {
                                if ($ST == $ANUNCIO[0]['STATUS']) {
                                    echo '<option value="' . $ST . '" selected>' . $ST . '</option>';
                                } else {
                                    echo '<option value="' . $ST . '">' . $ST . '</option>';
                                }
                            }
                            ?>
                            <option value="NOVO">NOVO</option>
                            <option value="SEMINOVO">SEMINOVO</option>
                            <option value="USADO">USADO</option>
                        </select>
                    </div>
                    <div class="has-validation mt-3">
                        <label class="form-label" for="quantidade">Quantidade de Itens</label>
                        <input type="text" class="form-control" name="quantidade" id="quantidade" placeholder="10" value="<?php echo $ANUNCIO[0]['QUANTITY'] ?>" required>
                    </div>
                    <div class="has-validation mt-3">
                        <label class="form-label" for="categoria">Categoria</label>
                        <select class="form-select" name="categoria" id="categoria" required aria-label="select example">
                            <?php
                            foreach ($CATEGORIAS as $CATEGORIA) {
                                if ($CATEGORIA['ID_CATEGORY'] == $ANUNCIO[0]['FK_ANNOUNCEMENT_CATEGORY_ID']) {
                                    echo $CATEGORIA['ID_CATEGORY'];
                            ?>
                                    <option value="<?php echo $CATEGORIA['ID_CATEGORY']; ?>" selected><?php echo utf8_encode($CATEGORIA['NAME']) ?></option>
                                <?php
                                } else {
                                ?>
                                    <option value="<?php echo $CATEGORIA['ID_CATEGORY']; ?>"><?php echo utf8_encode($CATEGORIA['NAME']) ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="has-validation mt-3">
                        <label class="form-label" for="descricao">Descrição do Anúncio</label>
                        <textarea class="form-control" name="descricao" id="descricao" maxlength="2000" placeholder="Descreva o estado do produto, tempo de uso, se está apresentando algum defeito" required><?php echo $ANUNCIO[0]['DESCRIPTION'] ?></textarea>
                        <div class="invalid-feedback">Escreva a descrição do seu anúncio</div>
                    </div>
                    <div class="has-validation mt-3">
                        <label class="form-label" for="valor">Valor do anúncio</label>
                        <input class="form-control" type="number" step="any" id="valor" name="valor" required placeholder="10.00 ou 25.50 ou 50,75" value="<?php echo $ANUNCIO[0]['ANNOUNCEMENT_VALUE'] ?>">
                    </div>
                    <div class="has-validation mt-3 mb-3">
                        <label class="form-label" for="ficha-tecnica">Ficha Técnica</label>
                        <textarea class="form-control" id="ficha-tecnica" name="ficha-tecnica" maxlength="2000" placeholder="Marca: marca do produto, Ano: ano de fabricação ou ano que foi comprado, Cor: cor do produto..." required><?php echo $ANUNCIO[0]['TECHNICAL_SHEET'] ?></textarea>
                        <div class="invalid-feedback">Preencha a ficha técnica</div>
                    </div>
                    <button class="btn btn-outline-light" type="submit" name="action" value="editar-anuncio">Atualizar Anúncio</button>
                </form>
            </div>
        </div>
    </section>
</body>

</html>
<?php
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'deletar') {
        if ($_GET['fld'] == 'foto') {
            $ANUNCIOS->manipularFotos(
                $_GET['name'],
                DIR_ADS . $_GET['id'],
                'deletar'
            );
            $ANUNCIOS->deletarDado(
                'PHOTOS',
                'ID_IMAGES',
                $_GET['img']
            );
            echo '<script>window.location.href = "/alterar/anuncio.php?id=' . $_GET['id'] . '";</script>';
        }
    }
}
?>