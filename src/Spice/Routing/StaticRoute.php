<?php
/**
 * Define a classe Spice_Routing_StaticRoute.
 *
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 */

/**
 * Representa uma rota estática.
 * Rotas estáticas mapeiam arquivos estáticos.
 *
 * @package Routing
 */
class Spice_Routing_StaticRoute extends Spice_Routing_AbstractRoute {
    /**
     * @inherit-doc
     *
     * @see Spice_Routing_RouteInterface::reverse()
     */
    public function reverse(array $params = array()) {
        return $this->getMatchPattern();
    }

    /**
     * @inherit-doc
     *
     * @see Spice_Routing_RouteInterface::match()
     */
    public function match(Spice_Util_RequestInterface $request) {
        if ($request->getUri() === $this->getMatchPattern()) {
            return new Spice_Routing_RouteMatch($this->getName());
        }
        throw new Spice_Routing_RouteMismatchException(
            "A rota {$this->getName()} não combina com a requisição"
        );
    }
}
