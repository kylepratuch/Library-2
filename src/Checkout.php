<?php

    class Checkout
    {
        private $patron_id;
        private $copy_id;
        private $due_date;
        private $status;
        private $id;

        function __construct($patron_id, $copy_id, $due_date, $status = 1, $id)
        {
            $this->patron_id = $patron_id;
            $this->copy_id = $copy_id;
            $this->due_date = $due_date;
            $this->status = $status;
            $this->id = $id;
        }

        function getPatronId()
        {
            return $this->patron_id;
        }

        function getCopyId()
        {
            return $this->copy_id;
        }

        function setDueDate($new_due_date)
        {
            $this->due_date = $new_due_date;
        }

        function getDueDate()
        {
            return $this->due_date;
        }

        function setStatus($new_status)
        {
            $this->status = $new_status;
        }

        function getStatus()
        {
            return $this->status;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO checkouts (copy_id, patron_id, due_date, status) VALUES
                {$this->getCopyId()},
                {$this->getPatronId()},
                '{$this->getDueDate()}',
                {$this->getStatus()};
            ");

            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_checkouts = $GLOBALS['DB']->query("SELECT * FROM checkouts;");
            $checkouts = array();
            foreach($returned_checkouts as $checkout)
            {
                $copy_id = $checkout['copy_id'];
                $patron_id = $checkout['patron_id'];
                $due_date = $checkout['due_date'];
                $status = $checkout['status'];
            }
            return $checkouts;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM checkouts;");
        }

        function update($new_status)
        {
            $GLOBALS['DB']->exec("UPDATE checkouts SET status = {$new_status} WHERE id = {$this->getId()};");
            $this->setStatus($new_status);
        }

    }


?>
