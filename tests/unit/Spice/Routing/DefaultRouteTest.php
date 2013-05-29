<?php 
namespace Spice\Routing;

class DefaultRouteTest extends AbstractRouteTest {
    const ROUTE_CLASS = '\\Spice\\Routing\\DefaultRoute';

    protected $defaultPattern = "/path/to/resource/{resource}";

    protected function createRoute($name, $pattern) {
        $refl = new \ReflectionClass(self::ROUTE_CLASS);
        return $refl->newInstance($name, $pattern);
    }

    private function createDefaultRoute(
        $name, 
        $pattern, 
        array $defaults = array(), 
        array $requiredMap = array()) {
        return new DefaultRoute($name, $pattern, $defaults, $requiredMap);
    }

    private function invokeInvisibleMethod($obj, $methodName, array $args = array()) {
        
        $method = new \ReflectionMethod(
            self::ROUTE_CLASS, $methodName
        );
        $method->setaccessible(true);
        return $method->invokeArgs($obj, $args);
    }

    /**
     * @testdox O parser de parâmetros funciona corretamente (para 1 e 2 parâmetros).
     * @test
     */
    public function testParamParsingFromPattern() {
        $params = array('resource');

        $this->assertAttributeEquals($params, 'paramList', $this->route);

        $newPattern = '/path/to/{another}/{resource}';
        $params = array('another', 'resource');

        $this->route->setMatchPattern($newPattern);

        $this->assertAttributeEquals($params, 'paramList', $this->route);
    }
   
    /**
     * @testdox O método `getParamList` funciona corretamente.
     * @test
     */
    public function testGetParamlist() {
        $this->assertEquals(array('resource'), $this->route->getParamList());
    }

    /**
     * @testdox A obrigatoriedade dos parâmetros é resetada com sucesso.
     * @test
     */
    public function testResetParamsRequiredMap() {
        $this->route->setParamRequired('resource', false);

        $this->invokeInvisibleMethod($this->route, 'resetParamsRequiredMap');

        $this->assertAttributeEquals(array('resource' => true), 'required', $this->route);
    }

    /**
     * @testdox Invalidação do cache da expressão regular da rota.
     * @test
     */
    public function testInvalidateMatchRegex() {
        $this->invokeInvisibleMethod($this->route, 'invalidateMatchRegex');

        $this->assertAttributeSame(null, 'matchRegex', $this->route);
    }

    /**
     * @testdox A expressão regular para "casar" com a url está correta.
     * @test
     */
    public function testGetMatchRegex() {
        /* /path/to/resource/{resource} */
        $expected = "#^/path/to/resource/(?<resource>[^/]+)$#";
        $actual = $this->invokeInvisibleMethod($this->route, 'getMatchRegex');       

        $this->assertEquals($expected, $actual);
        $this->assertAttributeEquals($expected, 'matchRegex', $this->route);

        $this->route->setMatchPattern("/foo/{bar}/{baz}");

        $expected = "#^/foo/(?<bar>[^/]+)/(?<baz>[^/]+)$#";
        $actual = $this->invokeInvisibleMethod($this->route, 'getMatchRegex');       

        $this->assertEquals($expected, $actual);
        $this->assertAttributeEquals($expected, 'matchRegex', $this->route);
    }

    /**
     * @testdox A expressão regular para "casar" com a url está correta, mesmo utilizando parâmetros opcionais.
     * @test
     */
    public function testMakeRegexWithOptionalParams() {
        $newPattern = '/path/to/{another}/{resource}';
        $this->route->setMatchPattern($newPattern);
        $this->route->setParamRequired('resource', false);

        $expected = "#^/path/to/(?<another>[^/]+)(?:/(?<resource>[^/]+))?$#";
        $actual = $this->invokeInvisibleMethod($this->route, 'getMatchRegex');       

        $this->assertEquals($expected, $actual);

        $this->route->setParamRequired('another', false);

        $expected = "#^/path/to(?:/(?<another>[^/]+))?(?:/(?<resource>[^/]+))?$#";
        $actual = $this->invokeInvisibleMethod($this->route, 'getMatchRegex');       

        $this->assertEquals($expected, $actual);
    }

    /**
     * @testdox Instanciação com parâmetros-padrão de rota feita com sucesso.
     * @test
     * @outputBuffering enabled
     */
    public function testInstantiateWithDefaultParams() {
        $defaults = array("resource" => "foo");
        $route = $this->createDefaultRoute(
            $this->defaultName,
            $this->defaultPattern,
            $defaults
        );
 
        $this->assertAttributeEquals($defaults, 'defaults', $route);
        $this->assertAttributeEquals(array('resource' => true), 'required', $route);
    }

