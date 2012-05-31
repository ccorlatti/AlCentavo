<?php
/**
 * $Id: prepend.php 12 2010-07-06 04:34:57Z corlatti $
 * @author Claudio Corlatti
 *
 */
//error_reporting(9999);
//inits session, MUST be first line before any output
session_start();

//constants definition
define('SITE', 'alcentavo');
define('SITE_URL', 'http://www.alcentavo.com.ar/');
define('SITE_FOLDER', $_SERVER['DOCUMENT_ROOT'] . '/' . SITE . '/');
define('LIBRARY_FOLDER', SITE_FOLDER . 'library/');
define('MODEL_FOLDER', LIBRARY_FOLDER . 'dao/');
define('DB_NAME','alcentavo');
define('CONNECTION_STRING', 'mysql://root:ade3saq1@localhost/' . DB_NAME);

define('FILE_TRANSACTIONS_IMPORT_DESTINATION',SITE_FOLDER . 'upload/transactions/');

//include helper to workaround nested includes problem
require_once 'IncludeHelper.class.php';


//generic exception include
IncludeHelper::inc('library/generic/SiteGenericException.exception.php');

//template engine
IncludeHelper::inc('library/generic/CCTemplate.class.php');

//Util
IncludeHelper::inc('library/generic/Util.class.php');

//Doctrine DAO config and init
IncludeHelper::inc('library/thirdParty/Doctrine.php');

spl_autoload_register(array('Doctrine', 'autoload'));
$manager = Doctrine_Manager::getInstance();
$conn = Doctrine_Manager::connection(CONNECTION_STRING);
$conn->setCharset('utf8');
$conn->setCollate('utf8_unicode_ci');

//profiler to log querys
$profiler = new Doctrine_Connection_Profiler();
$conn->setListener($profiler);
$manager->setCollate('utf8_unicode_ci');
$manager->setCharset('utf8');
$manager->setAttribute(Doctrine::ATTR_MODEL_LOADING, Doctrine::MODEL_LOADING_CONSERVATIVE);
$manager->setAttribute(Doctrine::ATTR_AUTOLOAD_TABLE_CLASSES, true);


Doctrine::loadModels(MODEL_FOLDER);





?>