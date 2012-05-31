<?php

define('INTERNAL', true);
define('MENUITEM', 'profile/atranscript');
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'atranscript');
define('SECTION_PAGE', 'index');

require_once(dirname(dirname(dirname(__FILE__))) . '/init.php');
define('TITLE', get_string('mesresultats', 'artefact.atranscript'));
require_once('pieforms/pieform.php');
require_once(get_config('docroot') . 'artefact/lib.php');

safe_require('artefact', 'atranscript');
PluginArtefactAtranscript::test_requete();


?>
