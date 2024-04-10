<?php
// класс для поиска пути Astar
class DomainLogic implements DomainLogicInterface
{
	private static array $_tiles;
	
    public function __construct()
    {

    }

	public static function init(array &$tiles)
	{
		$this->_tiles = $tiles;	
	}
	
    /**
     * @param Coordinate $node
     * @return Coordinate[]
     */
    public function getAdjacentNodes(mixed $node): iterable
    {    
        if(!$positions = $this->_tiles($node))
        {
            throw new Error('имеется ссылка на область '.$node.', но в матрице она отсутствует');
        }    
        
        return array_keys($positions);
    }

     // здесь можно влхвоащать сложность прохода по этому определенному маршруту из определеннйо клетки
    public function calculateRealCost(mixed $node, mixed $destination): float | int
    {
        if (!isset($this->_tiles($node)[$destination]))
        {
            throw new DomainException('из локации '.$node.' отсутствует путь в '.$destination);
        }

        // если есть кто то живой кроме нас сложность прохода этим путем увеличивается
      return $this->_tiles($node)[$destination];
    }

    public function calculateEstimatedCost(mixed $fromNode, mixed $toNode): float | int
    {
        $from = explode(Position::DELIMETR, $fromNode);
        $to = explode(Position::DELIMETR, $toNode);
        
        $xFactor = ($from[0] - $to[0]) ** 2;
        $yFactor = ($from[1] - $to[1]) ** 2;

        $factor = sqrt($xFactor + $yFactor);

       return $factor;
    }
}