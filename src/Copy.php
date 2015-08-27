<?php

	class Copy
	{
		private $amount;
		private $book_id;
		private $id;

		function __construct($amount = 0, $book_id = null, $id = null)
		{
			$this->amount = $amount;
			$this->book_id = $book_id;
			$this->id = $id;
		}

		function setAmount($new_amount)
		{
			$this->amount = $new_amount;

		}

		function getAmount()
		{
			return $this->amount;
		}

		function setBookId($new_book_id)
		{
			$this->book_id = $new_book_id;

		}

		function getBookId()
		{
			return $this->book_id;
		}

		function setId($new_id)
		{
			$this->id = $new_id;

		}

		function getId()
		{
			return $this->id;
		}

		function save()
		{
			$GLOBALS['DB']->exec("INSERT INTO copies (amount, book_id) VALUES ({$this->getAmount()}, {$this->getBookId()});");
			$this->setId($GLOBALS['DB']->lastInsertId());
		}

		function update($new_amount)
		{
			$GLOBALS['DB']->exec("UPDATE copies SET amount = {$new_amount} WHERE id = {$this->getId()};");
			$this->setAmount($new_amount);
		}

		static function getAll()
		{
			$returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies");
			$copies = array();
			foreach($returned_copies as $copy) {
				$amount = $copy['amount'];
				$book_id = $copy['book_id'];
				$id = $copy['id'];
				$new_copy = new Copy($amount, $book_id, $id);
				array_push($copies, $new_copy);
			}
			return $copies;
		}

		static function deleteAll()
		{
			$GLOBALS['DB']->exec("DELETE FROM copies;");
		}

		static function find($search_id)
		{
			$found_copy = null;
			$copies = Copy::getAll();
			foreach($copies as $copy) {
				$copy_id = $copy->getId();
				if($copy_id == $search_id) {
					$found_copy = $copy;
				}
				return $found_copy;
			}
		}

		static function findBookCopy($search_book_id) {
			$found_copy = null;
			$copies = Copy::getAll();
			foreach($copies as $copy) {
				$book_id = $copy->getBookId();
				if($book_id == $search_book_id) {
					$found_copy = $copy;
				}
			}
			return $found_copy;
		}

		function addCopies($number_added)
		{
			$new_amount = $this->getAmount() + $number_added;
			$this->update($new_amount);
		}

	}
?>
