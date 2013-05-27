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

        $this->assertInstanceOf("\\Spice\\Routing\\RouteMatch", $this->route->match($request));
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
}
