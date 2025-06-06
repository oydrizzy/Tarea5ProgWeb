<?php
$archivoProfesiones = 'datos/profesiones.json';
$archivoPersonajes = 'datos/personajes.json';

$profesiones = file_exists($archivoProfesiones) ? json_decode(file_get_contents($archivoProfesiones), true) : [];
$personajes = file_exists($archivoPersonajes) ? json_decode(file_get_contents($archivoPersonajes), true) : [];

// Totales
$totalProfesiones = count($profesiones);
$totalPersonajes = count($personajes);

// Edad promedio
$edadPromedio = $totalPersonajes > 0 ? round(array_sum(array_column($personajes, 'edad')) / $totalPersonajes, 1) : 0;

// Distribución por categoría
$categorias = [];
foreach ($profesiones as $p) {
    $cat = $p['categoria'];
    if (!isset($categorias[$cat])) $categorias[$cat] = ['total' => 0, 'count' => 0];
    $categorias[$cat]['total'] += $p['salario'];
    $categorias[$cat]['count']++;
}

// Promedio por categoría para gráfico
$labels = [];
$valores = [];
foreach ($categorias as $nombre => $datos) {
    $labels[] = $nombre;
    $valores[] = round($datos['total'] / $datos['count'], 2);
}

// Nivel de experiencia más común
$niveles = array_column($personajes, 'experiencia');
$experienciaMasComun = $niveles ? array_search(max(array_count_values($niveles)), array_count_values($niveles)) : 'N/A';

// Salario general
$salarios = array_column($profesiones, 'salario');
$salarioPromedio = $salarios ? round(array_sum($salarios) / count($salarios), 2) : 0;
$salarioMayor = max($salarios);
$salarioMenor = min($salarios);

// Profesiones con salarios extremos
$profesionMayor = '';
$profesionMenor = '';
foreach ($profesiones as $p) {
    if ($p['salario'] == $salarioMayor) $profesionMayor = $p['nombre'];
    if ($p['salario'] == $salarioMenor) $profesionMenor = $p['nombre'];
}

// Personaje con salario más alto
$personajeTop = '';
foreach ($personajes as $pj) {
if (isset($pj['salario']) && $pj['salario'] == $salarioMayor) {
        $personajeTop = $pj['nombre'];
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Barbie</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/css/styles.css" rel="stylesheet">
</head>
<body>
  <?php include 'php/nav.php'; ?>

  <div class="container mt-4">
    <h2 class="text-center">📊 Panel de Estadísticas Barbie</h2>

    <div class="estadisticas-barbie">
  <div class="fila-estadistica">
    <div class="dato">👩‍🎤 Total personajes: <strong><?= $totalPersonajes ?></strong></div>
    <div class="dato">👩‍🔧 Total profesiones: <strong><?= $totalProfesiones ?></strong></div>
    <div class="dato">🎂 Edad promedio: <strong><?= $edadPromedio ?></strong></div>
  </div>
  <div class="fila-estadistica">
    <div class="dato">🏅 Experiencia más común: <strong><?= $experienciaMasComun ?></strong></div>
    <div class="dato">💰 Salario promedio: <strong>$<?= $salarioPromedio ?></strong></div>
  </div>
  <div class="fila-estadistica">
    <div class="dato">📈 Mayor salario: <strong>$<?= $salarioMayor ?> (<?= $profesionMayor ?>)</strong></div>
    <div class="dato">📉 Menor salario: <strong>$<?= $salarioMenor ?> (<?= $profesionMenor ?>)</strong></div>
  </div>
  <div class="fila-estadistica">
    <div class="dato">👑 Personaje con salario más alto: <strong><?= $personajeTop ?: 'N/A' ?></strong></div>
  </div>
</div>

    <h4 class="text-center">💖 Salario Promedio por Categoría 💖</h4>
    <div style="max-width: 800px; margin: auto;">
      <canvas id="salaryChart" style="height:400px;"></canvas>
    </div>
  </div>

  <script>
    const ctx = document.getElementById("salaryChart").getContext("2d");
    new Chart(ctx, {
      type: "bar",
      data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
          label: "Salario Promedio ($USD)",
          data: <?= json_encode($valores) ?>,
          backgroundColor: [
            "#ff69b4", "#ffe066", "#ffb6c1", "#c06c84", "#a29bfe", "#f48fb1", "#f06292"
          ],
          borderRadius: 10
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { labels: { color: "#e0218a" } }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: { color: "#e0218a" }
          },
          x: {
            ticks: { color: "#e0218a" }
          }
        }
      }
    });
  </script>
</body>
</html>