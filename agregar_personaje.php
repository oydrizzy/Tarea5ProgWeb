<?php
$archivo_personajes = 'datos/personajes.json';
$archivo_obras = 'datos/obras.json';

// Obtener las obras para el select
$obras = file_exists($archivo_obras) ? json_decode(file_get_contents($archivo_obras), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $personaje = [
        'cedula' => $_POST['cedula'],
        'foto_url' => $_POST['foto_url'],
        'nombre' => $_POST['nombre'],
        'apellido' => $_POST['apellido'],
        'fecha_nacimiento' => $_POST['fecha_nacimiento'],
        'sexo' => $_POST['sexo'],
        'habilidades' => $_POST['habilidades'],
        'comida_favorita' => $_POST['comida_favorita'],
        'obra_codigo' => $_POST['obra_codigo']
    ];

    $personajes = file_exists($archivo_personajes) ? json_decode(file_get_contents($archivo_personajes), true) : [];

    foreach ($personajes as $p) {
        if ($p['cedula'] === $personaje['cedula']) {
            $mensaje = "⚠️ Esa cédula ya está registrada.";
            break;
        }
    }

    // Validar que el código de obra exista
    $obraExiste = false;
    foreach ($obras as $obra) {
        if ($obra['codigo'] === $personaje['obra_codigo']) {
            $obraExiste = true;
            break;
        }
    }

    if (!$obraExiste) {
        $mensaje = "⚠️ La obra seleccionada no existe.";
    }

    if (!isset($mensaje)) {
        $personajes[] = $personaje;
        file_put_contents($archivo_personajes, json_encode($personajes, JSON_PRETTY_PRINT));
        $mensaje = "✅ Personaje registrado correctamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Personajes</title>
    <link rel="stylesheet" href="assets/css/styles.css?<?php echo time();?>">
</head>
<body>

<?php include_once 'datos/menu.php' ?>

<div class="main">
    <div class="form-container">
        <h2>Registrar Personaje</h2>
        <?php if (isset($mensaje)): ?>
            <div class="mensaje <?= strpos($mensaje, '⚠️') !== false ? 'error' : '' ?>">
                <?= $mensaje ?>
            </div>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="cedula" placeholder="Cédula única" required>
            <input type="url" name="foto_url" placeholder="URL de imagen" required>
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="apellido" placeholder="Apellido" required>
            <input type="date" name="fecha_nacimiento" required>
            <select name="sexo" required>
                <option value="">Sexo</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
            </select>
            <input type="text" name="habilidades" placeholder="Habilidades (separadas por comas)" required>
            <input type="text" name="comida_favorita" placeholder="Comida favorita" required>
            <select name="obra_codigo" required>
                <option value="">Seleccionar obra</option>
                <?php foreach ($obras as $obra): ?>
                    <option value="<?= htmlspecialchars($obra['codigo']) ?>">
                        <?= htmlspecialchars($obra['nombre']) ?> (<?= htmlspecialchars($obra['codigo']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Guardar Personaje</button>
        </form>
    </div>
</div>

</body>
</html>
