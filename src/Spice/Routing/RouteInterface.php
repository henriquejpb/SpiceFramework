<?php
/**
 * Define a interface Spice_Routing_RouteInterface.
 *
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 */

/**
 * Abstraction for a route.
 *
 * @package Routing
 */
interface Spice_Routing_RouteInterface {
    /**
     * Tenta casar a rota com a requisição.
     *
     * @param Spice_Util_RequestInterface A requisição.
     *
     * @return Spice_Routing_RouteMatch Informações sobre a combinação
     *      da rota com a requisição.
     *
     * @throws Spice_Routing_RouteMismatchException Se a requisição não
     *      "casa" com a rota.
     */
    public function match(Spice_Util_RequestInterface $request);

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
     * @throws Spice_Routing_MissingRequiredParamException Se um parâmetro
     *      obrigatório não é fornecido e não há um valor padrão para o mesmo.
     * @throws Spice_Routing_ParamMismatchException Se algum parâmetro
     *      fornecido não atende as especificações.
     */
    public function reverse(array $params = array());

    /**
     * Estabelece os valores-padrão para os parâmetros requeridos da rota.
     *
     * @return void
     *
     * @throws Spice_Routing_ParamMismatchException Se algum parâmetro
     *      fornecido não atende as especificações.
     */
    /* public function setDefaults(array $defaults = array()); */

    /**
     * Retorna os valores-padrão para os parâmetros requeridos da rota.
     *
     * @return array<string>
     */
    /* public function getDefaults(); */

    /**
     * Retorna o nome da rota.
     *
     * @return string
     */
    /* public function getName(); */

}
