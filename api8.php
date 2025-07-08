<?php
$palabraClave = '';
$imagenUrl = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $palabraClave = trim($_POST['palabra']);
    if ($palabraClave !== '') {
        $imagenUrl = "https://picsum.photos/seed/" . urlencode($palabraClave) . "/800/600";
    } else {
        $error = "Por favor ingresa una palabra clave.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Generador de Imágenes con IA 🖼️</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans flex min-h-screen">

<?php echo include 'files/menu.php'; ?>

  <main class="flex-1 ml-64 p-10">
    <section class="bg-white rounded-lg shadow p-8 max-w-xl mx-auto border-4 border-purple-300">
      <h2 class="text-2xl font-bold text-purple-700 mb-4">🖼️ Generador de Imágenes con IA</h2>
      <form method="POST" class="space-y-4 mb-6">
        <input
          type="text"
          name="palabra"
          value="<?php echo htmlspecialchars($palabraClave); ?>"
          placeholder="Ej. naturaleza, ciudad, animales..."
          class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
        >
        <button
          type="submit"
          class="w-full bg-purple-500 text-white font-semibold py-2 rounded hover:bg-purple-600 transition"
        >
          Generar Imagen
        </button>
      </form>

      <?php if ($imagenUrl): ?>
        <div class="mt-6 text-center">
          <img
            src="<?php echo htmlspecialchars($imagenUrl); ?>"
            alt="Imagen generada"
            class="rounded shadow mx-auto"
          >
          <p class="mt-2 text-gray-600 italic">Imagen generada para: "<?php echo htmlspecialchars($palabraClave); ?>"</p>
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
