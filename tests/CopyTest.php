<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";
    require_once "src/Copy.php";
    require_once "src/Author.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CopyTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
            Copy::deleteAll();
            Author::deleteAll();
        }

        function testGetAmount()
        {
            $amount = 3;
            $book_id = 2;
            $id = null;
            $test_copy = new Copy($amount, $book_id, $id);

            $result = $test_copy->getAmount();

            $this->assertEquals(3, $result);
        }

        function testSetAmount()
        {
            $amount = 3;
            $book_id = 2;
            $id = null;
            $test_copy = new Copy($amount, $book_id, $id);

            $new_amount = 2;


            $test_copy->setAmount($new_amount);
            $result = $test_copy->getAmount();

            $this->assertEquals(2, $result);
        }

        function testSave_getAll()
        {
            $title = "Three Blind Mice";
            $test_book = new Book($title);
            $test_book->save();

            $amount = 3;
            $book_id = $test_book->getId();
            $test_copy = new Copy($amount, $book_id);
            $test_copy->save();

            $result = Copy::getAll();

            $this->assertEquals([$test_copy], $result);
        }

        function testDeleteAll()
        {
            $title = "Three Blind Mice";
            $test_book = new Book($title);
            $test_book->save();

            $amount = 3;
            $book_id = $test_book->getId();
            $test_copy = new Copy($amount, $book_id);
            $test_copy->save();

            Copy::deleteAll();
            $result = Copy::getAll();

            $this->assertEquals([], $result);
        }

        function test_addCopies()
        {
            $title = "Three Blind Mice";
            $test_book = new Book($title);
            $test_book->save();

            $test_copy = new Copy($amount = 1, $test_book->getId());
            $test_copy->save();

            $title2 = "Dune";
            $test_book2 = new Book($title2);
            $test_book2->save();

            $test_copy->addCopies(1);

            $result = $test_copy->getAmount();
            $this->assertEquals(2, $result);
        }

        function testFind()
        {
            $title = "Three Blind Mice";
            $test_book = new Book($title);
            $test_book->save();

            $test_copy = new Copy($amount = 1, $test_book->getId());
            $test_copy->save();

            $title2 = "Chicken Dog";
            $test_book2 = new Book($title2);
            $test_book2->save();

            $test_copy2 = new Copy($amount2 = 2, $test_book2->getId());
            $test_copy2->save();

            $result = Copy::find($test_copy->getId());

            $this->assertEquals($test_copy, $result);
        }

        function testFindBookCopy()
        {
            $title = "Three Blind Mice";
            $test_book = new Book($title);
            $test_book->save();

            $test_copy = new Copy($amount = 1, $test_book->getId());
            $test_copy->save();

            $title2 = "Chicken Dog";
            $test_book2 = new Book($title2);
            $test_book2->save();

            $test_copy2 = new Copy($amount2 = 2, $test_book2->getId());
            $test_copy2->save();

            $result = Copy::findBookCopy($test_book->getId());

            $this->assertEquals($test_copy, $result);
        }



    }

?>
