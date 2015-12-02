<?php

namespace RafaelSantiago\TesouroDiretoBundle\Helper;

use Doctrine\ORM\EntityManager;
use RafaelSantiago\TesouroDiretoBundle\Entity\Titulo;
use RafaelSantiago\TesouroDiretoBundle\Entity\TituloHistorico;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CalculadorHelper {

    const TAXA_SELIC = 14.15;

    private $em;

    private $arrFeriados = array(
        "2015-01-01","2015-02-16","2015-02-17","2015-04-03","2015-04-21","2015-05-01","2015-06-04",
        "2015-09-07","2015-10-12","2015-11-02","2015-11-15","2015-12-25","2016-01-01","2016-02-08","2016-02-09","2016-03-25","2016-04-21","2016-05-01",
        "2016-05-26","2016-09-07","2016-10-12","2016-11-02","2016-11-15","2016-12-25","2017-01-01","2017-02-27","2017-02-28","2017-04-14","2017-04-21",
        "2017-05-01","2017-06-15","2017-09-07","2017-10-12","2017-11-02","2017-11-15","2017-12-25","2018-01-01","2018-02-12","2018-02-13","2018-03-30",
        "2018-04-21","2018-05-01","2018-05-31","2018-09-07","2018-10-12","2018-11-02","2018-11-15","2018-12-25","2019-01-01","2019-03-04","2019-03-05",
        "2019-04-19","2019-04-21","2019-05-01","2019-06-20","2019-09-07","2019-10-12","2019-11-02","2019-11-15","2019-12-25","2020-01-01","2020-02-24",
        "2020-02-25","2020-04-10","2020-04-21","2020-05-01","2020-06-11","2020-09-07","2020-10-12","2020-11-02","2020-11-15","2020-12-25","2021-01-01",
        "2021-02-15","2021-02-16","2021-04-02","2021-04-21","2021-05-01","2021-06-03","2021-09-07","2021-10-12","2021-11-02","2021-11-15","2021-12-25"
    );

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    private function isWorkingDay(\DateTime $date)
    {
        $day = intval($date->format('N'));
        $string = $date->format('Y-m-d');
        if ($day < 6 && !in_array($string, $this->arrFeriados)) {
            return true;
        }
        return false;
    }

    private function taxaAnualParaDiaria($taxaAnual)
    {
        $calc = (pow(1 + ($taxaAnual/100),(1/252))-1);
        return round($calc,8);
    }

    function workingDaysBetween(\DateTime $start, \DateTime $finish)
    {
        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($start, $interval, $finish);
        $counter = 0;
        foreach ($period as $current) {
            if ($this->isWorkingDay($current, $this->arrFeriados)) {
                $counter++;
            }
        }
        return $counter;
    }

    public function calculaPrecoFinalTitulo(Titulo $objTitulo)
    {

        $repoTituloHistorico = $this->em->getRepository('RafaelSantiagoTesouroDiretoBundle:TituloHistorico');
        $objTituloHistorico = $repoTituloHistorico->getUltimaCotacao($objTitulo);

        if (strpos($objTitulo->getTitulo()->getDescricao(), '(LFT)') > 0){
            // Tesouro Selic (LFT)
            $objDataInicial = $objTituloHistorico->getData();
            $objDataFinal = $objTitulo->getTitulo()->getDataVencimento();
            $totalDias = $this->workingDaysBetween($objDataInicial, $objDataFinal);

            $taxaSelicDia = $this->taxaAnualParaDiaria(self::TAXA_SELIC);
            $valor = $objTitulo->getValorAtualizado() * pow(1 + $taxaSelicDia, $totalDias);
        }
        elseif (strpos($objTitulo->getTitulo()->getDescricao(), '(LTN)') > 0) {
            // Tesouro Prefixado (LTN)
            $objDataInicial = $objTitulo->getDataCompra();
            $objDataFinal = $objTitulo->getDataVencimento();
            $totalDias = $this->workingDaysBetween($objDataInicial, $objDataFinal) -1; // Tiro um porque o ultimo dia não tem rendimento

            $taxaPrefixadaDia = $this->taxaAnualParaDiaria($objTitulo->getTaxa());
            $valor = $objTitulo->getValorInvestido() * pow(1 + $taxaPrefixadaDia, $totalDias);
        }


        return $valor;
    }

}
?>