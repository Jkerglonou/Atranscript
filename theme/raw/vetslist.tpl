{str tag=Results section=artefact.atranscript}

<tr>
	<th>{str tag=YearObtention section=artefact.atranscript}
</th>
	<th>{str tag=Etab section=artefact.atranscript}
</th>
	<th>{str tag=code section=artefact.atranscript}
</th>
	<th>{str tag=libelle section=artefact.atranscript}
</th>
	<th>{str tag=resultat section=artefact.atranscript}
</th>
	<th>{str tag=note section=artefact.atranscript}
</th>
	<th>{str tag=annexedesc section=artefact.atranscript}
</th>
	<th>{str tag=pdfa section=artefact.atranscript}</th>
</tr>

{foreach from=$vets.data item=vet}
            <tr class="{cycle values='r0,r1'}">
                <td class="c1">{$vet->annee}</td>
                <td class="c3">{$vet->etbt}</td>
                <td class="c3">{$vet->cod_vet}</td>
                    <td class="c2">{$vet->libelle_vet}</td>
                    <td class="c3">{$vet->resultat}</td>
                    <td class="c3">{$vet->note}</td>
                    <td class="c3">{$vet->annexedesc}</td>
                    <td class="c3">{$vet->pdfa}</td>
            </tr>

