<?php

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $amostra = $_POST["amostra"] ?? "";
    $data = $_POST["data"] ?? "";
    $local = $_POST["local"] ?? "";

    $ph = $_POST["ph"] ?? "";
    $turbidez = $_POST["turbidez"] ?? "";
    $cloro = $_POST["cloro"] ?? "";
    $dureza = $_POST["dureza"] ?? "";
    $temperatura = $_POST["temperatura"] ?? "";

    $parametro = $_POST["parametro"] ?? "";
    $valorAntes = $_POST["valor_antes"] ?? "";
    $valorDepois = $_POST["valor_depois"] ?? "";

    if (
        empty($amostra) ||
        empty($data) ||
        empty($local) ||
        $ph === "" ||
        $turbidez === "" ||
        $cloro === "" ||
        $dureza === "" ||
        $temperatura === "" ||
        empty($parametro) ||
        $valorAntes === "" ||
        $valorDepois === ""
    ) {

        $mensagem = "Preencha todos os campos obrigatórios.";

    } else {

        /*
         * O processamento dos parâmetros será colocado aqui
         * posteriormente.
         *
         * Nesta etapa, o formulário já está preparado para
         * enviar os dados para o PHP.
         */

        session_start();

        $_SESSION["analise"] = [
            "amostra" => $amostra,
            "data" => $data,
            "local" => $local,
            "ph" => $ph,
            "turbidez" => $turbidez,
            "cloro" => $cloro,
            "dureza" => $dureza,
            "temperatura" => $temperatura,
            "parametro" => $parametro,
            "valor_antes" => $valorAntes,
            "valor_depois" => $valorDepois
        ];

        header("Location: resultados.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Análise | Laboratório da Água</title>

    <link rel="stylesheet" href="templates/global.css">
    <link rel="stylesheet" href="templates/analise.css">

</head>

<body>

<header class="header">

    <a href="index.php" class="logo">
        <span class="logo-icon">H₂O</span>

        <span>
            <strong>Laboratório da Água</strong>
            <small>Qualidade • Ciência • Sustentabilidade</small>
        </span>
    </a>

   <nav class="nav">
    <a href="index.php" class="active">Início</a>
    <a href="analise.php">Análise</a>
    <a href="resultados.php">Resultados</a>
</nav>

</header>


<main class="analysis-page">

    <section class="page-intro">

        <span class="eyebrow">
            01 / ANÁLISE
        </span>

        <h1>
            Registre os dados
            <em>da sua amostra.</em>
        </h1>

        <p>
            Informe os valores realmente coletados durante
            o experimento.
        </p>

    </section>


    <?php if ($mensagem): ?>

        <div class="error-message">
            <?= htmlspecialchars($mensagem) ?>
        </div>

    <?php endif; ?>


    <form method="POST" class="analysis-form">


        <section class="form-section">

            <div class="section-number">
                01
            </div>

            <div class="form-heading">

                <h2>
                    Identificação da amostra
                </h2>

                <p>
                    Informações básicas da coleta.
                </p>

            </div>


            <div class="form-grid">

                <label>
                    Nome da amostra

                    <input
                        type="text"
                        name="amostra"
                        placeholder="Ex.: Amostra 01"
                        required
                    >

                </label>


                <label>
                    Data da coleta

                    <input
                        type="date"
                        name="data"
                        required
                    >

                </label>


                <label class="full">
                    Local da coleta

                    <input
                        type="text"
                        name="local"
                        placeholder="Informe o local da coleta"
                        required
                    >

                </label>

            </div>

        </section>


        <section class="form-section">

            <div class="section-number">
                02
            </div>

            <div class="form-heading">

                <h2>
                    Parâmetros da água
                </h2>

                <p>
                    Informe os valores medidos.
                </p>

            </div>


            <div class="parameter-grid">


                <label class="parameter">

                    <strong>pH</strong>

                    <span>
                        Potencial hidrogeniônico
                    </span>

                    <input
                        type="number"
                        name="ph"
                        step="0.01"
                        placeholder="0,00"
                        required
                    >

                </label>


                <label class="parameter">

                    <strong>Turbidez</strong>

                    <span>
                        Turbidez da água
                    </span>

                    <input
                        type="number"
                        name="turbidez"
                        step="0.01"
                        min="0"
                        placeholder="0,00"
                        required
                    >

                </label>


                <label class="parameter">

                    <strong>Cloro</strong>

                    <span>
                        Cloro residual
                    </span>

                    <input
                        type="number"
                        name="cloro"
                        step="0.01"
                        min="0"
                        placeholder="0,00"
                        required
                    >

                </label>


                <label class="parameter">

                    <strong>Dureza</strong>

                    <span>
                        Dureza da água
                    </span>

                    <input
                        type="number"
                        name="dureza"
                        step="0.01"
                        min="0"
                        placeholder="0,00"
                        required
                    >

                </label>


                <label class="parameter">

                    <strong>Temperatura</strong>

                    <span>
                        Temperatura da água
                    </span>

                    <input
                        type="number"
                        name="temperatura"
                        step="0.1"
                        placeholder="0,0"
                        required
                    >

                </label>

            </div>

        </section>


        <section class="form-section biofilter">

            <div class="section-number">
                03
            </div>

            <div class="form-heading">

                <h2>
                    Biofiltro experimental
                </h2>

                <p>
                    Compare os valores antes e depois do processo.
                </p>

            </div>


            <div class="notice">

                <strong>Importante</strong>

                <p>
                    Utilize os dados realmente coletados
                    durante o experimento.
                </p>

            </div>


            <div class="comparison">

                <div>

                    <h3>
                        Antes do biofiltro
                    </h3>


                    <label>
                        Parâmetro

                        <select name="parametro" required>

                            <option value="">
                                Selecione
                            </option>

                            <option value="ph">
                                pH
                            </option>

                            <option value="turbidez">
                                Turbidez
                            </option>

                            <option value="cloro">
                                Cloro residual
                            </option>

                            <option value="dureza">
                                Dureza
                            </option>

                            <option value="temperatura">
                                Temperatura
                            </option>

                        </select>

                    </label>


                    <label>
                        Valor antes

                        <input
                            type="number"
                            name="valor_antes"
                            step="0.01"
                            placeholder="0,00"
                            required
                        >

                    </label>

                </div>


                <div class="comparison-arrow">
                    →
                </div>


                <div>

                    <h3>
                        Depois do biofiltro
                    </h3>


                    <label>
                        Valor depois

                        <input
                            type="number"
                            name="valor_depois"
                            step="0.01"
                            placeholder="0,00"
                            required
                        >

                    </label>

                </div>

            </div>

        </section>


        <div class="form-actions">

            <a
                href="index.php"
                class="button-secondary"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="button-primary"
            >
                Enviar para análise →
            </button>

        </div>

    </form>

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