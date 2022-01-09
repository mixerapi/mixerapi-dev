<?php
declare(strict_types=1);

namespace MixerApi\Service;

use MixerApi\Exception\InstallException;

/**
 * MixerAPI Installer Service
 */
class InstallerService
{
    private array $files;

    /**
     * @param null $assetsDir The application root directory with a trailing slash
     * @param null $rootDirectory The assets directory
     */
    public function __construct(
        private ?string $assetsDir = null,
        private ?string $rootDirectory = null,
    ) {
        // @phpstan-ignore-next-line ignore Constant ROOT not found.
        $this->assetsDir = $this->assetsDir ?? ROOT . 'plugins' . DS . 'mixerapi' . DS . 'assets';
        // @phpstan-ignore-next-line ignore Constant ROOT not found.
        $this->rootDirectory = $this->rootDirectory ?? ROOT;
        $config = $this->rootDirectory . 'config' . DS;

        $this->files = [
            'swaggerbake' => [
                'name' => 'SwaggerBake config',
                'source' => $this->assetsDir . 'swagger_bake.php',
                'destination' => $config . 'swagger_bake.php',
            ],
            'openapi' => [
                'name' => 'OpenAPI YAML',
                'source' => $this->assetsDir . 'swagger.yml',
                'destination' => $config . 'swagger.yml',
            ],
            'routes' => [
                'name' => 'CakePHP routes',
                'source' => $this->assetsDir . 'routes.php',
                'destination' => $config . 'routes.php',
            ],
            'config' => [
                'name' => 'CakePHP config',
                'source' => $this->assetsDir . 'app.php',
                'destination' => $config . 'app.php',
            ],
            'welcome' => [
                'name' => 'WelcomeController',
                'source' => $this->assetsDir . 'WelcomeController.php',
                'destination' => $this->rootDirectory . 'src' . DS . 'Controller' . DS . 'WelcomeController.php',
            ],
        ];
    }

    /**
     * Copy files.
     *
     * @param array $file an item in InstallerService::files.
     * @return void
     * @throws \MixerApi\Exception\InstallException
     */
    public function copyFile(array $file): void
    {
        if (!file_exists($file['source'])) {
            throw new InstallException(
                sprintf(
                    InstallException::SOURCE_FILE_MISSING,
                    $file['source']
                )
            );
        }
        if (file_exists($file['destination'])) {
            throw (new InstallException(
                sprintf(
                    InstallException::DESTINATION_FILE_EXISTS,
                    $file['name'],
                    $file['destination']
                )
            ))->setCanContinue(true);
        }
        if (!copy($file['source'], $file['destination'])) {
            throw new InstallException(
                sprintf(
                    InstallException::COPY_FAILED,
                    $file['source'],
                    $file['destination'],
                )
            );
        }
    }

    /**
     * Returns an array of files to be copied.
     *
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files;
    }
}
