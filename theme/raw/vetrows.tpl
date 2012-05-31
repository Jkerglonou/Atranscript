 {foreach from=$vets.data item=vet}
            <tr name="artefactids[{$vet->id}]">
                <td class="c1">{$vet->annee}</td>
                <td class="c3">{$vet->etbt}</td>
                <td class="c3">{$vet->cod_vet}</td>
                    <td class="c2">{$vet->libelle_vet}</td>
                    <td class="c3">{$vet->resultat}</td>
                    <td class="c3">{$vet->note}</td>
                    <td class="c3">{$vet->annexedesc}</td>
                    <td class="c3">{$vet->pdfa}</td>
            </tr>

