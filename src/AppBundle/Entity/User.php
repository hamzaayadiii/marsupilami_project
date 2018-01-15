<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $age;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private $famille;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private $race;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private $nourriture;

     /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="amide")
     * @ORM\JoinTable(name="liste_amis",
     * joinColumns={
     *      @ORM\JoinColumn(name="amis_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="ami_id", referencedColumnName="id")
     *  })
     */    
    private $amis;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="amis")
     */
    private $amide;

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return User
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set famille
     *
     * @param string $famille
     *
     * @return User
     */
    public function setFamille($famille)
    {
        $this->famille = $famille;

        return $this;
    }

    /**
     * Get famille
     *
     * @return string
     */
    public function getFamille()
    {
        return $this->famille;
    }

    /**
     * Set race
     *
     * @param string $race
     *
     * @return User
     */
    public function setRace($race)
    {
        $this->race = $race;

        return $this;
    }

    /**
     * Get race
     *
     * @return string
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * Set nourriture
     *
     * @param string $nourriture
     *
     * @return User
     */
    public function setNourriture($nourriture)
    {
        $this->nourriture = $nourriture;

        return $this;
    }

    /**
     * Get nourriture
     *
     * @return string
     */
    public function getNourriture()
    {
        return $this->nourriture;
    }

    /**
     * Add ami
     *
     * @param \AppBundle\Entity\User $ami
     *
     * @return User
     */
    public function addAmi(\AppBundle\Entity\User $ami)
    {
        $this->amis[] = $ami;

        return $this;
    }

    /**
     * Remove ami
     *
     * @param \AppBundle\Entity\User $ami
     */
    public function removeAmi(\AppBundle\Entity\User $ami)
    {
        $this->amis->removeElement($ami);
    }

    /**
     * Get amis
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAmis()
    {
        return $this->amis;
    }

    /**
     * Add amide
     *
     * @param \AppBundle\Entity\User $amide
     *
     * @return User
     */
    public function addAmide(\AppBundle\Entity\User $amide)
    {
        $this->amide[] = $amide;

        return $this;
    }

    /**
     * Remove amide
     *
     * @param \AppBundle\Entity\User $amide
     */
    public function removeAmide(\AppBundle\Entity\User $amide)
    {
        $this->amide->removeElement($amide);
    }

    /**
     * Get amide
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAmide()
    {
        return $this->amide;
    }
}
