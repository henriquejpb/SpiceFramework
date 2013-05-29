<?php
/**
 * Define a classe Spice\Filter\Any.
 *
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 */
namespace Spice\Filter;

/**
 * Este filtro aceitará qualquer valor.
 * @package Filter
 */
class Any extends AbstractFilter {
    /**
     * Aceita qualquer valor.
     * 
     * @inheritdoc
     *
     * @return boolean Sempre retornará `true`.
     */
    public function accept($value) {
        return true;
    }
}
