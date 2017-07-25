<?php

namespace Maciej\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GameRepository extends EntityRepository
{

    public function findByCriteria($request)
    {
        $em = $this->getEntityManager();
        $title = $request->get('title');
        $company = $request->get('company');
        $minDate = $request->get('minDate');
        $maxDate = $request->get('maxDate');

        $qb = $em->createQueryBuilder()
                ->select('g')
                ->from('MaciejStudyBundle:Game', 'g')
                ->join('g.company', 'c');

        if (!empty($title)) {
            $qb->andWhere('g.title = :title')
                    ->setParameter('title', $title);
        }
        if (!empty($company)) {
            $qb->andWhere('c.company = :company')
                    ->setParameter('company', $company);
        }
        if (!empty($minDate) && !empty($maxDate)) {
            $qb->andWhere('g.releaseDate BETWEEN :minDate AND :maxDate')
                    ->setParameter('minDate', $minDate)
                    ->setParameter('maxDate', $maxDate);
        }
        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;
    }

}
