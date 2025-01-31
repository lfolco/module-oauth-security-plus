<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\OauthSecurityPlus\Api\Data;

interface IpInterface
{
    /**
     * String constants for property names
     */
    public const IP_ID = "ip_id";
    public const IP_ADDRESS = "ip_address";
    public const IP_NAME = "ip_name";
    public const ENABLED = "enabled";

    /**
     * Getter for IpId.
     *
     * @return int|null
     */
    public function getIpId(): ?int;

    /**
     * Setter for IpId.
     *
     * @param int|null $ipId
     * @return void
     */
    public function setIpId(?int $ipId): void;

    /**
     * Getter for IpAddress.
     *
     * @return string|null
     */
    public function getIpAddress(): ?string;

    /**
     * Setter for IpAddress.
     *
     * @param string|null $ipAddress
     * @return void
     */
    public function setIpAddress(?string $ipAddress): void;

    /**
     * Getter for IpName.
     *
     * @return string|null
     */
    public function getIpName(): ?string;

    /**
     * Setter for IpName.
     *
     * @param string|null $ruleName
     * @return void
     */
    public function setIpName(?string $ruleName): void;

    /**
     * Getter for Enabled.
     *
     * @return bool|null
     */
    public function getEnabled(): ?bool;

    /**
     * Setter for Enabled.
     *
     * @param bool|null $enabled
     * @return void
     */
    public function setEnabled(?bool $enabled): void;
}
