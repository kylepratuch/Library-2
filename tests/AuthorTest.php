<?php 
	
	/**
	* @backupGlobals disabled
	* @backupStaticAttributes disabled
	*/
	require_once "src/Book.php";
	require_once "src/Author.php";
	$server = "mysql:host=localhost;dbname=library_test";
	$username ='root';
	$password = 'root';
	$DB = new PDO($server, $username, $password);
	
	class AuthorTest extends PHPUnit_Framework_TestCase
	{
		protected function tearDown()
		{
			Book::deleteAll();
			Author::deleteAll();
		}
		
		function test_getName()
		{
			$name = "Jerry Garcia";
			$id = 1;
			$test_author = new Author($name, $id);
			
			$result = $test_author->getName();
			
			$this->assertEquals($name, $result);
		}
		
		function test_getId()
		{
			$name = "Jerry Garcia";
			$id = 1;
			$test_author = new Author($name, $id);
			
			$result = $test_author->getId();
			
			$this->assertEquals($id, $result);
		}
		
		function test_getAll_save()
		{
			$name = "Jerry Garcia";
			$test_author = new Author($name);
			$test_author->save();
			
			$name2 = "Frank Sinatra";
			$test_author2 = new Author($name2);
			$test_author2->save();
			
			$result = Author::getAll();
			
			$this->assertEquals([$test_author, $test_author2], $result);
		}
		
		function test_update()
		{
			$name = "Jerry Garcia";
			$test_author = new Author($name);
			$test_author->save();
			
			$name2 = "Frank Sinatra";
			$test_author->update($name2);
			
			$result = Author::getAll();
			
			$this->assertEquals([$test_author], $result);
		}
		
		function test_delete()
		{
			$name = "Jerry Garcia";
			$test_author = new Author($name);
			$test_author->save();
			
			$name2 = "Frank Sinatra";
			$test_author2 = new Author($name2);
			$test_author2->save();
			
			$test_author->delete();
			
			$result = Author::getAll();
			
			$this->assertEquals([$test_author2], $result);
		}
		
		function test_find()
		{
			$name = "Jerry Garcia";
			$test_author = new Author($name);
			$test_author->save();
			
			$name2 = "Frank Sinatra";
			$test_author2 = new Author($name2);
			$test_author2->save();
			
			$result = Author::find($test_author->getId());
			
			$this->assertEquals($test_author, $result);
		}
		
		
		
		
	}
?>