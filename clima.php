<?php
require_once "funciones.php";

$ciudad = trim($_GET["ciudad"] ?? "Bogota");
$clima = null;
$mensaje = null;

if ($ciudad !== "") {

    $geoUrl = "https://geocoding-api.open-meteo.com/v1/search?name=" .
        urlencode($ciudad) . "&count=1&language=es&format=json";

    $geo = consumirApiGet($geoUrl);

    if ($geo["ok"] && !empty($geo["datos"]["results"])) {

        $lugar = $geo["datos"]["results"][0];

        $lat = $lugar["latitude"];
        $lon = $lugar["longitude"];

        $url = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}&current=temperature_2m,relative_humidity_2m,wind_speed_10m";

        $clima = consumirApiGet($url);

    } else {

        $mensaje = "Ciudad no encontrada";

    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clima</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <header class="hero">
        <h1>Clima por ciudad</h1>
    </header>

    <main class="contenedor">

        <a class="volver" href="index.php">← Volver</a>
        <br>
        <br>


        <form method="GET">
            <input
                type="text"
                name="ciudad"
                value="<?= htmlspecialchars($ciudad) ?>"
            >

            <button type="submit">Consultar clima</button>
        </form>

        <?php if ($mensaje): ?>

            <div class="error">
                <?= htmlspecialchars($mensaje) ?>
            </div>

        <?php endif; ?>

        <?php if ($clima && $clima["ok"]): ?>

            <?php $actual = $clima["datos"]["current"]; ?>

            <article class="tarjeta">

                <h2><?= htmlspecialchars($ciudad) ?></h2>

                <p>
                    Temperatura:
                    <?= $actual["temperature_2m"] ?> °C
                </p>

                <p>
                    Humedad:
                    <?= $actual["relative_humidity_2m"] ?> %
                </p>

                <p>
                    Viento:
                    <?= $actual["wind_speed_10m"] ?> km/h
                </p>

            </article>

        <?php endif; ?>

    </main>

</body>
</html>