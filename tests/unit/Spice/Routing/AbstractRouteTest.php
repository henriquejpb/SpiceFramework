<?php
abstract class Spice_Routing_AbstractRouteTest extends PHPUnit_Framework_TestCase {

    abstract protected function createRoute($name, $matchPattern);
    protected $defaultName = "my_route";
    protected $defaultPattern = "/path/to/resource";
    protected $route;

    protected function getRequestMock() {
        return $this->getMock('Spice_Util_RequestInterface');
    }

    /**
     * @before
     */
    public function setUp() {
        $this->route = $this->createRoute($this->defaultName, $this->defaultPattern);
    }

    /**
     * @testdox É possível instanciar o objeto.
     * @test
     */
    public function testInstantiate() {
        $this->assertInstanceOf("Spice_Routing_AbstractRoute", $this->route);

    }

    /**
     * @testdox Os valores iniciais para os atributos da classe estão corretos.
     * @test
     */
    public function testInitialValuesForNameAndPattern() {
        $this->assertAttributeEquals($this->defaultName, 'name', $this->route);
        $this->assertAttributeEquals($this->defaultPattern, 'matchPattern', $this->route);
    }


    /**
     * @testdox É possível alterar o padrão de "casamento" da rota depois de instanciar o objeto.
     * @test
     */
    public function testSetAndGetMatchPatternAfterInstantiate() {
        $newPattern = "/another/path";
        $this->route->setMatchPattern($newPattern);
        $this->assertAttributeEquals($newPattern, 'matchPattern', $this->route);
        $this->assertEquals($newPattern, $this->route->getMatchPattern());
    }

    /**
     * @testdox O caracter `/` do final do padrão é removido.
     * @test
     */
    public function testSetAndGetMatchPatternWithTrailingDirectorySeparator() {
        $newPattern = "/another/path//";
        $expected = "/another/path";

        $this->route->setMatchPattern($newPattern);

        $this->assertAttributeEquals($expected, 'matchPattern', $this->route);
        $this->assertEquals($expected, $this->route->getMatchPattern());
    }

    /**
     * @testdox O método `getName` funciona.
     * @test
     */
    public function testGetName() {
        $this->assertEquals($this->defaultName, $this->route->getName());
    }
}
