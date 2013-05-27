<?php
class Spice_Routing_StaticRouteTest extends Spice_Routing_AbstractRouteTest {

    protected function createRoute($name, $matchPattern) {
        return new Spice_Routing_StaticRoute($name, $matchPattern);
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

        $this->assertInstanceOf("Spice_Routing_RouteMatch", $this->route->match($request));
    }

    /**
     * @testdox Quando a rota não "casa" com a requisição, uma exceção será lançada.
     * @test
     * @expectedException Spice_Routing_RouteMismatchException
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
