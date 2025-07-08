<?php
$pokemon = null;
$nombre = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = strtolower(trim($_POST['nombre']));
    if ($nombre !== '') {
        $apiUrl = "https://pokeapi.co/api/v2/pokemon/" . urlencode($nombre);
        $response = @file_get_contents($apiUrl);

        if ($response !== FALSE) {
            $data = json_decode($response, true);
            if (isset($data['name'])) {
                $habilidades = array_map(function($h) {
                    return ucfirst($h['ability']['name']);
                }, $data['abilities']);

                $cryUrl = "https://raw.githubusercontent.com/PokeAPI/cries/main/cries/pokemon/latest/" . $data['id'] . ".ogg";
                $headers = @get_headers($cryUrl);
                $audioDisponible = is_array($headers) && strpos($headers[0], '200') !== false;

                $pokemon = [
                    'nombre' => ucfirst($data['name']),
                    'imagen' => $data['sprites']['other']['official-artwork']['front_default'],
                    'experiencia' => $data['base_experience'],
                    'habilidades' => $habilidades,
                    'audio' => $audioDisponible ? $cryUrl : null
                ];
            } else {
                $error = "Pokémon no encontrado. 😕";
            }
        } else {
            $error = "Error al conectarse a la API. ❌";
        }
    } else {
        $error = "Por favor ingresa un nombre de Pokémon. ✏️";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Información de un Pokémon ⚡</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans flex min-h-screen">

<?php echo include 'files/menu.php'; ?>

  <main class="flex-1 ml-64 p-10">
    <section class="bg-white rounded-lg shadow p-8 max-w-lg mx-auto border-4 border-yellow-400">
      <h2 class="text-2xl font-bold text-yellow-700 mb-4">🎮 Información de un Pokémon ⚡</h2>
      <form method="POST" class="space-y-4 mb-6">
        <input
          type="text"
          name="nombre"
          value="<?php echo htmlspecialchars($nombre); ?>"
          placeholder="Ej. pikachu"
          class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
        >
        <button
          type="submit"
          class="w-full bg-yellow-500 text-white font-semibold py-2 rounded hover:bg-yellow-600 transition"
        >
          Buscar Pokémon
        </button>
      </form>

      <?php if ($pokemon): ?>
        <div class="mt-6 p-4 rounded bg-yellow-50 text-center">
          <h3 class="text-xl font-semibold text-yellow-800"><?php echo htmlspecialchars($pokemon['nombre']); ?></h3>
          <img src="<?php echo htmlspecialchars($pokemon['imagen']); ?>" alt="Imagen de <?php echo htmlspecialchars($pokemon['nombre']); ?>" class="mx-auto w-40 h-40">
          <p class="mt-2 text-gray-700">✨ <strong>Experiencia base:</strong> <?php echo $pokemon['experiencia']; ?></p>
          <p class="mt-2 text-gray-700">💡 <strong>Habilidades:</strong> <?php echo implode(', ', $pokemon['habilidades']); ?></p>
          <?php if ($pokemon['audio']): ?>
            <audio controls class="mx-auto mt-4">
              <source src="<?php echo htmlspecialchars($pokemon['audio']); ?>" type="audio/ogg">
              Tu navegador no soporta el audio.
            </audio>
          <?php else: ?>
            <p class="mt-4 text-gray-500 italic">🔈 Sin audio disponible.</p>
          <?php endif; ?>
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
