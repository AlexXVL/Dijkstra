<?php

namespace AAV\Algorithm\Dijkstra;


use Exception;


/**
 * Interface GraphInterface
 * @package AAV\Algoritm\Dijkstra
 */
interface GraphInterface
{
    /**
     * Добавляет точку в граф
     *
     * @param Node $node
     * @return Graph
     * @throws Exception
     */
    public function add(Node $node): Graph;

    /**
     * Возвращает точку графа
     *
     * @param mixed $id
     * @return Node
     * @throws Exception
     */
    public function getNode($id): Node;

    /**
     * Возвращает все точки графа
     *
     * @return array
     */
    public function getNodes(): array;
}
