<?php
namespace Spice\Filter;

class DisjunctionTest extends \PHPUnit_Framework_TestCase {
    private $disjunction;

    private function getLeafMock() {
        return $this->getMock('\\Spice\\Filter\\FilterInterface');
    }

    /**
     * @before
     */
    public function setUp() {
        $this->composite = new \Spice\Filter\Disjunction();
    }

    public function assertPreConditions() {
        $this->assertInstanceOf('\\Spice\\Filter\\Disjunction', $this->composite);
    }

    /**
     * @tesdox O retorno de `accept()` da disjunção contendo duas folhas que retornam `true` será `true`.
     * @test
     */
    public function testAcceptReturnTrueWithTwoLeavesReturningOnlyTrue() {
        $value = 'foo';

        $leaf1 = $this->getLeafMock();
        $leaf1->expects($this->any())
            ->method('accept')
            ->with($value)
            ->will($this->returnValue(true));

        $leaf2 = $this->getLeafMock();
        $leaf2->expects($this->any())
            ->method('accept')
            ->with($value)
            ->will($this->returnValue(true));

        $this->composite->addFilter($leaf1)
                        ->addFilter($leaf2);

        $this->assertTrue($this->composite->accept($value));
    }

    /**
     * @tesdox O retorno de `accept()` da disjunção contendo duas folhas, sendo que a primeira retorna `true` e a segunda, `false`, será `true`.
     * @test
     */
    public function testAcceptReturnTrueWithTwoLeavesFirstReturnsTrueSecondReturnsFalse() {
        $value = 'foo';

        $leaf1 = $this->getLeafMock();
        $leaf1->expects($this->any())
            ->method('accept')
            ->with($value)
            ->will($this->returnValue(true));

        $leaf2 = $this->getLeafMock();
        $leaf2->expects($this->any())
            ->method('accept')
            ->with($value)
            ->will($this->returnValue(false));

        $this->composite->addFilter($leaf1)
                        ->addFilter($leaf2);

        $this->assertTrue($this->composite->accept($value));
    }
    
    /**
     * @tesdox O retorno de `accept()` da disjunção contendo duas folhas, sendo que a primeira retorna `false` e a segunda, `true`, será `true`.
     * @test
     */
    public function testAcceptReturnTrueWithTwoLeavesFirstReturnsFalseSecondReturnsTrue() {
        $value = 'foo';

        $leaf1 = $this->getLeafMock();
        $leaf1->expects($this->any())
            ->method('accept')
            ->with($value)
            ->will($this->returnValue(false));

        $leaf2 = $this->getLeafMock();
        $leaf2->expects($this->any())
            ->method('accept')
            ->with($value)
            ->will($this->returnValue(true));

        $this->composite->addFilter($leaf1)
                        ->addFilter($leaf2);

        $this->assertTrue($this->composite->accept($value));
    }

    /**
     * @tesdox O retorno de `accept()` da disjunção contendo duas folhas que retornam `false` será `false`.
     * @test
     */
    public function testAcceptReturnTrueWithTwoLeavesReturningOnlyFalse() {
        $value = 'foo';

        $leaf1 = $this->getLeafMock();
        $leaf1->expects($this->any())
            ->method('accept')
            ->with($value)
            ->will($this->returnValue(false));

        $leaf2 = $this->getLeafMock();
        $leaf2->expects($this->any())
            ->method('accept')
            ->with($value)
            ->will($this->returnValue(false));

        $this->composite->addFilter($leaf1)
                        ->addFilter($leaf2);

        $this->assertFalse($this->composite->accept($value));
    }
    
    /**
     * @tesdox O retorno de `accept()` da disjunção contendo X > 2 folhas, onde todas, exceto uma, retornam `false` será `true`.
     * @test
     */
    public function testAcceptReturnTrueWithMultipleLeavesWhereAllReturnFalseButOne() {
        $value = 'foo';

        $aux = $this->getLeafMock();
        $aux->expects($this->any())
            ->method('accept')
            ->with($value)
            ->will($this->returnValue(true));

        $this->composite->addFilter($aux);

        for ($i = 0; $i < 5; $i++) {
            $aux = $this->getLeafMock();
            $aux->expects($this->any())
                ->method('accept')
                ->with($value)
                ->will($this->returnValue(false));

            $this->composite->addFilter($aux);
        }

        $this->assertTrue($this->composite->accept($value));
    }

}
