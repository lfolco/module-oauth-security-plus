<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\OauthSecurityPlus\Model;

use Hawksama\OauthSecurityPlus\Api\Data\IpInterface;
use Hawksama\OauthSecurityPlus\Model\ResourceModel\IpResource;
use Magento\Framework\Model\AbstractModel;

class IpModel extends AbstractModel implements IpInterface
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'hawksama_ip_model';

    /**
     * Initialize magento model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(IpResource::class);
    }
    /**
     * Getter for IpId.
     *
     * @return int|null
     */
    public function getIpId(): ?int
    {
        return $this->getData(self::IP_ID) === null ? null
            : (int)$this->getData(self::IP_ID);
    }

    /**
     * Setter for IpId.
     *
     * @param int|null $ipId
     * @return void
     */
    public function setIpId(?int $ipId): void
    {
        $this->setData(self::IP_ID, $ipId);
    }

    /**
     * Getter for IpAddress.
     *
     * @return string|null
     */
    public function getIpAddress(): ?string
    {
        return $this->getData(self::IP_ADDRESS);
    }

    /**
     * Setter for IpAddress.
     *
     * @param string|null $ipAddress
     * @return void
     */
    public function setIpAddress(?string $ipAddress): void
    {
        $this->setData(self::IP_ADDRESS, $ipAddress);
    }

    /**
     * Getter for IpName.
     *
     * @return string|null
     */
    public function getIpName(): ?string
    {
        return $this->getData(self::IP_NAME);
    }

    /**
     * Setter for IpName.
     *
     * @param string|null $ruleName
     * @return void
     */
    public function setIpName(?string $ruleName): void
    {
        $this->setData(self::IP_NAME, $ruleName);
    }

    /**
     * Getter for Enabled.
     *
     * @return bool|null
     */
    public function getEnabled(): ?bool
    {
        return $this->getData(self::ENABLED) === null ? null
            : (bool)$this->getData(self::ENABLED);
    }

    /**
     * Setter for Enabled.
     *
     * @param bool|null $enabled
     * @return void
     */
    public function setEnabled(?bool $enabled): void
    {
        $this->setData(self::ENABLED, $enabled);
    }
}
