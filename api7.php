<?php
$resultados = [];
$error = '';
$cantidadUsd = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cantidadUsd = trim($_POST['cantidad']);
    if ($cantidadUsd !== '' && is_numeric($cantidadUsd) && $cantidadUsd > 0) {
        $apiUrl = 'https://api.exchangerate-api.com/v4/latest/USD';
        $response = @file_get_contents($apiUrl);

        if ($response !== FALSE) {
            $data = json_decode($response, true);
            if (isset($data['rates'])) {
                $monedas = [
                    'DOP' => '🇩🇴 Peso Dominicano',
                    'EUR' => '🇪🇺 Euro',
                    'MXN' => '🇲🇽 Peso Mexicano'
                ];

                foreach ($monedas as $codigo => $nombre) {
                    $tasa = $data['rates'][$codigo] ?? null;
                    if ($tasa) {
                        $resultados[] = [
                            'moneda' => $nombre,
                            'codigo' => $codigo,
                            'valor' => round($cantidadUsd * $tasa, 2)
                        ];
                    }
                }
            } else {
                $error = "No se encontraron tasas de cambio.";
            }
        } else {
            $error = "Error al conectarse a la API.";
        }
    } else {
        $error = "Por favor ingresa una cantidad válida en USD.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Conversión de Monedas 💰</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans flex min-h-screen">

<?php echo include 'files/menu.php'; ?>

  <main class="flex-1 ml-64 p-10">
    <section class="bg-white rounded-lg shadow p-8 max-w-lg mx-auto border-4 border-green-300">
      <h2 class="text-2xl font-bold text-green-700 mb-4">💰 Conversión de Monedas</h2>
      <form method="POST" class="space-y-4 mb-6">
        <input
          type="number"
          step="0.01"
          name="cantidad"
          value="<?php echo htmlspecialchars($cantidadUsd); ?>"
          placeholder="Cantidad en USD"
          class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
        >
        <button
          type="submit"
          class="w-full bg-green-500 text-white font-semibold py-2 rounded hover:bg-green-600 transition"
        >
          Convertir
        </button>
      </form>

      <?php if ($resultados): ?>
        <div class="mt-6 space-y-4">
          <?php foreach ($resultados as $r): ?>
            <div class="flex items-center justify-between p-4 bg-green-50 rounded shadow-sm">
              <div class="flex items-center space-x-2">
                <span class="text-2xl">💵</span>
                <span class="font-semibold text-green-800"><?php echo htmlspecialchars($r['moneda']); ?> (<?php echo $r['codigo']; ?>)</span>
              </div>
              <span class="text-xl font-bold text-green-700"><?php echo number_format($r['valor'], 2); ?></span>
            </div>
          <?php endforeach; ?>
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
