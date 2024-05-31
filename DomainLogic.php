<?php
// класс для поиска пути Astar
class DomainLogic implements DomainLogicInterface
{
	private static array $_tiles;
	
    public function __construct()
    {

    }

	// вообще PHP  nr массив передает по ссылки и выделяет под него память если меняется значение только 
	public static function init(array &$tiles)
	{
		PHP::log('Инициализация матрицы поиска пути');
		static::$_tiles = $tiles;
	}
	
    /**
     * @param Coordinate $node
     * @return Coordinate[]
     */
    public function getAdjacentNodes(mixed $node): iterable
    {    
        if(empty(static::$_tiles[$node]))
        {
            throw new Error('имеется ссылка на область '.$node.', но в матрице она отсутствует');
        }    
        
        return array_keys(static::$_tiles[$node]);
    }

     // здесь можно влхвоащать сложность прохода по этому определенному маршруту из определеннйо клетки
    public function calculateRealCost(mixed $node, mixed $destination): float | int
    {
        if (!isset(static::$_tiles[$node][$destination]))
        {
            throw new DomainException('из локации '.$node.' отсутствует путь в '.$destination);
        }

        // если есть кто то живой кроме нас сложность прохода этим путем увеличивается
      return static::$_tiles[$node][$destination];
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