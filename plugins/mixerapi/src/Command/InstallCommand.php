<?php
declare(strict_types=1);

namespace MixerApi\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use MixerApi\Exception\InstallException;
use MixerApi\Service\InstallerService;

/**
 * MixerApi installer
 */
class InstallCommand extends Command
{
    public const DONE = 'MixerApi Installation Complete!';

    /**
     * @param \MixerApi\Service\InstallerService $installerService The MixerAPI installer service
     */
    public function __construct(private InstallerService $installerService)
    {
        parent::__construct();
    }

    /**
     * @param \Cake\Console\ConsoleOptionParser $parser ConsoleOptionParser
     * @return \Cake\Console\ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser
            ->setDescription('MixerApi Installer')
            ->addOption('auto', [
                'help' => 'Non-interactive install, skips all prompts and uses defaults',
                'default' => 'N',
            ]);

        return $parser;
    }

    /**
     * @param \Cake\Console\Arguments $args Arguments
     * @param \Cake\Console\ConsoleIo $io ConsoleIo
     * @return int|void|null
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $isAuto = $args->getOption('auto') == 'Y';

        foreach ($this->installerService->getFiles() as $file) {
            try {
                $this->installerService->copyFile($file);
            } catch (InstallException $e) {
                if ($e->canContinue() && ($io->ask($e->getMessage(), 'Y') == 'Y' || $isAuto)) {
                    continue;
                }
                $io->abort($e->getMessage());
            }
        }

        $io->success(self::DONE);
    }
}
