<?php
require_once "funciones.php";

$busqueda = trim($_GET["q"] ?? "chicken");

$url = "https://www.themealdb.com/api/json/v1/1/search.php?s=" . urlencode($busqueda);

$resultado = consumirApiGet($url);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recetas</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <header class="hero">
        <h1>Buscador de recetas</h1>
    </header>
    <br>
    <br>
    

    <main class="contenedor">

        <a class="volver" href="index.php">← Volver</a>

        <form method="GET">
            <input
                type="text"
                name="q"
                value="<?= htmlspecialchars($busqueda) ?>"
                placeholder="Ej: chicken, pasta, cake"
            >
            <button type="submit">Buscar</button>
        </form>

        <?php if (!$resultado["ok"]): ?>

            <div class="error">Error consultando la API</div>

        <?php else: ?>

            <?php $recetas = $resultado["datos"]["meals"] ?? []; ?>

            <?php if (count($recetas) === 0): ?>

                <div class="error">No se encontraron recetas.</div>

            <?php else: ?>

                <section class="grid">

                    <?php foreach ($recetas as $receta): ?>

                        <article class="tarjeta">

                            <img
                                src="<?= htmlspecialchars($receta["strMealThumb"]) ?>"
                                alt="Receta"
                            >

                            <h2>
                                <?= htmlspecialchars($receta["strMeal"]) ?>
                            </h2>

                            <p>
                                Categoría:
                                <?= htmlspecialchars($receta["strCategory"]) ?>
                            </p>

                            <p>
                                Origen:
                                <?= htmlspecialchars($receta["strArea"]) ?>
                            </p>

                        </article>

                    <?php endforeach; ?>

                </section>

            <?php endif; ?>

        <?php endif; ?>

    </main>

</body>
</html>