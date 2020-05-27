# Dijkstra

За основу взят код со страницы http://www.o2b.ru/%D0%BF%D0%BE%D0%B8%D1%81%D0%BA-%D1%81%D0%B0%D0%BC%D0%BE%D0%B3%D0%BE-%D0%B4%D0%B5%D1%88%D0%B5%D0%B2%D0%BE%D0%B3%D0%BE-%D0%BC%D0%B0%D1%80%D1%88%D1%80%D1%83%D1%82%D0%B0-%D0%BD%D0%B0-php/

В оригинале алгоритм правильно работал только один раз, при повторном поиске маршрута работал неправильно.

Добавил возможность неоднократного поиска самого дешевого маршрута.

Пример:

```php
...
use AAV\Algorithm\Dijkstra\Dijkstra;
use AAV\Algorithm\Dijkstra\Graph;
...


...

private function fill_graph()
{
    $routes= [];

    $rows=  [
                ['from'=> 0, 'to'=> 1, 'price'=> 1],
                ['from'=> 0, 'to'=> 8, 'price'=> 9],
                ['from'=> 1, 'to'=> 4, 'price'=> 4],
                ['from'=> 4, 'to'=> 8, 'price'=> 3]
            ];

    foreach ($rows as $row)
    {
        $route{'from'}= $row{'from'};
        $route{'to'}= $row{'to'};
        $route{'price'}= $row{'price'};

        $routes[]= $route;
    }

    return Graph::fill_graph($routes);
}
    
    
public function printShortestPath($from_name, $to_name, $graph)
{
  $g= new Dijkstra($graph);
  $start_node= $graph->getNode($from_name);
  $end_node= $graph->getNode($to_name);
  $g->setStartingNode($start_node);
  $g->setEndingNode($end_node);
  echo "From: " . $start_node->getId() . "\n<br>";
  echo "To: " . $end_node->getId() . "\n<br>";
  if ($g->solve())
  {
      echo "Route: " . $g->getLiteralShortestPath() . "\n<br>";
      echo "Total: " . $g->getDistance() . "\n<br>";
  }
  else
      echo 'Путь не найден'."\n";

  print '-----'."\n<br><br>";
}

$graph= $this->fill_graph(); // создает и заполняет граф
printShortestPath(0, 8, $graph); // ищет самый выгодный маршрут между точками 0 и 8
```
