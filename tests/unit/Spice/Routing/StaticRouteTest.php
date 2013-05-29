<?php
namespace Spice\Routing;

class StaticRouteTest extends AbstractRouteTest {

    protected function createRoute($name, $matchPattern) {
        return new StaticRoute($name, $matchPattern);
    }
    
    /**
     * @testdox É possível fazer o roteamento reverso.
     * @test
     */
    public function testReverse() {
        $this->assertEquals($this->defaultPattern, $this->route->reverse());
    }

    /**
     * @testdox É possível "casar" a rota com uma requisição.
     * @test
     */
    public function testMatchOk() {
        $uri = $this->defaultPattern;
        $request = $this->getRequestMock();
        $request->expects($this->once())
                 ->method('getUri')
                 ->will($this->returnValue($uri));

        $match = $this->route->match($request);

        $this->assertInstanceOf("\\Spice\\Routing\\RouteMatch", $match);
        $this->assertEquals($this->route->getName(), $match->getRouteName());
    }

    /**
     * @testdox Quando a rota não "casa" com a requisição, uma exceção será lançada.
     * @test
     * @expectedException \Spice\Routing\RouteMismatchException
     */
    public function testMatchFails() {
        $uri = "/some/another/path";

        $request = $this->getRequestMock();
        $request->expects($this->once())
                 ->method('getUri')
                 ->will($this->returnValue($uri));

        $this->route->match($request);
    }

    /**
     * @testdox Parâmetros padrão da rota são incluídos no objeto RouteMatch resultante da combinação.
     * @test
     * @depends testMatchOk
     */
    public function testReturnMatchWithDefaultParams() {
        $uri = $this->defaultPattern;

        $request = $this->getRequestMock();
        $request->expects($this->once())
                 ->method('getUri')
                 ->will($this->returnValue($uri));

        $controller = array('controller' => 'bar');
        $action = array('action' => 'foo');
        $this->route->setDefaults($controller);
        $this->route->setDefaultParam(key($action), current($action));
        
        $match = $this->route->match($request);

        $this->assertEquals($controller + $action, $match->getParams());
    }
}
