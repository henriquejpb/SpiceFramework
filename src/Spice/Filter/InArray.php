<?php
/**
 * Define a classe Spice\Filter\InArray.
 *
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 */
namespace Spice\Filter;

/**
 * Este filtro aceitará apenas valores pertencentes a um conjunto predefinido.
 * @package Filter
 */
class InArray extends AbstractFilter {
    /**
     * @var array Conjunto de valores esperados.
     */ 
    private $allowed = array();

    /**
     * Constrói um filtro do tipo que aceitará apeans valores pertencentes
     * a um conjunto predefinido de valores.
     */
    public function __construct(array $allowed) {
        $this->setAllowedValues($allowed);
    }

    /**
     * Estabelece o conjunto de valores predefinidos aceitos pelo filtro,
     *
     * **IMPORTANTE:** Caso `$allowed` possua valores repetidos, eles serão
     * removidos. A comparação de tipos é estrita, ou seja, os tipos das
     * variáveis também serão levados em conta.
     *
     * @param array $allwed Os parâmetros aceitos pelo filtro.
     *
     * @return \Spice\Filter\InArray Fluent Interface
     */
    public function setAllowedValues(array $allowed) {
        $this->allowed = array();
        foreach ($allowed as $key => $value) {
            if (!in_array($value, $this->allowed, true)) {
                $this->allowed[] = $value;
            }
        }
        return $this;
    }

    /**
     * Retorna o conjunto de valores aceitáveis pelo filtro.
     *
     * @return array O conjunto de valores aceitos.
     */
    public function getAllowedValues() {
        return $this->allowed;
    }

    /**
     * @inheritdoc
     *
     * Aceita apenas valores pertencentes a um conjunto predefinido.
     * 
     * **Importante:** Os testes são feitos no modo estrito, ou seja,
     * também são feitas comparações de tipo, logo `1 !== '1'`.
     *
     * @return boolean Se o valor está no conjunto predefinido.
     */
    public function accept($value) {
        return in_array($value, $this->allowed, true);
    }
}
