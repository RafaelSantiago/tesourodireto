<?php

namespace RafaelSantiago\TesouroDiretoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TituloType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->setMethod('POST')
            ->add('data_compra', 'date', array(
                'widget' => 'single_text',
                'label' => 'Data Compra:',
                'label_attr' => array(
                    'class' => 'col-sm-3 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control datepicker'
                ),
                'format' => 'dd/MM/yyyy',
                'required' => true,
                'invalid_message' => 'Este campo é obrigatório',
            ))
            ->add('titulo', 'entity', array(
                'class' => 'RafaelSantiago\TesouroDiretoBundle\Entity\TituloTesouro',
                'property' => 'descricao',
                'label' => 'Título:',
                'label_attr' => array(
                    'class' => 'col-sm-3 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control'
                ),
                'required' => false,
                'invalid_message' => 'Este campo é obrigatório',
            ))
            ->add('data_vencimento', 'date', array(
                'widget' => 'single_text',
                'label' => 'Data Vencimento:',
                'label_attr' => array(
                    'class' => 'col-sm-3 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control datepicker',
                ),
                'format' => 'dd/MM/yyyy',
                'invalid_message' => 'Data inválida',
                'required' => true
            ))
            ->add('taxa', 'text', array(
                'label' => 'Taxa % (a.a):',
                'label_attr' => array(
                    'class' => 'col-sm-3 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control',
                ),
                'required' => false
            ))
            ->add('valor_titulo', 'text', array(
                'label' => 'Valor Título:',
                'label_attr' => array(
                    'class' => 'col-sm-3 control-label'
                ),
                'attr' => array(
                    'class' => 'form-control',
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
                ),
                'required' => true
            ))
            ->add('salvar', 'submit', array(
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