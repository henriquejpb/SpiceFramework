<?php
namespace Spice\Filter;

class AbstractFilterTest extends \PHPUnit_Framework_TestCase {

    /**
     * @testdox O método `__invoke` apenas delega a execução ao método `accept`.
     * @test
     */
    public function testInvokeMethodDelegatesToAcceptMethod() {
        $filter = $this->getMockForAbstractClass('\\Spice\\Filter\\AbstractFilter');

        $filter->expects($this->once())
               ->method('accept')
               ->with('foo')
               ->will($this->returnValue(true));
        
        $this->assertTrue($filter('foo'));
    }
}
