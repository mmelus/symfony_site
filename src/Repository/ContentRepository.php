<?php

namespace App\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Content;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Content>
 *
 * @method Content|null find($id, $lockMode = null, $lockVersion = null)
 * @method Content|null findOneBy(array $criteria, array $orderBy = null)
 * @method Content[]    findAll()
 * @method Content[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Content::class);
    }

    public function add(Content $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Content $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    * @return Content[] Returns an array of Content objects
    */
    public function queryContent(?string $locale, ?string $content_category, ?string $content_code, ?string $title, ?string $groupBy ): array
    {
        $queryBuilder = $this->createQueryBuilder('c');
        if(isset($locale) && $locale != null){
            $queryBuilder->andWhere('c.language = :c_lang');
            $queryBuilder->setParameter('c_lang', $locale); 
        }
        if(isset($content_category) && $content_category != null){
            $queryBuilder->andWhere('c.content_category = :c_category');
            $queryBuilder->setParameter('c_category', $content_category); 
        }
        if(isset($content_code) && $content_code != null){
            $queryBuilder->andWhere('c.content_code = :c_code');
            $queryBuilder->setParameter('c_code', $content_code); 
        }
        if(isset($title) && $title != null){
            $queryBuilder->andWhere('c.title = :c_title');
            $queryBuilder->setParameter('c_title', $title); 
        }
        if(isset($groupBy) && $groupBy != null){
            $queryBuilder->groupBy($groupBy);
           
        }
        return $queryBuilder->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
     /**
    * @return ArrayCollection Returns an array of Content objects
    */
    public function getBugs(string $locale): ArrayCollection
    {
        //"c.content_code"
        $bugs =  $this->queryContent($locale, Content::BUGS, null, null, null );
        return new ArrayCollection(array_reverse($bugs));
    }
         /**
    * @return ArrayCollection Returns an array of Content objects
    */
    public function getServices(string $locale): ArrayCollection
    {
        $services =  $this->queryContent($locale, Content::SERVICES, null, null, "c.content_code" );
        return new ArrayCollection($services);
    }



//    public function findOneBySomeField($value): ?Content
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}
