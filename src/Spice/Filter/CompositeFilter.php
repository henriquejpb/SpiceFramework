<?php
/**
 * Define a classe Spice\Filter\CompositeFilter.
 *
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 */
namespace Spice\Filter;

/**
 * Representa uma composição de diversos filtros.
 * @package Filter
 */
abstract class CompositeFilter extends AbstractFilter implements \Countable, \IteratorAggregate {
    /**
     * @var array $filters Uma coleção de filtros.
     */
    private $filters = array();

    /**
     * Inicializa uma composição de filtros.
     *
     * Pode-se passar um número qualquer de instâncias de `\Spice\Filter\FilterInterface`,
     * as quais serão adicionadas à coleção de filtros da composição.
     *
     * @param \Spice\Filter\FilterInterface $filter1, $filer2, ...
     */
    public function __construct(FilterInterface $filter1 = null) {
        $args = func_get_args();
        foreach ($args as $filter) {
            $this->addFilter($filter);
        }
    }

    /**
     * Adiciona um filtro à composição.
     *
     * @param \Spice\Filter\FilterInterface $filter Uma instância de um filtro.
     *
     * @return \Spice\Filter\CompositeFilter Fluent interface
     */
    public function addFilter(FilterInterface $filter) {
        if (!$this->hasFilter($filter)) {
            $this->filters[] = $filter;
        }
        return $this;
    }

    /**
     * Remove um filtro da composição.
     *
     * @param \Spice\Filter\FilterInterface $filter Uma instância de um filtro.
     *
     * @return \Spice\Filter\CompositeFilter Fluent interface
     */
    public function removeFilter(FilterInterface $filter) {
        if (($pos = array_search($filter, $this->filters)) !== false) {
            unset($this->filters[$pos]);
            $this->filters = array_values($this->filters);
        }
        return $this;
    }

    /**
     * Verifica se a composição possui o filtro `$filter`;
     *
     * **IMPORTANTE:** A comparação é feita com o operador de identidade,
     * ou seja, só retornará `true` se encontrar um objeto que seja a mesma
     * instância `$filter`.
     *
     * @param \Spice\Filter\FilterInterface $filter Uma instância de um filtro.
     *
     * @return boolean
     */
    public function hasFilter(FilterInterface $filter) {
        return in_array($filter, $this->filters, true);
    }

    /**
     * Implementação da interface `\Countable`.
     *
     * @return int O número de filtros na composição.
     *
     * @see \Countable
     */
    public function count() {
        return count($this->filters);
    }

    /**
     * Implementação da interface `\IteratorAggregate`.
     *
     * @return \Iterator Uma instância de iterador.
     *
     * @see \IteratorAggregate
     */
    public function getIterator() {
        return new \ArrayIterator($this->filters);
    }
}
