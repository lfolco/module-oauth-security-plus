<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\OauthSecurityPlus\Logger\Handler;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

class OauthSecurityPlusHandler extends Base
{
    /**
     * @var string Log file path in var/log
     * Adjust the file name as desired, e.g. api_security_plus.log
     */
    protected $fileName = '/var/log/api_security_plus.log';

    /**
     * @var int Log level
     */
    protected $loggerType = Logger::INFO;
}
