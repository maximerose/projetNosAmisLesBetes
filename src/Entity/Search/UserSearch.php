<?php
declare(strict_types=1);

namespace App\Entity\Search;

class UserSearch
{
    /**
     * @var string|null
     */
    private $username;

    /**
     * @var string[]|null
     */
    private $roles;

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     * @return UserSearch
     */
    public function setUsername(?string $username): UserSearch
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * @param string[]|null $roles
     * @return UserSearch
     */
    public function setRoles(?array $roles): UserSearch
    {
        $this->roles = $roles;
        return $this;
    }
}