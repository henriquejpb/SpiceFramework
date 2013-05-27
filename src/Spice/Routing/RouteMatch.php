<?php
/**
 * Define a classe Spice_Routing_RouteInterface.
 *
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 */

/**
 * Representa uma combinação feita com sucesso entre uma rota e uma requisição.
 * @package Routing
 */
class Spice_Routing_RouteMatch implements ArrayAccess {
    /**
     * @var string O nome da rota que corresponde à requisição atual.
     */
    private $routeName;

    /**
     * @var array Um array associativo contendo os parâmetros de rota encontrados.
     */
    private $params;

    /**
     * Inicializa um objeto `RouteMatch` com um nome e os parâmetros encontrados. 
     *
     * @param string $name O nome da rota correspondente.
     * @param array<string,string> $params Os parâmetros de rota encontrados.
     */
    public function __construct($name, array $params = array()) {
        $this->setRouteName($name);
        $this->setParams($params);
    }
    
    /**
     * Estabelece o nome da rota que casa com a requisição atual.
     *
     * @param string $name O nome da rota.
     *
     * @return Spice_Routing_RouteMatch Fluent interface.
     */
    public function setRouteName($name) {
        $this->routeName = (string) $name;
        return $this;
    }

    /**
     * Obtém o nome da rota que casa com a requisição atual.
     *
     * @return string
     */
    public function getRouteName() {
        return $this->routeName;
    }

    /**
     * Estabelece os parâmetros de rota.
     *
     * @param array<string,string> $params Os parâmetros.
     *
     * @return Spice_Routing_RouteMatch Fluent interface.
     */
    public function setParams(array $params) {
        foreach ($params as $key => $value) {
            $this->setParam($key, $value);
        }
        return $this;
    }

    /**
     * Obtém os parâmetros de rota.
     * 
     * @return array<string,string>
     */
    public function getParams() {
        return $this->params;
    }

    /**
     * Estabelece um parâmetro de rota.
     *
     * @param string $name O nome do parâmetro.
     * @param string $name O nome do parâmetro.
     *
     * @return Spice_Routing_RouteMatch Fluent interface.
     */
    public function setParam($name, $value) {
        $this->params[(string) $name] = (string) $value;
        return $this;
    }

    /**
     * Remove um parâmetro de rota.
     *
     * @param string $name O nome do parâmetro.
     * @param string $name O nome do parâmetro.
     *
     * @return Spice_Routing_RouteMatch Fluent interface.
     */
    public function unsetParam($name) {
        if (isset($this->params[$name])) {
            unset($this->params[$name]);
        }
        return $this;
    }

    /**
     * Obtém um parâmetro da rota.
     * Caso o parâmetro não exista, `$default` será retornado em seu lugar.
     *
     * @param string $name O nome do parâmetro. 
     * @param mixed $default O valor padrão a se retornar caso o parâmetro não exista.
     *
     * @return mixed Se o parâmetro existe, o retorno será uma string, se não, o tipo
     *      de retorno será o mesmo do parâmetro `$default`.
     */
    public function getParam($name, $default = null) {
        if (isset($this->params[$name])) {
            return $this->params[$name];
        }
        return $default;
    }

    /**
     * @inherit-doc
     */
    public function offsetGet($offset) {
        return $this->getParam($offset);
    }

    /**
     * @inherit-doc
     */
    public function offsetSet($offset, $value) {
        return $this->setParam($offset, $value);
    }
    
    /**
     * @inherit-doc
     */
    public function offsetUnset($offset) {
        return $this->unsetParam($offset);
    }

    /**
     * @inherit-doc
     */
    public function offsetExists($offset) {
        return $this->getParam($offset) !== null;
    }
}
