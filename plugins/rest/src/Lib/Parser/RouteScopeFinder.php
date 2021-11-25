<?php
declare(strict_types=1);

namespace MixerApi\Rest\Lib\Parser;

use MixerApi\Rest\Lib\Route\RouteWriter;
use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\NodeVisitorAbstract;

class RouteScopeFinder extends NodeVisitorAbstract
{
    /**
     * @param \MixerApi\Rest\Lib\Route\RouteWriter $routeWriter instance of RouteWriter
     */
    public function __construct(private RouteWriter $routeWriter)
    {
    }

    /**
     * @param \PhpParser\Node $node instance of Node
     * @return bool
     */
    public function finder(Node $node): bool
    {
        return $this->hasValidScope($node) || $this->hasValidPlugin($node);
    }

    /**
     * @param \PhpParser\Node $node instance of Node
     * @return bool
     */
    public function hasValidScope(Node $node): bool
    {
        if (!empty($this->routeWriter->getPlugin()) || !$this->isRouteScope($node)) {
            return false;
        }

        // @phpstan-ignore-next-line
        if (!isset($node->args, $node->args[0]->value->value)) {
            return false;
        }

        return $node->args[0]->value->value === $this->routeWriter->getPrefix();
    }

    /**
     * @param \PhpParser\Node $node instance of Node
     * @return bool
     */
    public function hasValidPlugin(Node $node): bool
    {
        if (empty($this->routeWriter->getPlugin()) || !$this->isRoutePlugin($node)) {
            return false;
        }

        // @phpstan-ignore-next-line
        if (!isset($node->expr->args, $node->expr->args[0]->value->value)) {
            return false;
        }

        if ($node->expr->args[0]->value->value !== $this->routeWriter->getPlugin()) {
            return false;
        }

        if (!isset($node->expr->args[1]->value) || !$node->expr->args[1]->value instanceof Array_) {
            return false;
        }

        $matchingPrefixes = array_filter(
            $node->expr->args[1]->value->items,
            function ($value) {
                // @phpstan-ignore-next-line
                return $value->key->value == 'path' && $value->value->value == $this->routeWriter->getPrefix();
            }
        );

        return count($matchingPrefixes) === 1;
    }

    /**
     * @param \PhpParser\Node $node instance of Node
     * @return bool
     */
    private function isRouteScope(Node $node): bool
    {
        return $node instanceof MethodCall && $node->name->name == 'scope';
    }

    /**
     * @param \PhpParser\Node $node instance of Node
     * @return bool
     */
    private function isRoutePlugin(Node $node): bool
    {
        return isset($node->expr)
            && $node->expr instanceof StaticCall
            && isset($node->expr->name->name)
            && $node->expr->name->name == 'plugin';
    }
}
