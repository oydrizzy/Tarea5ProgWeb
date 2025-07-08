<?php
$clima = null;
$ciudad = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ciudad = trim($_POST['ciudad']);
    if ($ciudad !== '') {
        $apiKey = 'aef310fcb40898a5c9e59300224c86b4'; // Reemplaza con tu API Key
        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($ciudad) . ",DO&units=metric&lang=es&appid=" . $apiKey;
        $response = @file_get_contents($apiUrl);

        if ($response !== FALSE) {
            $data = json_decode($response, true);
            if (isset($data['main'])) {
                $clima = [
                    'temp' => round($data['main']['temp']),
                    'descripcion' => ucfirst($data['weather'][0]['description']),
                    'icono' => $data['weather'][0]['icon'],
                    'principal' => $data['weather'][0]['main'],
                    'ciudad' => $data['name']
                ];
            } else {
                $error = "Ciudad no encontrada. 😕";
            }
        } else {
            $error = "Error al conectarse a la API. ❌";
        }
    } else {
        $error = "Por favor ingresa una ciudad. ✏️";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Clima en República Dominicana</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans flex min-h-screen">

<?php echo include 'files/menu.php'; ?>

  <!-- Contenido principal -->
  <main class="flex-1 ml-64 p-10">
    <section class="bg-white rounded-lg shadow p-8 max-w-lg mx-auto">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">🌦️ Clima en República Dominicana</h2>
      <form method="POST" class="space-y-4 mb-6">
        <input
          type="text"
          name="ciudad"
          value="<?php echo htmlspecialchars($ciudad); ?>"
          placeholder="Escribe una ciudad (ej. Santo Domingo)"
          class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
        <button
          type="submit"
          class="w-full bg-blue-500 text-white font-semibold py-2 rounded hover:bg-blue-600 transition"
        >
          Ver Clima
        </button>
      </form>

      <?php if ($clima): ?>
        <?php
          // Fondo según condición principal
          $bgColor = 'bg-blue-100';
          if ($clima['principal'] === 'Clear') $bgColor = 'bg-yellow-100';
          elseif ($clima['principal'] === 'Rain') $bgColor = 'bg-blue-200';
          elseif ($clima['principal'] === 'Clouds') $bgColor = 'bg-gray-200';
        ?>
        <div class="mt-6 p-4 rounded <?php echo $bgColor; ?> text-center">
          <h3 class="text-xl font-semibold text-gray-800"><?php echo htmlspecialchars($clima['ciudad']); ?></h3>
          <img src="https://openweathermap.org/img/wn/<?php echo $clima['icono']; ?>@2x.png" alt="Icono clima" class="mx-auto">
          <p class="text-3xl font-bold"><?php echo $clima['temp']; ?>°C</p>
          <p class="text-gray-700 mt-2"><?php echo htmlspecialchars($clima['descripcion']); ?></p>
        </div>
      <?php elseif ($error): ?>
        <div class="mt-6 p-4 bg-red-100 text-red-700 rounded">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>
    </section>
  </main>

</body>
</html>
