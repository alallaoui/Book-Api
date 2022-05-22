<?php

namespace App\Controller;

use App\Document\Book;
use App\Form\BookType;
use App\Service\Form\FormErrorsSerializer;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


/**
 * Class BookController
 * @package App\Controller
 */
#[Route(path: '/api/book')]
class BookController extends AbstractController
{
    /**
     * BookController constructor.
     */
    public function __construct(
        private readonly DocumentManager $dm
    ) {
    }

    #[Route('', name: 'book_list',  methods: ['GET'])]
    public function index(): Response
    {
        $books = $this->dm->getRepository(Book::class)->findAll();
        return $this->json($books, 200, [], [
            'groups' => ['id', 'book']
        ]);
    }

    /**
     * Create New Book
     *
     * @OA\Response(
     *     response=201,
     *     description="A new book has been created",
     * ),
     * @OA\Response(
     *     response=500,
     *     description="no book has been created (invalid values, ... )",
     * )
     * @OA\Parameter(
     *     name="form",
     *     in="query",
     *     required=true,
     *     description="Required values before submit",
     *     @Model(type=BookType::class),
     * )
     *
     * @OA\Tag(name="books")
     */
    #[Route(path: '', name: 'book_create', methods: ['POST'])]
    public function create(Request $request, FormErrorsSerializer $formErrorsSerializer): Response
    {
        $book = new Book();
        //dd($request->getContent());

        //traitememt formulaire creation du livre et enregistrement en base de données
        $bookForm = $this->createForm(BookType::class, $book);

        //submit du formulaire et retour de la réponse si le fomrulaire est valide
        if ($bookForm->submit(json_decode($request->getContent(), true))->isValid()) {
            $response = $this->json('A new book has been created, book id = ' . $book->getId(), 201);
            //add Location attribute do response header
            $response->headers->set('Location', $this->generateUrl('book_view', ['id'=>$book->getId()]));
            return $response;
        }
        // Form errors if validation fails
        return $this->json($formErrorsSerializer->serialize($bookForm), '400');
    }

    /**
     * Edit Book
     *
     * @OA\Response(
     *     response=200,
     *     description="Book has been created",
     * ),
     * @OA\Response(
     *     response=500,
     *     description="no book has been edited (invalid values, ... )",
     * )
     * @OA\Parameter(
     *     name="form",
     *     in="query",
     *     required=true,
     *     description="Required values before submit",
     *     @Model(type=BookType::class),
     * )
     * @ParamConverter("book", class="App\Document\Book")
     * @OA\Tag(name="books")
     */
    #[Route(path: '/{id}', name: 'book_edit', methods: ['PUT'])]
    public function edit(Request $request, FormErrorsSerializer $formErrorsSerializer, Book $book): Response
    {
        //traitememt formulaire edition du livre et enregistrement en base de données
        $bookForm = $this->createForm(BookType::class, $book);

        //submit du formulaire et retour de la réponse si le fomrulaire est valide
        if ($bookForm->submit(json_decode($request->getContent(), true))->isValid()) {
            return $this->json($book, 200, [], [
                'groups' => ['id', 'book']
            ]);
        }
        // Form errors if validation fails
        return $this->json($formErrorsSerializer->serialize($bookForm), '400');
    }

    /**
     * View New Book
     *
     * @OA\Response(
     *     response=200,
     *     description="View Book successfull",
     * ),
     *
     * @OA\Response(
     *     response=404,
     *     description="Book was not found",
     * )
     * @ParamConverter("book", class="App\Document\Book")
     * @OA\Tag(name="books")
     */
    #[Route(path: '/{id}', name: 'book_view', methods: ['GET'])]
    public function view(Book $book)
    {
        return $this->json($book, 200, [], [
            'groups' => ['id', 'book']
        ]);
    }

    /**
     * View New Book
     *
     * @OA\Response(
     *     response=200,
     *     description="Book has been deleted",
     * ),
     *
     * @OA\Response(
     *     response=404,
     *     description="Book was not found",
     * )
     * @ParamConverter("book", class="App\Document\Book")
     * @OA\Tag(name="books")
     */
    #[Route(path: '/{id}', name: 'book_delete', methods: ['DELETE'])]
    public function delete(Book $book)
    {
        $this->dm->remove($book);
        $this->dm->flush();
        return $this->json('Book Has been deleted', 200);
    }
}
