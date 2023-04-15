<?php

namespace App\Factory;

use App\Entity\Comment;
use App\Homework\CommentContentProviderInterface;
use App\Repository\CommentRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Comment>
 *
 * @method        Comment|Proxy create(array|callable $attributes = [])
 * @method static Comment|Proxy createOne(array $attributes = [])
 * @method static Comment|Proxy find(object|array|mixed $criteria)
 * @method static Comment|Proxy findOrCreate(array $attributes)
 * @method static Comment|Proxy first(string $sortedField = 'id')
 * @method static Comment|Proxy last(string $sortedField = 'id')
 * @method static Comment|Proxy random(array $attributes = [])
 * @method static Comment|Proxy randomOrCreate(array $attributes = [])
 * @method static CommentRepository|RepositoryProxy repository()
 * @method static Comment[]|Proxy[] all()
 * @method static Comment[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Comment[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Comment[]|Proxy[] findBy(array $attributes)
 * @method static Comment[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Comment[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class CommentFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(private CommentContentProviderInterface $commentContentProvider)
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        $words = ['PHP', 'C#', 'C++', 'Java', 'JS'];
        $wordsCount = self::faker()->boolean(70) ? mt_rand(1, 5) : 0;
        $content = $this
            ->commentContentProvider
            ->get(self::faker()->randomElement($words), $wordsCount)
        ;
        return [
            'article' => ArticleFactory::new(),
            'authorName' => self::faker()->name(),
            'content' => $content,
            'createdAt' => \DateTimeImmutable::createFromMutable(
                self::faker()->dateTimeBetween('-100 days', '-1 days')
            ),
            'deletedAt' => self::faker()->boolean() ? self::faker()->dateTimeThisMonth() : null

        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Comment $comment): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Comment::class;
    }
}
