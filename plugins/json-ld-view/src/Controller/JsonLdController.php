<?php
declare(strict_types=1);

namespace MixerApi\JsonLdView\Controller;

class JsonLdController extends AppController
{
    /**
     * @var \MixerApi\JsonLdView\Controller\Component\JsonLdContextComponent
     */
    protected $JsonLdContext;

    /**
     * @var \MixerApi\JsonLdView\Controller\Component\JsonLdVocabComponent
     */
    protected $JsonLdVocab;

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
     * @param string|null $entity Entity name
     * @return \Cake\Http\Response
     */
    public function contexts($entity = null)
    {
        $context = $this->JsonLdContext->build($entity);

        return $this
                ->response
                ->withType('application/ld+json')
                ->withStringBody(json_encode($context, JSON_PRETTY_PRINT));
    }

    /**
     * @return \Cake\Http\Response
     * @throws \ReflectionException
     */
    public function vocab()
    {
        $context = $this->JsonLdVocab->build();

        return $this
            ->response
            ->withType('application/ld+json')
            ->withStringBody(json_encode($context, JSON_PRETTY_PRINT));
    }
}
