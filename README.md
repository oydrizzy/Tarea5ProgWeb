# Tarea5ProgWeb
 Tarea 5: Portal Web en PHP con APIs Externas

# 🌐 Portal de Ejemplos con PHP y Tailwind CSS

Este proyecto es un portal web dinámico desarrollado con **PHP** y **Tailwind CSS**. Incluye ejemplos prácticos de consumo de APIs y generación de contenido en tiempo real, como:

- Clima actual en una ciudad
- Información de Pokémon
- Noticias de WordPress
- Conversión de monedas
- Generación de imágenes con IA
- Datos de países
- Chistes aleatorios

## 📂 Estructura de Archivos
/project-root
├── api1.php (Clima)
├── api2.php (Pokémon)
├── api3.php (Noticias)
├── api4.php (Conversión de Monedas)
├── api5.php (Imágenes con IA)
├── api6.php (Datos de Países)
├── api7.php (Chistes)
├── acerca.php
└── files/
└── menu.php


## ⚙️ Requisitos

- Servidor web con soporte PHP 7.4 o superior (Apache, Nginx, etc.)
- Extensión **cURL** habilitada en PHP
- Acceso a internet (para consumir las APIs públicas)

## 🚀 Cómo Ejecutar

1. **Subir los archivos al servidor**

   Copia todos los archivos al directorio público de tu servidor (por ejemplo, `htdocs` si usas XAMPP).

2. **Configurar menú**

   En el archivo `files/menu.php`, puedes agregar los enlaces de navegación a cada módulo:

   ```php
   <nav class="fixed top-0 left-0 w-64 h-full bg-gray-800 text-white p-4">
     <ul class="space-y-2">
       <li><a href="api1.php" class="hover:underline">Clima</a></li>
       <li><a href="api2.php" class="hover:underline">Pokémon</a></li>
       <li><a href="api3.php" class="hover:underline">Noticias</a></li>
       <li><a href="api4.php" class="hover:underline">Conversión de Monedas</a></li>
       <li><a href="api5.php" class="hover:underline">Imágenes con IA</a></li>
       <li><a href="api6.php" class="hover:underline">Datos de Países</a></li>
       <li><a href="api7.php" class="hover:underline">Chistes</a></li>
       <li><a href="acerca.php" class="hover:underline">Acerca de</a></li>
     </ul>
   </nav>
