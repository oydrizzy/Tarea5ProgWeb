<?php
$edad = null;
$categoria = '';
$nombre = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    if ($nombre !== '') {
        $apiUrl = "https://api.agify.io/?name=" . urlencode($nombre);
        $response = @file_get_contents($apiUrl);

        if ($response !== FALSE) {
            $data = json_decode($response, true);
            if (isset($data['age']) && $data['age'] !== null) {
                $edad = (int)$data['age'];
                if ($edad < 18) {
                    $categoria = 'joven';
                } elseif ($edad < 60) {
                    $categoria = 'adulto';
                } else {
                    $categoria = 'anciano';
                }
            } else {
                $error = "No se pudo determinar la edad. 🚫";
            }
        } else {
            $error = "Error al conectarse a la API. ❌";
        }
    } else {
        $error = "Por favor ingresa un nombre. ✏️";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Predicción de Edad</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans flex min-h-screen">

<?php echo include 'files/menu.php'; ?>

  <!-- Contenido principal -->
  <main class="flex-1 ml-64 p-10">
    <section class="bg-white rounded-lg shadow p-8 max-w-lg mx-auto">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">🎂 Predicción de Edad</h2>
      <form method="POST" class="space-y-4">
        <input
          type="text"
          name="nombre"
          value="<?php echo htmlspecialchars($nombre); ?>"
          placeholder="Escribe un nombre"
          class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
        <button
          type="submit"
          class="w-full bg-blue-500 text-white font-semibold py-2 rounded hover:bg-blue-600 transition"
        >
          Predecir Edad
        </button>
      </form>

      <?php if ($edad !== null): ?>
        <?php
          // Determinar imagen según categoría
          $imagen = '';
          if ($categoria === 'joven') {
              $imagen = '/assets/img/joven.jpg';
          } elseif ($categoria === 'adulto') {
              $imagen = '/assets/img/adulto.png';
          } else {
              $imagen = '/assets/img/anciano.jpg';
          }
        ?>
        <div class="mt-6 p-4 bg-green-100 text-green-700 rounded text-center">
          <p class="text-lg font-medium">
            <strong><?php echo htmlspecialchars($nombre); ?></strong> tiene aproximadamente <strong><?php echo $edad; ?></strong> años.
          </p>
          <p class="mt-2">
            Categoría:
            <?php if ($categoria === 'joven'): ?>
              👶 Joven
            <?php elseif ($categoria === 'adulto'): ?>
              🧑 Adulto
            <?php else: ?>
              👴 Anciano
            <?php endif; ?>
          </p>
          <img src="<?php echo $imagen; ?>" alt="<?php echo $categoria; ?>" class="w-24 h-24 mx-auto mt-4">
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
