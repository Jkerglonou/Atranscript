<?php
/**
 * Mahara: Electronic portfolio, weblog, resume builder and social networking
 * Copyright (C) 2006-2008 Catalyst IT Ltd (http://www.catalyst.net.nz).
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

defined('INTERNAL') || die();

class PluginArtefactAtranscript extends Plugin {
    
    public static function get_artefact_types() {
        return array(
            'atranscript'
        );
    }
    
    public static function get_block_types() {
        return array(); 
    }

    public static function get_plugin_name() {
        return 'atranscript';
    }

    public static function menu_items() {
        return array(
            array(
                'path' => 'content/atranscript',
                'title' => get_string('mesresultats', 'artefact.atranscript'),
                'url' => 'artefact/atranscript/',
                'weight' => 80,
            )
        );
    }

	public static function get_cron() {
		return array(
			(object)array(
			'callfunction' => 'import_atranscript_datas',
			'hour' => '*',
			'minute' => '25',
			),
		);
	}

public static function import_atranscript_datas() {
//APPEL DU CRON 
	$results = get_records_sql_array("SELECT * FROM atranscript_vet_tempo where fait='N'",array());
	if (empty($results)) return;
	db_begin();

        foreach ($results as $ligne) {
		// on regarde si le record existe
		$sql = "SELECT * 
				FROM {artefact} a JOIN {artefact_atranscript_vet} at ON at.artefact = a.id
				WHERE at.cod_etu = ? AND at.cod_vet = ? AND at.annee = ? AND a.artefacttype = 'atranscript'
			    ORDER BY at.annee, a.id";
			    
        ($verif = get_records_sql_array($sql, array($ligne->cod_etu,$ligne->cod_vet,$ligne->annee) ))
        || ($verif = array());
                                        
		// si non, on cree
		if (count($verif)==0) {
			if (!$leuser = get_record('usr', 'username', $ligne->username)) {
                    		log_warn('No user with username '.$ligne->username);
				continue;
            }
			
			$record = new ArtefactTypeAtranscript();
			$record->set('description' , $ligne->annee);
			$record->set('owner', $leuser->id);
			$record->set('title', $ligne->cod_vet);
			$record->set('cod_etu',$ligne->cod_etu);
			$record->set('etbt',$ligne->etbt);        // MODIF JF
			$record->set('cod_vet',$ligne->cod_vet);
			$record->set('libelle_vet',$ligne->libelle_vet);
			$record->set('annee',$ligne->annee);
			$record->set('resultat',$ligne->resultat);
			$record->set('note',$ligne->note);
			$record->commit();

            $sqlUpdate = "UPDATE atranscript_vet_tempo 
						  SET fait='O'
						  WHERE cod_etu = ? AND cod_vet = ? AND annee = ?";

			$parentUpdate = "UPDATE artefact 
							 SET parent = id 
							 WHERE artefacttype='atranscript' AND owner = ?";

           execute_sql($sqlUpdate , array($ligne->cod_etu,$ligne-i>cod_vet,$ligne->annee));
           execute_sql($parentUpdate , array($leuser->id));

		}
        }

	db_commit();

}
/*
public static function test_requete() {
//TEST DU CRON APOGEE
        $results = get_records_sql_array("SELECT * FROM atranscript_vet_tempo where fait='N'",array());
        if (empty($results)) return;
		db_begin();

        foreach ($results as $ligne) {
        // on regarde si le record existe
		$sql = "SELECT * 
				FROM {artefact} a JOIN {artefact_atranscript_vet} at ON at.artefact = a.id
				WHERE at.cod_etu = ? AND at.cod_vet = ? AND at.annee = ? AND a.artefacttype = 'atranscript'
	            ORDER BY at.annee, a.id";
        ($verif = get_records_sql_array($sql, array($ligne->cod_etu,$ligne->cod_vet,$ligne->annee) ))
        || ($verif = array());

		// si non, on cree
		if (count($verif)==0) {
			if (!$leuser = get_record('usr', 'username', $ligne->username)) {
                    		log_error('No user with username '.$ligne->username);
				continue;
                	}

			$record = new ArtefactTypeAtranscript();
			$record->set('description' , $ligne->annee);
			$record->set('owner', $leuser->id);
			$record->set('title', $ligne->cod_vet);
			$record->set('cod_etu',$ligne->cod_etu);
			$record->set('cod_vet',$ligne->cod_vet);
			$record->set('libelle_vet',$ligne->libelle_vet);
			$record->set('annee',$ligne->annee);
			$record->set('resultat',$ligne->resultat);
			$record->set('note',$ligne->note);
			$record->commit();

			$sqlUpdate = "UPDATE atranscript_vet_tempo 
						  SET fait='O'
						  WHERE cod_etu = ? AND cod_vet = ? AND annee = ?";

			execute_sql($sqlUpdate , array($ligne->cod_etu,$ligne->cod_vet,$ligne->annee));

		}
        }
	db_commit();


}*/


}

class ArtefactTypeAtranscript extends ArtefactType {
	protected $cod_vet;
	protected $etbt;  // MODIF JF
	protected $cod_etu;
	protected $resultat;
	protected $note;
	protected $libelle_vet;
	protected $annexedesc;
	protected $annee;
	protected $pdfa;


    public static function get_icon($options=null) {}

   /**
     * We override the constructor to fetch the extra data.
     *
     * @param integer
     * @param object
     */
    public function __construct($id = 0, $data = null) {
        parent::__construct($id, $data);

		log_info('EXTRA DATA construct !');

        if ($this->id) {
            if ($pdata = get_record('artefact_atranscript_vet', 'artefact', $this->id, null, null, null, null, '*, ' . db_format_tsfield('startdate') .
 ', ' . db_format_tsfield('enddate'))) {
                foreach($pdata as $name => $value) {
                    if (property_exists($this, $name)) {
                        $this->$name = $value;
                    }
                }
            }
            else {
                throw new ArtefactNotFoundException(get_string('vetdoesnotexist', 'artefact.atranscript'));
            }
        }
    }

    
    public static function is_singular() {
        return false;
    }

