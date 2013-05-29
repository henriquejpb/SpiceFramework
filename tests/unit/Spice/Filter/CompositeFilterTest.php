<?php
namespace Spice\Filter;

class CompositeFilterTest extends \PHPUnit_Framework_TestCase {
    private $composite;

    private function getCompositeMock() {
        $args = func_get_args();
        return $this->getMockForAbstractClass('\\Spice\\Filter\\CompositeFilter', $args);
    }
    
    private function getLeafMock() {
        return $this->getMock('\\Spice\\Filter\\FilterInterface');
    }

    /**
     * @before
     */
    public function setUp() {
        $this->composite = $this->getCompositeMock();
    }

    /**
     * @testdox Adiciona um filtro à composição com sucesso.
     * @test
     */
    public function testAddFilter() {
        $mock = $this->getLeafMock();
        $this->composite->addFilter($mock);

        $this->assertCount(1, $this->composite);
    }

    /**
     * @testdox Instanciação com parâmetros no construtor adiciona filhos à composição.
     * @test
     */
    public function testInstantiateWithConstructorParametersAddsChildrenToTheComposition() {
        $this->composite = $this->getCompositeMock($this->getLeafMock(), $this->getLeafMock());
        $this->assertCount(2, $this->composite);
    }

    /**
     * @testdox Instanciação com parâmetros inválidos no construtor dispara um erro.
     * @test
     * @expectedException \PHPUnit_Framework_Error
     */
    public function testInstantiateWithConstructorInvalidParametersTriggersError() {
        $this->getCompositeMock('foo');
    }


    /**
     * @testdox Não é possível adicionar o mesmo objeto filtro à composição duas vezes.
     * @test
     * @depends testAddFilter
     */
    public function testCannotAddSameFilterObjectTwice() {
        $mock = $this->getLeafMock();
        $this->composite->addFilter($mock);

        $this->composite->addFilter($mock);
        $this->assertCount(1, $this->composite);

        $this->composite->addFilter(clone $mock);
        $this->assertCount(2, $this->composite);
    }

    /**
     * @testdox Verificar se a composição de filtros possui um determinado filtro.
     * @test
     */
    public function testHasFilter() {
        $mock = $this->getLeafMock();
        $this->composite->addFilter($mock);

        $this->assertTrue($this->composite->hasFilter($mock));
        $this->assertAttributeContains($mock, 'filters', $this->composite);

        $anotherMock = clone $mock;
        $this->assertFalse($this->composite->hasFilter($anotherMock));
        $this->assertAttributeNotContains($anotherMock, 'filters', $this->composite);
    }

    /**
     * @testdox Remove um filtro com sucesso.
     * @test
     * @depends testAddFilter
     */
    public function testRemoveFilter() {
        $mock = $this->getLeafMock();
        $this->composite->addFilter($mock);

        $this->composite->removeFilter($mock);

        $this->assertFalse($this->composite->hasFilter($mock));
        $this->assertAttributeNotContains($mock, 'filters', $this->composite);
        $this->assertCount(0, $this->composite);
    }

    /**
     * @testdox Obtém um iterador e itera sobre seus atributos.
     * @test
     */
    public function testGetIterator() {
        $mock1 = $this->getLeafMock();
        $mock2 = $this->getLeafMock();

        $this->composite->addFilter($mock1)
                        ->addFilter($mock2);
        $this->assertCount(2, $this->composite);

        $it = $this->composite->getIterator();
        $this->assertInstanceOf('\\Iterator', $it);

        $it->rewind();
        $this->assertSame($mock1, $it->current());
        $it->next();
        $this->assertEquals($mock2, $it->current());
    }
}
