<?php
declare(strict_types=1);

use Cake\Core\Configure;
use Cake\TestSuite\Fixture\SchemaLoader;

/**
 * Test runner bootstrap.
 *
 * Add additional configuration/setup your application needs when running
 * unit tests in this file.
 */
require dirname(__DIR__) . '/vendor/autoload.php';

require dirname(__DIR__) . '/config/bootstrap.php';

$_SERVER['PHP_SELF'] = '/';

define('IS_TEST', true);

Configure::write('App.fullBaseUrl', 'http://localhost');
putenv('DB=sqlite');

ini_set('error_reporting', E_ALL);
Configure::write('debug', true);

// Fixate sessionid early on, as php7.2+
// does not allow the sessionid to be set after stdout
// has been written to.
session_id('cli');

/*
 * Set test database and load schema
 * @link https://book.cakephp.org/4/en/development/testing.html#creating-test-database-schema
 */
putenv('DB_DSN=sqlite:///:memory:');
(new SchemaLoader())->loadInternalFile(__DIR__ . DS . 'schema.php');
