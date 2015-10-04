<?php

namespace RafaelSantiago\TesouroDiretoBundle\Controller;

use RafaelSantiago\TesouroDiretoBundle\Entity\Titulo;
use RafaelSantiago\TesouroDiretoBundle\Form\Type\TituloType;
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

        // Titulos a venda
        $rpTitulosTesouro = $em->getRepository('RafaelSantiagoTesouroDiretoBundle:TituloTesouro');
        $arrTitulosTesouro = $rpTitulosTesouro->findAll();

        $valorInvestido = $rpTitulos->getValorInvestido();
        $valorCarteira = $rpTitulos->getValorCarteira();
        $valorProfit = $valorCarteira - $valorInvestido;
        $porcProfit = (($valorCarteira * 100) / $valorInvestido) - 100;
        $classProfit = ($valorProfit > 0) ? 'tiles-success' : 'tiles-alizarin';

        return $this->render('RafaelSantiagoTesouroDiretoBundle:Default:index.html.twig', array(
            'titulos' => $arrTitulos,
            'titulosTesouro' => $arrTitulosTesouro,
            'valorInvestido' => $valorInvestido,
            'valorCarteira' => $valorCarteira,
            'valorProfit' => $valorProfit,
            'porcProfit' => $porcProfit,
            'classProfit' => $classProfit
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

}
