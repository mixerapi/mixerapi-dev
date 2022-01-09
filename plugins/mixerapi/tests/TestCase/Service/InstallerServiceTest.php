<?php

namespace MixerApi\Test\TestCase\Service;

use Cake\TestSuite\TestCase;
use MixerApi\Exception\InstallException;
use MixerApi\Service\InstallerService;

class InstallerServiceTest extends TestCase
{
    public function test_copy_file_with_source_exception(): void
    {
        $file = '/tmp/' . md5((string)microtime(true));
        $this->expectException(InstallException::class);
        $this->expectExceptionMessage(
            sprintf(InstallException::SOURCE_FILE_MISSING, $file)
        );
        (new InstallerService())->copyFile(['source' => $file]);
    }

    public function test_copy_file_with_destination_exception(): void
    {
        $this->expectException(InstallException::class);
        $this->expectExceptionMessage(
            sprintf(InstallException::DESTINATION_FILE_EXISTS, 'Test Name', __FILE__)
        );
        (new InstallerService())->copyFile(['destination' => __FILE__, 'name' => 'Test Name', 'source' => __FILE__]);
    }
}
