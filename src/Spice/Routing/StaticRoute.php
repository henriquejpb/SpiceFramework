<?php
/**
 * Define a classe Spice\Routing\StaticRoute.
 *
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 */
namespace Spice\Routing;

use Spice\Http\RequestInterface;

/**
 * Representa uma rota estática.
 * Rotas estáticas mapeiam arquivos estáticos.
 *
 * @package Routing
 */
class StaticRoute extends AbstractRoute {
    /**
     * @inheritdoc
     *
     * @see \Spice\Routing\RouteInterface::reverse()
     */
    public function reverse(array $params = array()) {
        return $this->getMatchPattern();
    }

    /**
     * @inheritdoc
     *
     * @see \Spice\Routing\RouteInterface::match()
     */
    public function match(RequestInterface $request) {
        if ($request->getUri() === $this->getMatchPattern()) {
            return new \Spice\Routing\RouteMatch($this->getName(), $this->getDefaults());
        }
        throw new \Spice\Routing\RouteMismatchException(
            "A rota {$this->getName()} não combina com a requisição."
        );
    }
}
