<?php
/**
 * Define a classe Spice\Filter\Conjunction.
 *
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 */
namespace Spice\Filter;

/**
 * Este filtro fará uma disjunção entre o retorno de cada um de seus filhos.
 */
class Conjunction extends CompositeFilter {
    /**
     * Retornará `true` se todos os seus filhos retornarem `true`.
     * 
     * **IMPORTANTE:** Caso o objeto não possua nenhum filho, 
     * o retorno será `false`.
     *
     * @inherit-doc
     *
     * @return boolean Uma conjunção entre o retorno dos filhos do objeto.
     */
    public function accept($value) {
        foreach ($this->getIterator() as $leaf) {
            if (!$leaf->accept($value)) {
                return false;
            }
        }
        return $this->count() > 0;
    }
}
