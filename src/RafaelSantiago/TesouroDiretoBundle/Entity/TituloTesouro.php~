<?php

namespace RafaelSantiago\TesouroDiretoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="RafaelSantiago\TesouroDiretoBundle\Entity\Repository\TituloTesouroRepository")
 * @ORM\Table(name="titulo_tesouro")
 */
class TituloTesouro
{

    const TYPE_SELIC = 'SELIC';
    const TYPE_PREFIX = 'PREFIXADO';
    const TYPE_IPCA = 'IPCA';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="descricao", type="string", length=200, unique=false, nullable=false)
     * @Assert\NotBlank
     * @var string
     */
    protected $descricao;

    /**
     * @ORM\Column(name="data_vencimento", type="datetime", unique=false, nullable=false)
     * @Assert\NotBlank
     * @var \DateTime
     */
    protected $data_vencimento;

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
     * @ORM\OneToMany(targetEntity="RafaelSantiago\TesouroDiretoBundle\Entity\TituloHistorico", mappedBy="titulo")
     */
    private $tituloHistoricos;

    public $tituloHistoricosGrafico;

    public function setTituloHistoricosGrafico($tituloHistoricosGrafico)
    {
        $this->tituloHistoricosGrafico = $tituloHistoricosGrafico;
        return $this;
    }

    public function getTituloHistoricosGrafico()
    {
        return $this->tituloHistoricosGrafico;
    }

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
     * Set descricao
     *
     * @param string $descricao
     *
     * @return TituloTesouro
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set dataVencimento
     *
     * @param \DateTime $dataVencimento
     *
     * @return TituloTesouro
     */
    public function setDataVencimento($dataVencimento)
    {
        $this->data_vencimento = $dataVencimento;

        return $this;
    }

    /**
     * Get dataVencimento
     *
     * @return \DateTime
     */
    public function getDataVencimento()
    {
        return $this->data_vencimento;
    }

    /**
     * Set taxaCompra
     *
     * @param float $taxaCompra
     *
     * @return TituloTesouro
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
     * @return TituloTesouro
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
     * @return TituloTesouro
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
     * @return TituloTesouro
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
     * Constructor
     */
    public function __construct()
    {
        $this->tituloHistoricos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tituloHistorico
     *
     * @param \RafaelSantiago\TesouroDiretoBundle\Entity\TituloHistorico $tituloHistorico
     *
     * @return TituloTesouro
     */
    public function addTituloHistorico(\RafaelSantiago\TesouroDiretoBundle\Entity\TituloHistorico $tituloHistorico)
    {
        $this->tituloHistoricos[] = $tituloHistorico;

        return $this;
    }

    /**
     * Remove tituloHistorico
     *
     * @param \RafaelSantiago\TesouroDiretoBundle\Entity\TituloHistorico $tituloHistorico
     */
    public function removeTituloHistorico(\RafaelSantiago\TesouroDiretoBundle\Entity\TituloHistorico $tituloHistorico)
    {
        $this->tituloHistoricos->removeElement($tituloHistorico);
    }

    /**
     * Get tituloHistoricos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTituloHistoricos()
    {
        return $this->tituloHistoricos;
    }

    public function getTituloType()
    {
        $name = $this->getDescricao();

        if (strpos($name, 'NTNB') !== false){
            return self::TYPE_IPCA;
        }
        elseif (strpos($name, 'LTN') !== false || strpos($name, 'NTNF') !== false){
            return self::TYPE_PREFIX;
        }
        elseif (strpos($name, 'LFT') !== false){
            return self::TYPE_SELIC;
        }
        else {
            return '';
        }

    }
}
