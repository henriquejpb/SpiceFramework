<?php
/**
 * Define a exceção Spice_Routing_MissingRequiredParamException.
 *
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 */

/**
 * Exceção lançada quando se tenta reverter uma URL com parâmetros
 * obrigatórios sem fornecer valores para algum desses parâmetros.
 *
 * @package Routing
 */
class Spice_Routing_MissingRequiredParamException extends LogicException {

}
