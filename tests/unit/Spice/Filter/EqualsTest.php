<?php
namespace Spice\Filter;

class EqualsTest extends \PHPUnit_Framework_TestCase {
    /**
     * @testdox Aceita um valor escalar idêntico ao esperado.
     * @test
     */
    public function testAcceptWithIdenticalValueWillReturnTrue() {
        $filter = new \Spice\Filter\Equals('expected');

        $this->assertTrue($filter->accept('expected'));
    }

    /**
     * @testdox Rejeita um valor escalar diferente do esperado.
     * @test
     */
    public function testAcceptWithDifferentScalarValueWillReturnFalse() {
        $filter = new \Spice\Filter\Equals('expected');

        $this->assertFalse($filter->accept('not expected'));
    }

    /**
     * @testdox Rejeita um valor escalar igual ao esperado, mas com tipo diferente.
     * @test
     */
    public function testAcceptEqualsToExpectedButWithDifferentTypeWillReturnFalse() {
        $filter = new \Spice\Filter\Equals('1');

        $this->assertFalse($filter->accept(1));
        $this->assertFalse($filter->accept(true));
    }

    /**
     * @testdox Rejeita array contendo valores escalares iguais ao array esperado, mas com tipos diferentes.
     * @test
     */
    public function testAcceptArrayContainingScalarValuesEqualsToExpectedButWithDifferentTypesWillReturnFalse() {
        $filter = new \Spice\Filter\Equals(array('1', '2'));

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

        $filter = new \Spice\Filter\Equals($expected);

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

        $filter = new \Spice\Filter\Equals($expected);

        $value = new \StdClass();
        $value->foo = 'bar';
        $value->baz = 1;

        $this->assertTrue($filter->accept($value));
    }
}
