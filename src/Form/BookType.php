<?php

namespace App\Form;

use App\Document\Author;
use App\Document\Book;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Doctrine\Bundle\MongoDBBundle\Form\Type\DocumentType;

class BookType extends AbstractType
{
    /**
     * BookType constructor.
     */
    public function __construct(private readonly DocumentManager $dm)
    {
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new Length(
                        [
                            'max' => 150,
                        ]
                    ),
                    new NotBlank([
                        'message' => 'TITLE_REQUIRED',
                    ]),
                ],
                'documentation' => [
                    'maximum' => 150
                ],
            ])
            ->add('description', TextType::class, [
                'constraints' => [
                    new Length(
                        [
                            'max' => 255,
                        ]
                    ),
                ],
                'documentation' => [
                    'maximum' => 255,
                ],
            ])
            ->add('price', IntegerType::class, [
                'constraints' => [
                    new Length(
                        [
                            'max' => 1000,
                        ]
                    ),
                ],
                'documentation' => [
                    'maximum' => 1000,
                ],
            ])
            ->add('author', DocumentType::class, [
                'class' => Author::class,
                'required' => true,
                'invalid_message' => 'Author id does not exist',
                'constraints' => [
                    new NotBlank([
                        'message' => 'AUTHOR_REQUIRED',
                    ]),
                ],
            ]);
        $builder->addEventListener(FormEvents::POST_SUBMIT, [$this, 'onPostSubmit']);

    }

    /**
     * @param FormEvent $event
     * @throws TransportExceptionInterface
     */
    public function onPostSubmit(FormEvent $event)
    {
        $book = $event->getData();
        if ($event->getForm()->isValid()) {
            $this->dm->persist($book);
            $this->dm->flush();
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            'csrf_protection' => false,
        ]);
    }
}
