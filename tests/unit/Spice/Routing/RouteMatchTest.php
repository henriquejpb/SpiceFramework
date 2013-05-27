<?php
namespace Spice\Routing;

class RouteMatchTest extends \PHPUnit_Framework_TestCase {

    private function createRouteMatch($routeName, array $params = array()) {
        return new RouteMatch($routeName, $params);
    }

    /**
     * @testdox Testa se é possível criar uma instância do objeto.
     * @test
     */
    public function testCreateInstance() {
        $match = $this->createRouteMatch('foo'); 
        $this->assertInstanceOf('\\Spice\\Routing\\RouteMatch', $match);
    }

    /**
     * @testdox Testa se os parâmetros da rota correspondente são corretamente armazenados.
     * @test
     */
    public function testGetParams() {
        $params = array('param1' => 'value1');
        $match = $this->createRouteMatch('foo', $params);
        $this->assertAttributeEquals($params, 'params', $match);
        $this->assertEquals($params, $match->getParams());
    }

    /**
     * @testdox Testa um parâmetro da rota correspondente está corretamente armazenado.
     * @test
     */
    public function testGetExistentParam() {
        $params = array('param1' => 'value1');
        $match = $this->createRouteMatch('foo', $params);
        $this->assertArrayHasKey('param1', $match->getParams());
        $this->assertEquals($params['param1'], $match->getParam('param1'));
        $this->assertEquals($params['param1'], $match['param1']);
        $this->assertEquals($params['param1'], $match->getParam('param1', 'defaultValue'));
    }

    /**
     * @testdox Testa se o retorno do método `getParam` será o mesmo que 
     *      o passado como seu parâmetro `$default`.
     * @test
     */
    public function testGetInexistentParam() {
        $params = array('param1' => 'value1');
        $default = 'value2';
        $match = $this->createRouteMatch('foo', $params);

        $this->assertNull($match->getParam('param2'));
        $this->assertEquals($default, $match->getParam('param2', $default));
    }

    /**
     * @testdox Testa o método `setParam` funciona adequadamente tanto para 
     *      novos parâmetros quanto para existentes.
     * @test
     */
    public function testSetParams() {
        $paramName = 'param1';
        $params = array($paramName => 'value1');
        $match = $this->createRouteMatch('foo', $params);

        $newParamValue = 'baz';

        $match->setParam($paramName, $newParamValue);

        $this->assertEquals($newParamValue, $match->getParam($paramName));
        $this->assertEquals($newParamValue, $match->getParam($paramName, 'defaultValue'));

        $newParamName = 'param2';
        $newParamValue = 'value2';

        $match[$newParamName] = $newParamValue;

        $this->assertArrayHasKey($newParamName, $match->getParams());
        $this->assertEquals($newParamValue, $match->getParam($newParamName));
        $this->assertEquals($newParamValue, $match->getParam($newParamName, 'defaultValue'));
    }

    /**
     * @testdox Testa a remoção de um parâmetro.
     * @test
     */
    public function testUnsetParam() {
        $paramName = 'param1';
        $paramName2 = 'param2';
        $params = array($paramName => 'value1', $paramName2 => 'value2');
        $match = $this->createRouteMatch('foo', $params);

        $match->unsetParam($paramName);
        $this->assertArrayNotHasKey($paramName, $match->getParams());
        $this->assertNull($match->getParam($paramName));

        unset($match[$paramName2]);
        $this->assertNull($match->getParam($paramName2));
    }

    /**
     * @testdox Testa se um parâmetro existe.
     * @test
     */
    public function testIssetParam() {
        $paramName = 'param1';
        $params = array($paramName => 'value1');
        $match = $this->createRouteMatch('foo', $params);

        $this->assertTrue(isset($match[$paramName]));
    }

    /**
     * @testdox Testa se o nome da rota correspondente está correto.
     * @test
     */
    public function testGetRouteName() {
        $name = 'foo';
        $match = $this->createRouteMatch($name);

        $this->assertAttributeEquals($name, 'routeName', $match);
        $this->assertEquals($name, $match->getRouteName());
    }

    /**
     * @testdox Testa se altera-se corretamente o nome da rota correspondente.
     * @test
     */
    public function testSetRouteName() {
        $name = 'foo';
        $match = $this->createRouteMatch($name);
        $newName = 'bar';

        $match->setRouteName($newName);

        $this->assertAttributeEquals($newName, 'routeName', $match);
        $this->assertEquals($newName, $match->getRouteName());
    }
}
