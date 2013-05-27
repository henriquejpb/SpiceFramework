<?php
/**
 * Define a exceção Spice\Routing\MissingRequiredParamException.
 *
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 */
namespace Spice\Routing;

/**
 * Exceção lançada quando se tenta reverter uma URL com parâmetros
 * obrigatórios sem fornecer valores para algum desses parâmetros.
 *
 * @package Routing
 */
class MissingRequiredParamException extends \LogicException {

}
