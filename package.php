<?php

require_once 'PEAR/PackageFileManager.php';

$version = 'XXX';
$notes = <<<EOT
- removed bogus code from execute()
- new test case for floats/decimals and locale
- reworked fix for float/decimal handling
- expanded scientific notation handling
- fixed several minor issues with the datatype tests
- removed use of "*" in all places in the test suite that are followed by a fetch
- tweaked handling of free() for prepared statements
- return error if a prepared statement is attempted to be free'ed or executed again
- added result_wrap_class param to limitQuery()
- added parameter to not quote return value of getBeforeId()
- added setCharset()
- enable transactions by default
- added decimal reverse engineering test
- fixed parameter order in assertions in reverse engineering fields tests
- generalized quoteIdentifier() with a property
- switched most array_key_exists() calls to !empty() to improve readability and performance
- fixed a few edge cases and potential warnings
- added ability to rewrite queries for query(), exec() and prepare() using a debug handler callback
- added 'datatype_map' option (Request #7797)
- added reverse parameter to getColumnNames()
- added 'datatype_map_callback' option
- added getValidTypes() method to handle additional types from the 'datatype_map' option
- set last_query in _execute() to prepared statement (Bug #7856)
- adding random function emulation to generate a float between 0 and 1
- explicitly fetch row id = 1 in LOB tests
- cosmetic fix to prepare() (Bug #7883)

open todo items:
- handle autoincrement fields in alterTable()
- add support for ADODB style "smart transactions":
  http://phplens.com/lens/adodb/docs-adodb.htm#ex11
- add length handling to LOB reverse engineering
EOT;

$description =<<<EOT
PEAR MDB2 is a merge of the PEAR DB and Metabase php database abstraction layers.

It provides a common API for all supported RDBMS. The main difference to most
other DB abstraction packages is that MDB2 goes much further to ensure
portability. Among other things MDB2 features:
* An OO-style query API
* A DSN (data source name) or array format for specifying database servers
* Datatype abstraction and on demand datatype conversion
* Various optional fetch modes to fix portability issues
* Portable error codes
* Sequential and non sequential row fetching as well as bulk fetching
* Ability to make buffered and unbuffered queries
* Ordered array and associative array for the fetched rows
* Prepare/execute (bind) emulation
* Sequence emulation
* Replace emulation
* Limited sub select emulation
* Row limit support
* Transactions support
* Large Object support
* Index/Unique Key/Primary Key support
* Autoincrement emulation
* Module framework to load advanced functionality on demand
* Ability to read the information schema
* RDBMS management methods (creating, dropping, altering)
* Reverse engineering schemas from an existing DB
* SQL function call abstraction
* Full integration into the PEAR Framework
* PHPDoc API documentation
EOT;

$package = new PEAR_PackageFileManager();

$result = $package->setOptions(
    array(
        'package'           => 'MDB2',
        'summary'           => 'database abstraction layer',
        'description'       => $description,
        'version'           => $version,
        'state'             => 'stable',
        'license'           => 'BSD License',
        'filelistgenerator' => 'cvs',
        'ignore'            => array('package*.php', 'package*.xml', 'sqlite*', 'mssql*', 'oci8*', 'pgsql*', 'mysqli*', 'mysql*', 'fbsql*', 'querysim*', 'ibase*', 'peardb*'),
        'notes'             => $notes,
        'changelogoldtonew' => false,
        'simpleoutput'      => true,
        'baseinstalldir'    => '/',
        'packagedirectory'  => './',
        'dir_roles'         => array(
            'docs' => 'doc',
             'examples' => 'doc',
             'tests' => 'test',
        ),
    )
);

if (PEAR::isError($result)) {
    echo $result->getMessage();
    die();
}

$package->addMaintainer('lsmith', 'lead', 'Lukas Kahwe Smith', 'smith@pooteeweet.org');
$package->addMaintainer('pgc', 'contributor', 'Paul Cooper', 'pgc@ucecom.com');
$package->addMaintainer('quipo', 'contributor', 'Lorenzo Alberton', 'l.alberton@quipo.it');
$package->addMaintainer('danielc', 'helper', 'Daniel Convissor', 'danielc@php.net');
$package->addMaintainer('davidc', 'helper', 'David Coallier', 'david@jaws.com.mx');

$package->addDependency('php', '4.3.2', 'ge', 'php', false);
$package->addDependency('PEAR', '1.3.6', 'ge', 'pkg', false);

$package->addglobalreplacement('package-info', '@package_version@', 'version');

if (array_key_exists('make', $_GET) || (isset($_SERVER['argv'][1]) && $_SERVER['argv'][1] == 'make')) {
    $result = $package->writePackageFile();
} else {
    $result = $package->debugPackageFile();
}

if (PEAR::isError($result)) {
    echo $result->getMessage();
    die();
}
