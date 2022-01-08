<?php
declare(strict_types=1);

namespace MixerApi\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * MixerApi installer
 */
class InstallCommand extends Command
{
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
            ])
            ->addOption('test_config_dir', [
                'help' => 'For testing purposes only (don\'t use)',
            ])
            ->addOption('test_src_dir', [
                'help' => 'For testing purposes only (don\'t use)',
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
        if ($args->getOption('auto') !== 'Y') {
            $io->hr();
            $io->out('| MixerApi Install');
            $io->hr();

            if (strtoupper($io->ask('Continue?', 'Y')) !== 'Y') {
                $io->abort('Install aborted');
            }
        }

        $configDir = defined('CONFIG') ? CONFIG : null;
        $srcDir = defined('APP_DIR') ? APP_DIR . DS : null;

        $configDir = $args->getOption('test_config_dir') ?? $configDir;
        $srcDir = $args->getOption('test_src_dir') ?? $srcDir;

        if (empty($configDir) || empty($srcDir)) {
            $io->abort('Unable to locate config and src directories');
        }

        $assets = __DIR__ . DS . '..' . DS . '..' . DS . 'assets' . DS;
        // @phpstan-ignore-next-line ignore Constant ROOT not found.
        $swaggerBake = ROOT . DS . 'vendor' . DS . 'cnizzardini' . DS . 'cakephp-swagger-bake';

        $files = [
            [
                'name' => 'OpenAPI YAML file',
                'source' => $assets . 'swagger.yml',
                'destination' => $configDir . 'swagger.yml',
            ],
            [
                'name' => 'SwaggerBake config file',
                'source' => $swaggerBake . DS . 'assets' . DS . 'swagger_bake.php',
                'destination' => $configDir . 'swagger_bake.php',
            ],
            [
                'name' => 'CakePHP routes file',
                'source' => $assets . 'routes.php',
                'destination' => $configDir . 'routes.php',
            ],
            [
                'name' => 'CakePHP config file',
                'source' => $assets . 'app.php',
                'destination' => $configDir . 'app.php',
            ],
            [
                'name' => 'A WelcomeController file',
                'source' => $assets . 'WelcomeController.php',
                'destination' => $srcDir . 'Controller' . DS . 'WelcomeController.php',
            ],
        ];

        foreach ($files as $file) {
            if (!file_exists($file['source'])) {
                $io->warning(sprintf(
                    'Unable to locate %s, your install might fail. Please report a bug.',
                    $file['source']
                ));
                continue;
            }
            if (file_exists($file['destination'])) {
                $question = sprintf(
                    'A %s already exists at %s. Do you want to overwrite it?',
                    $file['name'],
                    $file['destination']
                );
                if ($io->ask($question, 'Y') !== 'Y') {
                    continue;
                }
            }
            if (!copy($file['source'], $file['destination'])) {
                $io->warning(sprintf(
                    'Unable to copy %s to destination %s.',
                    $file['source'],
                    $file['destination'],
                ));
            }
        }

        $io->success('MixerApi Installation Complete!');
    }
}
