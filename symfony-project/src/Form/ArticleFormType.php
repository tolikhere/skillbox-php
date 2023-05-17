<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\User;
use App\Form\DataTransformer\ArticleWordsFilterTransformer;
use App\Homework\ArticleWordsFilter;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    public function __construct(
        private UserRepository $userRepository,
        private ArticleWordsFilterTransformer $transformer
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', options:       ['label' => 'Название статьи'])
            ->add('description', options: ['label' => 'Описание статьи'])
            ->add('body', options:        ['label' => 'Содержание статьи'])
            ->add('keywords', options:    ['label' => 'Ключевые слова статьи'])
            ->add('author', EntityType::class, [
                'class'        => User::class,
                'label'        => 'Автор статьи',
                'choice_label' => function (User $user) {
                    return $user->getFirstName();
                },
                'choices'     => $this->userRepository->findAllSortedByFirstName(),
                'attr'        => ['class' => "col-6"],
                'placeholder' => 'Выберите автора статьи',
            ])
            ->add('publishedAt', options: [
                'label'  => 'Дата публикации статьи',
                'widget' => 'single_text',
                'attr'   => ['class' => "col-2"],
            ])
            ->add('Submit', SubmitType::class, ['label' => 'Создать'])
        ;

        $builder->get('body')->addModelTransformer($this->transformer);
        $builder->get('description')->addModelTransformer($this->transformer)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
