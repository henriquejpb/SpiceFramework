<?php
/**
 * Define a classe Spice\Filter\Disjunction.
 *
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 */
namespace Spice\Filter;

/**
 * Este filtro fará uma disjunção entre o retorno de cada um de seus filhos.
 */
class Disjunction extends CompositeFilter {
    /**
     * Retornará `true` se ao menos um dos seus filhos retornar `true`.
     * 
     * **IMPORTANTE:** Caso o objeto não possua nenhum filho, 
     * o retorno será `false`.
     *
     * @inherit-doc
     *
     * @return boolean Uma disjunção entre o retorno dos filhos do objeto.
     */
    public function accept($value) {
        foreach ($this->getIterator() as $leaf) {
            if ($leaf->accept($value)) {
                return true;
            }
        }
        return false;
    }
}
