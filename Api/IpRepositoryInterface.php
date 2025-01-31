<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\OauthSecurityPlus\Api;

use Hawksama\OauthSecurityPlus\Api\Data\IpInterface;
use Hawksama\OauthSecurityPlus\Model\IpModel;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject;

interface IpRepositoryInterface
{
    public function save(AbstractModel $ip): AbstractModel;

    public function getByIp(string $ipAddress): ?IpInterface;

    /**
     * @return DataObject[]
     */
    public function getAll(): array;

    /**
     * @return DataObject[]
     */
    public function getAllEnabled(): array;

    public function delete(IpModel $ip): void;

    public function deleteByIp(string $ipAddress): void;
}
