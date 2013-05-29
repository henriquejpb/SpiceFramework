<?php
/**
 * Define a classe Spice\Filter\AbstractFilter.
 *
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 */
namespace Spice\Filter;

/**
 * Operações comuns para um filtro.
 * Esta classe define que o método `__invoke` irá apenas
 * delegar a execução para o método `accept`.
 * @package Filter
 */
abstract class AbstractFilter {
    /**
     * @inheritdoc
     * @see \Spice\Filter\FilterInterface::accept()
     */
    public abstract function accept($value);

    /**
     * Deleta a execução ao método `accept`, passando-lhe o mesmo 
     * argumento `$value` sem nenhum tipo de conversão ou validação.
     *
     * @return boolean Se o valor `$value` é aceito ou não.
     */
    public function __invoke($value) {
        return $this->accept($value);
    }
}
