<?php

namespace Api\Entity;

use Api\Hydrator\DateTimeStrategy;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Zend\Crypt\Password\Bcrypt;
use Zend\Hydrator;
use Zend\Math\Rand;

/**
 * @author Jhon Mike <developer@jhonmike.com.br>
 *
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $salt;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $activationKey;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $active = false;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    protected $role;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $created;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $updated;

    public function __construct()
    {
        $this->salt = base64_encode(Rand::getBytes(8));
        $this->setCreated();
        $this->setUpdated();
    }

    public function getId() : ?int
    {
        return $this->id;
    }

    public function setName(string $name) : User
    {
        $this->name = $name;
        return $this;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setEmail(string $email) : User
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function setPassword(string $password) : User
    {
        $this->password = $this->encryptPassword($password);
        return $this;
    }

    public function encryptPassword($password) : string
    {
        return (new Bcrypt())->create($password);
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function getSalt() : string
    {
        return $this->salt;
    }

    public function setActivationKey() : User
    {
        $this->activationKey = $this->generateKeys();
        return $this;
    }

    public function generateKeys() : User
    {
        if (empty($this->email)) {
            throw new \Exception("Email inexistente", 1);
        }
        $this->activationKey = md5($this->email.$this->salt);
        return $this;
    }

    public function getActivationKey() : string
    {
        return $this->activationKey;
    }

    public function setActive(bool $active) : User
    {
        $this->active = $active;
        return $this;
    }

    public function getActive() : bool
    {
        return $this->active;
    }

    public function setLastLogin(DateTime $lastLogin) : User
    {
        $this->lastLogin = $lastLogin;
        return $this;
    }

    public function getLastLogin() : ?DateTime
    {
        return $this->lastLogin;
    }

    public function setToken(string $token = null) : User
    {
        $this->token = $token;
        return $this;
    }

    public function getToken() : ?string
    {
        return $this->token;
    }

    public function generateToken() : User
    {
        if (empty($this->getLastLogin())) {
            throw new \Exception("Last login inexistente", 1);
        }
        $this->token = md5($this->getLastLogin()->format('ymd').$this->salt);
        return $this;
    }

    public function setPhoto(string $photo) : User
    {
        $this->photo = $photo;
        return $this;
    }

    public function getPhoto() : ?string
    {
        return $this->photo;
    }

    public function setRole(string $role = null) : User
    {
        $this->role = $role;
        return $this;
    }

    public function getRole() : ?string
    {
        return $this->role;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreated() : void
    {
        $this->created = new DateTime();
    }

    public function getCreated() : DateTime
    {
        return $this->created;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdated() : void
    {
        $this->updated = new DateTime();
    }

    public function getUpdated() : DateTime
    {
        return $this->updated;
    }

    public function hydrator(array $options) : User
    {
        $hydrator = new Hydrator\ClassMethods();
        $hydrator->hydrate($options, $this);
        return $this;
    }

    public function toArray() : array
    {
        $hydrator = new Hydrator\ClassMethods();
        $hydrator->addStrategy('created', new DateTimeStrategy());
        $hydrator->addStrategy('updated', new DateTimeStrategy());
        $array = $hydrator->extract($this);
        if ($this->getLastLogin() instanceof DateTime)
            $array['last_login'] = $this->getLastLogin()->format('Y-m-d\TH:i:sP');
        unset($array['password']);
        unset($array['salt']);
        return $array;
    }
}
