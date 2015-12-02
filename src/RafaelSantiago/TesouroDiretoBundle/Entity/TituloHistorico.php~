<?php

namespace RafaelSantiago\TesouroDiretoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="RafaelSantiago\TesouroDiretoBundle\Entity\Repository\TituloHistoricoRepository")
 * @ORM\Table(name="titulo_historico")
 */
class TituloHistorico
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="RafaelSantiago\TesouroDiretoBundle\Entity\TituloTesouro", inversedBy="tituloHistoricos")
     * @ORM\JoinColumn(name="titulo_tesouro_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $titulo;

    /**
     * @ORM\Column(name="data", type="datetime", unique=false, nullable=false)
     * @Assert\NotBlank
     * @var \DateTime
     */
    protected $data;

    /**
     * @ORM\Column(name="taxa_compra", type="float", unique=false, nullable=true)
     * @var float
     */
    protected $taxa_compra;

    /**
     * @ORM\Column(name="taxa_venda", type="float", unique=false, nullable=true)
     * @var float
     */
    protected $taxa_venda;

    /**
     * @ORM\Column(name="valor_compra", type="float", unique=false, nullable=false)
     * @var float
     */
    protected $valor_compra;

    /**
     * @ORM\Column(name="valor_venda", type="float", unique=false, nullable=false)
     * @var float
     */
    protected $valor_venda;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set data
     *
     * @param \DateTime $data
     *
     * @return TituloHistorico
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set taxaCompra
     *
     * @param float $taxaCompra
     *
     * @return TituloHistorico
     */
    public function setTaxaCompra($taxaCompra)
    {
        $this->taxa_compra = $taxaCompra;

        return $this;
    }

    /**
     * Get taxaCompra
     *
     * @return float
     */
    public function getTaxaCompra()
    {
        return $this->taxa_compra;
    }

    /**
     * Set taxaVenda
     *
     * @param float $taxaVenda
     *
     * @return TituloHistorico
     */
    public function setTaxaVenda($taxaVenda)
    {
        $this->taxa_venda = $taxaVenda;

        return $this;
    }

    /**
     * Get taxaVenda
     *
     * @return float
     */
    public function getTaxaVenda()
    {
        return $this->taxa_venda;
    }

    /**
     * Set valorCompra
     *
     * @param float $valorCompra
     *
     * @return TituloHistorico
     */
    public function setValorCompra($valorCompra)
    {
        $this->valor_compra = $valorCompra;

        return $this;
    }

    /**
     * Get valorCompra
     *
     * @return float
     */
    public function getValorCompra()
    {
        return $this->valor_compra;
    }

    /**
     * Set valorVenda
     *
     * @param float $valorVenda
     *
     * @return TituloHistorico
     */
    public function setValorVenda($valorVenda)
    {
        $this->valor_venda = $valorVenda;

        return $this;
    }

    /**
     * Get valorVenda
     *
     * @return float
     */
    public function getValorVenda()
    {
        return $this->valor_venda;
    }

    /**
     * Set titulo
     *
     * @param \RafaelSantiago\TesouroDiretoBundle\Entity\TituloTesouro $titulo
     *
     * @return TituloHistorico
     */
    public function setTitulo(\RafaelSantiago\TesouroDiretoBundle\Entity\TituloTesouro $titulo = null)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return \RafaelSantiago\TesouroDiretoBundle\Entity\TituloTesouro
     */
    public function getTitulo()
    {
        return $this->titulo;
    }
}
