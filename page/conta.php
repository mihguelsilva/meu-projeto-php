<?php
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'global.php';
require_once CONNECT;
require_once CL_USER;
if (!isset($_SESSION['LOGIN']) && !isset($_SESSION['NAME']) && !isset($_SESSION['PHOTO'])) {
    header('location: /login');
}
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <header class="container-fluid p-3 bg-secondary text-center">
        <h1 class="display-1">Mihgara</h1>
        <h2>Registrando Usuários</h2>
    </header>
    <section class="container-fluid p-3 mt-3 mb-3">
        <div class="row">
            <div class="col-sm-12 col-xl-10 mx-auto">
                <div class="mt-3 overflow-auto">
                <h2 class="mb-3">Dados Pessoais</h2>
                    <table class="table table-dark table-striped">
                        <tr>
                        <th class="col">Foto de Perfil</th>
                        <?php
                        if ($dados['PHOTO'] == NULL) {
                            echo '<td class="col"><img class="img-fluid img-thumbnail" src="/img/no-image.jpg" width="120px"></td>' ;
                        } else {
                            echo '<td class="col"><img class="img-fluid img-thumbnail" src="/img/perfil/'.$dados['ID'].DIRECTORY_SEPARATOR.$dados['PHOTO'].'" width="120px"></td>';
                        }
                        ?>
                        </tr>
                        <tr>
                            <th class="col">Nome</th>
                            <td class="col"><?php echo $dados['NAME'];?></td>
                        </tr>
                        <tr>
                            <th class="col">Email</th>
                            <td class="col"><?php echo $dados['EMAIL']?></td>
                        </tr>
                    </table>
                </div>
                <div class="mt-5">
                <h2 class="mb-3">Dados de Acesso</h2>
                    <table class="table table-dark table-striped">
                        <tr>
                            <th class="col">Usuário</th>
                            <td class="col"><?php echo $dados['USERNAME']?></td>
                        </tr>
                        <tr>
                            <th class="col">Senha</th>
                            <td class="col"><?php echo"**************" ?></td>
                        </tr>
                    </table>
                </div>
                <div class="mt-5">
                <h2 class="mb-3">Endereço</h2>
                    <table class="table table-dark table-striped">
                        <tr>
                            <th class="col">Rua</th>
                            <td class="col"><?php echo $dados['STREET']?></td>
                        </tr>
                        <tr>
                            <th class="col">Número</th>
                            <td class="col"><?php echo $dados['NUMBER']?></td>
                        </tr>
                        <tr>
                            <th class="col">Bairro</th>
                            <td class="col"><?php echo $dados['NEIGHBORHOOD']?></td>
                        </tr>
                        <tr>
                            <th class="col">Cidade</th>
                            <td class="col"><?php echo $dados['CITY']?></td>
                        </tr>
                        <tr>
                            <th class="col">Estado</th>
                            <td class="col"><?php echo $dados['STATE']?></td>
                        </tr>
                        <tr>
                            <th class="col">CEP</th>
                            <td class="col"><?php echo $dados['ZIP_CODE']?></td>
                        </tr>
                    </table>
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
                        foreach($telefones[$a] as $chave => $telefone) {
                            if ($chave == 'ID_PHONE') $TEL_ID = $telefone;
                            if ($chave != 'FK_PHONE_USER_ID' && $chave != 'ID_PHONE') {
                                if ($telefone == NULL) {
                                    echo '<td class="col">Não definido</td>';
                                } else {
                                    echo '<td class="col pe-auto telefone">' . $telefone . ' <button class="btn btn-sm btn-outline-light"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
  <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
</svg></button> <a href="?id='.$TEL_ID.'&type='.$chave.'"><button type="button" class="btn btn-sm btn-outline-danger" aria-label="Close">X</button></a></td>';
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