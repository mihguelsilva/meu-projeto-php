<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="comando[]" value="joao" readonly style="display:none;">
        <input type="text" name="comando[]" value="pedro" readonly style="display:none;">
        <input type="submit" name="action" value="vai">
    </form>
</body>
</html>
<?php
if (isset($_POST['action'])) {
    echo '<pre>'.print_r($_POST).'</pre>';
    echo '<pre>'.print_r($_POST['comando']).'</pre>';
}
?>