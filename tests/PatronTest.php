<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";
    require_once "src/Copy.php";
    require_once "src/Author.php";
    require_once "src/Patron.php";

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
    }
?>
