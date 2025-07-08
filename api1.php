<?php
$genero = null;
$nombre = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    if ($nombre !== '') {
        $apiUrl = "https://api.genderize.io/?name=" . urlencode($nombre);
        $response = @file_get_contents($apiUrl);

        if ($response !== FALSE) {
            $data = json_decode($response, true);
            if (isset($data['gender']) && $data['gender'] !== null) {
                $genero = $data['gender'];
            } else {
                $error = "No se pudo determinar el género. 🚫";
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
  <title>Predicción de Género</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans flex min-h-screen">

<?php echo include 'files/menu.php'; ?>

  <main class="flex-1 ml-64 p-10">
    <section class="bg-white rounded-lg shadow p-8 max-w-lg mx-auto">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">👦👧 Predicción de Género</h2>
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
          Predecir Género
        </button>
      </form>

      <?php if ($genero): ?>
        <div class="mt-6 p-4 rounded <?php echo $genero === 'male' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700'; ?>">
          <p class="text-lg font-medium">
            El género de <strong><?php echo htmlspecialchars($nombre); ?></strong> es:
            <?php if ($genero === 'male'): ?>
              Masculino 💙
            <?php else: ?>
              Femenino 💖
            <?php endif; ?>
          </p>
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
