<?php

namespace App\Command;

use App\Service\CurrencyExchangeService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:check-currency',
    description: 'Check currency command',
    aliases: ['app:check-currency'],
    hidden: false
)]
class CheckCurrencyCommand extends Command
{

    public function __construct(
        private readonly CurrencyExchangeService $currencyExchangeService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Start check currency',
            '============',
            '',
        ]);

        $actuallyCurrenciesByBank = $this->currencyExchangeService->getActuallyCurrencyExchanges();
        $output->writeln([
            'Save currency Exchanges',
            '============',
            '',
        ]);
        $this->currencyExchangeService->saveCurrencyExchanges($actuallyCurrenciesByBank);

        return Command::SUCCESS;
    }
}
