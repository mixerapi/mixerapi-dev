<?php
declare(strict_types=1);

namespace MixerApi\ExceptionRender;

use SwaggerBake\Lib\OpenApi\Schema;
use SwaggerBake\Lib\OpenApi\SchemaProperty;
use SwaggerBake\Lib\OpenApiExceptionSchemaInterface;

class OpenApiExceptionSchema extends ValidationException implements OpenApiExceptionSchemaInterface
{
    /**
     * @inheritDoc
     */
    public static function getExceptionCode(): string
    {
        return '422';
    }

    /**
     * @inheritDoc
     */
    public static function getExceptionDescription(): ?string
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public static function getExceptionSchema(): Schema|string
    {
        return (new Schema())
            ->setProperties([
                (new SchemaProperty())
                    ->setName('exception')->setExample('ValidationException'),
                (new SchemaProperty())
                    ->setName('message')->setExample('Error saving resource'),
                (new SchemaProperty())
                    ->setName('url')->setFormat('url')->setExample('/url/path'),
                (new SchemaProperty())
                    ->setName('code')->setType('integer')->setFormat('int32')->setExample(422),
                (new SchemaProperty())
                    ->setName('violations')->setType('array')->setItems([
                        (new Schema())
                            ->setProperties([
                                (new SchemaProperty())
                                    ->setName('propertyPath')->setExample('property_name'),
                                (new SchemaProperty())
                                    ->setName('messages')->setType('array')->setItems([
                                        (new Schema())
                                            ->setProperties([
                                                (new SchemaProperty())
                                                    ->setName('rule')->setExample('rule_name'),
                                                (new SchemaProperty())
                                                    ->setName('message')->setExample('error msg'),
                                            ]),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
