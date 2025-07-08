<?php
$chiste = null;
$error = '';

$apiUrl = 'https://official-joke-api.appspot.com/random_joke';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200 && $response !== FALSE) {
    $data = json_decode($response, true);
    if (isset($data['setup']) && isset($data['punchline'])) {
        $chiste = [
            'pregunta' => $data['setup'],
            'respuesta' => $data['punchline']
        ];
    } else {
        $error = "No se pudo obtener un chiste. 😕";
    }
} else {
    $error = "Error al conectarse a la API. Código HTTP: $httpCode";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Generador de Chistes 🤣</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans flex min-h-screen">

<?php echo include 'files/menu.php'; ?>

  <main class="flex-1 ml-64 p-10">
    <section class="bg-white rounded-lg shadow p-8 max-w-lg mx-auto border-4 border-yellow-300">
      <h2 class="text-2xl font-bold text-yellow-700 mb-4">🤣 Chiste Aleatorio</h2>

      <?php if ($chiste): ?>
        <div class="mt-4 p-4 bg-yellow-100 rounded text-center">
          <p class="text-lg font-semibold text-yellow-800">👉 <?php echo htmlspecialchars($chiste['pregunta']); ?></p>
          <p class="mt-3 text-yellow-700">😆 <strong><?php echo htmlspecialchars($chiste['respuesta']); ?></strong></p>
        </div>
      <?php elseif ($error): ?>
        <div class="mt-4 p-4 bg-red-100 text-red-700 rounded">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>
    </section>
  </main>

</body>
</html>
