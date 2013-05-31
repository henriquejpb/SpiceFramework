<?php
/**
 * Define a classe Spice\Filter\Equals.
 *
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 */
namespace Spice\Filter;

/**
 * Aceita valores iguais ao valor esperado.
 * A comparação é feita no modo estrito, ou seja, também se verifica o tipo
 * do valor.
 *
 * @package Filter
 */
class Equals extends AbstractFilter {
    /**
     * @var mixed O valor esperado.
     */
    private $expected;

    /**
     * Cria um filtro que aceita apenas valores iguais ao esperado.
     * A comparação é feita no modo estrito para escalares e arrays,
     * mas não para objetos.
     *
     * @param $expected O valor esperado.
     */
    public function __construct($expected) {
        $this->setExpected($expected);
    }

    /**
     * Estabelece o padrão da expressão regular.
     *
     * @param $expected O padrão da expressão regular.
     * @return \Spice\Filter\Regex Fluent interface.
     */
    public function setExpected($expected) {
        $this->expected = $expected;
        return $this;
    }

    /**
     * Obtém o padrão da expressão regular.
     *
     * @return string
     */
    public function getExpected() {
        return $this->expected;
    }

    /**
     * Aceitará o valor se o mesmo for igual ao esperado.
     *
     * **ATENÇÃO:**
     *
     * Para valores escalares e arrays, a comparação é feita no modo estrito, 
     * ou seja, com o operador `===`, que também se verifica o tipo do valor.
     *
     * Para objetos, a comparação é feita com o comparador `==`, já que não
     * é necessário que dois objetos sejam a mesma instância para serem iguais.
     * Este operador irá comparar cada propriedade do objeto através do mesmo
     * operador `==`.
     * Desta forma, os seguintes objetos são considerados iguais:
     * <code>
     * $obj1 = new \StdClass();
     * $obj1->prop = '1';
     *
     * $obj2 = new \StdClass();
     * $obj2->prop = 1;
     *
     * var_dump($obj1 == $obj2); // boolean(true)
     * </code>
     * 
     *
     * @inheritdoc
     */
    public function accept($value) {
        if (gettype($this->expected) == 'object') {
            return ($this->expected == $value);
        } else {
            return ($this->expected === $value);
        }
    }
}
