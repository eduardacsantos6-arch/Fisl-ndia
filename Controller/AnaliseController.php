<?php

namespace Controller;

use Model\Amostra;

class AnaliseController
{
    private ?Amostra $amostra;

    /**
     * O model Amostra só é exigido quando o controller precisa persistir
     * dados no banco. Para os algoritmos de validação, classificação e
     * cálculo (cobertos pelos testes unitários) ele não é necessário,
     * então nunca é instanciado aqui dentro do construtor.
     */
    public function __construct(?Amostra $amostra = null)
    {
        $this->amostra = $amostra;
    }

    private function getAmostraModel(): Amostra
    {
        if ($this->amostra === null) {
            $this->amostra = new Amostra();
        }

        return $this->amostra;
    }

    /**
     * Valida os dados enviados pelo formulário (campos obrigatórios).
     * @param array $dados
     * @return array
     */
    public function validarDados(array $dados): array
    {
        $erros = [];

        if (empty($dados['nome'])) {
            $erros[] = 'O nome da amostra é obrigatório';
        }

        if (empty($dados['data'])) {
            $erros[] = 'A data da coleta é obrigatória';
        }

        if (empty($dados['local'])) {
            $erros[] = 'O local da coleta é obrigatório';
        }

        $parametros = [
            'ph' => 'pH',
            'turbidez' => 'turbidez',
            'cloro' => 'cloro residual',
            'dureza' => 'dureza',
            'temperatura' => 'temperatura',
        ];

        foreach ($parametros as $campo => $nome) {
            if (!isset($dados[$campo]) || $dados[$campo] === '') {
                $erros[] = "O campo {$nome} precisa ser preenchido";
            }
        }

        if (!isset($dados['parametro']) || $dados['parametro'] === '') {
            $erros[] = 'Selecione o parâmetro do biofiltro';
        }

        if (!isset($dados['valor_antes']) || $dados['valor_antes'] === '') {
            $erros[] = 'Informe o valor antes do biofiltro';
        }

        if (!isset($dados['valor_depois']) || $dados['valor_depois'] === '') {
            $erros[] = 'Informe o valor depois do biofiltro';
        }

        return $erros;
    }

    /**
     * Verifica se os valores numéricos informados são válidos.
     * @param array $dados
     * @return array
     */
    public function validarValores(array $dados): array
    {
        $erros = [];

        $parametros = [
            'ph' => 'pH',
            'turbidez' => 'turbidez',
            'cloro' => 'cloro residual',
            'dureza' => 'dureza',
            'temperatura' => 'temperatura',
        ];

        foreach ($parametros as $campo => $nome) {
            if (isset($dados[$campo]) && $dados[$campo] !== '' && !is_numeric($dados[$campo])) {
                $erros[] = "Valor inválido para o campo {$nome}";
            }
        }

        return $erros;
    }

    /**
     * Classifica o pH de acordo com a faixa de referência (6,0 a 9,5)
     * definida pela Portaria GM/MS nº 888/2021. Valores fora da escala
     * física possível (0 a 14) são considerados inválidos.
     * @param float $ph
     * @return string
     */
    public function classificarPh(float $ph): string
    {
        if ($ph < 0 || $ph > 14) {
            return 'Valor de pH inválido';
        }

        if ($ph >= 6.0 && $ph <= 9.5) {
            return 'adequado';
        }

        return 'inadequado';
    }

    /**
     * Classifica a turbidez (até 5,0 uT é considerado adequado).
     * @param float $turbidez
     * @return string
     */
    public function classificarTurbidez(float $turbidez): string
    {
        if ($turbidez < 0) {
            return 'Valor de turbidez inválido';
        }

        if ($turbidez <= 5.0) {
            return 'adequado';
        }

        return 'inadequado';
    }

    /**
     * Classifica o cloro residual livre (faixa adequada: 0,2 a 5,0 mg/L).
     * @param float $cloro
     * @return string
     */
    public function classificarCloro(float $cloro): string
    {
        if ($cloro < 0) {
            return 'Valor de cloro residual inválido';
        }

        if ($cloro >= 0.2 && $cloro <= 5.0) {
            return 'adequado';
        }

        return 'inadequado';
    }

