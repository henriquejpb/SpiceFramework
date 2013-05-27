<?php
/**
 * Define a classe Spice\Routing\AbstractRout.
 *
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 */
namespace Spice\Routing;

/**
 * Implementa funcionalidades e armazena propriedades comuns aos tipos de rota.
 * @package Routing
 */
abstract class AbstractRoute implements RouteInterface {
    
    /**
     * @var string O nome da rota.
     */
    private $name;

    /**
     * @var string O padrão de combinação da rota para uma requisição.
     */
    private $matchPattern;

    /**
     * Inicializa os parâmetros comuns de uma rota.
     *
     * @param string $name O nome da rota.
     * @param string $matchPattern O padrão de "casamento" da rota.
     */
    public function __construct($name, $matchPattern) {
        $this->setName($name);
        $this->setMatchPattern($matchPattern);
    }

    /**
     * Obtém o nome da rota.
     *
     * @return string O nome da rota.
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Estabelece o nome da rota.
     *
     * @param strign $name O nome da rota.
     *
     * @return void
     */
    private function setName($name) {
        $this->name = (string) $name;
    }

    /**
     * Obtém o padrão de "casamento" da rota com a requisição.
     * 
     * @return string O padrão de "casamento" da rota com a requisição.
     */
    public function getMatchPattern() {
        return $this->matchPattern;
    }

    /**
     * Estabelece o padrão de "casamento" da rota com uma requisição.
     * 
     * **ATENÇÃO:** Caracteres `/` no fim do padrão serão removidos.
     * 
     * @param string $matchPattern Um padrão de combinação.
     *
     * @return void
     */
    public function setMatchPattern($matchPattern) {
        $matchPattern = (string) $matchPattern;
        while (substr($matchPattern, -1) == '/') {
            $matchPattern = substr($matchPattern, 0, strlen($matchPattern) - 1);
        }
        $this->matchPattern = $matchPattern;
    }
}
