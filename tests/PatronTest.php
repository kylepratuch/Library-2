<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";
    require_once "src/Copy.php";
    require_once "src/Author.php";
    require_once "src/Patron.php";
    require_once "src/Checkout.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class PatronTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
            Copy::deleteAll();
            Author::deleteAll();
            Patron::deleteAll();
            Checkout::deleteAll();
        }

        function test_setName()
        {
            //Arrange
            $name = "John Franti";
            $test_patron = new Patron($name);

            $new_name = "Mike Rapp";

            //Act
            $test_patron->setName($new_name);
            $result = $test_patron->getName();

            //Assert
            $this->assertEquals($new_name, $result);
        }

        function test_GetName()
        {
            $name = "Joe Montana";
            $test_patron = new Patron($name);

            $result = $test_patron->getName();

            $this->assertEquals($name, $result);
        }

        function test_getAll_save()
        {
            $name = "Joe Bongtana";
            $test_patron = new Patron($name);
            $test_patron->save();

            $name2 = "Jesus Christ";
            $test_patron2 = new Patron($name2);
            $test_patron2->save();

            $result = Patron::getAll();

            $this->assertEquals([$test_patron, $test_patron2], $result);
        }

        function test_find()
        {
            $name = "Joe Bongtana";
            $test_patron = new Patron($name);
            $test_patron->save();

            $name2 = "Jesus Christ";
            $test_patron2 = new Patron($name2);
            $test_patron2->save();


            $result = Patron::find($test_patron->getId());

            $this->assertEquals($test_patron, $result);
        }

        function testAddCheckout()
        {
            $title = "Three Blind Mice";
            $test_book = new Book($title);
            $test_book->save();

            $test_copy = new Copy($amount = 1, $test_book->getId());
            $test_copy->save();

            $name = "Joe Bongtana";
            $test_patron = new Patron($name);
            $test_patron->save();

            $due_date = "01-01-2016";
            $status = 1;
            $test_checkout = new Checkout($test_copy->getId(), $test_patron->getId(), $due_date, $status);
            $test_checkout->save();

            $test_patron->addCheckout($test_checkout);
            $result = Checkout::getAll();

            $this->assertEquals($test_checkout, $result);
        }
    }
?>
