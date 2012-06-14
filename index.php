<?php
/**
 * Mahara: Electronic portfolio, weblog, resume builder and social networking
 * Copyright (C) 2006-2008 Catalyst IT Ltd (http://www.catalyst.net.nz)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    mahara
 * @subpackage artefact-atranscript
 * @author     Jean-Guy Avelin, Julien Kerglonou
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2012 UBO, kerglonou@univ-brest.fr
 *
 */

define('INTERNAL', true);
define('MENUITEM', 'content/atranscript');
define('SECTION_PLUGINTYPE', 'artefact');
define('SECTION_PLUGINNAME', 'atranscript');
define('SECTION_PAGE', 'index');

require_once(dirname(dirname(dirname(__FILE__))) . '/init.php');
define('TITLE', get_string('mesresultats', 'artefact.atranscript'));
require_once('pieforms/pieform.php');
require_once(get_config('docroot') . 'artefact/lib.php');

safe_require('artefact', 'atranscript');

$les_vets = ArtefactTypeAtranscript::get_allvets(0,20);
ArtefactTypeAtranscript::build_vets_list_html($les_vets);

$js = <<< EOF
addLoadEvent(function () {
    {$les_vets['pagination_js']}
});
EOF;

$smarty = smarty(array('paginator'));
$smarty->assign_by_ref('vets', $les_vets);
$smarty->assign('strnovets',
    get_string('novets', 'artefact.atranscript', '', ''));
$smarty->assign('PAGEHEADING', hsc(get_string("mesresultats", "artefact.atranscript")));
$smarty->assign('INLINEJAVASCRIPT', $js);
$smarty->display('artefact:atranscript:index.tpl');


?>

