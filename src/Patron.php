<?php

	class Patron
	{
		private $name;
		private $id;

		function __construct($name, $id = null)
		{
			$this->name = $name;
			$this->id = $id;
		}

		function setName($new_name)
		{
			$this->name = $new_name;
		}

		function getName()
		{
			return $this->name;
		}

		function getId()
		{
			return $this->id;
		}

		function save()
		{
			$GLOBALS['DB']->exec("INSERT INTO patrons (name) VALUES ('{$this->getName()}');");
			$this->id = $GLOBALS['DB']->lastInsertId();
		}

		function update($new_name)
		{
			$GLOBALS['DB']->exec("UPDATE patrons SET name = '{$new_name}' WHERE id = {$this->getId()};");
			$this->setName($new_name);
		}

		function delete()
		{
			$GLOBALS['DB']->exec("DELETE FROM patrons WHERE id = {$this->getId()};");
			$GLOBALS['DB']->exec("DELETE FROM checkouts WHERE patron_id = {$this->getId()};");
		}

		static function  deleteAll()
		{
			$GLOBALS['DB']->exec("DELETE FROM patrons;");
		}

		static function getAll()
		{
			$returned_patrons = $GLOBALS['DB']->query("SELECT * FROM patrons;");
			$patrons = array();
			foreach($returned_patrons as $patron)
			{
				$name = $patron['name'];
				$id = $patron['id'];
				$new_patron = new Patron($name, $id);
				array_push($patrons, $new_patron);
			}
			return $patrons;
		}

		static function find($search_id)
		{
			$found_patron = null;
			$patrons = Patron::getAll();
			foreach($patrons as $patron) {
				$patron_id = $patron->getId();
				if($patron_id == $search_id) {
					$found_patron = $patron;
				}
			}
			return $found_patron;
		}

		function getCheckouts()
		{
			$checkouts = array();
			$results = $GLOBALS['DB']->query("SELECT * FROM checkouts WHERE patron_id = {$this->getId()};");

			foreach ($results as $checkout) {
				$copy_id = $checkout['copy_id'];
				$patron_id = $checkout['patron_id'];
				$due_date = $checkout['due_date'];
				$status = $checkout['status'];
				$id = $checkout['id'];
				$new_checkout = new Checkout ($copy_id, $patron_id, $due_date, $status);
				array_push($checkouts, $new_checkout);
			}
			return $checkouts;
		}

		function addCheckout($copy, $new_checkout)
		{
			$GLOBALS['DB']->exec("INSERT INTO checkouts (copy_id, patron_id, due_date, status) VALUES
				({$copy->getId()},
				{$this->getId()},
				{$new_checkout->getDueDate()},
				{$new_checkout->getStatus()});
			");
		}
	}
?>
