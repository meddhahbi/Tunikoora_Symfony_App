<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Panierp
 *
 * @ORM\Table(name="panierp", indexes={@ORM\Index(name="fk_panier_produit", columns={"produit_id"}), @ORM\Index(name="fk_panier_user1", columns={"user_id"})})
 * @ORM\Entity
 */
class Panierp
{
    /**
     * @var int
     *
     * @ORM\Column(name="idPanier", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpanier;

    /**
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produit_id", referencedColumnName="id")
     * })
     */
    private $produit;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;


}
