<?php

namespace NeoBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use NeoBundle\Controller\ReportBestMonth\BestMonthProviderInterface;
use NeoBundle\Controller\ReportBestYear\BestYearProviderInterface;
use NeoBundle\Controller\ReportFastest\FastestNeoProviderInterface;
use NeoBundle\Controller\ReportHazardous\HazardousNeoProviderInterface;
use NeoBundle\Entity\Neo;

class NeoRepository
    extends EntityRepository
    implements HazardousNeoProviderInterface,
    FastestNeoProviderInterface,
    BestYearProviderInterface,
    BestMonthProviderInterface
{
    public function saveBatch(Neo ...$listOfNeo)
    {
        foreach ($listOfNeo as $neo) {
            $this->getEntityManager()->persist($neo);
        }
        $this->getEntityManager()->flush();
    }

    /**
     * @return Neo[]
     */
    public function listHazardousNeo()
    {
        return $this->findBy(['isHazardous' => true]);
    }

    /**
     * @param $isHazardous
     *
     * @return Neo|null
     */
    public function getFastestNeo($isHazardous = false)
    {
        $qb = $this->createQueryBuilder('n');
        $qb
            ->where($qb->expr()->eq('n.isHazardous', ':isHazardous'))
            ->setParameter('isHazardous', $isHazardous)
            ->orderBy('n.speed', 'ASC')
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param $isHazardous
     *
     * @return string
     */
    public function getYearWithMostAsteroids($isHazardous = false)
    {
        $qb = $this->createQueryBuilder('n');
        $qb
            ->select('YEAR(n.date) AS year')
            ->addSelect('COUNT(n.date) as asteroids_number')
            ->where($qb->expr()->eq('n.isHazardous', ':isHazardous'))
            ->setParameter('isHazardous', $isHazardous)
            ->groupBy('year')
            ->orderBy('asteroids_number', 'ASC')
            ->setMaxResults(1);

        $rows = $qb->getQuery()->getArrayResult();

        return isset($rows[0]['year']) ? $rows[0]['year'] : null;
    }

    /**
     * @param $isHazardous
     *
     * @return string
     */
    public function getMonthWithMostAsteroids($isHazardous = false)
    {
        $qb = $this->createQueryBuilder('n');
        $qb
            ->select("DATE_FORMAT(n.date, '%Y-%m') AS month")
            ->addSelect('COUNT(n.date) as asteroids_number')
            ->where($qb->expr()->eq('n.isHazardous', ':isHazardous'))
            ->setParameter('isHazardous', $isHazardous)
            ->groupBy('month')
            ->orderBy('asteroids_number', 'ASC')
            ->setMaxResults(1);

        $rows = $qb->getQuery()->getArrayResult();

        return isset($rows[0]['month']) ? $rows[0]['month'] : null;
    }
}