    /**
     * @testdox Instanciação com parâmetros-padrão de rota e obrigatórios feita com sucesso.
     * @test
     */
    public function testInstantiateWithDefaultParamsAndRequiredMap() {
        $defaults = array("resource" => "foo");
        $required = array("resource" => false);

        $route = $this->createDefaultRoute(
            $this->defaultName,
            $this->defaultPattern,
            $defaults,
            $required
        );
 
        $this->assertAttributeEquals($defaults, 'defaults', $route);
        $this->assertAttributeEquals($required, 'required', $route);
    }

    /**
     * @testdox Modificar todos os parâmetros-padrão da rota.
     * @test
     */
    public function testSetAndGetDefaultParams() {
        $defaults = array('resource' => 'foo');
        $this->route->setDefaults($defaults);

        $this->assertAttributeEquals($defaults, 'defaults', $this->route);
        $this->assertEquals($defaults, $this->route->getDefaults());
    }
    
    /**
     * @testdox Modificar o mapeamento dos parâmetros obrigatórios.
     * @test
     */
    public function testSetAndGetParamsRequiredMap() {
        $map = array('resource' => false);
        $this->route->setParamsRequiredMap($map);
        $this->assertEquals($map, $this->route->getParamsRequiredMap());

        $this->route->setMatchPattern('/foo/{bar}/{baz}');
        $this->assertEquals(
            array('bar' => true, 'baz' => true),
            $this->route->getParamsRequiredMap()
        );
    }

    /**
     * @testdox Modificar um parâmetro padrão da rota.
     * @test
     */
    public function testSetAndGetSingleDefaultParam() {
        $paramName = 'resource';
        $paramValue = 'foo';
        $this->route->setDefaultParam($paramName, $paramValue);

        $this->assertAttributeEquals(array($paramName => $paramValue), 'defaults', $this->route);
        $this->assertEquals($paramValue, $this->route->getDefaultParam($paramName));
    }

    /**
     * @testdox Modificar a obrigatoriedade de um parâmetro.
     * @test
     */
    public function testSetAndVerifyParamRequired() {
        $this->route->setMatchPattern('/foo/{bar}/{baz}');
        $paramName = 'baz';
        $paramValue = false;
        $this->route->setParamRequired($paramName, $paramValue);

        $this->assertEquals(
            $paramValue,
            $this->route->isParamRequired($paramName)
        );
    }

    /**
     * @testdox Modificar obrigatoriedade de parâmetro inexistente não executa nenhuma ação.
     * @test
     */
    public function testSetAndVerifyInexistentParamRequired() {
        $paramName = 'foo';
        $paramValue = true;
        $this->route->setParamRequired($paramName, $paramValue);

        $this->assertEquals(
            false,
            $this->route->isParamRequired($paramName)
        );
    }

    /**
     * @testdox Constrói uma URL com base nos parâmetros pasados.
     * @test
     */
    public function testReverseUrl() {
        $expected = "/path/to/resource/foo";
        $actual = $this->route->reverse(array('resource' => 'foo'));

        $this->assertEquals($expected, $actual);
    }


