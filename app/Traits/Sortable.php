<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait Sortable
{
    /**
     * Integer that follows position changes.
     *
     * @static int
     */
    protected $moveCounter;
    
    /**
     * Array to keep track of position changes.
     *
     * @static array
     */
    protected static $moveArray = [];

	/**
	 * Repair the order column (e.g. after a delete). Additionally,
     * refresh the positions in case they have been altered externally.
	 * 
	 * @return void
	 */
	protected function initializeMoves()
    {
        $this->moveCounter = self::$moveArray[$this->id] ?? 0;
	}

	/**
	 * Repair the order column (e.g. after a delete). Additionally,
     * refresh the positions in case they have been altered externally.
	 * 
	 * @return void
	 */
	protected function updateMoves()
    {
        # INITIALIZE MOVE ARRAY
        if (!isset(self::$moveArray[$this->id])) {
            self::$moveArray[$this->id] = 0;
        }
        # 1INCREMENT MOVE ARRAY
        ++self::$moveArray[$this->id];
        # INCREMENT MOVE VARIABLE
        $this->moveCounter = self::$moveArray[$this->id];
	}

	/**
	 * Check if model has moved.
	 * 
	 * @return bool
	 */
	public function isMoved()
    {
        return isset(self::$moveArray[$this->id]) && $this->moves !== self::$moveArray[$this->id];
	}

	/**
	 * Repair the order column (e.g. after a delete). Additionally,
     * refresh the positions in case they have been altered externally.
	 * 
	 * @return void
	 */
	public function resort()
    {
        $books = $this->user->books()->orderBy('position')->get();
        
        foreach ($books as $key=>$book) {
            if ($book->position != $key) {
                $book->position = $key;
                $book->save();
            }
            if ($book->id === $this->id) { # UPDATE THIS MODEL'S POSITION ATTRIBUTE
                $this->position = $key;
            }
        }
	}

	/**
	 * Check if book has moved and update position accordingly.
	 * 
	 * @return void
	 */
	public function updatePosition()
    {
        $this->move('up');
	}

	/**
	 * Move book up in list.
	 * 
	 * @return void
	 */
	public function moveUp()
    {
        $this->move('up');
	}

	/**
	 * Move book up in list.
	 * 
	 * @return void
	 */
	public function moveDown()
    {
        $this->move('down');
	}

	/**
	 * Move book up or down in list.
	 * 
	 * @param  string  $dir 'up' or 'down'
	 * @return void
	 */
	public function move(string $dir)
    {
        if ($dir !== 'up' && $dir !== 'down') {
            return;
        }
        $this->resort();
        
        switch ($dir) {
            case 'up':
                $op = '<';
                $direc= 'desc';
                break;
            case 'down':
                $op = '>';
                $direc = 'asc';
                break;
        }
        
        $target = $this->user->books()
                ->where('position', $op, $this->position)
                ->orderBy('position', $direc)->first();
        if ($target) {
            $this->swap($target);
        }
	}

	/**
	 * Swap positions with a second book.
	 * 
	 * @param  Book  $target book to be swapped with
	 * @return void
	 */
	public function swap(self $target)
    {
        if ($this->user_id !== $target->user_id) {
            return;
        }
        
        $this->resort();
        
        $book = $this;
        DB::transaction(function() use ($book, $target) {
            $position = $book->position;
            
            $book->position = $target->position;
            $target->position = $position;
            $book->save();
            $target->save();
            
            $book->updateMoves();
            $target->updateMoves();
        });
	}
}