<?php

namespace RafaelSantiago\TesouroDiretoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class VendaType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->setMethod('POST')
            ->add('data_venda', 'date', array(
                'widget' => 'single_text',
                'label' => 'Data Venda:',
                'label_attr' => array(
                    'class' => 'col-sm-3 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control datepicker',
                    'ng-model' => 'dataVenda',
                    'ng-change' => 'atualizaValores()'
                ),
                'format' => 'dd/MM/yyyy',
                'required' => true,
                'invalid_message' => 'Este campo é obrigatório',
            ))
            ->add('tituloTesouro', 'entity', array(
                'class' => 'RafaelSantiago\TesouroDiretoBundle\Entity\TituloTesouro',
                'property' => 'descricao',
                'label' => 'Título:',
                'label_attr' => array(
                    'class' => 'col-sm-3 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control',
                    'ng-model' => 'tituloId',
                    'ng-change' => 'atualizaValores()'
                ),
                'required' => false,
                'invalid_message' => 'Este campo é obrigatório',
            ))
            ->add('valor_venda', 'text', array(
                'label' => 'Valor de Venda:',
                'label_attr' => array(
                    'class' => 'col-sm-3 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control',
                    'ng-model' => 'valorVenda',
                    'ng-change' => 'atualizaValorTotal()'
                ),
                'required' => true
            ))
            ->add('quantidade', 'text', array(
                'label' => 'Quantidade:',
                'label_attr' => array(
                    'class' => 'col-sm-3 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control',
                    'ng-model' => 'quantidade',
                    'ng-change' => 'atualizaValorTotal()'
                ),
                'required' => true
            ))
            ->add('valor_total_venda', 'text', array(
                'mapped' => false,
                'label' => 'Valor Total:',
                'label_attr' => array(
                    'class' => 'col-sm-3 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control',
                    'ng-model' => 'valorTotalVenda'
                ),
                'required' => true
            ))
            ->add('valor_taxa_custodia', 'hidden', array(
                'label' => 'Valor Taxas:',
                'label_attr' => array(
                    'class' => 'col-sm-3 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control',
                ),
                'required' => true
            ))
            ->add('valor_impostos', 'hidden', array(
                'label' => 'Valor Impostos:',
                'label_attr' => array(
                    'class' => 'col-sm-3 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control',
                ),
                'required' => true
            ))
            ->add('salvar', 'submit', array(
                'label' => 'Salvar',
                'attr' => array(
                    'class' => 'btn btn-primary',
                    'icon' => 'icon-ok'
                )
            ));
    }

    public function getName()
    {
        return 'titulo';
    }
}