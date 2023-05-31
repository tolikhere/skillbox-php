<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\User;
use App\Form\DataTransformer\ArticleWordsFilterTransformer;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;

class ArticleFormType extends AbstractType
{
    public function __construct(
        private UserRepository $userRepository,
        private ArticleWordsFilterTransformer $transformer
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var  Article|null $article*/
        $article = $options['data'] ?? null;
        $isEdit = $article?->getId() && $article?->isPublished();
        $imageConstraints = [
            new Image([
                'maxSize' => '2M',
                'minWidth' => 480,
                'minHeight' => 300,
                'allowLandscape' => true,
                'allowPortrait' => false,
            ])
        ];

        if (! $article?->getImageFilename()) {
            $imageConstraints[] = new NotNull([
                'message' => 'article.null_image'
            ]);
        }
        $builder
            ->add('imageFile', FileType::class, [
                'label' => 'label.image_file_name',
                'mapped' => false,
                'required' => ! $article?->getImageFilename(),
                'constraints' => $imageConstraints,
                'attr' => [
                    'placeholder' => $article?->getImageFilename() ?: 'placeholder.image_file'
                ]
            ])
            ->add('title', options:       ['label' => 'label.title'])
            ->add('description', options: ['label' => 'label.description'])
            ->add('body', options:        ['label' => 'label.body'])
            ->add('keywords', options:    ['label' => 'label.keywords'])
            ->add('author', EntityType::class, [
                'class'        => User::class,
                'disabled'     => $isEdit,
                'label'        => 'label.author',
                'choice_label' => function (User $user) {
                    return $user->getFirstName();
                },
                'choices'     => $this->userRepository->findAllSortedByFirstName(),
                'attr'        => ['class' => "col-6"],
                'placeholder' => 'choices.placeholder.author',
            ])
        ;

        if ($options['enabled_published_at']) {
            $builder->add('publishedAt', options: [
                    'label'  => 'label.publishedAt',
                    'widget' => 'single_text',
                    'attr'   => ['class' => "col-3"],
            ]);
        }

        $builder->get('body')->addModelTransformer($this->transformer);
        $builder->get('description')->addModelTransformer($this->transformer)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'enabled_published_at' => false,
        ]);
    }
}
