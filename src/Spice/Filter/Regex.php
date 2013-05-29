<?php
/**
 * Define a classe Spice\Filter\Regex.
 *
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 */
namespace Spice\Filter;

/**
 * Aceita valores que casam com uma dada expressão regular.
 * @package Filter
 */
class Regex extends AbstractFilter {
    /**
     * @var string A expressão regular para casar com valores.
     */
    private $pattern;

    /**
     * Cria um filtro baseado em expressões regulares.
     *
     * @param $pattern O padrão da expressão regular.
     */
    public function __construct($pattern) {
        $this->setPattern($pattern);
    }

    /**
     * Estabelece o padrão da expressão regular.
     *
     * @param $pattern O padrão da expressão regular.
     * @return \Spice\Filter\Regex Fluent interface.
     */
    public function setPattern($pattern) {
        $this->pattern = (string) $pattern;
        return $this;
    }

    /**
     * Obtém o padrão da expressão regular.
     *
     * @return string
     */
    public function getPattern() {
        return $this->pattern;
    }

    /**
     * Aceitará o valor se o mesmo casar com a expressão regular.
     *
     * @inheritdoc
     */
    public function accept($value) {
        return (bool) preg_match($this->pattern, $value);
    }
}
