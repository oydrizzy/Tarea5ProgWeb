<?php
// Rutas a los archivos JSON
$archivoPersonajes = 'datos/personajes.json';
$archivoProfesiones = 'datos/profesiones.json';

// Carga profesiones existentes
$profesiones = file_exists($archivoProfesiones) ? json_decode(file_get_contents($archivoProfesiones), true) : [];
$mensaje = '';

// Si el formulario fue enviado (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear nuevo personaje desde el formulario
    $nuevo = [
        'id' => uniqid(), // ID único generado automáticamente
        'nombre' => $_POST['nombre'],
        'apellido' => $_POST['apellido'],
        'fecha_nacimiento' => $_POST['fecha_nacimiento'],
        'foto_url' => $_POST['foto_url'],
        'profesion' => $_POST['profesion'],
        'experiencia' => $_POST['experiencia']
    ];

    // Cargar personajes existentes
    $personajes = file_exists($archivoPersonajes) ? json_decode(file_get_contents($archivoPersonajes), true) : [];

    // Agregar nuevo personaje y guardar
    $personajes[] = $nuevo;
    file_put_contents($archivoPersonajes, json_encode($personajes, JSON_PRETTY_PRINT));

    // Mensaje de éxito
    $mensaje = "✅ Personaje registrado exitosamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Personajes Barbie</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/css/styles.css" rel="stylesheet">
</head>
<body>

  <?php include_once 'php/nav.php'?> <!-- Navegación superior -->

  <div class="container mt-4">
    <h2>Registrar Nuevo Personaje</h2>

    <!-- Mostrar mensaje de éxito si se registró correctamente -->
    <?php if ($mensaje): ?>
      <div class="alert alert-success"><?= $mensaje ?></div>
    <?php endif; ?>

    <!-- Formulario de registro de personaje -->
    <form method="POST" class="p-4 rounded shadow bg-white">
      <div class="row mb-3">
        <div class="col">
          <label>Nombre</label>
          <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="col">
          <label>Apellido</label>
          <input type="text" name="apellido" class="form-control" required>
        </div>
      </div>
      <div class="mb-3">
        <label>Fecha de Nacimiento</label>
        <input type="date" name="fecha_nacimiento" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Foto URL</label>
        <input type="url" name="foto_url" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Profesión</label>
        <select name="profesion" class="form-select" required>
          <option value="">Selecciona una profesión</option>
          <!-- Opciones generadas desde el JSON de profesiones -->
          <?php foreach ($profesiones as $prof): ?>
            <option value="<?= htmlspecialchars($prof['nombre']) ?>"><?= htmlspecialchars($prof['nombre']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label>Nivel de Experiencia</label>
        <select name="experiencia" class="form-select" required>
          <option>Principiante</option>
          <option>Intermedio</option>
          <option>Avanzado</option>
        </select>
      </div>

      <button type="submit" class="btn btn-barbie">💖 Registrar Personaje</button>
    </form>
  </div>

</body>
</html>