    /**
     * Classifica a dureza total (até 500 mg/L de CaCO3 é considerado adequado).
     * @param float $dureza
     * @return string
     */
    public function classificarDureza(float $dureza): string
    {
        if ($dureza < 0) {
            return 'Valor de dureza inválido';
        }

        if ($dureza <= 500) {
            return 'adequado';
        }

        return 'inadequado';
    }

    /**
     * Classifica a temperatura (faixa de referência adotada: 15 a 25°C).
     * Valores abaixo do zero absoluto (-273,15°C) são fisicamente impossíveis.
     * @param float $temperatura
     * @return string
     */
    public function classificarTemperatura(float $temperatura): string
    {
        if ($temperatura < -273.15) {
            return 'Valor de temperatura inválido';
        }

        if ($temperatura >= 15 && $temperatura <= 25) {
            return 'adequado';
        }

        return 'inadequado';
    }

    /**
     * Classifica todos os parâmetros de uma amostra de uma só vez.
     * @param array $dados Deve conter as chaves ph, turbidez, cloro, dureza e temperatura
     * @return array
     */
    public function classificarParametros(array $dados): array
    {
        return [
            'ph' => $this->classificarPh((float) $dados['ph']),
            'turbidez' => $this->classificarTurbidez((float) $dados['turbidez']),
            'cloro' => $this->classificarCloro((float) $dados['cloro']),
            'dureza' => $this->classificarDureza((float) $dados['dureza']),
            'temperatura' => $this->classificarTemperatura((float) $dados['temperatura']),
        ];
    }

    /**
     * Calcula a eficiência (%) do biofiltro experimental a partir dos
     * valores do parâmetro antes e depois do processo.
     * Quando o valor inicial é zero, retorna uma mensagem de erro em vez
     * de lançar uma exceção de divisão por zero.
     * @param float $valorAntes
     * @param float $valorDepois
     * @return float|string
     */
    public function calcularEficienciaBiofiltro(float $valorAntes, float $valorDepois): float|string
    {
        if ($valorAntes == 0.0) {
            return 'Não é possível calcular a eficiência: valor inicial igual a zero';
        }

        return round((($valorAntes - $valorDepois) / $valorAntes) * 100, 2);
    }

    /**
     * Gera o parecer final da amostra: só é considerada "Água potável"
     * quando todos os parâmetros individuais estão classificados como
     * "adequado".
     * @param array $classificacoes
     * @return string
     */
    public function gerarParecerFinal(array $classificacoes): string
    {
        foreach ($classificacoes as $classificacao) {
            if ($classificacao !== 'adequado') {
                return 'Água imprópria para consumo';
            }
        }

        return 'Água potável';
    }

    /**
     * Persiste a amostra, seus parâmetros e o resultado do biofiltro.
     * @param array $dados
     * @param array $classificacoes
     * @param float|string $eficiencia
     * @param string $parecer
     * @return int|bool
     */
    public function salvarAnalise(array $dados, array $classificacoes, float|string $eficiencia, string $parecer): int|bool
    {
        $idAmostra = $this->getAmostraModel()->createAmostra($dados['nome'], $dados['data'], $dados['local'], $parecer);

        if (!$idAmostra) {
            return false;
        }

        $parametros = [
            'ph' => $dados['ph'],
            'turbidez' => $dados['turbidez'],
            'cloro' => $dados['cloro'],
            'dureza' => $dados['dureza'],
            'temperatura' => $dados['temperatura'],
        ];

        $this->getAmostraModel()->createParametros($idAmostra, $parametros, $classificacoes);

        if (is_float($eficiencia)) {
            $this->getAmostraModel()->createBiofiltro($idAmostra, $dados['parametro'], (float) $dados['valor_antes'], (float) $dados['valor_depois'], $eficiencia);
        }

        return $idAmostra;
    }
}