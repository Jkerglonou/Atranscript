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
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2012 UBO, kerglonou@univ-brest.fr
 *
 */

defined('INTERNAL') || die();

function xmldb_artefact_atranscript_upgrade($oldversion=0) {

    if ($oldversion < 2011093000) {
        set_field('artefact', 'container', 1, 'artefacttype', 'atranscript');
		// ajout colonne intitule
        execute_sql( 'ALTER TABLE artefact_atranscript_vet ADD libelle_vet varchar(256)' );
    }

// VOIR http://docs.moodle.org/dev/XMLDB_creating_new_DDL_functions

    return true;
}

?>

