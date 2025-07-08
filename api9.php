<?php
$pais = null;
$nombrePais = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombrePais = trim($_POST['pais']);
    if ($nombrePais !== '') {
        $apiUrl = 'https://restcountries.com/v3.1/name/' . urlencode($nombrePais);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && $response !== FALSE) {
            $data = json_decode($response, true);
            if (is_array($data) && count($data) > 0) {
                $info = $data[0];

                $monedaKey = array_key_first($info['currencies']);
                $monedaNombre = $info['currencies'][$monedaKey]['name'];
                $monedaSimbolo = $info['currencies'][$monedaKey]['symbol'];

                $pais = [
                    'nombre' => $info['name']['common'],
                    'bandera' => $info['flags']['png'],
                    'capital' => $info['capital'][0] ?? 'N/A',
                    'poblacion' => number_format($info['population']),
                    'moneda' => $monedaNombre . " (" . $monedaSimbolo . ")"
                ];
            } else {
                $error = "País no encontrado. 🌐";
            }
        } else {
            $error = "Error al conectarse a la API. Código HTTP: $httpCode";
        }
    } else {
        $error = "Por favor ingresa un nombre de país.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Datos de un país 🌍</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans flex min-h-screen">

<?php echo include 'files/menu.php'; ?>

  <main class="flex-1 ml-64 p-10">
    <section class="bg-white rounded-lg shadow p-8 max-w-lg mx-auto border-4 border-indigo-300">
      <h2 class="text-2xl font-bold text-indigo-700 mb-4">🌍 Datos de un país</h2>
      <form method="POST" class="space-y-4 mb-6">
        <input
          type="text"
          name="pais"
          value="<?php echo htmlspecialchars($nombrePais); ?>"
          placeholder="Ej. Dominican Republic"
          class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >
        <button
          type="submit"
          class="w-full bg-indigo-500 text-white font-semibold py-2 rounded hover:bg-indigo-600 transition"
        >
          Consultar País
        </button>
      </form>

      <?php if ($pais): ?>
        <div class="mt-6 p-4 bg-indigo-50 rounded text-center">
          <h3 class="text-xl font-bold text-indigo-800"><?php echo htmlspecialchars($pais['nombre']); ?></h3>
          <img src="<?php echo htmlspecialchars($pais['bandera']); ?>" alt="Bandera" class="mx-auto my-4 w-32 h-auto rounded shadow">
          <p class="text-gray-700"><span class="font-semibold">🏛️ Capital:</span> <?php echo htmlspecialchars($pais['capital']); ?></p>
          <p class="text-gray-700"><span class="font-semibold">👥 Población:</span> <?php echo htmlspecialchars($pais['poblacion']); ?></p>
          <p class="text-gray-700"><span class="font-semibold">💵 Moneda:</span> <?php echo htmlspecialchars($pais['moneda']); ?></p>
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
