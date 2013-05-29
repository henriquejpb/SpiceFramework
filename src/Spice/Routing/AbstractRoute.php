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
     * @var array Os valores padrão de parâmetros em caso de sucesso
     *      na combinação da rota com a requisição.
     */
    private $defaults;

    /**
     * Inicializa os parâmetros comuns de uma rota.
     *
     * @param string $name O nome da rota.
     * @param string $matchPattern O padrão de "casamento" da rota.
     * @param array $defaultsMap [OPCIONAL] Um array associativo para os 
     *      valores-padrão dos parâmetros de rota.
     */
    public function __construct(
        $name, 
        $matchPattern, 
        array $defaultsMap = array()
    ) {
        $this->setName($name);
        $this->setMatchPattern($matchPattern);
        $this->setDefaults($defaultsMap);
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

    /**
     * Estabelece os valores padrão para os parâmetros da rota.
     * Não há nenhum tipo de verificação se dado parâmetro existe.
     *
     * O array `$defaultsMap` é associativo da forma:
     * <code>
     *  array (
     *      param1 => value1,
     *      param2 => value2,
     *      ...
     *  )
     * </code>
     * onde são fornecidos valores padrão para os argumentos requeridos.
     *
     * @param array $defaultsMap [OPCIONAL] Um array associativo para os 
     *      valores-padrão dos parâmetros de rota.
     *
     * @return void
     */
    public function setDefaults(array $defaultsMap) {
        $this->defaults = array_map(
            function ($item) {
                return (string) $item;
            }, 
            $defaultsMap
        );
    }

    /**
     * Retorna os valores padrão dos parâmetros da rota.
     *
     * O retorno será da forma:
     * <code>
     *  array (
     *      param1 => value1,
     *      param2 => value2,
     *      ...
     *  )
     * </code>
     *
     * @return array<string> Um array contendo os parâmetros.
     */
    public function getDefaults() {
        return $this->defaults;
    }

    /**
     * Estabelece o valor padrão de um parâmetro.
     * Se já existe um valor para o referido parâmetro, o mesmo será 
     * sobrescrito, sem nenhum tipo de aviso ou exceção lançada.
     *
     * @param string $name O nome do parâmetro.
     * @param string $value O valor do parâmetro.
     *
     * @return void
     */
    public function setDefaultParam($name, $value) {
        $this->defaults[(string) $name] = (string) $value;
    }

    /**
     * Obtém o valor padrão de um parâmetro.
     * Se dito parâmetro não existir, `NULL` será retornado.
     *
     * @param string $name O nome do parâmetro.
     *
     * @return void
     */
    public function getDefaultParam($name) {
        return isset($this->defaults[$name]) ? $this->defaults[$name] : null;
    }

}
