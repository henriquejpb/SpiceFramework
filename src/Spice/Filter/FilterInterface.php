<?php
/**
 * Define a interface Spice\Filter\FilterInterface.
 *
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 */
namespace Spice\Filter;

/**
 * Abstração para um filtro de valores.
 * Define que os objetos que a implementam devem implementar
 * o método mágico `__invoke()` que permite a utilização de
 * objetos como callbacks.
 * @package Filter
 */
interface FilterInterface {
    /**
     * Verifica se um dado valor será aceito.
     *
     * @param mixed $value O valor para verificação.
     *
     * @return boolean Se o parâmetro é válido.
     */
    public function accept($value);


    /**
     * Define o comportamento do objeto quando se tenta utilizá-lo como
     * um callback.
     *
     * @param mixed $value O valor para verificação.
     *
     * @return boolean Se o parâmetro é válido.
     */
    public function __invoke($value);
}
