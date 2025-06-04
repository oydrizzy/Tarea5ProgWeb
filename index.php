<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>🌸 Mundo Barbie - Inicio</title>
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
      width: 120px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

  <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3b/Barbie_Logo.svg/2560px-Barbie_Logo.svg.png" alt="Logo Barbie" class="logo">
  <h1>Bienvenida al Mundo Barbie 💖</h1>
  <p style="font-size: 1.2rem;">Gestiona tus personajes, profesiones y descubre estadísticas brillantes</p>

  <div class="container mt-5">
    <a href="personajes.php" class="btn btn-barbie">👩‍🎤 Registrar Personajes</a>
    <a href="profesiones.php" class="btn btn-barbie">💼 Registrar Profesiones</a>
    <a href="dashboard.php" class="btn btn-barbie">📊 Ver Dashboard</a>
  </div>

</body>
</html>
