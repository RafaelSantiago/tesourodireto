<?php

namespace RafaelSantiago\TesouroDiretoBundle\Controller;

use RafaelSantiago\TesouroDiretoBundle\Entity\Titulo;
use RafaelSantiago\TesouroDiretoBundle\Form\Type\TituloType;
use RafaelSantiago\TesouroDiretoBundle\Helper\CalculadorHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        // Titulos em carteira
        $rpTitulos = $em->getRepository('RafaelSantiagoTesouroDiretoBundle:Titulo');
        $arrTitulos = $rpTitulos->findAll();

        $dadosGraficoCarteira = array();
        $totalCarteira = 0;

        foreach ($arrTitulos as $objTitulo){
            $tipo = $objTitulo->getTitulo()->getTituloType();

            if (!isset($dadosGraficoCarteira[$tipo])){
                $dadosGraficoCarteira[$tipo] = round($objTitulo->getValorAtualizado(),2);
            }
            else {
                $dadosGraficoCarteira[$tipo] += round($objTitulo->getValorAtualizado(),2);
            }
            $totalCarteira += $objTitulo->getValorAtualizado();
        }

        $arrPorcentagensCarteira = array();
        foreach ($dadosGraficoCarteira as $key => $value){
            $arrPorcentagensCarteira[$key] = round((($value * 100) / $totalCarteira),2);
        }

        // Titulos a venda
        $rpTitulosTesouro = $em->getRepository('RafaelSantiagoTesouroDiretoBundle:TituloTesouro');
        $arrTitulosTesouro = $rpTitulosTesouro->findAll();
        foreach ($arrTitulosTesouro as $key => $objTituloTesouro){
            $objTituloTesouro->setTituloHistoricosGrafico($rpTitulosTesouro->getHistoricoTitulo($objTituloTesouro, 10));
            $arrTitulosTesouro[$key] = $objTituloTesouro;
        }

        $valorInvestido = $rpTitulos->getValorInvestido();
        $valorCarteira = $rpTitulos->getValorCarteira();
        $valorProfit = $valorCarteira - $valorInvestido;

        if ($valorCarteira > 0 && $valorInvestido > 0){
            $porcProfit = (($valorCarteira * 100) / $valorInvestido) - 100;
        }
        else {
            $porcProfit = 0;
        }

        $classProfit = ($valorProfit > 0) ? 'tiles-success' : 'tiles-alizarin';

        return $this->render('RafaelSantiagoTesouroDiretoBundle:Default:index.html.twig', array(
            'titulos' => $arrTitulos,
            'titulosTesouro' => $arrTitulosTesouro,
            'valorInvestido' => $valorInvestido,
            'valorCarteira' => $valorCarteira,
            'valorProfit' => $valorProfit,
            'porcProfit' => $porcProfit,
            'classProfit' => $classProfit,
            'dadosGraficoCarteira' => $arrPorcentagensCarteira
        ));
    }

    public function insertAction(Request $request)
    {
        $objTitulo = new Titulo();

        $formTitulo = $this->createForm(new TituloType($objTitulo), $objTitulo);

        if ($request->isMethod('POST')){
            $formTitulo->submit($request);

            if (true === $formTitulo->isValid()) {
                /** @var $objTitulo Titulo */
                $dados = $request->request->get('titulo');
                $objTitulo = $formTitulo->getData();
                $objTitulo->setValorTitulo(str_replace(',','.',$dados['valor_titulo']));
                $objTitulo->setQuantidade(str_replace(',','.',$dados['quantidade']));
                $objTitulo->setTaxa(str_replace(',','.',$dados['taxa']));
                $objTitulo->setValorInvestido($objTitulo->getValorTitulo() * $objTitulo->getQuantidade());


                $em = $this->getDoctrine()->getManager();
                $em->persist($objTitulo);
                $em->flush();

                $this->container->get('session')->getFlashBag()->add('success', 'Título Cadastrado');

                return $this->redirect($this->generateUrl('rafael_santiago_tesouro_direto_homepage'));
            } else {
                $this->container->get('session')->getFlashBag()->add('failure', 'Erro no cadastro');
            }

        }

        return $this->render('@RafaelSantiagoTesouroDireto/Default/insert.html.twig', array(
            'form' => $formTitulo->createView()
        ));

    }

    public function performanceAction(Request $request)
    {

        $arrRentabilidades = $this->calculaRentabilidadeTitulos();
        $arrTitulosAgrupadosLFT = $this->getTitulosAgrupados('LFT');
        $arrTitulosAgrupadosLTN = $this->getTitulosAgrupados('LTN');
        $arrTitulosAgrupadosNTNB = $this->getTitulosAgrupados('NTNB');
        $arrTitulosAgrupadosNTNBP = $this->getTitulosAgrupados('NTNB Princ');
        $arrTitulosAgrupadosNTNF = $this->getTitulosAgrupados('NTNF');

        return $this->render('@RafaelSantiagoTesouroDireto/Default/performance.html.twig', array(
            'rentabilidadesGerais' => $arrRentabilidades,
            'arrTitulosLFT' => $arrTitulosAgrupadosLFT,
            'arrTitulosLTN' => $arrTitulosAgrupadosLTN,
            'arrTitulosNTNB' => $arrTitulosAgrupadosNTNB,
            'arrTitulosNTNBP' => $arrTitulosAgrupadosNTNBP,
            'arrTitulosNTNF' => $arrTitulosAgrupadosNTNF,
        ));
    }

    private function getTitulosAgrupados($type)
    {

        $em = $this->getDoctrine()->getManager();
        $repoTituloTesouro = $em->getRepository('RafaelSantiagoTesouroDiretoBundle:TituloTesouro');
        $repoTitulo = $em->getRepository('RafaelSantiagoTesouroDiretoBundle:Titulo');

        $arrTitulosTesouro = $repoTituloTesouro->findByType($type);
        $arrTitulosCarteira = $repoTitulo->findByTitulo($arrTitulosTesouro);

        $arrTitulosAgrupados = array();

        $calculador = new CalculadorHelper($em);

        foreach ($arrTitulosCarteira as $objTitulo){
            /** @var Titulo $objTitulo */
            /** @var TituloTesouro $objTituloTesouro */

            $objTituloTesouro = $objTitulo->getTitulo();

            if (!isset($arrTitulosAgrupados[$objTituloTesouro->getId()])){

                $arrTitulosAgrupados[$objTituloTesouro->getId()] = array(
                    'tituloTesouroId'   => $objTituloTesouro->getId(),
                    'descricao'         => $objTituloTesouro->getDescricao(),
                    'quantidade'        => $objTitulo->getQuantidade(),
                    'valorCompra'       => $objTitulo->getValorInvestido(),
                    'valorAtual'        => $objTitulo->getValorAtualizado(),
                    'valorVencimento'   => $calculador->calculaPrecoFinalTitulo($objTitulo),
                );

            }
            else {

                $arrTitulosAgrupados[$objTituloTesouro->getId()]['quantidade'] += $objTitulo->getQuantidade();
                $arrTitulosAgrupados[$objTituloTesouro->getId()]['valorCompra'] += $objTitulo->getValorInvestido();
                $arrTitulosAgrupados[$objTituloTesouro->getId()]['valorAtual'] += $objTitulo->getValorAtualizado();
                $arrTitulosAgrupados[$objTituloTesouro->getId()]['valorVencimento'] += $calculador->calculaPrecoFinalTitulo($objTitulo);

            }

        }

        return $arrTitulosAgrupados;

    }
    /**
     * Retorna o array de rentabilidades dos títulos em carteira
     * @return array
     */
    private function calculaRentabilidadeTitulos()
    {

        $arrValores = array(
            'today'     => 0,
            '1day'      => 0,
            'week'      => 0,
            'month'     => 0,
            '30days'    => 0,
            'year'      => 0,
            '12months'  => 0
        );

        $em = $this->getDoctrine()->getManager();
        $rpTitulos = $em->getRepository('RafaelSantiagoTesouroDiretoBundle:Titulo');

        $arrTitulos = $rpTitulos->findAll();

        foreach ($arrTitulos as $objTitulo){
            $arrRentabilidadeTitulo = $rpTitulos->getRentabilidadeTitulo($objTitulo);

            if ($arrRentabilidadeTitulo !== null){
                $arrValores['today']      += $arrRentabilidadeTitulo['today']['value'];
                $arrValores['1day']       += $arrRentabilidadeTitulo['1day']['value'];
                $arrValores['week']       += $arrRentabilidadeTitulo['week']['value'];
                $arrValores['month']      += $arrRentabilidadeTitulo['month']['value'];
                $arrValores['30days']     += $arrRentabilidadeTitulo['30days']['value'];
                $arrValores['year']       += $arrRentabilidadeTitulo['year']['value'];
                $arrValores['12months']   += $arrRentabilidadeTitulo['12months']['value'];
            }
        }

        $arrRentabilidades = array(
            '1day'      => ((($arrValores['today'] * 100) / $arrValores['1day']) - 100),
            'week'      => ((($arrValores['today'] * 100) / $arrValores['week']) - 100),
            'month'     => ((($arrValores['today'] * 100) / $arrValores['month']) - 100),
            '30days'    => ((($arrValores['today'] * 100) / $arrValores['30days']) - 100),
            'year'      => ((($arrValores['today'] * 100) / $arrValores['year']) - 100),
            '12months'  => ((($arrValores['today'] * 100) / $arrValores['12months']) - 100)
        );

        return $arrRentabilidades;
    }

}
