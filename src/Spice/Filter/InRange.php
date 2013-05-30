<?php
/**
 * Define a classe Spice\Filter\InRange.
 *
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 */
namespace Spice\Filter;

/**
 * Este filtro aceitará apenas valores pertencentes a um intervalo.
 * Os intervalos são inclusivos, ou seja, os limites do intervalo também
 * são valores válidos.
 *
 * Este filtro funciona bem para intervalos de inteiros e strings.
 * Outros tipos de dados, como números de ponto flutuante, podem ter
 * comportamentos incertos devido à sua natureza.
 *
 * @package Filter
 */
class InRange extends AbstractFilter {

    private $start;
    private $end;

    public function __construct($start, $end) {
        $this->setRange($start, $end);
    }

    public function setRange($start, $end) {
        if ($end < $start) {
            throw new \LogicException(
                "O intervalo [{$start}, {$end}] é inválido, 
                 o início não pode ser maior que o fim"
            );
        }

        $this->start = $start;
        $this->end = $end;
    }

    public function setRangeStart($start) {
        $this->setRange($start, $this->end);
    }

    public function getRangeStart() {
        return $this->start;
    }

    public function setRangeEnd($end) {
        $this->setRange($this->start, $end);
    }

    public function getRangeEnd() {
        return $this->end;
    }

    public function accept($value) {
        return ($value <= $this->end && $value >= $this->start);
    }
}
