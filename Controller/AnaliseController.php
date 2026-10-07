<?php

namespace Controller;

use Model\Amostra;

class AnaliseController
{
    private $amostraModel;

    public function __construct(Amostra $amostraModel)
    {
        $this->amostraModel = $amostraModel;
    }

    public function validarDados(array $dados): array
{
    $erros = [];
    $campos = ['nome', 'data', 'local', 'ph', 'turbidez', 'cloro', 'dureza', 'temperatura'];
    
    $mensagens = [
        'nome' => 'O nome da amostra é obrigatório',
        'data' => 'A data da coleta é obrigatória',
        'local' => 'O local da coleta é obrigatório',
        'ph' => 'O campo pH precisa ser preenchido',
        'turbidez' => 'O campo turbidez precisa ser preenchido',
        'cloro' => 'O campo cloro precisa ser preenchido',
        'dureza' => 'O campo dureza precisa ser preenchido',
        'temperatura' => 'O campo temperatura precisa ser preenchido',
    ];
    
    foreach ($campos as $campo) {
        if (empty($dados[$campo] ?? '')) {
            $erros[] = $mensagens[$campo];
        }
    }
    
    return $erros;
}

public function validarValores(array $dados): array
{
    $erros = [];
    $campos = ['ph', 'turbidez', 'cloro', 'dureza', 'temperatura'];
    
    $labels = [
        'ph' => 'pH',
        'turbidez' => 'Turbidez',
        'cloro' => 'Cloro',
        'dureza' => 'Dureza',
        'temperatura' => 'Temperatura',
    ];
    
    foreach ($campos as $campo) {
        $valor = $dados[$campo] ?? '';
        if ($valor !== '' && !is_numeric($valor)) {
            $erros[] = "Valor inválido para o campo " . $labels[$campo];
        }
    }
    
    return $erros;
}
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

    public function classificarTurbidez(float $turbidez): string
    {
        if ($turbidez <= 5.0) {
            return 'adequado';
        }
        return 'inadequado';
    }

    public function classificarCloro(float $cloro): string
    {
        if ($cloro >= 0.2 && $cloro <= 5.0) {
            return 'adequado';
        }
        return 'inadequado';
    }

    public function classificarDureza(float $dureza): string
    {
        if ($dureza <= 500) {
            return 'adequado';
        }
        return 'inadequado';
    }

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

    public function classificarParametros(array $dados): array
    {
        return [
            'ph' => $this->classificarPh((float)$dados['ph']),
            'turbidez' => $this->classificarTurbidez((float)$dados['turbidez']),
            'cloro' => $this->classificarCloro((float)$dados['cloro']),
            'dureza' => $this->classificarDureza((float)$dados['dureza']),
            'temperatura' => $this->classificarTemperatura((float)$dados['temperatura']),
        ];
    }

    public function calcularEficienciaBiofiltro(float $valorAntes, float $valorDepois): float|string
    {
        if ($valorAntes == 0) {
            return 'Não é possível calcular a eficiência: valor inicial igual a zero';
        }
        return (($valorAntes - $valorDepois) / $valorAntes) * 100;
    }

    public function gerarParecerFinal(array $classificacoes): string
    {
        foreach ($classificacoes as $classificacao) {
            if ($classificacao === 'inadequado' || strpos($classificacao, 'inválido') !== false) {
                return 'Água imprópria para consumo';
            }
        }
        return 'Água potável';
    }

    public function salvarAnalise(array $dados): bool
    {
        return true;
    }
}