<?php
namespace AAV\Algorithm\Dijkstra;


/**
 * Interface NodeInterface
 * @package AAV\Algoritm\Dijkstra
 */
interface NodeInterface
{
    /**
     * Соединение с другой точкой
     *
     * @param Node $node
     * @param int $distance
     */
    public function connect(Node $node, $distance= 1);

    /**
     * Возвращает соединения с другими точками
     *
     * @return array
     */
    public function getConnections();

    /**
     * Возвращает идентификатор точки
     *
     * @return mixed
     */
    public function getId();

    /**
     * Возвращает потенциал точки
     *
     * @return int
     */
    public function getPotential();

    /**
     * Возвращает точку для которой присвоен потенциал
     *
     * @return Node
     */
    public function getPotentialFrom();

    /**
     * Возвращает посетили точку или нет
     *
     * @return bool
     */
    public function isPassed();

    /**
     * Помечает точку как пройденную
     */
    public function markPassed();

    /**
     * Присваивает потенциал для точки если он еще не присвоен или больше чем новый
     *
     * @param int $potential
     * @param Node $from
     * @return bool
     */
    public function setPotential($potential, Node $from);
}
