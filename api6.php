<?php
$noticias = [];
$error = '';
$paginaSeleccionada = '';

$opcionesSitios = [
    'whitehouse' => [
        'nombre' => 'The White House',
        'api' => 'https://www.whitehouse.gov/wp-json/wp/v2/posts',
        'logo' => 'https://www.whitehouse.gov/wp-content/themes/whitehouse/assets/images/logos/wh_logo_seal_blue.svg'
    ]
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paginaSeleccionada = $_POST['pagina'] ?? '';
    if (array_key_exists($paginaSeleccionada, $opcionesSitios)) {
        $sitio = $opcionesSitios[$paginaSeleccionada];
        $response = @file_get_contents($sitio['api'] . '?per_page=3');

        if ($response !== FALSE) {
            $data = json_decode($response, true);
            if (is_array($data)) {
                foreach ($data as $post) {
                    $noticias[] = [
                        'titulo' => $post['title']['rendered'],
                        'resumen' => strip_tags($post['excerpt']['rendered']),
                        'link' => $post['link']
                    ];
                }
            } else {
                $error = "No se encontraron noticias.";
            }
        } else {
            $error = "Error al conectarse a la API.";
        }
    } else {
        $error = "Por favor selecciona una página válida.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Noticias desde WordPress 📰</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans flex min-h-screen">

<?php echo include 'files/menu.php'; ?>

  <main class="flex-1 ml-64 p-10">
    <section class="bg-white rounded-lg shadow p-8 max-w-2xl mx-auto border-4 border-blue-300">
      <h2 class="text-2xl font-bold text-blue-700 mb-4">📰 Noticias desde WordPress</h2>
      <form method="POST" class="space-y-4 mb-6">
        <select
          name="pagina"
          class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          <option value="">-- Selecciona una página --</option>
          <?php foreach ($opcionesSitios as $key => $sitio): ?>
            <option value="<?php echo htmlspecialchars($key); ?>" <?php echo $paginaSeleccionada === $key ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($sitio['nombre']); ?>
            </option>
          <?php endforeach; ?>
        </select>
        <button
          type="submit"
          class="w-full bg-blue-500 text-white font-semibold py-2 rounded hover:bg-blue-600 transition"
        >
          Obtener Noticias
        </button>
      </form>

      <?php if ($noticias && isset($sitio)): ?>
        <div class="mt-6 space-y-6">
          <div class="flex items-center space-x-4">
            <img src="<?php echo htmlspecialchars($sitio['logo']); ?>" alt="Logo" class="w-12 h-12 rounded">
            <h3 class="text-xl font-bold text-blue-800"><?php echo htmlspecialchars($sitio['nombre']); ?></h3>
          </div>
          <?php foreach ($noticias as $n): ?>
            <div class="p-4 bg-blue-50 rounded shadow-sm">
              <h4 class="text-lg font-semibold text-blue-700"><?php echo $n['titulo']; ?></h4>
              <p class="text-gray-700 mt-2"><?php echo $n['resumen']; ?></p>
              <a href="<?php echo htmlspecialchars($n['link']); ?>" target="_blank" class="inline-block mt-2 text-blue-600 hover:underline">Leer más</a>
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
