<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Author.php";

    $app = new Silex\Application();
    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('books' => Book::getAll(), 'authors' => Author::getAll()));
    });

    $app->get("/books", function() use ($app) {
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    $app->post("/books", function() use ($app) {
        $book_title = $_POST['book_title'];
        $book = new Book($book_title);
        $book->save();
        return $app['twig']->render('books.html.twig', array('books'=> Book::getAll()));
    });

    $app->post("/delete_books", function() use ($app) {
        Book::deleteAll();
        return $app['twig']->render('books.html.twig', array('books' => Book::getAll()));
    });

    $app->get("/authors", function() use ($app) {
        return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll()));
    });

    $app->post("/authors", function() use ($app) {
        $name = $_POST['name'];
        $author = new Author($name);
        $author->save();
        return $app['twig']->render('authors.html.twig', array('authors'=> Author::getAll()));
    });

    $app->post("/delete_authors", function() use ($app) {
        Author::deleteAll();
        return $app['twig']->render('authors.html.twig', array('authors' => Author::getAll()));
    });

    return $app;

?>
