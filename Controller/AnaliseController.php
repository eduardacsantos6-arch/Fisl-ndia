<?php

namespace Controller;

use Model\Amostra;

class AnaliseController {
    private Amostra $amostra;

    public function __construct() {

        $this->amostra = new Amostra();
    }

    /**
     * Valida os dados enviados pelo formulário
     */

    public function validarDados(array $dados): array {

        $erros = [];

        if(empty($dados['nome'])) {

            $erros[] = 'O nome da amostra é obrigatório';
        }

        if(empty($dados['data'])) {

            $erros[] = 'A data da coleta é obrigatória';
        }

        if(empty($dados['local'])) {

            $erros[] = 'O local da coleta é obrigatório';
        }

        $parametros = ['ph' => 'pH', 'turbidez' => 'Turbidez', 'cloro' => 'Cloro residual', 'dureza' => 'Dureza', 'temperatura' => 'Temperatura'];

          foreach ($parametros as $campo => $nome) {

            if (!isset($dados[$campo]) || $dados[$campo] === '') {
                $erros[] = "O campo {$nome} é obrigatório";
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
     * Verifica se os valores númericos são validos
     */

    public function validarValores(array $dados): array {

        $erros = [];

    $parametros = ['ph' => 'pH', 'turbidez' => 'Turbidez', 'cloro' => 'Cloro residual', 'dureza' => 'Dureza', 'temperatura' => 'Temperatura'];

      foreach ($parametros as $campo => $nome) {
            
        if (isset($dados[$campo]) && $dados[$campo] !== '' && !is_numeric($dados[$campo])) {

                $erros[] = "O valor de {$nome} deve ser numérico";

    }
}

    }

}