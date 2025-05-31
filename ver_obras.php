<?php
$archivoObras = 'datos/obras.json';
$archivoPersonajes = 'datos/personajes.json';

$obras = file_exists($archivoObras) ? json_decode(file_get_contents($archivoObras), true) : [];
$personajes = file_exists($archivoPersonajes) ? json_decode(file_get_contents($archivoPersonajes), true) : [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Obras</title>
    <link rel="stylesheet" href="assets/css/styles.css?<?php echo time();?>">
</head>
<body>
<?php include_once 'datos/menu.php' ?>
<div class="main">
    <h2>📋 Obras Registradas</h2>
    <div class="grid">
        <?php foreach ($obras as $obra): ?>
            <?php
                $cantidad = 0;
                foreach ($personajes as $p) {
                    if ($p['obra_codigo'] === $obra['codigo']) {
                        $cantidad++;
                    }
                }
            ?>
            <div class="card">
                <img src="<?= htmlspecialchars($obra['foto_url']) ?>" alt="Imagen de <?= htmlspecialchars($obra['nombre']) ?>" draggable="false">
                <div class="card-body">
                    <h3><?= htmlspecialchars($obra['nombre']) ?></h3>
                    <p><strong>Tipo:</strong> <?= $obra['tipo'] ?></p>
                    <p><strong>País:</strong> <?= $obra['pais'] ?></p>
                    <p><strong>Personajes:</strong> <?= $cantidad ?></p>
                    <a class="button" href="detalle.php?codigo=<?= urlencode($obra['codigo']) ?>">Detalle</a>
                    <a class="button" href="imprimir_obra.php?codigo=<?= urlencode($obra['codigo']) ?>" target="_blank">Imprimir</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
