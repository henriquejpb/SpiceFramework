<?php
/**
 * Define a interface Spice\Util\RequestInterface.
 *
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 */
namespace Spice\Util;

/**
 * Abstração para uma requisição genérica.
 *
 * @package Util
 */
interface RequestInterface {
    /**
     * Obtém a URI (Unified Resource Identifier) da requisição.
     *
     * @return string
     */
    public function getUri();

    /**
     * Estabelece a URI da requisição.
     *
     * @param string $uri Uma URI válida.
     */
    public function setUri($uri);

    /**
     * Obtém o método da requisição.
     *
     * @return string
     */
    public function getMethod();

    /**
     * Estabelece o método da requisição
     *
     * @param string $method O método da requisição.
     *
     * @return void
     */
    public function setMethod($method);

    /**
     * Retorna todos os parâmetros de Route da requisição.
     *
     * @return array<string> Uma coleção de parâmetros.
     */
    public function getRouteParams();

    /**
     * Estabelece os parâmetros de Route da requisição.
     * 
     * @param array<string> $params Uma coleção de parâmetros.
     * @return void
     */
    public function setRouteParams(array $params);

    /**
     * Remove todos os parâmetros de Route da requisição.
     * 
     * @return void
     */
    public function clearRouteParams();

    /**
     * Obtém um parâmetro de Route da requisição.
     * Se não há um parâmetro com nome `$paramName`, será retornado
     * o valor `$default`, sem qualquer conversão de tipos.
     *
     * @param string $paramName O nome do parâmetro.
     * @param mixed $default O valor padrão a ser retornado caso não exista
     *      tal parâmetro na lista de parâmetros da requisição.
     *
     * @return string|mixed O valor do parâmetro ou o valor de `$default`.
     */
    public function getRouteParam($paramName, $default = null);

    /**
     * Estabelece um parâmetro de Route da requisição.
     * Valores existentes serão sobrescritos sem nenhum tipo de aviso
     * ou exceção lançada.
     *
     * @param string $paramName O nome do parâmetro.
     * @param string $paramValue O valor do parâmetro.
     *
     * @return void
     */
    public function setRouteParam($paramName, $paramValue);

    /**
     * Remove um parâmetro de Route da requisição.
     * Se o parâmetro não existe, nenhuma ação é executada.
     *
     * @param string $paramName O nome do parâmetro.
     *
     * @return void
     */
    public function unsetRouteParam($paramName);
}

