<?php
namespace Spice\Filter;

class RegexTest extends \PHPUnit_Framework_TestCase {
    private $regex;

    private function createFilter($pattern) {
        $this->regex = new \Spice\Filter\Regex($pattern);
    }
    
    /**
     * @testdox É possível alterar a expressão regular do filtro.
     * @test
     */
    public function testSetAndGetPattern() {
        $this->createFilter('/^\d+$/');
        $newPattern = '/^\w+$/';
        $this->regex->setPattern($newPattern);
        $this->assertEquals($newPattern, $this->regex->getPattern());
    }

    /**
     * @testdox Um valor válido é aceito.
     * @test
     */
    public function testAcceptWithValidValue() {
        $this->createFilter('/^\d+$/');
        $this->assertTrue($this->regex->accept(10));
    }
    
    /**
     * @testdox Um valor inválido não é aceito.
     * @test
     */
    public function testAcceptWithInvalidValue() {
        $this->createFilter('/^\d+$/');
        $this->assertFalse($this->regex->accept('foo'));
    }
}
