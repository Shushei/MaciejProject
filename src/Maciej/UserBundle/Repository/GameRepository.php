<?php

namespace Maciej\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GameRepository extends EntityRepository
{

    public function findByCriteria($array, $page)
    {
        $em = $this->getEntityManager();


        $qb = $em->createQueryBuilder()
                ->select('g')
                ->from('MaciejStudyBundle:Game', 'g')
                ->setMaxResults(3)
                ->setFirstResult(($page - 1) * 3);

        if (!empty($array['title'])) {
            $qb->andWhere('g.title = :title')
                    ->setParameter('title', $array['title']);
        }
        if (!empty($array['company'])) {
            $qb->join('g.company', 'c')
                    ->andWhere('c.id = :company')
                    ->setParameter('company', $array['company']);
        }
        if (!empty($array['minDate']) Or !empty($array['maxDate'])) {
            if (!empty($array['minDate']) && !empty($array['maxDate'])){
            $qb->andWhere('g.releaseDate BETWEEN :minDate AND :maxDate')
                    ->setParameter('minDate', $array['minDate'])
                    ->setParameter('maxDate', $array['maxDate']);
            }elseif (!empty($array['minDate']) && empty($array['maxDate'])){
                $qb->andWhere('g.releaseDate > :minDate')
                    ->setParameter('minDate', $array['minDate']);
            }elseif (empty($array['minDate']) && !empty($array['maxDate'])){
                $qb->andWhere('g.releaseDate < :maxDate')
                    ->setParameter('maxDate', $array['maxDate']);
            }
        }

        $query = $qb->getQuery();
        $result['result'] = $query->getResult();
        $result['count'] = $qb->Select('COUNT(g)')
                ->setFirstResult(0)
                ->getQuery()
                ->getSingleScalarResult();

        return $result;
    }

}
