<?php
$archivo = 'datos/personajes.json';
$personajes = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>🌸 Mundo Barbie</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to bottom right, #ffe4f2, #ffc4e1);
      font-family: 'Comic Sans MS', cursive, sans-serif;
      color: #e0218a;
      text-align: center;
      padding-top: 50px;
    }
    .btn-barbie {
      background-color: #ff69b4;
      color: white;
      border: none;
      border-radius: 30px;
      padding: 15px 30px;
      font-size: 18px;
      margin: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      transition: transform 0.2s;
    }
    .btn-barbie:hover {
      background-color: #ff1493;
      transform: scale(1.05);
    }
    h1 {
      font-size: 3rem;
      font-weight: bold;
      text-shadow: 2px 2px white;
    }
    .logo {
      width: 220px;
      margin-bottom: 20px;
    }
    .tarjeta-personaje {
      background-color: white;
      border-radius: 20px;
      padding: 15px;
      margin: 15px;
      box-shadow: 0 4px 12px rgba(255,105,180,0.3);
      text-align: center;
      max-width: 220px;
    }
    .tarjeta-personaje img {
      width: 100px;
      height: 100px;
      object-fit: contain;
      border-radius: 50%;
      margin-bottom: 10px;
    }
    .tarjetas-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 15px;
      margin-top: 30px;
    }
    .tarjeta-personaje small {
      font-size: 0.8rem;
      color: #888;
    }
  </style>
</head>
<body>

  <img src="/img/logo.png" alt="Logo" class="logo">
  <h1>Bienvenid@ al Mundo Barbie 💖</h1>
  <p style="font-size: 1.2rem;">Gestiona tus personajes, profesiones y descubre estadísticas brillantes</p>

  <div class="container mt-5">
    <a href="personajes.php" class="btn btn-barbie">👩‍🎤 Registrar Personajes</a>
    <a href="profesiones.php" class="btn btn-barbie">💼 Registrar Profesiones</a>
    <a href="dashboard.php" class="btn btn-barbie">📊 Ver Dashboard</a>
  </div>

  <?php if ($personajes): ?>
    <h3 class="mt-5">👑 Personajes</h3>
    <div class="tarjetas-grid">
      <?php foreach ($personajes as $p): ?>
        <div class="tarjeta-personaje">
          <img src="<?= htmlspecialchars($p['foto_url']) ?>" alt="<?= htmlspecialchars($p['nombre']) ?>">
          <strong><?= htmlspecialchars($p['nombre']) ?> <?= htmlspecialchars($p['apellido']) ?></strong>
          <div><small>🎂 <?= $p['fecha_nacimiento'] ?></small></div>
          <div>💼 <?= htmlspecialchars($p['profesion']) ?></div>
          <div>⭐ <?= htmlspecialchars($p['experiencia']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

</body>
</html>
