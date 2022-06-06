<?php
declare(strict_types=1);

namespace MixerApi\JwtAuth\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;
use Cake\Utility\Inflector;
use MixerApi\Rest\Lib\Controller\ControllerUtility;
use MixerApi\Rest\Lib\Route\ResourceScanner;
use MixerApi\Rest\Lib\Route\RouteDecoratorFactory;
use MixerApi\Rest\Lib\Route\RouteWriter;


class KeysCommand extends Command
{
    /**
     * @param \Cake\Console\ConsoleOptionParser $parser ConsoleOptionParser
     * @return \Cake\Console\ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser
            ->addArgument('type', [
                'options' => ['hmac', 'rsa'],
                'required' => true
            ]);

        return $parser;
    }

    /**
     * List Cake Routes that can be added to Swagger. Prints to console.
     *
     * @param \Cake\Console\Arguments $args Arguments
     * @param \Cake\Console\ConsoleIo $io ConsoleIo
     * @return int|void|null
     * @throws \ReflectionException
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $type = (string) $args->getArgument('type');

        if ($type === 'hmac') {
            $io->out(sodium_crypto_generichash_keygen());
        } else if ($type === 'rsa') {
            $privateKey = openssl_pkey_new();
            //$io->out(openssl_pkey_get_private($privateKey));
            $io->out(openssl_pkey_get_details($privateKey)['key']);
        }
    }
}
