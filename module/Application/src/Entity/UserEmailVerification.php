<?php

declare(strict_types=1);

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

use function bin2hex;

/**
 * User email verification
 *
 * @ORM\Entity
 * @ORM\Table(
 *     name="users_email_verification",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="user_id", columns={"user_id"})}
 * )
 */
class UserEmailVerification
{
    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Application\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="cascade")
     *
     * @var User
     */
    protected $user;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default"=false})
     *
     * @var bool
     */
    protected $verified;

    /**
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     */
    protected $token;

    /**
     * @throws \Exception
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->verified = false;
        $this->token = bin2hex(random_bytes(10));
    }

    public function isVerified(): bool
    {
        return $this->verified;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function verify(string $check): bool
    {
        $this->verified = $this->token === $check;

        return $this->verified;
    }
}
