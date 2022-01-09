<?php

namespace MixerApi\Test\TestCase\Command;

use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;
use MixerApi\Service\InstallerService;

class InstallCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;
    // @phpstan-ignore-next-line ignore Constant ROOT not found.
    private const MIXERAPI = ROOT . DS . 'plugins' . DS . 'mixerapi' . DS;

    public function setUp(): void
    {
        parent::setUp();
        $this->setAppNamespace('MixerApi\Test\App');
        $this->useCommandRunner();
        $outputDir = self::MIXERAPI . 'tests' . DS . 'installer_output' . DS;
        @unlink($outputDir . 'config' . DS . 'swagger.yml');
        @unlink($outputDir . 'config' . DS . 'swagger_bake.php');
        @unlink($outputDir . 'config' . DS . 'routes.php');
        @unlink($outputDir . 'config' . DS . 'app.php');
        @unlink($outputDir . 'src' . DS . 'Controller' . DS . 'WelcomeController.php');
    }

    public function test_auto_install(): void
    {
        $mixerapi = SELF::MIXERAPI;
        $this->mockService(InstallerService::class, function () use ($mixerapi) {
            return new InstallerService(
                $mixerapi . 'assets' . DS,
                $mixerapi . 'tests' . DS . 'installer_output' . DS,
            );
        });

        $this->exec('mixerapi install --auto Y');

        $this->assertFilesExist();
    }

    /*
    public function test_interactive_install(): void
    {
        $this->exec(
            'mixerapi install' .
            ' --test_config_dir ' . self::CONFIG_DIR .
            ' --test_src_dir ' . self::SRC_DIR,
            ['Y']
        );

        $this->filesExist();
    }

    public function test_auto_install(): void
    {
        $this->exec(
            'mixerapi install' .
            ' --test_config_dir ' . self::CONFIG_DIR .
            ' --test_src_dir ' . self::SRC_DIR .
            ' --auto Y'
        );

        $this->filesExist();
    }

    public function test_abort_interactive_install(): void
    {
        $this->exec(
            'mixerapi install' .
            ' --test_config_dir ' . self::CONFIG_DIR .
            ' --test_src_dir ' . self::SRC_DIR,
            ['N']
        );

        $this->assertExitError();
    }
    */
    private function assertFilesExist(): void
    {
        $assetsDir = self::MIXERAPI . 'assets' . DS;
        $configDir = self::MIXERAPI . 'tests' . DS . 'installer_output' . DS . 'config' . DS;

        $this->assertFileExists($assetsDir . 'swagger.yml');
        $this->assertFileExists($configDir . 'swagger.yml');
        $this->assertFileEquals($assetsDir . 'swagger.yml', $configDir . 'swagger.yml');

        $this->assertFileExists($assetsDir . 'routes.php');
        $this->assertFileExists($configDir . 'routes.php');
        $this->assertFileEquals($assetsDir . 'routes.php',$configDir . 'routes.php');

        $this->assertFileExists($assetsDir . 'app.php');
        $this->assertFileExists($configDir . 'app.php');
        $this->assertFileEquals($assetsDir . 'app.php',$configDir . 'app.php');

        $srcDir = self::MIXERAPI . 'tests' . DS . 'installer_output' . DS . 'src' . DS;

        $this->assertFileExists($assetsDir . DS . 'WelcomeController.php');
        $this->assertFileExists($srcDir . 'Controller' . DS . 'WelcomeController.php');
        $this->assertFileEquals(
            $assetsDir . 'WelcomeController.php',
            $srcDir . 'Controller' . DS . 'WelcomeController.php'
        );
    }
}
