<?php
$archivoPersonajes = 'datos/personajes.json';
$archivoProfesiones = 'datos/profesiones.json';

$profesiones = file_exists($archivoProfesiones) ? json_decode(file_get_contents($archivoProfesiones), true) : [];
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo = [
        'id' => uniqid(),
        'nombre' => $_POST['nombre'],
        'apellido' => $_POST['apellido'],
        'fecha_nacimiento' => $_POST['fecha_nacimiento'],
        'foto_url' => $_POST['foto_url'],
        'profesion' => $_POST['profesion'],
        'experiencia' => $_POST['experiencia']
    ];

    $personajes = file_exists($archivoPersonajes) ? json_decode(file_get_contents($archivoPersonajes), true) : [];
    $personajes[] = $nuevo;
    file_put_contents($archivoPersonajes, json_encode($personajes, JSON_PRETTY_PRINT));
    $mensaje = "✅ Personaje registrado exitosamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Personaje - Mundo Barbie</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to bottom right, #ffe4f2, #ffc4e1);
      font-family: 'Comic Sans MS', cursive, sans-serif;
      color: #e0218a;
    }
    .navbar {
      background-color: #ff69b4;
    }
    .navbar-brand, .nav-link {
      color: white !important;
    }
    .form-control, .form-select {
      border-radius: 20px;
    }
    .btn-barbie {
      background-color: #ff69b4;
      color: white;
      border: none;
      border-radius: 20px;
    }
    .btn-barbie:hover {
      background-color: #ff1493;
    }
    h2 {
      text-align: center;
      margin-top: 20px;
      color: #e0218a;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">🏠 Mundo Barbie</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link" href="personajes.php">👩‍🎤 Personajes</a></li>
          <li class="nav-item"><a class="nav-link" href="profesiones.php">💼 Profesiones</a></li>
          <li class="nav-item"><a class="nav-link" href="dashboard.php">📊 Dashboard</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    <h2>Registrar Nuevo Personaje</h2>
    <?php if ($mensaje): ?>
      <div class="alert alert-success"><?= $mensaje ?></div>
    <?php endif; ?>

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
