<?php
// api3.php
$universidades = [];
$pais = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pais = trim($_POST['pais']);
    if ($pais !== '') {
        $apiUrl = "http://universities.hipolabs.com/search?country=" . urlencode($pais);
        $response = @file_get_contents($apiUrl);

        if ($response !== FALSE) {
            $data = json_decode($response, true);
            if (!empty($data)) {
                $universidades = $data;
            } else {
                $error = "No se encontraron universidades para ese país. 🌍";
            }
        } else {
            $error = "Error al conectarse a la API. ❌";
        }
    } else {
        $error = "Por favor ingresa un país. ✏️";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Universidades de un País</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans flex min-h-screen">

<?php echo include 'files/menu.php'; ?>

  <!-- Contenido principal -->
  <main class="flex-1 ml-64 p-10">
    <section class="bg-white rounded-lg shadow p-8 max-w-4xl mx-auto">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">🎓 Universidades de un País</h2>
      <form method="POST" class="space-y-4 mb-6">
        <input
          type="text"
          name="pais"
          value="<?php echo htmlspecialchars($pais); ?>"
          placeholder="Escribe el nombre del país en inglés (ej. Dominican Republic)"
          class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
        <button
          type="submit"
          class="w-full bg-blue-500 text-white font-semibold py-2 rounded hover:bg-blue-600 transition"
        >
          Buscar Universidades
        </button>
      </form>

      <?php if (!empty($universidades)): ?>
        <div class="overflow-x-auto">
          <table class="min-w-full bg-white border border-gray-200">
            <thead>
              <tr class="bg-blue-50">
                <th class="py-2 px-4 border-b text-left">Nombre</th>
                <th class="py-2 px-4 border-b text-left">Dominio</th>
                <th class="py-2 px-4 border-b text-left">Enlace</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($universidades as $uni): ?>
                <tr class="hover:bg-gray-50">
                  <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($uni['name']); ?></td>
                  <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($uni['domains'][0]); ?></td>
                  <td class="py-2 px-4 border-b">
                    <a href="<?php echo htmlspecialchars($uni['web_pages'][0]); ?>" target="_blank" class="text-blue-600 hover:underline">
                      Visitar sitio 🌐
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
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
