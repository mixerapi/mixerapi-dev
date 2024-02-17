<?php
declare(strict_types=1);

namespace MixerApi\JsonLdView\Controller;

use MixerApi\JsonLdView\View\JsonLdView;

/**
 * @property \MixerApi\JsonLdView\Controller\Component\JsonLdContextComponent $JsonLdContext
 * @property \MixerApi\JsonLdView\Controller\Component\JsonLdVocabComponent $JsonLdVocab
 */
class JsonLdController extends AppController
{
    /**
     * @return void
     * @throws \Exception
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('MixerApi/JsonLdView.JsonLdContext');
        $this->loadComponent('MixerApi/JsonLdView.JsonLdVocab');
    }

    /**
     * @inheritDoc
     */
    public function viewClasses(): array
    {
        return [JsonLdView::class];
    }

    /**
     * Displays JSON-LD context for the given entity.
     *
     * @link https://json-ld.org/learn.html
     * @param string|null $entity Entity name
     * @return \Cake\Http\Response
     */
    public function contexts(?string $entity = null): \Cake\Http\Response
    {
        $context = $this->JsonLdContext->build($entity);

        return $this->getResponse()
                ->withType('application/ld+json')
                ->withStringBody(json_encode($context, JSON_PRETTY_PRINT));
    }

    /**
     * Displays JSON-LD vocab for entities in your API.
     *
     * @link https://json-ld.org/learn.html
     * @return \Cake\Http\Response
     * @throws \ReflectionException
     */
    public function vocab(): \Cake\Http\Response
    {
        $vocab = $this->JsonLdVocab->build();

        return $this->getResponse()
            ->withType('application/ld+json')
            ->withStringBody(json_encode($vocab, JSON_PRETTY_PRINT));
    }
}
