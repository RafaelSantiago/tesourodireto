<?php

namespace RafaelSantiago\TesouroDiretoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use RafaelSantiago\TesouroDiretoBundle\Helper\CalculadorHelper;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="RafaelSantiago\TesouroDiretoBundle\Entity\Repository\TituloRepository")
 * @ORM\Table(name="titulo")
 */
class Titulo
{

    const TX_CUSTODIA = 0.3;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="data_compra", type="datetime", unique=false, nullable=false)
     * @Assert\NotBlank
     * @var \DateTime
     */
    protected $data_compra;

    /**
     * @ORM\Column(name="data_vencimento", type="datetime", unique=false, nullable=false)
     * @Assert\NotBlank
     * @var \DateTime
     */
    protected $data_vencimento;

    /**
     * @ORM\ManyToOne(targetEntity="RafaelSantiago\TesouroDiretoBundle\Entity\TituloTesouro")
     * @ORM\JoinColumn(name="titulo_tesouro_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $titulo;

    /**
     * @ORM\OneToMany(targetEntity="TituloHistorico", mappedBy="titulo")
     */
    private $tituloHistoricos;

    /**
     * @ORM\Column(name="taxa", type="float", unique=false, nullable=true)
     * @var float
     */
    protected $taxa;

    /**
     * @ORM\Column(name="valor_titulo", type="float", unique=false, nullable=false)
     * @var float
     */
    protected $valor_titulo;

    /**
     * @ORM\Column(name="quantidade", type="float", unique=false, nullable=true)
     * @var float
     */
    protected $quantidade;

    /**
     * @ORM\Column(name="valor_investido", type="float", unique=false, nullable=false)
     * @var float
     */
    protected $valor_investido;


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
     * Set dataCompra
     *
     * @param \DateTime $dataCompra
     *
     * @return Titulo
     */
    public function setDataCompra($dataCompra)
    {
        $this->data_compra = $dataCompra;

        return $this;
    }

    /**
     * Get dataCompra
     *
     * @return \DateTime
     */
    public function getDataCompra()
    {
        return $this->data_compra;
    }

    /**
     * Set dataVencimento
     *
     * @param \DateTime $dataVencimento
     *
     * @return Titulo
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
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set taxa
     *
     * @param float $taxa
     *
     * @return Titulo
     */
    public function setTaxa($taxa)
    {
        $this->taxa = $taxa;

        return $this;
    }

    /**
     * Get taxa
     *
     * @return float
     */
    public function getTaxa()
    {
        return $this->taxa;
    }

    /**
     * Set valorTitulo
     *
     * @param float $valorTitulo
     *
     * @return Titulo
     */
    public function setValorTitulo($valorTitulo)
    {
        $this->valor_titulo = $valorTitulo;

        return $this;
    }

    /**
     * Get valorTitulo
     *
     * @return float
     */
    public function getValorTitulo()
    {
        return $this->valor_titulo;
    }

    /**
     * Set quantidade
     *
     * @param integer $quantidade
     *
     * @return Titulo
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set valorInvestido
     *
     * @param float $valorInvestido
     *
     * @return Titulo
     */
    public function setValorInvestido($valorInvestido)
    {
        $this->valor_investido = $valorInvestido;

        return $this;
    }

    /**
     * Get valorInvestido
     *
     * @return float
     */
    public function getValorInvestido()
    {
        return $this->valor_investido;
    }

    public function getDiasInvestido()
    {
        $objDataCompra = $this->getDataCompra();
        $objDataAtual = new \DateTime();

        $diff = $objDataCompra->diff($objDataAtual);
        return $diff->format('%a');
    }

    public function getValorAtualizado()
    {
        return $this->getQuantidade() * $this->getTitulo()->getValorVenda();
    }

    public function getValorProfit()
    {
        return $this->getValorAtualizado() - $this->getValorInvestido();
    }

    public function getValorProfitLiquido()
    {
        return $this->getValorProfit() - $this->getValorImpostos();
    }

    public function getValorIof()
    {
        $tabelaIOF = array(96,96,93,90,86,83,80,76,73,70,66,63,60,56,53,50,46,43,40,36,33,30,26,23,20,16,13,10,6,3,0);
        $diasInvestido = $this->getDiasInvestido();

        if ($diasInvestido < 30 && $this->getValorProfit() > 0){
            return ($this->getValorProfit() * $tabelaIOF[$diasInvestido]) / 100;
        }

        return 0;
    }

    public function getValorIrrf()
    {
        $dias = $this->getDiasInvestido();

        if ($this->getValorProfit() <= 0){
            return 0;
        }

        if ($dias <= 180){
            $taxa = 22.5;
        }
        elseif ($dias <= 360){
            $taxa = 20.0;
        }
        elseif ($dias <= 720){
            $taxa = 17.5;
        }
        else {
            $taxa = 15;
        }

        return ($this->getValorProfit() * $taxa) / 100;

    }

    public function getValorTxCustodia()
    {
        $txDiaria = (pow(1 + (self::TX_CUSTODIA/100),(1/365))-1);
        $valor = $this->getValorInvestido() * pow(1 + ($txDiaria), $this->getDiasInvestido()) - $this->getValorInvestido();

        return $valor;
    }

    public function getValorImpostos()
    {
        return $this->getValorIof() + $this->getValorIrrf();
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
     * @return Titulo
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

    public function getPrevisaoValorVencimento()
    {
        $objCalculador = new CalculadorHelper();
        $objCalculador->calculaPrecoFinalTitulo($this);
    }

}
