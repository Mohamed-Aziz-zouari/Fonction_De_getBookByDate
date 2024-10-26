<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

//    /**
//     * @return Author[] Returns an array of Author objects
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

//    public function findOneBySomeField($value): ?Author
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function getAuthorsOrderByName (){
// 1. Accéder à l'EntityManager
    $em = $this->getEntityManager();
// 2. Créer une Requête DQL avec createQuery
$query= $em->createQuery('SELECT a FROM App\Entity\Author a ORDER BY a.username ASC');

$results = $query->getResult(); return $results; }

public function getAuthorsOrderByEmail ($email){
    // 1. Accéder à l'EntityManager
        $em = $this->getEntityManager();
    // 2. Créer une Requête DQL avec createQuery
    $query= $em->createQuery('SELECT a FROM App\Entity\Author a Where a.email =:em');
    $query->setParameter('em', $email);
    $results = $query->getResult(); return $results; }

}