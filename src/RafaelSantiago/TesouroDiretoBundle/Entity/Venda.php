<?php

namespace RafaelSantiago\TesouroDiretoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="RafaelSantiago\TesouroDiretoBundle\Entity\Repository\VendaRepository")
 * @ORM\Table(name="venda")
 */
class Venda
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="data_venda", type="datetime", unique=false, nullable=false)
     * @Assert\NotBlank
     * @var \DateTime
     */
    protected $data_venda;

    /**
     * @ORM\ManyToOne(targetEntity="RafaelSantiago\TesouroDiretoBundle\Entity\TituloTesouro")
     * @ORM\JoinColumn(name="titulo_tesouro_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $tituloTesouro;

    /**
     * @ORM\Column(name="valor_venda", type="float", unique=false, nullable=false)
     * @var float
     */
    protected $valor_venda;

    /**
     * @ORM\Column(name="quantidade", type="float", unique=false, nullable=false)
     * @var float
     */
    protected $quantidade;

    /**
     * @ORM\Column(name="valor_lucro_bruto", type="float", unique=false, nullable=false)
     * @var float
     */
    protected $valor_lucro_bruto;

    /**
     * @ORM\Column(name="valor_taxa_custodia", type="float", unique=false, nullable=false)
     * @var float
     */
    protected $valor_taxa_custodia;

    /**
     * @ORM\Column(name="valor_impostos", type="float", unique=false, nullable=false)
     * @var float
     */
    protected $valor_impostos;

    /**
     * @ORM\Column(name="valor_lucro_liquido", type="float", unique=false, nullable=false)
     * @var float
     */
    protected $valor_lucro_liquido;


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
     * Set dataVenda
     *
     * @param \DateTime $dataVenda
     *
     * @return Venda
     */
    public function setDataVenda($dataVenda)
    {
        $this->data_venda = $dataVenda;

        return $this;
    }

    /**
     * Get dataVenda
     *
     * @return \DateTime
     */
    public function getDataVenda()
    {
        return $this->data_venda;
    }

    /**
     * Set valorVenda
     *
     * @param float $valorVenda
     *
     * @return Venda
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
     * Set quantidade
     *
     * @param float $quantidade
     *
     * @return Venda
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    /**
     * Get quantidade
     *
     * @return float
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set valorLucroBruto
     *
     * @param float $valorLucroBruto
     *
     * @return Venda
     */
    public function setValorLucroBruto($valorLucroBruto)
    {
        $this->valor_lucro_bruto = $valorLucroBruto;

        return $this;
    }

    /**
     * Get valorLucroBruto
     *
     * @return float
     */
    public function getValorLucroBruto()
    {
        return $this->valor_lucro_bruto;
    }

    /**
     * Set valorTaxaCustodia
     *
     * @param float $valorTaxaCustodia
     *
     * @return Venda
     */
    public function setValorTaxaCustodia($valorTaxaCustodia)
    {
        $this->valor_taxa_custodia = $valorTaxaCustodia;

        return $this;
    }

    /**
     * Get valorTaxaCustodia
     *
     * @return float
     */
    public function getValorTaxaCustodia()
    {
        return $this->valor_taxa_custodia;
    }

    /**
     * Set valorImpostos
     *
     * @param float $valorImpostos
     *
     * @return Venda
     */
    public function setValorImpostos($valorImpostos)
    {
        $this->valor_impostos = $valorImpostos;

        return $this;
    }

    /**
     * Get valorImpostos
     *
     * @return float
     */
    public function getValorImpostos()
    {
        return $this->valor_impostos;
    }

    /**
     * Set valorLucroLiquido
     *
     * @param float $valorLucroLiquido
     *
     * @return Venda
     */
    public function setValorLucroLiquido($valorLucroLiquido)
    {
        $this->valor_lucro_liquido = $valorLucroLiquido;

        return $this;
    }

    /**
     * Get valorLucroLiquido
     *
     * @return float
     */
    public function getValorLucroLiquido()
    {
        return $this->valor_lucro_liquido;
    }

    /**
     * Set tituloTesouro
     *
     * @param \RafaelSantiago\TesouroDiretoBundle\Entity\TituloTesouro $tituloTesouro
     *
     * @return Venda
     */
    public function setTituloTesouro(\RafaelSantiago\TesouroDiretoBundle\Entity\TituloTesouro $tituloTesouro = null)
    {
        $this->tituloTesouro = $tituloTesouro;

        return $this;
    }

    /**
     * Get tituloTesouro
     *
     * @return \RafaelSantiago\TesouroDiretoBundle\Entity\TituloTesouro
     */
    public function getTituloTesouro()
    {
        return $this->tituloTesouro;
    }
}
