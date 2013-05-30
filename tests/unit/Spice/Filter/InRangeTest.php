<?php
namespace Spice\Filter;

class InRangeTest extends \PHPUnit_Framework_TestCase {
    private $filter;

    public function getFilter($start, $end) {
        return new \Spice\Filter\InRange($start, $end);
    }

    public function setUp() {
        $rangeStart = 0;
        $rangeEnd = 10;
        $inclusive = false;

        $this->filter = $this->getFilter(0, 10, false);
    }

    /**
     * @testdox Filtro é inicializado com sucesso.
     * @test
     */
    public function testSuccessfullyInitialized() {
        $this->assertInstanceof('\\Spice\\Filter\\InRange', $this->filter);
        $this->assertAttributeEquals(0, 'start', $this->filter);
        $this->assertAttributeEquals(10, 'end', $this->filter);
    }

    /**
     * @testdox É possível alterar o valor do início do intervalo válido de valores.
     * @test
     */
    public function testSetAndGetRangeStart() {
        $newStart = 5;
        $prevEnd = $this->filter->getRangeEnd();
        $this->filter->setRangeStart($newStart);
        $this->assertEquals($newStart, $this->filter->getRangeStart());
        $this->assertEquals($prevEnd, $this->filter->getRangeEnd());
    }

    /**
     * @testdox Não é possível estabelecer um início de intervalo maior do que o fim. 
     * @test
     * @expectedException \LogicException
     */
    public function testSetInvalidRangeStartFails() {
        $this->filter->setRangeStart(100);
    }

    /**
     * @testdox É possível alterar o fim intervalo válido de valores.
     * @test
     */
    public function testSetAndGetRangeEnd() {
        $newEnd = 20;
        $prevStart = $this->filter->getRangeStart();
        $this->filter->setRangeEnd($newEnd);
        $this->assertEquals($newEnd, $this->filter->getRangeEnd());
        $this->assertEquals($prevStart, $this->filter->getRangeStart());
    }

    /**
     * @testdox Não é possível estabelecer um fim de intervalo menor do que o inicio. 
     * @test
     * @expectedException \LogicException
     */
    public function testSetInvalidRangeEndFails() {
        $this->filter->setRangeEnd(-20);
    }

    /**
     * @testdox É possível alterar todo o intervalo de valores.
     * @test
     */
    public function testSetAndGetRange() {
        $this->filter->setRange(100, 200);

        $this->assertEquals(100, $this->filter->getRangeStart());
        $this->assertEquals(200, $this->filter->getRangeEnd());
    }

    /**
     * @testdox Não é possível estabelecer um intervalo inválido de valores.
     * @test
     * @expectedException \LogicException
     */
    public function testSetInvalidRangeFails() {
        $this->filter->setRange(20, 10);
    }
    
    /**
     * @testdox O método `accept` retornará `true` ante um parâmetro dentro do intervalo especificado.
     * @test
     */
    public function testAcceptWithValueInRangeWillReturnTrue() {
        $this->assertTrue($this->filter->accept(5));
    }

    /**
     * @testdox O método `accept` retornará `false` ante um parâmetro fora do intervalo especificado.
     * @test
     */
    public function testAcceptWithValueOutOfRangeWillReturnTrue() {
        $this->assertFalse($this->filter->accept(50));
    }
    
    /**
     * @testdox O método `accept` retornará `true` ante um parâmetro igual ao limite superior do intervalo.
     * @test
     */
    public function testAcceptWithValueEqualsRangeEndWillReturnTrue() {
        $this->assertTrue($this->filter->accept(10));
    }

    /**
     * @testdox O método `accept` retornará `true` ante um parâmetro igual ao limite inferior do intervalo.
     * @test
     */
    public function testAcceptWithValueEqualsRangeStartWillReturnTrue() {
        $this->assertTrue($this->filter->accept(0));
    }

    /**
     * @testdox O método `accept` retornará `true` quando tanto o intervalo quando o valor são strings e o valor se encontra dentro do intervalo.
     * @test
     */
    public function testAcceptWhenValueAndRangeAreStringsAndValueIsInRangeWillReturnTrue() {
        $this->filter->setRange('apple', 'pineapple');
        $this->assertTrue($this->filter->accept('orange'));
    }

    /**
     * @testdox O método `accept` retornará `false` quando tanto o intervalo quando o valor são strings e o valor se encontra fora do intervalo.
     * @test
     */
    public function testAcceptWhenValueAndRangeAreStringsAndValueIsOutOfRangeWillReturnTrue() {
        $this->filter->setRange('apple', 'banana');
        $this->assertFalse($this->filter->accept('orange'));
    }
}

