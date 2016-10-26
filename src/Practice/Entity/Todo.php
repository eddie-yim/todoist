<?php
namespace Practice\Entity;

use \DateTime;
use Practice\Entity\Enum\TodoStatus;

/**
 * @Entity
 * @Table(name="tb_todo")
 * @HashLifecycleCallbacks
 **/
class Todo extends Entity
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     * @var integer
     */
    protected $id;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $content;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="todos")
     * @JoinColumn(name="writer", referencedColumnName="id")
     * @var User
     */
    protected $writer;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $status = TodoStatus::ACTIVE;

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
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return User
     */
    public function getWriter(): User
    {
        return $this->writer;
    }

    /**
     * @param User $writer
     */
    public function setWriter(User $writer)
    {
        $this->writer = $writer;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
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

    public function isOwnedBy(int $user_id)
    {
        if ($user_id == null || $this->writer == null) {
            return false;
        }

        return $user_id === $this->writer->getId();
    }
}
