<h2 style="text-align:center; color:#e0218a; font-family:'Comic Sans MS', cursive;">💖 Salario Promedio por Categoría 💖</h2>
<canvas id="salaryChart" width="400" height="200"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById("salaryChart").getContext("2d");
  const salaryChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: ["Moda", "Ciencia", "Arte", "Deporte", "Entretenimiento"],
      datasets: [{
        label: "Salario Promedio ($USD)",
        data: [3200, 5000, 4000, 3800, 4500],
        backgroundColor: [
          "#ff69b4", // rosa Barbie
          "#ffe066", // amarillo pastel
          "#ffb6c1", // rosa claro
          "#c06c84", // lila rosado
          "#a29bfe"  // morado pastel
        ],
        borderRadius: 10
      }]
    },
    options: {
      plugins: {
        legend: {
          labels: {
            color: "#e0218a"
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            color: "#e0218a"
          }
        },
        x: {
          ticks: {
            color: "#e0218a"
          }
        }
      }
    }
  });
</script>
