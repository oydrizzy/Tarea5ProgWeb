<?php
// Carga el archivo de personajes en un array
$archivo = 'datos/personajes.json';
$personajes = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];

// Si se solicita eliminar un personaje por ID
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $personajes = array_filter($personajes, fn($p) => $p['id'] !== $id);
    file_put_contents($archivo, json_encode(array_values($personajes), JSON_PRETTY_PRINT));
    header("Location: editar_personajes.php");
    exit;
}

// Si se envió el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($personajes as &$p) {
        if ($p['id'] === $_POST['id']) {
            // Actualiza los datos del personaje
            $p['nombre'] = $_POST['nombre'];
            $p['fecha_nacimiento'] = $_POST['fecha_nacimiento'];
            $p['experiencia'] = $_POST['experiencia'];
            $p['profesion'] = $_POST['profesion'];
            break;
        }
    }
    file_put_contents($archivo, json_encode($personajes, JSON_PRETTY_PRINT));
    header("Location: editar_personajes.php");
    exit;
}

// Si se va a editar, busca el personaje correspondiente
$editando = null;
if (isset($_GET['editar'])) {
    $editando = array_filter($personajes, fn($p) => $p['id'] === $_GET['editar']);
    $editando = array_shift($editando);
}

// Función para calcular edad desde la fecha de nacimiento
function calcularEdad($fecha) {
    $nacimiento = new DateTime($fecha);
    $hoy = new DateTime();
    return $nacimiento->diff($hoy)->y;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Personajes</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/css/styles.css" rel="stylesheet">
</head>
<body>
  <?php include 'php/nav.php'; ?>

  <div class="container mt-4">
    <h2 class="text-center">✏️​ Editar Personajes</h2>

    <?php if ($editando): ?>
      <div class="p-4 rounded shadow bg-white" style="max-width: 700px; margin: auto;">
        <form method="POST">
          <input type="hidden" name="id" value="<?= $editando['id'] ?>">
          <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" class="form-control" name="nombre" value="<?= $editando['nombre'] ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Fecha de nacimiento:</label>
            <input type="date" class="form-control" name="fecha_nacimiento" value="<?= $editando['fecha_nacimiento'] ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Experiencia:</label>
            <select class="form-select" name="experiencia">
              <option <?= $editando['experiencia']==='Principiante'?'selected':'' ?>>Principiante</option>
              <option <?= $editando['experiencia']==='Intermedio'?'selected':'' ?>>Intermedio</option>
              <option <?= $editando['experiencia']==='Avanzado'?'selected':'' ?>>Avanzado</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Profesión:</label>
            <input type="text" class="form-control" name="profesion" value="<?= $editando['profesion'] ?>" required>
          </div>
          <button class="btn btn-barbie">Guardar Cambios</button>
        </form>
      </div>
    <?php endif; ?>

    <div class="table-responsive mt-4">
      <table class="table table-bordered text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>Nombre</th>
            <th>Edad</th>
            <th>Experiencia</th>
            <th>Profesión</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($personajes as $p): ?>
            <tr>
              <td><?= $p['nombre'] ?></td>
              <td><?= isset($p['fecha_nacimiento']) ? calcularEdad($p['fecha_nacimiento']) : 'N/D' ?></td>
              <td><?= $p['experiencia'] ?></td>
              <td><?= $p['profesion'] ?></td>
              <td>
                <a href="?editar=<?= $p['id'] ?>" class="btn btn-sm btn-warning btn-barbie">Editar</a>
                <a href="?eliminar=<?= $p['id'] ?>" class="btn btn-sm btn-danger btn-barbie" onclick="return confirm('¿Eliminar personaje?')">Eliminar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>