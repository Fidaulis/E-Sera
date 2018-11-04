<?php

namespace App\Entity;

use App\Helpers\StringHelpers;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36)
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $stringHelpers = new StringHelpers();
        $this->id      = $stringHelpers->generateUuid();
    }
}