    public static function format_child_data($artefact, $pluginname) {
        $a = new StdClass;
        $a->id         = $artefact->id;
        $a->isartefact = true;
        $a->title      = '';
        $a->text       = get_string($artefact->artefacttype, 'artefact.atranscript');
        $a->container  = (bool) $artefact->container;
        $a->parent     = $artefact->id;
        return $a;
    }

    public static function get_links($id) {
        return array();
    }

    public function render_self($options) {
        //
    }

  /**
     * These two functions return a list of the given user's atranscript data.
     *
     * @param limit how many vet to display per page
     * @param offset current page to display
     * @return array (count: integer, data: array)
     */
    public static function get_vets($transc, $offset=0, $limit=20) {

        ($vets = get_records_sql_array("
			SELECT * FROM {artefact} a 
			JOIN {artefact_atranscript_vet} at ON at.artefact = a.id
            WHERE a.artefacttype = 'atranscript' AND a.parent = ?
            ORDER BY at.annee, a.id", array($transc), $offset, $limit))
        || ($vets = array());

        $result = array(
            'count'  => count_records('artefact', 'artefacttype', 'atranscript', 'parent', $transc),
            'data'   => $vets,
            'offset' => $offset,
            'limit'  => $limit,
			'id' 	 => $transc,
        );

        return $result;
    }


    public static function get_allvets($offset=0, $limit=20) {
        global $USER;

        ($vets = get_records_sql_array("
			SELECT * FROM {artefact} a 
			JOIN {artefact_atranscript_vet} at ON at.artefact = a.id
            WHERE a.owner = ? AND a.artefacttype = 'atranscript'
            ORDER BY at.annee, a.id", array($USER->get('id')), $offset, $limit))
        || ($vets = array());

        $result = array(
            'count'  => count_records('artefact', 'owner', $USER->get('id'), 'artefacttype', 'atranscript'),
            'data'   => $vets,
            'offset' => $offset,
            'limit'  => $limit,
        );

        return $result;
    }


    /**
     * This method extends ArtefactType::commit() by adding additional data
     * into the artefact__atranscript_vet table.
     *
     */
    public function commit() {
        if (empty($this->dirty)) {
            return;
        }

        // Return whether or not the commit worked
        $success = false;

        db_begin();
        $new = empty($this->id);

        parent::commit();

        $this->dirty = true;

	$data = (object)array('artefact'  => $this->get('id'),
		'resultat' => $this->get('resultat'),
		'cod_vet' => $this->get('cod_vet'),
		'cod_etu' => $this->get('cod_etu'),
		'etbt' => $this->get('etbt'), // MODIF JF
		'libelle_vet' => $this->get('libelle_vet'),
		'annee' => $this->get('annee'),
    	'annexedesc' => $this->get('annexedesc'),
	    'pdfa' => $this->get('pdfa'),
		'note' => $this->get('note')
);

        if ($new) {
            $success = insert_record('artefact_atranscript_vet', $data);
        }
        else {
            $success = update_record('artefact_atranscript_vet', $data, 'artefact');
        }

        db_commit();

        $this->dirty = $success ? false : true;

        return $success;
    }

/* copied from taks plugin
*/
   public function render_vets(&$vets, $template, $options, $pagination, $instance) {
        $smarty = smarty_core();
        $configdata = $instance->get('configdata');
        $smarty->assign('vets', $vets);
        $smarty->assign('options', $options);
        $smarty->assign('cols', $configdata['cols']);
        $vets['tablerows'] = $smarty->fetch($template);

        if ($vets['limit'] && $pagination) { 
            $pagination = build_pagination(array(
                'id' => $pagination['id'],
                'class' => 'center',
                'datatable' => $pagination['datatable'],
                'url' => $pagination['baseurl'],
                'jsonscript' => $pagination['jsonscript'],
                'count' => $vets['count'],
                'limit' => $vets['limit'],
                'offset' => $vets['offset'],
                'numbersincludefirstlast' => false,
                'resultcounttextsingular' => get_string('vets', 'artefact.atranscript'),
                'resultcounttextplural' => get_string('vets', 'artefact.atranscript'),
            ));
            $vets['pagination'] = $pagination['html'];
            $vets['pagination_js'] = $pagination['javascript'];
        }
    }


    /**
     * Builds the vets list table
     *
     * @param vets (reference)
     */
     public static function build_vets_list_html(&$vets) {
        $smarty = smarty_core();
        $smarty->assign_by_ref('vets', $vets);
        $vets['tablerows'] = $smarty->fetch('artefact:atranscript:vetslist.tpl');
        $pagination = build_pagination(array(
            'id' => 'atranscriptlist_pagination',
            'class' => 'center',
            'url' => get_config('wwwroot') . 'artefact/atranscript/index.php',
            'jsonscript' => 'artefact/atranscript/atranscript.json.php',
            'datatable' => 'atranscriptlist',
            'count' => $vets['count'],
            'limit' => $vets['limit'],
            'offset' => $vets['offset'],
            'firsttext' => '',
            'previoustext' => '',
            'nexttext' => '',
            'lasttext' => '',
            'numbersincludefirstlast' => false,
            'resultcounttextsingular' => get_string('annee', 'artefact.atranscript'),
            'resultcounttextplural' => get_string('annee', 'artefact.atranscript'),
        ));
        $vets['pagination'] = $pagination['html'];
        $vets['pagination_js'] = $pagination['javascript'];
    }



}

?>
