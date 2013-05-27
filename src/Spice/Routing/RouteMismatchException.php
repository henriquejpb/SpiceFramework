<?php
/**
 * Define a exceção Spice_Route_RouteMismatchException.
 *
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 */

/**
 * Exceção lançada quando se tenta "casar" uma rota com uma requisição
 * e não há correspondêndia entre o padrão da rota e a URI da requisição.
 *
 * @package Routing
 */
class Spice_Routing_RouteMismatchException extends RuntimeException {

}
