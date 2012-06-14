 {foreach from=$vets.data item=vet}
            <tr name="artefactids[{$vet->id}]">
{foreach from=$cols item=val}
{if $val == 0} <td class="c1">{$vet->annee}</td> {/if}
{if $val == 1} <td class="c3">{$vet->etbt}</td> {/if}
{if $val == 2} <td class="c3">{$vet->cod_vet}</td> {/if}
{if $val == 3} <td class="c2">{$vet->libelle_vet}</td> {/if}
{if $val == 4} <td class="c3">{$vet->resultat}</td> {/if}
{if $val == 5} <td class="c3">{$vet->note}</td> {/if}
{if $val == 6} <td class="c3">{$vet->annexedesc}</td> {/if}
{if $val == 7} <td class="c3">{$vet->pdfa}</td>  {/if}
{/foreach}
            </tr>

