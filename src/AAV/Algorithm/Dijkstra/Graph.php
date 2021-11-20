<?php

namespace AAV\Algorithm\Dijkstra;


use Exception;


/**
 * Class Graph
 * @package AAV\Algoritm\Dijkstra
 * @implements GraphInterface
 */
class Graph implements GraphInterface
{
    /**
     * Массив точек графа
     * array[id]= Node
     * @var array $nodes
     */
    private array $nodes = [];


    /**
     * Добавляет точку графа
     *
     * @param Node $node
     * @return Graph
     * @throws Exception
     */
    public function add(Node $node): Graph
    {
        if (array_key_exists($node->getId(), $this->getNodes()))
            throw new Exception('Точка с таким индексом уже есть в графе');

        $this->nodes[$node->getId()] = $node;
        return $this;
    }


    /**
     * Возвращает точку графа
     *
     * @param mixed $id
     * @return Node
     * @throws Exception
     */
    public function getNode($id): Node
    {
        if (!array_key_exists($id, $this->getNodes()))
            throw new Exception('Точка "' . $id . '" в графе не найдена');

        return $this->getNodes()[$id];
    }


    /**
     * Возвращает все точки графа
     *
     * @return array
     */
    public function getNodes(): array
    {
        return $this->nodes;
    }


    /**
     * Заполняет граф точками и возвращает граф
     *
     * @param array $routes
     * @return Graph
     * @throws Exception
     */
    public static function fill_graph(array $routes): Graph
    {
        $graph = new Graph();
        foreach ($routes as $route) {
            $from = $route['from'];
            $to = $route['to'];
            $price = $route['price'];
            if (!array_key_exists($from, $graph->getNodes())) {
                $from_node = new Node($from);
                $graph->add($from_node);
            } else
                $from_node = $graph->getNode($from);

            if (!array_key_exists($to, $graph->getNodes())) {
                $to_node = new Node($to);
                $graph->add($to_node);
            } else
                $to_node = $graph->getNode($to);

            $from_node->connect($to_node, $price);
        }

        return $graph;
    }


    /**
     * Сбрасывает точки в начальное состояние
     */
    public function reset()
    {
        /**
         * @var Node $node
         */
        foreach ($this->nodes as $node)
            $node->reset();
    }
}
