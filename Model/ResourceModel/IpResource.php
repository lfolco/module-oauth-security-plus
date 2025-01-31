<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\OauthSecurityPlus\Model\ResourceModel;

use Hawksama\OauthSecurityPlus\Api\Data\IpInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class IpResource extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'hawksama_ip_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('hawksama_ip_whitelist', IpInterface::IP_ID);
        $this->_useIsObjectNew = true;
    }
}
