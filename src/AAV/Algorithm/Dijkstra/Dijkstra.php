<?php
namespace AAV\Algorithm\Dijkstra;


use Exception;


/**
 * Class Dijkstra
 * @package AAV\Algoritm\Dijkstra
 */
class Dijkstra
{
    /**
     * Начальная точка
     * @var Node $startingNode
     */
    private $startingNode;

    /**
     * Конечная точка
     * @var Node $endingNode
     */
    private $endingNode;

    /**
     * Набор точек со стоимостью расстояний между ними
     * @var Graph $graph
     */
    private $graph;

    /**
     * @var array $paths
     */
    private $paths= [];

    private $solution= false;


    /**
     * Dijkstra constructor.
     * @param Graph $graph
     */
    public function __construct(Graph $graph)
    {
        $this->graph= $graph;
    }


    /**
     * Возвращает стоимость пути между начальной и конечной точкой
     *
     * @return int
     * @throws Exception
     */
    public function getDistance()
    {
        if (!$this->isSolved())
            throw new Exception('Невозможно рассчитать путь (путь не найден, либо не выполнен $this->solve()');

        return $this->getEndingNode()->getPotential();
    }


    /**
     * Возвращает путь в текстовом формате
     *
     * @return string
     * @throws Exception
     */
    public function getLiteralShortestPath()
    {
        $path= $this->solve();
        $literal= '';
        foreach ( $path as $p )
            $literal.= "{$p->getId()} - ";

        return substr($literal, 0, strlen($literal) - 4);
    }


    /**
     * Возвращает массив точек через которые проходит кратчайший маршрут
     *
     * @return array
     * @throws Exception
     */
    public function getArrayShortestPath()
    {
        $result= [];
        $path= $this->solve();
        foreach ( $path as $p )
            $result[]= $p->getId();

        return $result;
    }


    /**
     * Вычисляет самый выгодный маршрут
     *
     * @return array|bool
     */
    public function getShortestPath()
    {
        $path= [];
        $node= $this->getEndingNode();
        while ( $node->getId()!= $this->getStartingNode()->getId() )
        {
            $path[]= $node;

            if (is_null($node->getPotentialFrom()))
                return false;

            $node= $node->getPotentialFrom();
        }

        $path[]= $this->getStartingNode();
        return array_reverse($path);
    }


    /**
     * Возвращает начальную точку
     *
     * @return Node
     */
    public function getStartingNode()
    {
        return $this->startingNode;
    }


    /**
     * Возвращает конечную точку
     *
     * @return Node
     */
    public function getEndingNode()
    {
        return $this->endingNode;
    }


    /**
     * Присваивает начальную точку
     *
     * @param Node $node
     */
    public function setStartingNode(Node $node)
    {
        $this->paths[]= array($node);
        $this->startingNode= $node;
    }


    /**
     * Присваивает конечную точку
     *
     * @param Node $node
     */
    public function setEndingNode(Node $node)
    {
        $this->endingNode= $node;
    }


    /**
     * Запускаем поиск самого выгодного маршрута и возвращаем результат
     *
     * @return array
     * @throws Exception
     */
    public function solve()
    {
        $this->getGraph()->reset();
        if (!$this->getStartingNode() || !$this->getEndingNode())
            throw new Exception('Необходимо задать начальную и конечную точки');

        $this->calculatePotentials($this->getStartingNode());
        $this->solution= $this->getShortestPath();
        return $this->solution;
    }


    /**
     * Вычисляет самый выгодный маршрут
     *
     * @param Node $node
     * @throws Exception
     */
    private function calculatePotentials(Node $node)
    {
        $connections= $node->getConnections();
        $sorted= array_flip($connections);
        krsort($sorted);
        foreach ( $connections as $id => $distance )
        {
            $v= $this->getGraph()->getNode($id);
            $v->setPotential($node->getPotential() + $distance, $node);
            foreach ( $this->getPaths() as $path )
            {
                $count= count($path);
                if ($path[$count - 1]->getId() === $node->getId())
                    $this->paths[]= array_merge($path, array($v));
            }
        }
        $node->markPassed();

        foreach ( $sorted as $id )
        {
            $node= $this->getGraph()->getNode($id);
            if (!$node->isPassed())
                $this->calculatePotentials($node);
        }
    }


    /**
     * Возвращает граф
     *
     * @return Graph
     */
    protected function getGraph()
    {
        return $this->graph;
    }


    /**
     * Возвращает найденный путь
     *
     * @return array
     */
    private function getPaths()
    {
        return $this->paths;
    }


    /**
     * Проверяет решён алгоритм или нет
     *
     * @return boolean
     */
    private function isSolved()
    {
        return ( bool ) $this->solution;
    }
}
