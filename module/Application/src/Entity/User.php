<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Hydrator;
use Zend\Math\Rand;

/**
 * Class User
 * @package Application\Entity
 * @author Jhon Mike <developer@jhonmike.com.br>
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=45, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="password_clue", type="string", length=45, nullable=true)
     */
    private $passwordClue;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=false)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="activation_key", type="string", length=255, nullable=false)
     */
    private $activationKey;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * Constructor
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->salt = base64_encode(Rand::getBytes(8));
        $hydrator = new Hydrator\ClassMethods();
        $hydrator->hydrate($options, $this);
        $this->activationKey = md5($this->email.$this->salt);
        $this->created = new \DateTime("now");
        $this->lastLogin = new \DateTime("now");
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() : Integer
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName(String $name) : User
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() : String
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail(String $email) : User
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() : String
    {
        return $this->email;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername(String $username) : User
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername() : String
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword(String $password) : User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword() : String
    {
        return $this->password;
    }

    /**
     * Set passwordClue
     *
     * @param string $passwordClue
     *
     * @return User
     */
    public function setPasswordClue(String $passwordClue) : User
    {
        $this->passwordClue = $passwordClue;

        return $this;
    }

    /**
     * Get passwordClue
     *
     * @return string
     */
    public function getPasswordClue() : String
    {
        return $this->passwordClue;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt(String $salt) : User
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt() : String
    {
        return $this->salt;
    }

    /**
     * Set activationKey
     *
     * @param string $activationKey
     *
     * @return User
     */
    public function setActivationKey(String $activationKey) : User
    {
        $this->activationKey = $activationKey;

        return $this;
    }

    /**
     * Get activationKey
     *
     * @return string
     */
    public function getActivationKey() : String
    {
        return $this->activationKey;
    }

    /**
     * Set active
     *
     * @param bool $active
     *
     * @return User
     */
    public function setActive(Boolean $active) : User
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function getActive() : Boolean
    {
        return $this->active;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return User
     */
    public function setCreated(\DateTime $created) : User
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated() : \DateTime
    {
        return $this->created;
    }

    /**
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     *
     * @return User
     */
    public function setLastLogin(\DateTime $lastLogin) : User
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return \DateTime
     */
    public function getLastLogin() : \DateTime
    {
        return $this->lastLogin;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        $hydrator = new Hydrator\ClassMethods();
        $array = $hydrator->extract($this);
        unset($array['password']);

        return $array;
    }

}
