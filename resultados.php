<?php

session_start();

$analise = $_SESSION["analise"] ?? null;

if (!$analise) {
    header("Location: analise.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Resultados | Laboratório da Água</title>

    <link rel="stylesheet" href="templates/global.css">
    <link rel="stylesheet" href="templates/resultados.css">

</head>

<body>

<header class="header">

    <a href="index.php" class="logo">

        <span class="logo-icon">
            H₂O
        </span>

        <span>
            <strong>
                Laboratório da Água
            </strong>

            <small>
                Qualidade • Ciência • Sustentabilidade
            </small>
        </span>

    </a>


    <nav class="nav">
    <a href="index.php" class="active">Início</a>
    <a href="analise.php">Análise</a>
    <a href="resultados.php">Resultados</a>
</nav>

</header>


<main class="results-page">


    <section class="page-intro">

        <span class="eyebrow">
            02 / RESULTADOS
        </span>

        <h1>
            Resultado da
            <em>amostra.</em>
        </h1>

        <p>
            Confira os dados registrados e,
            posteriormente, as classificações
            calculadas pelo sistema.
        </p>

    </section>


    <section class="sample-header">

        <div>

            <span>
                AMOSTRA ANALISADA
            </span>

            <h2>
                <?= htmlspecialchars($analise["amostra"]) ?>
            </h2>

            <p>
                <?= htmlspecialchars($analise["local"]) ?>
                ·
                <?= htmlspecialchars($analise["data"]) ?>
            </p>

        </div>

        <div class="waiting-status">

            <span></span>

            Aguardando processamento

        </div>

    </section>


    <section class="result-grid">


        <article class="result-card">

            <span>
                pH
            </span>

            <strong>
                <?= htmlspecialchars($analise["ph"]) ?>
            </strong>

            <small>
                Classificação será calculada pelo PHP.
            </small>

        </article>


        <article class="result-card">

            <span>
                Turbidez
            </span>

            <strong>
                <?= htmlspecialchars($analise["turbidez"]) ?>
            </strong>

            <small>
                Classificação será calculada pelo PHP.
            </small>

        </article>


        <article class="result-card">

            <span>
                Cloro residual
            </span>

            <strong>
                <?= htmlspecialchars($analise["cloro"]) ?>
            </strong>

            <small>
                Classificação será calculada pelo PHP.
            </small>

        </article>


        <article class="result-card">

            <span>
                Dureza
            </span>

            <strong>
                <?= htmlspecialchars($analise["dureza"]) ?>
            </strong>

            <small>
                Classificação será calculada pelo PHP.
            </small>

        </article>


        <article class="result-card">

            <span>
                Temperatura
            </span>

            <strong>
                <?= htmlspecialchars($analise["temperatura"]) ?> °C
            </strong>

            <small>
                Classificação será calculada pelo PHP.
            </small>

        </article>


    </section>


    <section class="biofilter-result">

        <div>

            <span class="eyebrow">
                BIOFILTRO EXPERIMENTAL
            </span>

            <h2>
                Eficiência do processo
            </h2>

            <p>
                O resultado será calculado utilizando
                os valores registrados antes e depois
                do biofiltro.
            </p>

        </div>


        <div class="efficiency">

            <small>
                EFICIÊNCIA
            </small>

            <strong>
                —
            </strong>

        </div>

    </section>


    <section class="final-result">

        <div class="result-icon">
            ✓
        </div>

        <div>

            <span class="eyebrow">
                PARECER FINAL
            </span>

            <h2>
                Aguardando classificação
            </h2>

            <p>
                O parecer final será gerado depois que
                os algoritmos de classificação forem
                implementados no PHP.
            </p>

        </div>

    </section>


    <div class="result-actions">

        <a
            href="analise.php"
            class="button-primary"
        >
            Nova análise →
        </a>

    </div>

</main>


<footer class="footer">

    <div class="footer-logo">

        <span class="logo-icon">
            H₂O
        </span>

        <div>

            <strong>
                Laboratório da Água
            </strong>

            <small>
                Projeto acadêmico
            </small>

        </div>

    </div>

    <span>
        © 2026 Laboratório da Água
    </span>

</footer>

</body>
</html>