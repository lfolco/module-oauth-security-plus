<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\OauthSecurityPlus\Plugin;

use Magento\Framework\Exception\LocalizedException;
use Magento\Integration\Api\AdminTokenServiceInterface;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Hawksama\OauthSecurityPlus\Model\Config;
use Hawksama\OauthSecurityPlus\Logger\Logger;
use Hawksama\OauthSecurityPlus\Api\IpRepositoryInterface;

class CheckIp
{
    public function __construct(
        private RemoteAddress $remoteAddress,
        private Config $config,
        private Logger $logger,
        private IpRepositoryInterface $ipRepository
    ) {
    }

    public function beforeCreateAdminAccessToken(
        AdminTokenServiceInterface $subject,
        string $username,
        string $password
    ): void {
        if (!$this->config->isModuleEnabled()) {
            return;
        }
        $ip = $this->remoteAddress->getRemoteAddress();

        // Log every attempt
        $this->logger->info(sprintf('OAuth token request: username=%s, IP=%s', $username, $ip));

        $enabledIps = $this->ipRepository->getAllEnabled();

        // Convert them to an array of IP strings
        $allowedIps = array_map(
            fn($ipModel) => $ipModel->getData('ip_address'),
            $enabledIps
        );

        if (!in_array($ip, $allowedIps, true)) {
            $this->logger->warning(sprintf('Unauthorized token request blocked: username=%s, IP=%s', $username, $ip));
            throw new LocalizedException(
                __('You are not allowed to create a token')
            );
        }
    }
}
