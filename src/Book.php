<?php

	class Book
	{
		private $title;
		private $id;

		function __construct($title, $id = null)
		{
			$this->title = $title;
			$this->id = $id;
		}

		function setTitle($new_title)
		{
			$this->title = $new_title;
		}

		function getTitle()
		{
			return $this->title;
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
			$GLOBALS['DB']->exec("INSERT INTO books (title) VALUES ('{$this->getTitle()}');");
			$this->id = $GLOBALS['DB']->lastInsertId();
		}

		function update($new_title)
		{
			$GLOBALS['DB']->exec("UPDATE books SET title = '{$new_title}' WHERE id = {$this->getId()};");
			$this->setTitle($new_title);
		}

		static function getAll()
		{
			$returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");
			$books = array();
			foreach($returned_books as $book)
			{
				$title = $book['title'];
				$id = $book['id'];
				$new_book = new Book($title, $id);
				array_push($books, $new_book);
			}
			return $books;
		}

		static function deleteAll()
		{
			$GLOBALS['DB']->exec("DELETE FROM books;");
		}

		function delete()
		{
			$GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
			$GLOBALS['DB']->exec("DELETE FROM authors_books WHERE book_id = {$this->getId()};");
		}

		function getAuthors()
		{
			$authors = array();
			$results = $GLOBALS['DB']->query("SELECT authors.* FROM
											  books JOIN authors_books ON (books.id = authors_books.book_id)
											  		JOIN authors ON (authors_books.author_id = authors.id)
											  WHERE books.id = {$this->getId()};");
			foreach($results as $author) {
				$author_name = $author['name'];
				$author_id = $author['id'];
				$new_author = new Author($author_name, $author_id);
				array_push($authors, $new_author);
			}
			return $authors;
		}

		function addAuthor($new_author)
		{
			$GLOBALS['DB']->exec("INSERT INTO authors_books (author_id, book_id) VALUES ({$new_author->getId()}, {$this->getId()});");
		}

		static function find($search_id)
		{
			$found_book = null;
			$books = Book::getAll();
			foreach($books as $book) {
				$book_id = $book->getId();
				if($book_id == $search_id) {
					$found_book = $book;
				}
			}
			return $found_book;
		}

		static function searchTitle($search_title)
		{
			$returned_books = $GLOBALS['DB']->query("SELECT * FROM books WHERE title = '{$search_title}';");
			$books = array();
			foreach($returned_books as $book)
			{
				$title = $book['title'];
				$id = $book['id'];
				$new_book = new Book($title, $id);
				array_push($books, $new_book);
			}
			return $books;
		}


	}
?>
