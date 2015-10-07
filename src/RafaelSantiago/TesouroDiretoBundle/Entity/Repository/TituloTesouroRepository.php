<?php

namespace RafaelSantiago\TesouroDiretoBundle\Entity\Repository;
use RafaelSantiago\TesouroDiretoBundle\Entity\TituloTesouro;

/**
 * TituloTesouroRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TituloTesouroRepository extends \Doctrine\ORM\EntityRepository
{

    public function getHistoricoTitulo(TituloTesouro $objTituloTesouro, $interval = 0)
    {

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('titulo_historico')
            ->from('RafaelSantiagoTesouroDiretoBundle:TituloHistorico','titulo_historico')
            ->where('titulo_historico.titulo = :titulo_id')
            ->orderBy('titulo_historico.data', 'DESC');

        if ($interval > 0){
            $query->setMaxResults($interval);
        }

        $query->setParameter('titulo_id', $objTituloTesouro->getId());

        $arrHistorico = $query->getQuery()->execute();

        $valores = array();
        foreach ($arrHistorico as $objTituloHistorico){
            array_unshift($valores, $objTituloHistorico->getValorVenda());
        }

        return implode(',',$valores);

    }

}
