<?php
namespace Spice\Filter;

class AnyTest extends \PHPUnit_Framework_TestCase {
    /**
     * @testdox Aceita uma série de valores de diversos tipos.
     * @test
     */
    public function testAcceptVariousTypesOfArguments() {
        $filter = new \Spice\Filter\Any();

        $this->assertTrue($filter->accept(null));
        $this->assertTrue($filter->accept(true));
        $this->assertTrue($filter->accept(false));
        $this->assertTrue($filter->accept('string'));
        // Integer 0
        $this->assertTrue($filter->accept(0));
        // Negative integer
        $this->assertTrue($filter->accept(-1));
        // Maximum integer
        $this->assertTrue($filter->accept(PHP_INT_MAX));
        // Float
        $this->assertTrue($filter->accept(.005));
        // Object
        $this->assertTrue($filter->accept(new \stdClass()));
        // Array
        $this->assertTrue($filter->accept(array()));
    }
}
