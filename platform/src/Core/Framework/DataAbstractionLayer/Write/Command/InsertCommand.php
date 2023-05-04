<?php declare(strict_types=1);

namespace Shopware\Core\Framework\DataAbstractionLayer\Write\Command;

use Shopware\Core\Framework\Api\Acl\Role\AclRoleDefinition;
use Shopware\Core\Framework\Log\Package;

/**
 * @final tag:v6.5.0
 */
#[Package('core')]
class InsertCommand extends WriteCommand
{
    public function getPrivilege(): ?string
    {
        return AclRoleDefinition::PRIVILEGE_CREATE;
    }
}
