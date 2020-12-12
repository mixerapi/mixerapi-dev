<?php
declare(strict_types=1);

namespace MixerApi\CollectionView;

use Adbar\Dot;
use Cake\Core\Configure;
use Cake\Http\ServerRequest;
use Cake\ORM\ResultSet;
use Cake\Utility\Xml;
use Cake\View\Helper\PaginatorHelper;
use RuntimeException;

class Serializer
{
    /**
     * ServerRequest or null
     *
     * @var \Cake\Http\ServerRequest|null
     */
    private $request;

    /**
     * PaginatorHelper or null
     *
     * @var \Cake\View\Helper\PaginatorHelper|null
     */
    private $paginator;

    /**
     * serialized data
     *
     * @var array
     */
    private $data;

    /**
     * @var array
     */
    private $config;

    /**
     * If constructed without parameters collection meta data will not be added to HAL $data
     *
     * @param mixed $serialize the data to be converted into a HAL array
     * @param \Cake\Http\ServerRequest|null $request optional ServerRequest
     * @param \Cake\View\Helper\PaginatorHelper|null $paginator optional PaginatorHelper
     */
    public function __construct($serialize, ?ServerRequest $request = null, ?PaginatorHelper $paginator = null)
    {
        $this->request = $request;
        $this->paginator = $paginator;
        $this->config = Configure::read('CollectionView');

        if ($serialize instanceof ResultSet) {
            $this->data = $this->collection($serialize);
        } else {
            $this->data = $serialize;
        }
    }

    /**
     * Serializes as JSON
     *
     * @param int $jsonOptions JSON options see https://www.php.net/manual/en/function.json-encode.php
     * @return string
     * @throws \RuntimeException
     */
    public function asJson(int $jsonOptions = 0): string
    {
        $json = json_encode($this->data, $jsonOptions);

        if ($json === false) {
            throw new RuntimeException(json_last_error_msg(), json_last_error());
        }

        return $json;
    }

    /**
     * Serializes as XML
     *
     * @param array $options same as Cake\Utility\Xml
     * @param string $rootNode the rootNode
     * @return string
     * @throws \RuntimeException
     */
    public function asXml(array $options, string $rootNode = 'response'): string
    {
        return Xml::fromArray([$rootNode => $this->data], $options)->saveXML();
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param \Cake\ORM\ResultSet $resultSet the data to be converted into a HAL array
     * @return array
     */
    private function collection(ResultSet $resultSet): array
    {
        $dot = new Dot();
        foreach ($this->config as $key => $value) {
            $dot->set($key, $value);
        }

        $return = $dot->all();

        $collection = array_search('{{collection}}', $this->config);
        $url = array_search('{{url}}', $return[$collection]);
        $count = array_search('{{count}}', $return[$collection]);
        $pages = array_search('{{pages}}', $return[$collection]);
        $total = array_search('{{total}}', $return[$collection]);
        $next = array_search('{{next}}', $return[$collection]);
        $prev = array_search('{{prev}}', $return[$collection]);
        $first = array_search('{{first}}', $return[$collection]);
        $last = array_search('{{last}}', $return[$collection]);
        $data = array_search('{{data}}', $this->config);

        $return[$collection][$count] = intval($resultSet->count());
        $return[$collection][$url] = '';

        if ($this->request instanceof ServerRequest) {
            $uri = $this->request->getUri();
            $query = $uri->getQuery();
            $return[$collection][$url] = $uri->getPath();
            $return[$collection][$url] .= !empty($query) ? '?' . $query : '';
        }

        if ($this->paginator instanceof PaginatorHelper) {
            $return[$collection][$next] = (string)$this->paginator->next();
            $return[$collection][$prev] = (string)$this->paginator->prev();
            $return[$collection][$first] = (string)$this->paginator->first();
            $return[$collection][$last] = (string)$this->paginator->last();
            $return[$collection][$pages] = intval($this->paginator->total());
            $return[$collection][$total] = intval($this->paginator->param('count'));
        }

        if (empty($return[$collection][$first]) && !empty($return[$collection][$url])) {
            $return[$collection][$first] = $return[$collection][$url];
        }

        $return[$data] = $resultSet->toArray();

        return $return;
    }
}
