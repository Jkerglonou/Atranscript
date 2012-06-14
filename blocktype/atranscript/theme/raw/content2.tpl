<div class="blockinstance-content">
{if $vets.data}
<table id="vetstable_{$blockid}" class="atranscriptblocktable">
    <colgroup width="50%" span="2"></colgroup>
    <thead>
        <tr>
{foreach from=$cols item=val} 
{if $val == 0} <th class="c1">{str tag='annee' section='artefact.atranscript'}</th> {/if}
{if $val == 1} <th class="c2">{str tag='Etab' section='artefact.atranscript'}</th> {/if}
{if $val == 2} <th class="c2">{str tag='code' section='artefact.atranscript'}</th> {/if}
{if $val == 3} <th class="c3">{str tag='libelle' section='artefact.atranscript'}</th> {/if}
{if $val == 4} <th class="c3">{str tag='resultat' section='artefact.atranscript'}</th> {/if}
{if $val == 5} <th class="c3">{str tag='note' section='artefact.atranscript'}</th> {/if}
{if $val == 6} <th class="c3">{str tag='annexedesc' section='artefact.atranscript'}</th> {/if}
{if $val == 7} <th class="c3">{str tag='pdfa' section='artefact.atranscript'}</th> {/if}
{/foreach}
        </tr>
    </thead>
    <tbody>
    {$vets.tablerows|safe}
    </tbody>
</table>
{if $vets.pagination_js}
<script>
{literal}
function rewriteVetsTitles() {
    forEach(
{/literal}
        getElementsByTagAndClassName('a', 'vets-title','vetstable_{$blockid}'),
{literal}
        function(element) {
            connect(element, 'onclick', function(e) {
                e.stop();
                var description = getFirstElementByTagAndClassName('div', 'vets-desc', element.parentNode);
                toggleElementClass('hidden', description);
            });
        }
    );
}

addLoadEvent(function() {{/literal}
    {$vets.pagination_js|safe}
    removeElementClass('atranscript_page_container', 'hidden');
{literal}}{/literal});

function VetsPager_{$blockid}() {literal}{
    var self = this;
    paginatorProxy.addObserver(self);
    connect(self, 'pagechanged', rewriteVetsTitles);
}
{/literal}
var vetsPager_{$blockid} = new VetsPager_{$blockid}();
addLoadEvent(rewriteVetsTitles);
</script>
{/if} {* pagination_js *}
{else}
    <p>{str tag='novets' section='artefact.atranscript'}</p>
{/if}
</div>
