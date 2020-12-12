<?php

namespace MixerApi\Bake\Test\TestCase;

use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

class BakeTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    public $fixtures = [
        'plugin.MixerApi/Bake.Departments',
    ];

    /** @var string  */
    private $controllers;

    private const CONTROLLER_FILE = 'DepartmentsController.php';

    public function setUp() : void
    {
        parent::setUp();
        $this->setAppNamespace('MixerApi\Bake\Test\App');
        $this->useCommandRunner();

        $this->controllers = APP . 'Controller' . DS;
        unlink($this->controllers . self::CONTROLLER_FILE);
    }

    public function testBake()
    {
        $this->exec('bake controller Departments --no-test --theme MixerApi/Bake');

        $assets = TEST . DS . 'assets' . DS;

        $this->assertOutputContains('Baking controller class for Departments...');
        $this->assertOutputContains('<success>Wrote</success>');
        $this->assertOutputContains('tests/test_app/App/Controller/' . self::CONTROLLER_FILE);
        $this->assertFileExists($this->controllers . self::CONTROLLER_FILE);
        $this->assertFileEquals($assets . self::CONTROLLER_FILE, $this->controllers . self::CONTROLLER_FILE);
    }
}