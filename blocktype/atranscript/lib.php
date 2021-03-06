<?php
/**
 * Mahara: Electronic portfolio, weblog, resume builder and social networking
 * Copyright (C) 2006-2009 Catalyst IT Ltd and others; see:
 *                         http://wiki.mahara.org/Contributors
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
 *
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2012 UBO, kerglonou@univ-brest.fr
 *
 */

defined('INTERNAL') || die();

class PluginBlocktypeAtranscript extends PluginBlocktype {

    public static function get_title() {
        return get_string('title', 'blocktype.atranscript/atranscript');
    }

    public static function get_description() {
        return get_string('description', 'blocktype.atranscript/atranscript');
    }

    public static function get_categories() {
        return array('general');
    }

    public static function render_instance(BlockInstance $instance, $editing=false) {
        global $exporter;

        require_once(get_config('docroot') . 'artefact/lib.php');
        safe_require('artefact','atranscript');

		$configdata = $instance->get('configdata');

	//copie sur tasks
       $smarty = smarty_core();
		$smarty->assign('cols', $configdata['cols']);
        if (!empty($configdata['artefactids'])) {
            $les_vets = ArtefactTypeAtranscript::get_vets($configdata['artefactids']);
			$template = 'artefact:atranscript:vetrows.tpl';
            $blockid = $instance->get('id');
            if ($exporter) {
                $pagination = false;
            }
            else {
                $pagination = array(
                    'baseurl'   => $instance->get_view()->get_url() . '&block=' . $blockid,
                    'id'        => 'block' . $blockid . '_pagination',
                    'datatable' => 'vetstable_' . $blockid,
                    'jsonscript' => 'artefact/atranscript/atranscript.json.php',
                );
            }
            ArtefactTypeAtranscript::render_vets($les_vets, $template, $configdata, $pagination, $instance);
            if ($exporter && $vets['count'] > $vets['limit']) {
                $artefacturl = get_config('wwwroot') . 'view/artefact.php?artefact=' . $configdata['artefactids']
                    . '&amp;view=' . $instance->get('view');
                $les_vets['pagination'] = '<a href="' . $artefacturl . '">' . get_string('allvets', 'artefact.atranscript') . '</a>';
            }
            $smarty->assign_by_ref('vets',$les_vets);
        }
        else {

            $smarty->assign('novets','blocktype.atranscript/atranscript');
        }

        $smarty->assign('blockid', $instance->get('id'));
		$smarty->assign('cols', $configdata['cols']);
        return $smarty->fetch('blocktype:atranscript:content2.tpl');


    }

    // Mes diplomes blocktype only has 'title' option so next two functions return as normal
    public static function has_instance_config() {
        return true;
    }

    public static function instance_config_form($instance) {
        $configdata = $instance->get('configdata');

        $form = array();
        // Which field does the user want
        $form[] = self::artefactchooser_element((isset($configdata['artefactids'])) ? $configdata['artefactids'] : null);

        // Columns selection
        $options = array(
            0 => get_string('annee', 'blocktype.atranscript/atranscript'),
            1 => get_string('Etab', 'blocktype.atranscript/atranscript'),
            2 => get_string('code', 'blocktype.atranscript/atranscript'),
            3 => get_string('libelle', 'blocktype.atranscript/atranscript'),
            4 => get_string('resultat', 'blocktype.atranscript/atranscript'),
            5 => get_string('note', 'blocktype.atranscript/atranscript'),
            6 => get_string('annexedesc', 'blocktype.atranscript/atranscript'),
            7 => get_string('pdfa', 'blocktype.atranscript/atranscript'),
        );

        $form['cols'] = array(
            'type'    => 'select',
            'title'   => get_string('selectcol', 'blocktype.atranscript/atranscript'),
			'description'	  => get_string('helpcol', 'blocktype.atranscript/atranscript'),
            'multiple' => true,
            'options' => $options,
			'defaultvalue' => array(0, 1, 2, 3, 4, 5, 6, 7),
			'size'	  => 8,
        ); 

        return $form;
    }

    public static function artefactchooser_element($default=null) {
        safe_require('artefact', 'atranscript');
        return array(
            'name'  => 'artefactids',
            'type'  => 'artefactchooser',
            'title' => get_string('vetstoshow', 'blocktype.atranscript/atranscript'),
            'defaultvalue' => $default,
            'blocktype' => 'atranscript',
            'selectone' => true,
            'search'    => false,
            'artefacttypes' => PluginArtefactAtranscript::get_artefact_types(),
            'template'  => 'artefact:atranscript:artefactchooser-element.tpl',
        );
    }

    public static function allowed_in_view(View $view) {
        return $view->get('owner') != null;
    }

}
?>
