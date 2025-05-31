<?php
$archivo = 'datos/obras.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $obra = [
        'codigo' => $_POST['codigo'],
        'foto_url' => $_POST['foto_url'],
        'tipo' => $_POST['tipo'],
        'nombre' => $_POST['nombre'],
        'descripcion' => $_POST['descripcion'],
        'pais' => $_POST['pais'],
        'autor' => $_POST['autor']
    ];

    $obras = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];

    foreach ($obras as $item) {
        if ($item['codigo'] === $obra['codigo']) {
            $mensaje = "⚠️ Ese código ya está registrado.";
            break;
        }
    }

    if (!isset($mensaje)) {
        $obras[] = $obra;
        file_put_contents($archivo, json_encode($obras, JSON_PRETTY_PRINT));
        $mensaje = "✅ Obra guardada correctamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Obras</title>
    <link rel="stylesheet" href="assets/css/styles.css?<?php echo time();?>">
</head>
<body>

<?php include_once 'datos/menu.php' ?>

<div class="main">
    <div class="form-container">
        <h2>Registrar Obra</h2>
        <?php if (isset($mensaje)): ?>
            <div class="mensaje <?= strpos($mensaje, '⚠️') !== false ? 'error' : '' ?>">
                <?= $mensaje ?>
            </div>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="codigo" placeholder="Código único" required>
            <input type="url" name="foto_url" placeholder="URL de imagen" required>
            <select name="tipo" required>
                <option value="">Seleccionar tipo</option>
                <option value="Serie">Serie</option>
                <option value="Película">Película</option>
                <option value="Libro">Libro</option>
            </select>
            <input type="text" name="nombre" placeholder="Nombre" required>
            <textarea name="descripcion" placeholder="Descripción breve" required></textarea>
            <input type="text" name="pais" placeholder="País de origen" required>
            <input type="text" name="autor" placeholder="Autor o creador" required>
            <button type="submit">Guardar Obra</button>
        </form>
    </div>
</div>



</body>
</html>
