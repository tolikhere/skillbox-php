<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function save(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    * @return Article[] Returns an array of Article objects
    */
    public function orderByPublishedAtField(): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.publishedAt IS NOT NULL')
            ->leftJoin('a.comments', 'c')
            ->addSelect('c')
            ->leftJoin('a.author', 'u')
            ->addSelect('u')
            ->leftJoin('a.tags', 't')
            ->addSelect('t')
            ->orderBy('a.publishedAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Article[] Returns an array of Article objects
    */
    public function findBySlugField(?string $slug): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.slug = :slug')
            ->setParameter('slug', $slug)
            ->leftJoin('a.comments', 'c')
            ->addSelect('c')
            ->leftJoin('a.tags', 't')
            ->addSelect('t')
            ->getQuery()
            ->getResult()
        ;
    }

    public function latestQueryBuilder(string $search = null)
    {
        $query = $this->createQueryBuilder('a');
        if ($search) {
            $query
                ->andWhere('a.title LIKE :search OR a.body LIKE :search OR u.firstName LIKE :search')
                ->setParameter('search', "%$search%")
            ;
        }
        return $query
            ->leftJoin('a.author', 'u')
            ->addSelect('u')
            ->orderBy('a.publishedAt', 'DESC');
    }

//    /**
//     * @return Article[] Returns an array of Article objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
