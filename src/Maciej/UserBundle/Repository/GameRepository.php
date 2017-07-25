<?php

namespace Maciej\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GameRepository extends EntityRepository
{

    public function findByCriteria($request)
    {
        $em = $this->getEntityManager();
        $array = $request->get('url');

        $qb = $em->createQueryBuilder()
                ->select('g')
                ->from('MaciejStudyBundle:Game', 'g')
                ->join('g.company', 'c');

        if (!empty($array['title'])) {
            $qb->andWhere('g.title = :title')
                    ->setParameter('title', $array['title']);
        }
        if (!empty($array['company'])) {
            $qb->andWhere('c.company = :company')
                    ->setParameter('company', $array['company']);
        }
        if (!empty($array['minDate']) && !empty($array['maxDate'])) {
            $qb->andWhere('g.releaseDate BETWEEN :minDate AND :maxDate')
                    ->setParameter('minDate', $array['minDate'])
                    ->setParameter('maxDate', $array['maxDate']);
        }
        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;
    }

}
