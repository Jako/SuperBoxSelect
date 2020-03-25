<div id="superboxselect-tv-{$tv->id}"></div>
<script type="text/javascript">
    // <![CDATA[ {literal}
    Ext.onReady(function () { {/literal}
        var tv{$tv->id}store = {literal}new Ext.data.JsonStore({
            id: 'id',
            root: 'results',
            fields: ['id', 'title'],{/literal}
            url: '{$connector}',{literal}
            baseParams: {{/literal}
                action: 'types/{$params.selectType}/getlist',
                allowedUsergroups: '{$params.allowedUsergroups}',
                contextKey: '{$params.contextKey}',
                deniedUsergroups: '{$params.deniedUsergroups}',
                depth: '{$params.depth}',
                limitRelatedContext: {if ($params.limitRelatedContext === 1) || ($params.limitRelatedContext === 'true') }true{else}false{/if},
                package: '{$params.selectPackage}',
                parents: '{$params.parents}',
                resourceId: '{$params.resourceId}',
                valueField: '{$params.valueField}' || 'id',
                where: '{$params.where}'{literal}
            }
        });{/literal}
        {if $params.maxElements != 1} {literal}
        new SuperBoxSelect.combo.SuperBoxSelectTV({
            options: { {/literal}
                allowBlank: {if $params.allowBlank === 1 || $params.allowBlank === 'true'}true{else}false{/if},
                fieldLabel: _('superboxselect.{$params.selectType}'),
                fieldTpl: {if $params.fieldTpl}'{$params.fieldTpl}'{else}{literal}'{title} ({id})'{/literal}{/if},
                maxElements: {($params.maxElements) ? $params.maxElements * 1 : 0},
                stackItems: {if ($params.stackItems === 1) || ($params.stackItems === 'true') }true{else}false{/if},
                {if $params.pageSize}pageSize: {$params.pageSize * 1},
                {/if}store: tv{$tv->id}store,
                tvid: '{$tv->id}',
                value: '{$value}'{literal}
            }
        }); {/literal}
        {else} {literal}
        new SuperBoxSelect.combo.SuperBoxSelectTVSingle({
            options: { {/literal}
                allowBlank: {if $params.allowBlank === 1 || $params.allowBlank === 'true'}true{else}false{/if},
                fieldTpl: {if $params.fieldTpl}'{$params.fieldTpl}'{else}{literal}'{title} ({id})'{/literal}{/if},
                fieldLabel: _('superboxselect.{$params.selectType}'),
                maxElements: {($params.maxElements) ? $params.maxElements * 1 : 0},
                {if $params.pageSize}pageSize: {$params.pageSize * 1},
                {/if}store: tv{$tv->id}store,
                tvid: '{$tv->id}',
                value: '{$value}'{literal}
            }
        }); {/literal}
        {/if} {literal}
    });{/literal}
    // ]]>
</script>
