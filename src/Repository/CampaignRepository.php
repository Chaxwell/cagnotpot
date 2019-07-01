<?php

namespace App\Repository;

use App\Entity\Payment;
use App\Entity\Campaign;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Campaign|null find($id, $lockMode = null, $lockVersion = null)
 * @method Campaign|null findOneBy(array $criteria, array $orderBy = null)
 * @method Campaign[]    findAll()
 * @method Campaign[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampaignRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Campaign::class);
        $this->em = $this->getEntityManager();
        $this->connectionManager = $this->getEntityManager()->getConnection();
        $this->paymentTable = $this->em->getClassMetadata(Payment::class)->getTableName();
        $this->campaignTable = $this->em->getClassMetadata(Campaign::class)->getTableName();
        $this->participantTable = $this->em->getClassMetadata(Participant::class)->getTableName();
    }

    /**
     *  Count the number of participants of a given Campaign
     * @param Campaign $campaign
     * @return int
     */
    public function countParticipants(Campaign $campaign): ?int
    {
        $listOfParticipants = $this->connectionManager
            ->prepare("SELECT COUNT(*) as count FROM {$this->participantTable}
                       WHERE {$this->participantTable}.campaign_id = ?");
        $listOfParticipants->execute(array($campaign->getId()));

        return $listOfParticipants->fetch()['count'];
    }

    /**
     * Count the total donation amount of a given Campaign
     * @param Campaign $campaign
     * @return int
     */
    public function countTotalAmount(Campaign $campaign): ?int
    {
        $getTotalAmount = $this->connectionManager
            ->prepare("SELECT SUM({$this->paymentTable}.amount) as amount FROM {$this->paymentTable}
                       INNER JOIN {$this->participantTable} ON {$this->paymentTable}.participant_id = {$this->participantTable}.id
                       WHERE {$this->participantTable}.campaign_id = ?");
        $getTotalAmount->execute(array($campaign->getId()));

        return $getTotalAmount->fetch()['amount'];
    }

    /**
     * Get the list of participants' emails and donations of a given Campaign
     * @param Campaign $campaign
     * @return array
     */
    public function getParticipants(Campaign $campaign): ?array
    {
        $getParticipantInfos = $this->connectionManager
            ->prepare("SELECT {$this->participantTable}.email, {$this->paymentTable}.amount,
                              {$this->paymentTable}.hide_identity, {$this->paymentTable}.hide_amount
                       FROM {$this->participantTable}
                       INNER JOIN {$this->paymentTable} ON {$this->participantTable}.id = {$this->paymentTable}.participant_id
                       WHERE {$this->participantTable}.campaign_id = ?
                       ORDER BY {$this->participantTable}.id DESC");
        $getParticipantInfos->execute(array($campaign->getId()));

        return $getParticipantInfos->fetchAll();
    }

    // /**
    //  * @return Campaign[] Returns an array of Campaign objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Campaign
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
