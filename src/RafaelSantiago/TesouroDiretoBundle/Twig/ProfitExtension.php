<?php

namespace RafaelSantiago\TesouroDiretoBundle\Twig;

use Doctrine\ORM\EntityManager;

class ProfitExtension extends \Twig_Extension
{

    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('titulo_profit', array($this, 'tituloProfitFunction')),
        );
    }

    public function tituloProfitFunction($valorInicial, $valorFinal, $colors = true)
    {

        $valorProfit = $valorFinal - $valorInicial;

        if ($colors){
            $classProfit = ($valorProfit > 0) ? 'text-success' : 'text-danger';
        }
        else {
            $classProfit = '';
        }

        $iconProfit = ($valorProfit > 0) ? 'fa-arrow-up' : 'fa-arrow-down';

        $porcentagem = (($valorFinal * 100) / $valorInicial) - 100;
        $porcentagem = round($porcentagem, 2);

        return "<span class='".$classProfit."'>R$ ". number_format($valorProfit,2,',','.') ."<br/><span class='small'>(".$porcentagem." %)</span></span>";

    }

    public function getName()
    {
        return 'titulo_profit';
    }
}