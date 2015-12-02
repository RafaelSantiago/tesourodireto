<?php

namespace RafaelSantiago\TesouroDiretoBundle\Command;

use RafaelSantiago\TesouroDiretoBundle\Entity\TituloHistorico;
use RafaelSantiago\TesouroDiretoBundle\Entity\TituloTesouro;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

class TitulosCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('tesouro:titulos:atualizar')
            ->setDescription('Atualiza os titulos com base no site do tesouro direto')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $objDataAtual = new \DateTime();
        $objDataAtual->setTime(0,0,0);

        $doctrine = $this->getContainer()->get('doctrine');
        $em = $doctrine->getManager();
        $tituloRepo = $em->getRepository('RafaelSantiagoTesouroDiretoBundle:TituloTesouro');
        $tituloHistoricoRepo = $em->getRepository('RafaelSantiagoTesouroDiretoBundle:TituloHistorico');

        $html = file_get_contents('http://www.tesouro.fazenda.gov.br/tesouro-direto-precos-e-taxas-dos-titulos');

        $crawler = new Crawler($html);
        $arrTitulos = $crawler->filter('tr.camposTesouroDireto');

        foreach ($arrTitulos as $htmlTitulo)
        {
            $htmlTitulo = $crawler = new Crawler($htmlTitulo);

            $dadosTitulo = array();

            foreach ($htmlTitulo->filter('td') as $htmlTd){
                /** @var $htmlTd \DOMElement */
                $dadosTitulo[] = $htmlTd->nodeValue;
            }

            $objTitulo = $tituloRepo->findOneBy(array('descricao' => $dadosTitulo[0]));

            if (!$objTitulo instanceof TituloTesouro){
                $objTitulo = new TituloTesouro();
            }
            $objDataVencimento = \DateTime::createFromFormat('d/m/Y H:i:s', $dadosTitulo[1] . '00:00:00');

            $objTitulo->setDescricao($dadosTitulo[0]);
            $objTitulo->setDataVencimento($objDataVencimento);
            $objTitulo->setTaxaCompra($this->formataValor($dadosTitulo[2]));
            $objTitulo->setTaxaVenda($this->formataValor($dadosTitulo[3]));
            $objTitulo->setValorCompra($this->formataValor($dadosTitulo[4]));
            $objTitulo->setValorVenda($this->formataValor($dadosTitulo[5]));

            $em->persist($objTitulo);
            $em->flush();

            // Grava o historico do título
            $objTituloHistorico = $tituloHistoricoRepo->findOneBy(
                array(
                    'data' => $objDataAtual,
                    'titulo' => $objTitulo->getId()
                )
            );

            if (!$objTituloHistorico instanceof TituloHistorico){
                $objTituloHistorico = new TituloHistorico();
                $objTituloHistorico->setTitulo($objTitulo);
                $objTituloHistorico->setData($objDataAtual);
                $objTituloHistorico->setTaxaCompra($this->formataValor($dadosTitulo[2]));
                $objTituloHistorico->setTaxaVenda($this->formataValor($dadosTitulo[3]));
                $objTituloHistorico->setValorCompra($this->formataValor($dadosTitulo[4]));
                $objTituloHistorico->setValorVenda($this->formataValor($dadosTitulo[5]));

                $em->persist($objTituloHistorico);
                $em->flush();
            }

        }
    }

    private function formataValor($valor)
    {
        $valor = filter_var($valor, FILTER_SANITIZE_NUMBER_FLOAT);
        $valor = $valor / 100;

        return $valor;
    }

}