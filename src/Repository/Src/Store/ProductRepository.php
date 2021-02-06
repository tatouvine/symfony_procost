<?php

namespace App\Repository\Src\Store;

use App\Entity\Src\Store\Color;
use App\Entity\Src\Store\Comment;
use App\Entity\Src\Store\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findByTimeFourLastProduct()
    {
        $qb = $this->createQueryBuilder('p')
            ->addSelect('i')
            ->leftJoin('p.image', 'i')
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults(4);
        return $qb->getQuery()->getResult();
    }

    public function findByFourProductHaveLotOfComment()
    {
        /**
         * SELECT * , COUNT(*)
         * FROM sto_product INNER JOIN sto_comment on sto_product.id = sto_comment.sto_product_id
         * GROUP BY sto_product.id
         * HAVING COUNT(*) >0
         * ORDER BY COUNT(*) DESC
         */
        $qb = $this->createQueryBuilder('p')
            ->select('p')
            ->addSelect('i')
            ->leftJoin('p.image', 'i')
            ->innerJoin(Comment::class, 'comment', Join::WITH, 'p.id = comment.product')
            ->groupBy('p.id')
            ->having('count(p)>0')
            ->orderBy('count(p)', 'DESC')
            ->setMaxResults(4);
        return $qb->getQuery()->getResult();
    }


    public function findAllWithImage()
    {
        $qb = $this->createQueryBuilder('p')
            ->addSelect('i')
            ->leftJoin('p.image', 'i');
        return $qb->getQuery()->getResult();
    }

    public function findAllWithImageById(int $brand)
    {
        $qb = $this->createQueryBuilder('p')
            ->addSelect('i')
            ->leftJoin('p.image', 'i')
            ->where('p.brand = :brand')
            ->setParameter('brand', $brand);
        return $qb->getQuery()->getResult();
    }

    public function findByIdAndSlug(int $id, string $slug)
    {
        $qb = $this->createQueryBuilder('p')
            ->addSelect('i')
            ->addSelect('b')
            ->addSelect('colors')
            ->addSelect('comments')
            ->leftJoin('p.image', 'i')
            ->leftJoin('p.brand', 'b')
            ->leftJoin('p.colors', 'colors')
            ->leftJoin('p.comments','comments')
            ->where('p.id = :id')
            ->andWhere('p.slug = :slug')
            ->setParameter('id', $id)
            ->setParameter('slug', $slug);
        return $qb->getQuery()->getOneOrNullResult();
    }
}
