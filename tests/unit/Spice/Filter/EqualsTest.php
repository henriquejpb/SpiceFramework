<?php
namespace Spice\Filter;

class EqualsTest extends \PHPUnit_Framework_TestCase {

    private function getFilter($expected) {
        return new \Spice\Filter\Equals($expected);
    }

    /**
     * @testdox O objeto é inicializado corretamente.
     * @test
     */
    public function testInitialization() {
        $filter = $this->getFilter('foo');

        $this->assertAttributeEquals('foo', 'expected', $filter);
    }


    /**
     * @testdox É possível alterar o valor esperado pelo filtro.
     * @test
     */
    public function testSetAndGetExpectedValue() {
        $filter = $this->getFilter('foo');
        $filter->setExpected('bar');

        $this->assertEquals('bar', $filter->getExpected());
    }

    /**
     * @testdox Aceita um valor escalar idêntico ao esperado.
     * @test
     */
    public function testAcceptWithIdenticalValueWillReturnTrue() {
        $filter = $this->getFilter('expected');

        $this->assertTrue($filter->accept('expected'));
    }

    /**
     * @testdox Rejeita um valor escalar diferente do esperado.
     * @test
     */
    public function testAcceptWithDifferentScalarValueWillReturnFalse() {
        $filter = $this->getFilter('expected');

        $this->assertFalse($filter->accept('not expected'));
    }

    /**
     * @testdox Rejeita um valor escalar igual ao esperado, mas com tipo diferente.
     * @test
     */
    public function testAcceptEqualsToExpectedButWithDifferentTypeWillReturnFalse() {
        $filter = $this->getFilter('1');

        $this->assertFalse($filter->accept(1));
        $this->assertFalse($filter->accept(true));
    }

    /**
     * @testdox Rejeita array contendo valores escalares iguais ao array esperado, mas com tipos diferentes.
     * @test
     */
    public function testAcceptArrayContainingScalarValuesEqualsToExpectedButWithDifferentTypesWillReturnFalse() {
        $filter = $this->getFilter(array('1', '2'));

        $this->assertFalse($filter->accept(array('1', 2)));
    }

    /**
     * @testdox Aceita objetos diferentes contendo as mesmas propriedades com valores escalares iguais e de mesmo tipo.
     * @test
     */
    public function testAcceptDifferentInstancesWithSamePropertiesWithEqualValuesAndTypesWillReturnTrue() {
        $expected = new \StdClass();
        $expected->foo = 'bar';
        $expected->baz = '1';

        $filter = $this->getFilter($expected);

        $this->assertTrue($filter->accept(clone $expected));
    }

    /**
     * @testdox Aceita objetos diferentes contendo as mesmas propriedades com valores escalares iguais, mas de tipos diferentes.
     * @test
     */
    public function testAcceptDifferentInstancesWithSamePropertiesWithEqualValuesButDifferentTypesWillReturnTrue() {
        $expected = new \StdClass();
        $expected->foo = 'bar';
        $expected->baz = '1';

        $filter = $this->getFilter($expected);

        $value = new \StdClass();
        $value->foo = 'bar';
        $value->baz = 1;

        $this->assertTrue($filter->accept($value));
    }
}
