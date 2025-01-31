<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\OauthSecurityPlus\Console;

use Hawksama\OauthSecurityPlus\Model\IpModel;
use Hawksama\OauthSecurityPlus\Query\Ip\GetListQuery;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * CLI Command: Add IP(s) to the API whitelist.
 */
class Show extends Command
{
    public function __construct(
        private readonly GetListQuery $listQuery,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setName('hawksama:api-whitelist:list')
            ->setDescription('List all the API stored to DB');
    }

    /**
     * @throws CouldNotSaveException
     * @throws LocalizedException
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $ips = $this->listQuery->execute();

        /** @var IpModel $ip */
        foreach ($ips->getItems() as $ip) {
            $status = (bool) $ip->getEnabled();
            $tag = $status ? '<info>' : '<error>';
            $endTag = $status ? '</info>' : '</error>';

            $output->writeln(sprintf(
                '%s%s %s%s',
                $tag,
                $ip->getIpAddress(),
                $status ? 'Enabled' : 'Disabled',
                $endTag
            ));
        }

        return Command::SUCCESS;
    }
}
