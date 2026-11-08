<?php
require_once "funciones.php";

$cantidad = isset($_GET["cantidad"]) ? (int) $_GET["cantidad"] : 6;
$cantidad = max(1, min(100, $cantidad));

$resultado = consumirApiGet(
    "https://randomuser.me/api/?results=" . $cantidad
);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personas</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <header class="hero">
        <h1>Personas aleatorias</h1>
    </header>

    <main class="contenedor">

        <a class="volver" href="index.php">← Volver</a>
        <br>
        <br>
        

        <form method="GET">
            <input
                type="number"
                name="cantidad"
                min="1"
                max="100"
                value="<?= $cantidad ?>"
            >

            <button type="submit">Consultar</button>
        </form>

        <?php if (!$resultado["ok"]): ?>

            <div class="error">
                <?= htmlspecialchars($resultado["error"]) ?>
            </div>

        <?php else: ?>

            <section class="grid">

                <?php foreach ($resultado["datos"]["results"] as $persona): ?>

                    <article class="tarjeta">

                        <img
                            src="<?= htmlspecialchars($persona["picture"]["large"]) ?>"
                            alt="Foto"
                        >

                        <h2>
                            <?= htmlspecialchars(
                                $persona["name"]["first"] . " " .
                                $persona["name"]["last"]
                            ) ?>
                        </h2>

                        <p>
                            <?= htmlspecialchars($persona["email"]) ?>
                        </p>

                        <p>
                            <?= htmlspecialchars($persona["location"]["city"]) ?>
                        </p>

                        <p>
                            Nacionalidad:
                            <?= htmlspecialchars($persona["nat"]) ?>
                        </p>

                    </article>

                <?php endforeach; ?>

            </section>

        <?php endif; ?>

    </main>

</body>
</html>