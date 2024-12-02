<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function search(string $search){
        //on instancie le queryBuilder qui permet d'aller interroger la dataBase
        //quand on passe par le querybuilder pour faire des requetes SQL
        //on appelle les variable avec :nomVariable
        return $this->createQueryBuilder('a')
            //je débute ma requet SQL an précisant le where = 1 condition
            ->where('a.title LIKE :search')
            //on donne une seconde condition
            ->orWhere('a.content LIKE :search')
            //on paramètre la variable search
            ->setParameter('search', '%'.$search.'%')
            //on construit la requete SQL à partir des données précisées plus haut
            ->getQuery()
            //on récupère les article filtrés par la DB
            ->getResult();

        //ce qu'on écrit en SQL :
        // SELECT * FROM article AS WHERE a.title LIKE %search% OR WHERE a.content LIKE %search%
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
