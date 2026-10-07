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
    public function it_should_classify_temperature_as_adequate_when_value_is_valid()
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
        ];

        $erros = $this->analiseController->validarDados($dados);
        $this->assertContains('O campo turbidez precisa ser preenchido', $erros);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_validate_non_numeric_value()
    {
        $dados = [
            'ph' => '7.0',
            'turbidez' => '3.0',
            'cloro' => 'abc',
            'dureza' => '200',
            'temperatura' => '20',
        ];

        $erros = $this->analiseController->validarValores($dados);
        $this->assertContains('Valor inválido para o campo Cloro', $erros);
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
}