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
    <title>Imprimir Obra - <?= htmlspecialchars($obra['nombre']) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: white;
            color: black;
        }

        h2, h3 {
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        .obra {
            margin-bottom: 30px;
        }

        .obra img {
            max-width: 250px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
        }

        .personaje {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
        }

        .personaje img {
            max-width: 150px;
            float: left;
            margin-right: 15px;
            border: 1px solid #aaa;
        }

        .clear {
            clear: both;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="no-print">
    <button onclick="window.print()">🖨️ Imprimir</button>
</div>

<h2>📖 Detalle de la Obra</h2>
<div class="obra">
    <img src="<?= htmlspecialchars($obra['foto_url']) ?>" alt="Imagen de <?= htmlspecialchars($obra['nombre']) ?>">
    <p><strong>Nombre:</strong> <?= htmlspecialchars($obra['nombre']) ?></p>
    <p><strong>Código:</strong> <?= htmlspecialchars($obra['codigo']) ?></p>
    <p><strong>Tipo:</strong> <?= htmlspecialchars($obra['tipo']) ?></p>
    <p><strong>País:</strong> <?= htmlspecialchars($obra['pais']) ?></p>
    <p><strong>Autor:</strong> <?= htmlspecialchars($obra['autor']) ?></p>
    <p><strong>Descripción:</strong><br><?= nl2br(htmlspecialchars($obra['descripcion'])) ?></p>
</div>

<h3>🎭 Personajes (<?= count($personajesRelacionados) ?>)</h3>

<?php if (empty($personajesRelacionados)): ?>
    <p>No hay personajes registrados para esta obra.</p>
<?php else: ?>
    <?php foreach ($personajesRelacionados as $p): ?>
        <div class="personaje">
            <img src="<?= htmlspecialchars($p['foto_url']) ?>" alt="Imagen de <?= htmlspecialchars($p['nombre']) ?>">
            <p><strong>Nombre:</strong> <?= htmlspecialchars($p['nombre']) . ' ' . htmlspecialchars($p['apellido']) ?></p>
            <p><strong>Cédula:</strong> <?= htmlspecialchars($p['cedula']) ?></p>
            <p><strong>Fecha de Nacimiento:</strong> <?= htmlspecialchars($p['fecha_nacimiento']) ?></p>
            <p><strong>Sexo:</strong> <?= htmlspecialchars($p['sexo']) ?></p>
            <p><strong>Comida favorita:</strong> <?= htmlspecialchars($p['comida_favorita']) ?></p>
            <p><strong>Habilidades:</strong> <?= nl2br(htmlspecialchars($p['habilidades'])) ?></p>
            <div class="clear"></div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>
