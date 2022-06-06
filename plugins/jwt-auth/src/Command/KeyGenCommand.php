<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

class KeyGenCommand extends Command
{
    /**
     * @param \Cake\Console\ConsoleOptionParser $parser ConsoleOptionParser
     * @return \Cake\Console\ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser
            ->setDescription('Generate JWT keys')
            ->addArgument('type', [
                'options' => ['hmac'],
                'required' => true,
            ]);

        return $parser;
    }

    /**
     * @param \Cake\Console\Arguments $args Arguments
     * @param \Cake\Console\ConsoleIo $io ConsoleIo
     * @return void
     */
    public function execute(Arguments $args, ConsoleIo $io): void
    {
        $type = (string)$args->getArgument('type');

        if ($type === 'hmac') {
            $io->info('Generating base64 encoded hash: ');
            $io->out(base64_encode(sodium_crypto_generichash_keygen()));
        }
    }
}