    /**
     * @testdox Constrói uma URL com parâmetros opcionais.
     * @test
     */
    public function testReverseUrlWithOptionalParameters() {
        $expected = "/path/to/resource";
        $this->route->setParamRequired('resource', false);

        $actual = $this->route->reverse();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @testdox Tenta construir uma URI com parâmetros obrigatórios faltando.
     * @expectedException \Spice\Routing\MissingRequiredParamException
     * @test
     */
    public function testReverseUriWithMissingMandatoryParameters() {
        $actual = $this->route->reverse();
    }

    /**
     * @testdox Constrói uma URI com parâmetros opcionais.
     * @test
     */
    public function testReverseUriWithDefaultValuesForMandatoryParameters() {
        $expected = "/path/to/resource/foo";
        $this->route->setDefaults(array('resource' => 'foo'));

        $actual = $this->route->reverse();

        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @testdox Realiza o "casamento" da rota com uma requisição com sucesso.
     * @test
     */
    public function testSuccessfullyMatchRequestUri() {
        $uri = "/path/to/resource/foo";

        $request = $this->getRequestMock();
        $request->expects($this->once())
                 ->method('getUri')
                 ->will($this->returnValue($uri));

        $match = $this->route->match($request);
        $this->assertInstanceOf('\\Spice\\Routing\\RouteMatch', $match);
        $this->assertArrayHasKey('resource', $match->getParams());
        $this->assertContains('foo', $match->getParams());
    }

    /**
     * @testdox O "casamento" da rota com uma requisição falhará.
     * @test
     * @expectedException \Spice\Routing\RouteMismatchException
     */
    public function testMismatchRequestUri() {
        $uri = "/path/to/another/foo";

        $request = $this->getRequestMock();
        $request->expects($this->once())
                 ->method('getUri')
                 ->will($this->returnValue($uri));

        $match = $this->route->match($request);
    }

    /**
     * @testdox Realiza o casamento da rota com uma requisição vários parâmetros.
     * @test
     */
    public function testSuccessfullyMatchRequestUriMultipleParameters() {
        $this->route->setMatchPattern('/foo/{bar}/{baz}');
        $uri = "/foo/a/b";

        $request = $this->getRequestMock();
        $request->expects($this->once())
                 ->method('getUri')
                 ->will($this->returnValue($uri));

        $match = $this->route->match($request);
        $this->assertInstanceOf('\\Spice\\Routing\\RouteMatch', $match);
        $this->assertArrayHasKey('bar', $match->getParams());
        $this->assertArrayHasKey('baz', $match->getParams());
        $this->assertContains('a', $match->getParams());
        $this->assertContains('b', $match->getParams());
    }

    /**
     * @testdox Realiza o casamento da rota contendo um parâmetro opcional com uma requisição.
     * @test
     */
    public function testSuccessfullyMatchRequestUriWithOptionalParameter() {
        $this->route->setMatchPattern('/foo/{bar}/{baz}');
        $this->route->setParamRequired('baz', false);

        $uri = "/foo/a";

        $request = $this->getRequestMock();
        $request->expects($this->once())
                 ->method('getUri')
                 ->will($this->returnValue($uri));

        $match = $this->route->match($request);
        $this->assertInstanceOf('\\Spice\\Routing\\RouteMatch', $match);
        $this->assertArrayHasKey('bar', $match->getParams());
        $this->assertArrayNotHasKey('baz', $match->getParams());
        $this->assertContains('a', $match->getParams());
    }

    /**
     * @testdox Realiza o casamento da rota contendo mais de um parâmetro opcional com uma requisição.
     * @test
     */
    public function testSuccessfullyMatchRequestUriWithMultipleOptionalParameters() {
        $this->route->setMatchPattern('/foo/{bar}/{baz}');
        $this->route->setParamRequired('baz', false);
        $this->route->setParamRequired('bar', false);

        $uri = "/foo";
        
        $request = $this->getRequestMock();
        $request->expects($this->once())
                 ->method('getUri')
                 ->will($this->returnValue($uri));

        $match = $this->route->match($request);
        $this->assertInstanceOf('\\Spice\\Routing\\RouteMatch', $match);
        $this->assertArrayNotHasKey('bar', $match->getParams());
        $this->assertArrayNotHasKey('baz', $match->getParams());
    }

    /**
     * @testdox Realiza o casamento da rota contendo um parâmetro opcional no meio da URI sem que o mesmo exista nesta.
     * @test
     */
    public function testSuccessfullyMatchRequestUriWithOptionalParameterInTheMiddleOfTheUri() {
        $this->route->setMatchPattern('/foo/{bar}/{baz}');
        $this->route->setParamRequired('bar', false);

        $uri = "/foo/a";
        
        $request = $this->getRequestMock();
        $request->expects($this->once())
                 ->method('getUri')
                 ->will($this->returnValue($uri));

        $match = $this->route->match($request);
        $this->assertInstanceOf('\\Spice\\Routing\\RouteMatch', $match);
        $this->assertEquals('a', $match['baz']);
        $this->assertArrayNotHasKey('bar', $match->getParams());
    }


    /**
     * @testdox Realiza o casamento da rota contendo um parâmetro opcional no meio da URI sem que o mesmo exista nesta, mas possui valor padrão.
     * @test
     */
    public function testSuccessfullyMatchRequestUriWithOptionalParameterInTheMiddleOfTheUriWithDefaultValue() {
        $this->route->setMatchPattern('/foo/{bar}/{baz}');
        $this->route->setParamRequired('bar', false);
        $this->route->setDefaults(array('bar' => 'b'));

        $uri = "/foo/a";
        
        $request = $this->getRequestMock();
        $request->expects($this->once())
                 ->method('getUri')
                 ->will($this->returnValue($uri));

        $match = $this->route->match($request);
        $this->assertInstanceOf('\\Spice\\Routing\\RouteMatch', $match);
        $this->assertEquals(array('baz' => 'a', 'bar' => 'b'), $match->getParams());
    }

    /**
     * @testdox Verifica se um parâmetro padrão não presente do padrão de combinação da rota é incluído nas informações da combinação com a requisição.
     */
    public function testDefaultParamNotInRoutePatternIncludedAsRouteMatchParam() {
        $uri = "/path/to/resource/foo";
        
        $request = $this->getRequestMock();
        $request->expects($this->once())
                 ->method('getUri')
                 ->will($this->returnValue($uri));

        $this->route->setDefaultParam('controller', 'bar');

        $match = $this->route->match($request);

        $this->assertInstanceOf('\\Spice\\Routing\\RouteMatch', $match);
        $this->assertEquals(array('resource' => 'foo', 'controller' => 'bar'), $match->getParams());
    }
}
