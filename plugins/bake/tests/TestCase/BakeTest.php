<?php

namespace MixerApi\Bake\Test\TestCase;

use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

class BakeTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    /**
     * @var string[] fixtures
     */
    public $fixtures = [
        'plugin.MixerApi/Bake.Departments',
    ];

    /**
     * @var string path to this plugin
     */
    private const BAKE_PLUGIN = ROOT . DS . 'plugins' . DS . 'bake' . DS;

    /**
     * @var string test controller
     */
    private const CONTROLLER_FILE = 'DepartmentsController.php';

    /**
     * @var string controller path
     */
    private const CONTROLLER_PATH = APP . 'Controller' . DS;

    public function setUp() : void
    {
        parent::setUp();
        $this->setAppNamespace('MixerApi\Bake\Test\App');
        $this->useCommandRunner();
        $this->removeBakedController();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->removeBakedController();
    }

    public function test_with_no_plugins(): void
    {
        $this->exec('bake controller Departments --no-test --force --theme MixerApi/Bake');

        $assets = self::BAKE_PLUGIN . 'tests' . DS . 'assets' . DS;

        $this->assertOutputContains('Baking controller class for Departments...');
        $this->assertOutputContains('<success>Wrote</success>');
        $this->assertOutputContains(self::CONTROLLER_FILE);
        $this->assertFileExists(self::CONTROLLER_PATH . self::CONTROLLER_FILE);
        $this->assertFileEquals(
            $assets . self::CONTROLLER_FILE,
            self::CONTROLLER_PATH . self::CONTROLLER_FILE
        );
    }

    private function removeBakedController(): void
    {
        if (file_exists(self::CONTROLLER_PATH . self::CONTROLLER_FILE)) {
            unlink(self::CONTROLLER_PATH . self::CONTROLLER_FILE);
        }
    }
}
