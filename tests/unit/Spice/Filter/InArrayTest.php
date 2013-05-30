<?php
namespace Spice\Filter;

class InArrayTest extends \PHPUnit_Framework_TestCase {
    public function getFilter(array $allowed) {
        return new \Spice\Filter\InArray($allowed);
    }

    /**
     * @testdox Filtro é inicializado com sucesso.
     * @test
     */
    public function testSuccessfullyInitialized() {
        $allowed = array('foo', 'bar', 'baz');
        $filter = $this->getFilter($allowed);

        $this->assertAttributeEquals($allowed, 'allowed', $filter);
    }

    /**
     * @testdox Valores repetidos na lista de valores permitidos pelos filtro são removidos.
     * @test
     */
    public function testRepeatedAllowedValuesAreRemoved() {
        $allowed = array('foo', 'bar', 'foo', 'baz', 'baz');
        $filter = $this->getFilter($allowed);

        $this->assertAttributeCount(3, 'allowed', $filter);
    }
    
    /**
     * @testdox Valores repetidos -- mas com tipos diferentes -- na lista de valores permitidos pelos filtro são mantidos.
     * @test
     */
    public function testRepeatedButWithDifferentTypesAllowedValuesAreKept() {
        $allowed = array(false, 0, null, '0');
        $filter = $this->getFilter($allowed);

        $this->assertAttributeEquals($allowed, 'allowed', $filter);
        $this->assertAttributeCount(4, 'allowed', $filter);
    }

    /**
     * @testdox É possível alterar os valores permitidos pelo filtro.
     * @test
     */
    public function testSetAndGetAllowedValues() {
        $filter = $this->getFilter(array('foo', 'bar', 'baz'));
        
        $allowed = array('bar', 'bazzinga');
        $filter->setAllowedValues($allowed);

        $this->assertEquals($allowed, $filter->getAllowedValues());
    }

    /**
     * @testdox O método `accept` retorna `true` quando um valor dentre os permitidos é fornecido.
     * @test
     */
    public function testAcceptWithValidValueReturnsTrue() {
        $filter = $this->getFilter(array('foo', 'bar', 'baz'));
        $this->assertTrue($filter->accept('foo'));
    }

    /**
     * @testdox O método `accept` retorna `false` quando um valor fora dos permitidos é fornecido.
     * @test
     */
    public function testAcceptWithInvalidValueReturnsFalse() {
        $filter = $this->getFilter(array('foo', 'bar', 'baz'));
        $this->assertFalse($filter->accept('bazzinga'));
    }
    
    /**
     * @testdox Variável de tipo diferente dos valores aceitáveis não é aceita (comapração estrita),
     * @test
     */
    public function testAccpetWillReturnFalseIfValueTypeIsDifferentFromAllowedValues() {
        $filter = $this->getFilter(array(1, 10, 100));
        $this->assertTrue($filter->accept(1));
        $this->assertFalse($filter->accept('1'));
    }
}
