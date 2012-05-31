{include file="header.tpl"}
<div id="atranscriptwrap">
<p>{str tag="atranscriptdesc" section="artefact.atranscript"}</p>
{$atranscriptvet|safe}
{contextualhelp plugintype='artefact' pluginname='atranscript' section='vetdesc'}
<br>
{if !$vets.data}
    <div class="message">{$strnovets|safe}</div>
{else}
<table id="vetslist" class="fullwidth listing">
    <tbody>
        {$vets.tablerows|safe}
    </tbody>
</table>
   {$vets.pagination|safe}
{/if}
</div>


{include file="footer.tpl"}
