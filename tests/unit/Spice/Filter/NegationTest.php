<?php
namespace Spice\Filter;

class NegationTest extends \PHPUnit_Framework_TestCase {
    private function getFilterMock() {
        return $this->getMock('\\Spice\\Filter\\FilterInterface');
    }

    /**
     * @testdox O objeto é inicializado com sucesso.
     * @test
     */
    public function testInitialize() {
        $mock = $this->getFilterMock();

        $filter = new \Spice\Filter\Negation($mock);
        $this->assertAttributeSame($mock, 'realFilter', $filter);
    }

    /**
     * @testdox É possível alterar o filtro real decorado pela operação de negação.
     * @test
     */
    public function testSetAndGetRealFilter() {
        $mock1 = $this->getFilterMock();
        $mock2 = $this->getFilterMock();

        $filter = new \Spice\Filter\Negation($mock1);
        $filter->setRealFilter($mock2);
        $this->assertSame($mock2, $filter->getRealFilter());
    }

    /**
     * @testdox Nega a aceitação de valores pelo filtro real.
     * @test
     */
    public function testNegatesAccpeptanceOfValuesByTheRealFilter() {
        $value1 = 'foo';
        $value2 = 'bar';

        $mock = $this->getFilterMock();
        $mock->expects($this->at(0))
            ->method('accept')
            ->with($value1)
            ->will($this->returnValue(true));
        $mock->expects($this->at(1))
            ->method('accept')
            ->with($value2)
            ->will($this->returnValue(false));

        $filter = new \Spice\Filter\Negation($mock);

        $this->assertFalse($filter->accept($value1));
        $this->assertTrue($filter->accept($value2));
    }
}

