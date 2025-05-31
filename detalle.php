<?php
$archivoObras = 'datos/obras.json';
$archivoPersonajes = 'datos/personajes.json';

$codigo = $_GET['codigo'] ?? '';
$obras = file_exists($archivoObras) ? json_decode(file_get_contents($archivoObras), true) : [];
$personajes = file_exists($archivoPersonajes) ? json_decode(file_get_contents($archivoPersonajes), true) : [];

$obra = null;
foreach ($obras as $o) {
    if ($o['codigo'] === $codigo) {
        $obra = $o;
        break;
    }
}

if (!$obra) {
    echo "<p>❌ Obra no encontrada.</p>";
    exit;
}

$personajesRelacionados = array_filter($personajes, function ($p) use ($codigo) {
    return $p['obra_codigo'] === $codigo;
});
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Obra</title>
    <link rel="stylesheet" href="assets/css/styles.css?<?php echo time(); ?>">
</head>
<body>
<?php include_once 'datos/menu.php' ?>

<div class="main">
    <h2>📖 Detalle de Obra</h2>

    <div class="card detalle">
        <img src="<?= htmlspecialchars($obra['foto_url']) ?>" alt="Imagen de <?= htmlspecialchars($obra['nombre']) ?>" draggable="false">
        <div class="card-body">
            <h3><?= htmlspecialchars($obra['nombre']) ?></h3>
            <p><strong>Código:</strong> <?= htmlspecialchars($obra['codigo']) ?></p>
            <p><strong>Tipo:</strong> <?= htmlspecialchars($obra['tipo']) ?></p>
            <p><strong>País:</strong> <?= htmlspecialchars($obra['pais']) ?></p>
            <p><strong>Autor:</strong> <?= htmlspecialchars($obra['autor']) ?></p>
            <p><strong>Descripción:</strong><br><?= nl2br(htmlspecialchars($obra['descripcion'])) ?></p>
        </div>
    </div>
</br>
    <h3>🎭 Personajes de esta obra (<?= count($personajesRelacionados) ?>)</h3>

    <?php if (count($personajesRelacionados) === 0): ?>
        <p>No hay personajes registrados para esta obra.</p>
    <?php else: ?>
        <div class="grid personajes">
            <?php foreach ($personajesRelacionados as $p): ?>
                <div class="card personaje-card">
                    <img src="<?= htmlspecialchars($p['foto_url']) ?>" alt="Imagen de <?= htmlspecialchars($p['nombre']) ?>" draggable="false">
                    <div class="card-body">
                        <h4><?= htmlspecialchars($p['nombre']) . ' ' . htmlspecialchars($p['apellido']) ?></h4>
                        <p><strong>Cédula:</strong> <?= htmlspecialchars($p['cedula']) ?></p>
                        <p><strong>Fecha de Nacimiento:</strong> <?= htmlspecialchars($p['fecha_nacimiento']) ?></p>
                        <p><strong>Sexo:</strong> <?= htmlspecialchars($p['sexo']) ?></p>
                        <p><strong>Comida favorita:</strong> <?= htmlspecialchars($p['comida_favorita']) ?></p>
                        <p><strong>Habilidades:</strong><br><?= nl2br(htmlspecialchars($p['habilidades'])) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
