<?php 
	
	 /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Book.php";
    require_once 'src/Author.php';
    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
	
	class BookTest extends PHPUnit_Framework_TestCase
	{
		protected function tearDown()
        {
            Book::deleteAll();
            Author::deleteAll();
        }
		
		function test_getTitle()
		{
			$title = "Three Blind Mice";
			$id = 1;
			$test_book = new Book($title, $id);
			
			$result = $test_book->getTitle();
			
			$this->assertEquals($title, $result);
		}
		
		function test_getId()
		{
			$title = "Three Blind Mice";
			$id = 1;
			$test_book = new Book($title, $id);
			
			$result = $test_book->getId();
			
			$this->assertEquals($id, $result);
		}
		
		function test_getAll_save()
		{
			$title = "Three Blind Mice";
			$test_book = new Book($title);
			$test_book->save();
			
			$title2 = "Chicken Dog";
			$test_book2 = new Book($title2);
			$test_book2->save();
			
			$result = Book::getAll();
			
			$this->assertEquals([$test_book, $test_book2], $result);
		}
		
		function test_update()
		{
			$title = "Three Blind Mice";
			$test_book = new Book($title);
			$test_book->save();
			
			$title2 = "Chicken Dog";
			$test_book->update($title2);
			
			$result = Book::getAll();
			
			$this->assertEquals([$test_book], $result);
		}
		
		function test_delete()
		{
			$title = "Three Blind Mice";
			$test_book = new Book($title);
			$test_book->save();
			
			$title2 = "Chicken Dog";
			$test_book2 = new Book($title2);
			$test_book2->save();
			
			$test_book->delete();
			
			$result = Book::getAll();
			
			$this->assertEquals([$test_book2], $result);
		}
		
		function test_find()
		{
			$title = "Three Blind Mice";
			$test_book = new Book($title);
			$test_book->save();
			
			$title2 = "Chicken Dog";
			$test_book2 = new Book($title2);
			$test_book2->save();
			
			$result = Book::find($test_book->getId());
			
			$this->assertEquals($test_book, $result);
		}
		
		function test_addAuthor_getAuthors()
		{
			$title = "Three Blind Mice";
			$test_book = new Book($title);
			$test_book->save();
			
			$title2 = "Chicken Dog";
			$test_book2 = new Book($title2);
			$test_book2->save();
			
			$author_name = "Jimmy Neutron";
			$test_author = new Author($author_name);
			$test_author->save();
			
			$test_book->addAuthor($test_author);
			
			$result = $test_book->getAuthors();
			
			$this->assertEquals([$test_author], $result);
		}
	}
?>