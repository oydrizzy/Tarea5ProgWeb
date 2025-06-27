<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Portal Web con APIs Externas</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans flex min-h-screen">

<?php echo include'files/menu.php'?>

  <!-- Contenido principal -->
  <main class="flex-1 ml-64 p-10">
    <section class="bg-white rounded-lg shadow p-8 text-center">
      <img src="/assets/img/yo.jpg" alt="mi foto" class="w-32 h-32 rounded-full border-4 border-blue-500 object-cover mx-auto">
      <h1 class="text-2xl font-bold text-gray-800 mt-4">Rolando Paulino</h1>
      <h2 class="text-3xl font-semibold text-gray-800 mt-6">Bienvenido a mi portal web dinámico</h2>
      <p class="mt-4 text-gray-600 text-lg">
        Aquí podrás explorar distintas APIs y aprender más sobre mis proyectos.
        Utiliza el menú a la izquierda para navegar.
      </p>
    </section>
  </main>

</body>
</html>