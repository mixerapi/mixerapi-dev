<?php
declare(strict_types=1);

namespace MixerApi\Rest\Test\App\Controller;

/**
 * Countries Controller
 *
 * @property \App\Model\Table\CountriesTable $Countries
 * @method \App\Model\Entity\Country[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NoCrudController extends AppController
{
    public function index()
    {

    }

    public function nope()
    {

    }
}
