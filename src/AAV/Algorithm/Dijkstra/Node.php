<?php

namespace AAV\Algorithm\Dijkstra;


/**
 * Class Node
 * @package AAV\Algoritm\Dijkstra
 * @implements NodeInterface
 */
class Node implements NodeInterface
{
    /**
     * Идентификатор точки
     * @var mixed $id
     */
    private $id;

    /**
     * Потенциал точки
     * @var int|null $potential
     */
    private ?int $potential = null;

    /**
     * Точка для которой присвоен потенциал
     * @var Node|null $potentialFrom
     */
    private ?Node $potentialFrom = null;

    /**
     * Соединения с другими точками
     * @var array $connections
     */
    private array $connections = [];

    /**
     * Посетили точку или нет
     * @var bool $passed
     */
    private bool $passed = false;


    /**
     * Создает новую точку
     *
     * @param mixed $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }


    /**
     * Соединяет с другой точкой
     *
     * @param Node $node
     * @param int $distance
     */
    public function connect(Node $node, int $distance = 1)
    {
        $this->connections[$node->getId()] = $distance;
    }


    /**
     * Возвращает стоимость маршрута между точками
     * @param Node $node
     * @return array
     * @todo проверить работу функции. в Dijkstra.php есть непонятный метод getDistance
     *
     */
    public function getDistance(Node $node): array
    {
        return $this->connections[$node->getId()];
    }


    /**
     * Возвращает соединения с другими точками
     *
     * @return array
     */
    public function getConnections(): array
    {
        return $this->connections;
    }


    /**
     * Возвращает идентификатор точки
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Возвращает потенциал точки
     *
     * @return ?int
     */
    public function getPotential(): ?int
    {
        return $this->potential;
    }


    /**
     * Возвращает точку для которой присвоен потенциал
     *
     * @return Node|null
     */
    public function getPotentialFrom(): ?Node
    {
        return $this->potentialFrom;
    }


    /**
     * Возвращает посетили точку или нет
     *
     * @return bool
     */
    public function isPassed(): bool
    {
        return $this->passed;
    }


    /**
     * Помечает точку как пройденную
     */
    public function markPassed()
    {
        $this->passed = true;
    }


    /**
     * Присваивает потенциал для точки если он еще не присвоен или больше чем новый
     *
     * @param int $potential
     * @param Node $from
     * @return boolean
     */
    public function setPotential(int $potential, Node $from): bool
    {
        $potential = (int)$potential;

        if (!$this->getPotential() || $potential < $this->getPotential()) {
            $this->potential = $potential;
            $this->potentialFrom = $from;
            return true;
        }

        return false;
    }


    /**
     * Сбрасывает точку в начальное состояние
     */
    public function reset()
    {
        $this->potential = null;
        $this->potentialFrom = null;
        $this->passed = false;
    }
}
