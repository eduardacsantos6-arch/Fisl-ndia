<?php

use PHPUnit\Framework\TestCase;
use Controller\AnaliseController;
use Model\Amostra;

class AnaliseControllerTest extends TestCase
{
    private $mockAmostraModel;
    private $analiseController;

    protected function setUp(): void
    {
        $this->mockAmostraModel = $this->createMock(Amostra::class);
        $this->analiseController = new AnaliseController($this->mockAmostraModel);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_classify_ph_as_adequate_when_value_is_within_range()
    {
        $phResult = $this->analiseController->classificarPh(7.0);
        $this->assertEquals('adequado', $phResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_classify_ph_as_adequate_when_value_is_at_lower_limit()
    {
        $phResult = $this->analiseController->classificarPh(6.0);
        $this->assertEquals('adequado', $phResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_classify_ph_as_adequate_when_value_is_at_upper_limit()
    {
        $phResult = $this->analiseController->classificarPh(9.5);
        $this->assertEquals('adequado', $phResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_classify_ph_when_value_is_physically_invalid()
    {
        $phResult = $this->analiseController->classificarPh(15.0);
        $this->assertEquals('Valor de pH inválido', $phResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_classify_ph_as_inadequate_when_value_is_below_range()
    {
        $phResult = $this->analiseController->classificarPh(5.9);
        $this->assertEquals('inadequado', $phResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_classify_ph_as_inadequate_when_value_is_above_range()
    {
        $phResult = $this->analiseController->classificarPh(9.6);
        $this->assertEquals('inadequado', $phResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_classify_turbidity_as_adequate_when_value_is_within_range()
    {
        $turbidezResult = $this->analiseController->classificarTurbidez(3.0);
        $this->assertEquals('adequado', $turbidezResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_classify_turbidity_as_inadequate_when_value_exceeds_limit()
    {
        $turbidezResult = $this->analiseController->classificarTurbidez(8.0);
        $this->assertEquals('inadequado', $turbidezResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_classify_turbidity_as_adequate_when_at_limit()
    {
        $turbidezResult = $this->analiseController->classificarTurbidez(5.0);
        $this->assertEquals('adequado', $turbidezResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_classify_chlorine_as_adequate_when_value_is_within_range()
    {
        $cloroResult = $this->analiseController->classificarCloro(1.0);
        $this->assertEquals('adequado', $cloroResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_classify_chlorine_as_inadequate_when_value_is_below_minimum()
    {
        $cloroResult = $this->analiseController->classificarCloro(0.1);
        $this->assertEquals('inadequado', $cloroResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_classify_chlorine_as_adequate_when_at_upper_limit()
    {
        $cloroResult = $this->analiseController->classificarCloro(5.0);
        $this->assertEquals('adequado', $cloroResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_classify_chlorine_as_inadequate_when_exceeds_upper_limit()
    {
        $cloroResult = $this->analiseController->classificarCloro(5.5);
        $this->assertEquals('inadequado', $cloroResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_classify_hardness_as_adequate_when_value_is_within_range()
    {
        $durezaResult = $this->analiseController->classificarDureza(200.0);
        $this->assertEquals('adequado', $durezaResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_classify_hardness_as_inadequate_when_value_exceeds_limit()
    {
        $durezaResult = $this->analiseController->classificarDureza(650.0);
        $this->assertEquals('inadequado', $durezaResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_classify_hardness_as_adequate_when_at_limit()
    {
        $durezaResult = $this->analiseController->classificarDureza(500.0);
        $this->assertEquals('adequado', $durezaResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_classify_temperature_as_adequate_when_value_is_within_range()
    {
        $tempResult = $this->analiseController->classificarTemperatura(20.0);
        $this->assertEquals('adequado', $tempResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_classify_temperature_when_below_absolute_zero()
    {
        $tempResult = $this->analiseController->classificarTemperatura(-300.0);
        $this->assertEquals('Valor de temperatura inválido', $tempResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_classify_temperature_as_adequate_when_at_lower_limit()
    {
        $tempResult = $this->analiseController->classificarTemperatura(15.0);
        $this->assertEquals('adequado', $tempResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_classify_temperature_as_adequate_when_at_upper_limit()
    {
        $tempResult = $this->analiseController->classificarTemperatura(25.0);
        $this->assertEquals('adequado', $tempResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_classify_temperature_as_inadequate_when_below_range()
    {
        $tempResult = $this->analiseController->classificarTemperatura(10.0);
        $this->assertEquals('inadequado', $tempResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_classify_temperature_as_inadequate_when_above_range()
    {
        $tempResult = $this->analiseController->classificarTemperatura(30.0);
        $this->assertEquals('inadequado', $tempResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_calculate_biofilter_efficiency_correctly()
    {
        $eficiencia = $this->analiseController->calcularEficienciaBiofiltro(10.0, 4.0);
        $this->assertEquals(60.0, $eficiencia);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_calculate_biofilter_efficiency_with_known_result()
    {
        $eficiencia = $this->analiseController->calcularEficienciaBiofiltro(50.0, 25.0);
        $this->assertEquals(50.0, $eficiencia);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_calculate_efficiency_when_initial_value_is_zero()
    {
        $eficiencia = $this->analiseController->calcularEficienciaBiofiltro(0.0, 5.0);
        $this->assertEquals('Não é possível calcular a eficiência: valor inicial igual a zero', $eficiencia);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_calculate_zero_efficiency_when_no_reduction()
    {
        $eficiencia = $this->analiseController->calcularEficienciaBiofiltro(10.0, 10.0);
        $this->assertEquals(0.0, $eficiencia);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_calculate_100_percent_efficiency_when_complete_reduction()
    {
        $eficiencia = $this->analiseController->calcularEficienciaBiofiltro(10.0, 0.0);
        $this->assertEquals(100.0, $eficiencia);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_validate_empty_field()
    {
        $dados = [
            'nome' => 'Amostra 1',
            'data' => '2026-10-06',
            'local' => 'Rio',
            'ph' => '7.0',
            'turbidez' => '',
            'cloro' => '1.0',
            'dureza' => '200',
            'temperatura' => '20',
            'parametro' => 'turbidez',
            'valor_antes' => '10',
            'valor_depois' => '4',
        ];

        $erros = $this->analiseController->validarDados($dados);
        $this->assertContains('O campo turbidez precisa ser preenchido', $erros);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_validate_non_numeric_value()
    {
        $dados = [
            'ph' => 'abc',
            'turbidez' => '3.0',
            'cloro' => '1.0',
            'dureza' => '200',
            'temperatura' => '20',
        ];

        $erros = $this->analiseController->validarValores($dados);
        $this->assertContains('Valor inválido para o campo pH', $erros);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_validate_all_required_fields()
    {
        $dados = [
            'nome' => '',
            'data' => '',
            'local' => '',
            'ph' => '',
            'turbidez' => '',
            'cloro' => '',
            'dureza' => '',
            'temperatura' => '',
            'parametro' => '',
            'valor_antes' => '',
            'valor_depois' => '',
        ];

        $erros = $this->analiseController->validarDados($dados);

        $this->assertGreaterThan(0, count($erros));
        $this->assertContains('O nome da amostra é obrigatório', $erros);
        $this->assertContains('A data da coleta é obrigatória', $erros);
        $this->assertContains('O local da coleta é obrigatório', $erros);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_generate_potable_water_verdict_when_all_parameters_adequate()
    {
        $classificacoes = [
            'ph' => 'adequado',
            'turbidez' => 'adequado',
            'cloro' => 'adequado',
            'dureza' => 'adequado',
            'temperatura' => 'adequado',
        ];

        $parecer = $this->analiseController->gerarParecerFinal($classificacoes);
        $this->assertEquals('Água potável', $parecer);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_generate_unfit_water_verdict_when_one_parameter_inadequate()
    {
        $classificacoes = [
            'ph' => 'adequado',
            'turbidez' => 'inadequado',
            'cloro' => 'adequado',
            'dureza' => 'adequado',
            'temperatura' => 'adequado',
        ];

        $parecer = $this->analiseController->gerarParecerFinal($classificacoes);
        $this->assertEquals('Água imprópria para consumo', $parecer);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_generate_unfit_water_verdict_when_multiple_parameters_inadequate()
    {
        $classificacoes = [
            'ph' => 'inadequado',
            'turbidez' => 'inadequado',
            'cloro' => 'adequado',
            'dureza' => 'inadequado',
            'temperatura' => 'adequado',
        ];

        $parecer = $this->analiseController->gerarParecerFinal($classificacoes);
        $this->assertEquals('Água imprópria para consumo', $parecer);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_classify_all_parameters_at_once()
    {
        $dados = [
            'ph' => '7.0',
            'turbidez' => '3.0',
            'cloro' => '1.0',
            'dureza' => '200',
            'temperatura' => '20',
        ];

        $classificacoes = $this->analiseController->classificarParametros($dados);

        $this->assertEquals('adequado', $classificacoes['ph']);
        $this->assertEquals('adequado', $classificacoes['turbidez']);
        $this->assertEquals('adequado', $classificacoes['cloro']);
        $this->assertEquals('adequado', $classificacoes['dureza']);
        $this->assertEquals('adequado', $classificacoes['temperatura']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_classify_parameters_with_inadequate_values()
    {
        $dados = [
            'ph' => '5.0',
            'turbidez' => '8.0',
            'cloro' => '0.1',
            'dureza' => '600',
            'temperatura' => '-300',
        ];

        $classificacoes = $this->analiseController->classificarParametros($dados);

        $this->assertEquals('inadequado', $classificacoes['ph']);
        $this->assertEquals('inadequado', $classificacoes['turbidez']);
        $this->assertEquals('inadequado', $classificacoes['cloro']);
        $this->assertEquals('inadequado', $classificacoes['dureza']);
        $this->assertEquals('Valor de temperatura inválido', $classificacoes['temperatura']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_process_complete_analysis_workflow_with_valid_data()
    {
        $dados = [
            'nome' => 'Amostra Rio das Flores',
            'data' => '2026-10-06',
            'local' => 'Rio das Flores - Camaçari',
            'ph' => '7.0',
            'turbidez' => '3.0',
            'cloro' => '1.0',
            'dureza' => '200',
            'temperatura' => '20',
            'parametro' => 'turbidez',
            'valor_antes' => '10',
            'valor_depois' => '4',
        ];

        $errosDados = $this->analiseController->validarDados($dados);
        $this->assertEquals(0, count($errosDados));

        $errorsValores = $this->analiseController->validarValores($dados);
        $this->assertEquals(0, count($errorsValores));

        $classificacoes = $this->analiseController->classificarParametros($dados);
        foreach ($classificacoes as $classificacao) {
            $this->assertNotEmpty($classificacao);
        }

        $eficiencia = $this->analiseController->calcularEficienciaBiofiltro(
            (float) $dados['valor_antes'],
            (float) $dados['valor_depois']
        );
        $this->assertIsFloat($eficiencia);
        $this->assertEquals(60.0, $eficiencia);

        $parecer = $this->analiseController->gerarParecerFinal($classificacoes);
        $this->assertEquals('Água potável', $parecer);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_detect_errors_in_invalid_analysis_workflow()
    {
        $dados = [
            'nome' => '',
            'data' => '2026-10-06',
            'local' => 'Rio',
            'ph' => 'abc',
            'turbidez' => '-5',
            'cloro' => '1.0',
            'dureza' => '200',
            'temperatura' => '20',
            'parametro' => 'turbidez',
            'valor_antes' => '0',
            'valor_depois' => '4',
        ];

        $errosDados = $this->analiseController->validarDados($dados);
        $this->assertGreaterThan(0, count($errosDados));
        $this->assertContains('O nome da amostra é obrigatório', $errosDados);

        $errorsValores = $this->analiseController->validarValores($dados);
        $this->assertGreaterThan(0, count($errorsValores));
        $this->assertContains('Valor inválido para o campo pH', $errorsValores);

        $eficiencia = $this->analiseController->calcularEficienciaBiofiltro(0.0, 4.0);
        $this->assertIsString($eficiencia);
        $this->assertStringContainsString('não é possível', $eficiencia);
    }
}