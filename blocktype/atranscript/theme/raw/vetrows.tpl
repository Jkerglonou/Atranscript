        {foreach from=$vets item=task}
            <tr class="plan_incomplete">
                <td class="c1">{$task->completiondate}</td>
{if $task->description}
                <td class="c2"><a class="vets-title" href="">{$task->title}</a>
                <div class="vets-desc hidden">{$task->description}</div></td>
{else}
                <td class="c2">{$task->title}</td>
{/if}
                <td class="c3">&nbsp;</td>
            </tr>
        {else}
            <tr class="{cycle values='r0,r1'}">
                <td class="c1">{$task->completiondate}</td>
{if $task->description}
                <td class="c2"><a class="vets-title" href="">{$task->title}</a>
                <div class="vets-desc hidden" id="vets-desc-{$task->id}">{$task->description}</div></td>
{else}
                <td class="c2">{$task->title}</td>
{/if}
                {if $task->completed == 1}
                    <td class="c3"><div class="plan_completed"><img src="{$WWWROOT}theme/raw/static/images/success.gif" alt="" /></div></td>
                {else}
                    <td class="c3">&nbsp;</td>
                {/if}
            </tr>
