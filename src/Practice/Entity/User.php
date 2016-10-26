<?php
namespace Practice\Entity;

use \DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Practice\Web\Utils\Encryptions;

/**
 * @Entity
 * @Table(
 *     name="tb_user",
 *     uniqueConstraints={
 *          @UniqueConstraint(
 *              name="uniq_user_email",
 *              columns={"email"}
 *          )
 *     },
 *     indexes={
 *          @Index(
 *              name="idx_user_email",
 *              columns={"email"}
 *          )
 *      }
 * )
 * @HashLifecycleCallbacks
 */
class User extends Entity
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     * @var integer
     */
    protected $id;

    /**
     * @Column(type="string", unique=true)
     * @var string
     */
    protected $email;

    /**
     * @Column(type="string", length=30)
     * @var string
     */
    protected $name;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $encrypted_password;

    /**
     * @OneToMany(
     *     targetEntity="Todo",
     *     mappedBy="writer",
     *     cascade={"persist", "remove", "merge"},
     *     orphanRemoval=true,
     *     fetch="EXTRA_LAZY"
     * )
     * @var ArrayCollection
     */
    protected $todos;

    /**
     * @Column(type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     * @var DateTime
     */
    protected $created;

    /**
     * @Column(type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     * @var DateTime
     */
    protected $last_modified;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEncryptedPassword(): string
    {
        return $this->encrypted_password;
    }

    /**
     * @param string $encrypted_password
     */
    public function setEncryptedPassword(string $encrypted_password)
    {
        $this->encrypted_password = $encrypted_password;
    }

    /**
     * @return null|ArrayCollection
     */
    public function getTodos()
    {
        return $this->todos;
    }

    /**
     * @param ArrayCollection $todos
     */
    public function setTodos(ArrayCollection $todos)
    {
        $this->todos = $todos;
    }

    /**
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     */
    public function setCreated(DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @return DateTime
     */
    public function getLastModified(): DateTime
    {
        return $this->last_modified;
    }

    /**
     * @param DateTime $last_modified
     */
    public function setLastModified(DateTime $last_modified)
    {
        $this->last_modified = $last_modified;
    }

    /**
     * @param $raw_password
     * @return bool
     */
    public function passwordMatches($raw_password)
    {
        return Encryptions::equals($raw_password, $this->encrypted_password);
    }
}
