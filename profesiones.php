<?php
$archivoProfesiones = 'datos/profesiones.json';
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nueva = [
        'id' => uniqid(),
        'nombre' => $_POST['nombre'],
        'categoria' => $_POST['categoria'],
        'salario' => floatval($_POST['salario'])
    ];

    $profesiones = file_exists($archivoProfesiones) ? json_decode(file_get_contents($archivoProfesiones), true) : [];
    $profesiones[] = $nueva;
    file_put_contents($archivoProfesiones, json_encode($profesiones, JSON_PRETTY_PRINT));
    $mensaje = "✅ Profesión registrada exitosamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Profesión - Mundo Barbie</title>
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
    <h2>Registrar Nueva Profesión</h2>
    <?php if ($mensaje): ?>
      <div class="alert alert-success"><?= $mensaje ?></div>
    <?php endif; ?>

    <form method="POST" class="p-4 rounded shadow bg-white">
      <div class="mb-3">
        <label>Nombre de la Profesión</label>
        <input type="text" name="nombre" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Categoría</label>
        <select name="categoria" class="form-select" required>
          <option>Moda</option>
          <option>Ciencia</option>
          <option>Arte</option>
          <option>Deporte</option>
          <option>Entretenimiento</option>
          <option>Otros</option>
        </select>
      </div>
      <div class="mb-3">
        <label>Salario Mensual Estimado ($USD)</label>
        <input type="number" step="0.01" name="salario" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-barbie">💼 Guardar Profesión</button>
    </form>
  </div>

</body>
</html>
