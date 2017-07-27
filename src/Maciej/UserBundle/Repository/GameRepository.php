<?php

namespace Maciej\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GameRepository extends EntityRepository
{

    private function findByCriteriaRaw($array, $page, $pageSize)
    {
        $em = $this->getEntityManager();


        $qb = $em->createQueryBuilder()
                ->select('g')
                ->from('MaciejStudyBundle:Game', 'g')
                ->setMaxResults($pageSize)
                ->setFirstResult(($page - 1) * $pageSize);

        if (!empty($array['title'])) {
            $qb->andWhere('g.title = :title')
                    ->setParameter('title', $array['title']);
        }
        if (!empty($array['company'])) {
            $qb->join('g.company', 'c')
                    ->andWhere('c.company = :company')
                    ->setParameter('company', $array['company']);
        }

        if (!empty($array['minDate']) && empty($array['maxDate'])) {
            $qb->andWhere('g.releaseDate > :minDate')
                    ->setParameter('minDate', $array['minDate']);
        }
        if (empty($array['minDate']) && !empty($array['maxDate'])) {
            $qb->andWhere('g.releaseDate < :maxDate')
                    ->setParameter('maxDate', $array['maxDate']);
        }
      
        return $qb;
    }
    public function findByCriteria($array, $page, $pageSize)
    {
        $qb = $this->findByCriteriaRaw($array, $page, $pageSize);
        $result = $qb->getQuery()->getResult();
        return $result;
    }
    public function countByCriteria($array, $page, $pageSize)
    {
        $qb = $this->findByCriteriaRaw($array, $page, $pageSize);
        $result = $qb->Select('COUNT(g)')
                ->setFirstResult(0)
                ->getQuery()
                ->getSingleScalarResult();
        return $result;
    }

}
