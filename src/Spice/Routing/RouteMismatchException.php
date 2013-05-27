<?php
/**
 * Define a exceção Spice\Routing\RouteMismatchException.
 *
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 */
namespace Spice\Routing;

/**
 * Exceção lançada quando se tenta "casar" uma rota com uma requisição
 * e não há correspondêndia entre o padrão da rota e a URI da requisição.
 *
 * @package Routing
 */
class RouteMismatchException extends \RuntimeException {

}
