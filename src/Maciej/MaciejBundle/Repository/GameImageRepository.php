<?php

namespace Maciej\MaciejBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GameImageRepository extends EntityRepository
{

    public function findByGameTitle($title)
    {
        $em = $this->getEntityManager();


        $qb = $em->createQueryBuilder()
                ->select('i')
                ->from('MaciejStudyBundle:GameImage', 'i')
                ->join('i.title', 'g')
                ->andWhere('g.id = :title')
                ->setParameter('title', $title);

        $result = $qb->getQuery()->getResult();
        return $result;
    }

}
