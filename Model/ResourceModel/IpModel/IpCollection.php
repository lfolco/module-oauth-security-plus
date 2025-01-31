<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\OauthSecurityPlus\Model\ResourceModel\IpModel;

use Hawksama\OauthSecurityPlus\Model\IpModel;
use Hawksama\OauthSecurityPlus\Model\ResourceModel\IpResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class IpCollection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'hawksama_ip_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(IpModel::class, IpResource::class);
    }
}
