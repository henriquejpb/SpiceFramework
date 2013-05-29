<?php
/**
 * Define a interface Spice\Routing\RouteInterface.
 *
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 */
namespace Spice\Routing;

use Spice\Util\RequestInterface;

/**
 * Abstraction for a route.
 *
 * @package Routing
 */
interface RouteInterface {
    /**
     * Tenta combinar a rota com a requisição.
     *
     * Caso o "casamento" se realize com sucesso, retornará um objeto
     * `Spice\Routing\RouteMatch` contendo as informações sobre a
     * combinação da rota com a requisição.
     *
     * @param \Spice\Util_RequestInterface A requisição.
     *
     * @return \Spice\Routing\RouteMatch Informações sobre a combinação
     *      da rota com a requisição.
     *
     * @throws \Spice\Routing\RouteMismatchException Se a requisição não
     *      "casa" com a rota.
     */
    public function match(RequestInterface $request);

    /**
     * Constrói uma URI com base no padrão de "casamento" da rota.
     * O parâmetro `$params` deve ser um array associativo da forma
     * `nome_parametro => valor`.
     *
     * Parâmetros que não pertencem à rota são apenas ignorados.
     *
     * @param array $params [OPCIONAL] Um array associativo com parâmetros de
     *      roteamento.
     *
     * @return string
     *
     * @throws \Spice\Routing\MissingRequiredParamException Se um parâmetro
     *      obrigatório não é fornecido e não há um valor padrão para o mesmo.
     * @throws \Spice\Routing\ParamMismatchException Se algum parâmetro
     *      fornecido não atende as especificações.
     */
    public function reverse(array $params = array());

    /**
     * Retorna o nome da rota.
     *
     * @return string
     */
    public function getName();

}
