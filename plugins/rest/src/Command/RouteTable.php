<?php
declare(strict_types=1);

namespace MixerApi\Rest\Command;

use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;

/**
 * Write Ascii Table of Routes to console
 */
class RouteTable
{
    /**
     * @var \Cake\Console\ConsoleIo
     */
    private $io;

    /**
     * @var \Cake\Console\Arguments
     */
    private $args;

    /**
     * @var \MixerApi\Rest\Lib\Route\RouteDecorator[]
     */
    private $routeDecorators;

    /**
     * @param \Cake\Console\ConsoleIo $io ConsoleIo
     * @param \Cake\Console\Arguments $args Arguments
     * @param \MixerApi\Rest\Lib\Route\RouteDecorator[] $routeDecorators Array of RouteDecorator
     */
    public function __construct(ConsoleIo $io, Arguments $args, array $routeDecorators)
    {
        $this->io = $io;
        $this->args = $args;
        $this->routeDecorators = $routeDecorators;
    }

    /**
     * Write Ascii Table of Routes to console
     *
     * @return void
     */
    public function output(): void
    {
        $output = [
            ['Route name', 'URI template', 'Method(s)', 'Controller', 'Action', 'Plugin'],
        ];

        foreach ($this->routeDecorators as $route) {
            if ($this->args->getOption('plugin') !== null) {
                $plugin = $this->args->getOption('plugin');
                $plugin = $plugin == 'App' ? null : trim($this->args->getOption('plugin'));

                if ($route->getPlugin() != $plugin) {
                    continue;
                }
            }

            $output[] = [
                $route->getName(),
                $route->getTemplate(),
                implode(', ', $route->getMethods()),
                $route->getController(),
                $route->getAction(),
                $route->getPlugin(),
            ];
        }

        $this->io->helper('table')->output($output);
    }
}
