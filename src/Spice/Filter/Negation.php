<?php
/**
 * Define a classe Spice\Filter\Negation.
 *
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 */
namespace Spice\Filter;

/**
 * Este filtro negará a aceitação de qualquer valor pelo filtro interno.
 * @package Filter
 */
class Negation extends AbstractFilter {
    /**
     * @var \Spice\Filter\FilterInterface O filtro real.
     */
    private $realFilter;

    /**
     * Inicializa um filtro que negará (operação booleana) a aceitação de 
     * qualquer valor pelo filtro real.
     *
     * @param \Spice\Filter\FilterInterface O filtro real.
     */
    public function __construct(FilterInterface $realFilter) {
        $this->realFilter = $realFilter;
    }

    /**
     * Estabelece o filtro real.
     *
     * @param \Spice\Filter\FilterInterface O filtro real.
     * @return \Spice\Filter\Negation Fluent interface.
     */
    public function setRealFilter(FilterInterface $realFilter) {
        $this->realFilter = $realFilter;
        return $this;
    }

    /**
     * Obtém o filtro real.
     *
     * @return \Spice\Filter\FilterInterface O filtro real.
     */
    public function getRealFilter() {
        return $this->realFilter;
    }

    /**
     * Nega a aceitação de qualquer valor pelo filtro real.
     * 
     * @inheritdoc
     *
     * @return boolean A negação (booleana) da aceitação do valor
     *      pelo filtro real.
     */
    public function accept($value) {
        return !$this->realFilter->accept($value);
    }
}
