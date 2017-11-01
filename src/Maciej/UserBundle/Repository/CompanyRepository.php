<?php

namespace Maciej\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CompanyRepository extends EntityRepository
{

    private function findByCriteriaRaw($array, $page, $pageSize)
    {
        $em = $this->getEntityManager();


        $qb = $em->createQueryBuilder()
                ->select('c')
                ->from('MaciejStudyBundle:Company', 'c');
        
        if (!empty($pageSize)){
                $qb->setMaxResults($pageSize);
        }
        if (!empty($page)){
                            $qb->setFirstResult(($page - 1) * $pageSize);
        }

        if (!empty($array['company'])) {
            $qb->andWhere('c.company = :company')
                    ->setParameter('company', $array['company']);
        }
        if (!empty($array['ownername'])) {
                    $qb->andWhere('c.ownername = :ownername')
                    ->setParameter('ownername', $array['ownername']);
        }
        if (!empty($array['ownersurname'])) {
                    $qb->andWhere('c.ownersurname = :ownersurname')
                    ->setParameter('ownersurname', $array['ownersurname']);
        }

        if (!empty($array['minDate'])) {
            $qb->andWhere('g.founded > :minDate')
                    ->setParameter('minDate', $array['minDate']);
        }
        if (!empty($array['maxDate'])) {
            $qb->andWhere('g.founded < :maxDate')
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
        $result = $qb->Select('COUNT(c)')
                ->setFirstResult(0)
                ->getQuery()
                ->getSingleScalarResult();
        return $result;
    }

}