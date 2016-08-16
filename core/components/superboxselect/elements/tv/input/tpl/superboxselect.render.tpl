<div id="superboxselect-tv{$tv->id}"></div>
<script type="text/javascript">
    // <![CDATA[ {literal}
    Ext.onReady(function () { {/literal}
        var tv{$tv->id}resources = {literal}new Ext.data.JsonStore({
            id: 'id',
            root: 'results',
            fields: [{
                name: 'id',
                type: 'int'
            }, {
                name: {/literal}'{$params.displayField}'{literal},
                type: 'string'
            }],{/literal}
            url: '{$connector}',{literal}
            baseParams: {{/literal}
                action: '{$params.processorAction}',
                parents: '{$params.parents}',
                depth: '{$params.depth}',
                limitRelatedContext: {if ($params.limitRelatedContext == 1) || ($params.limitRelatedContext == 'true') }true{else}false{/if},
                where: '{$params.where}',
                {if ({!$params.pageSize})}limit: 0,
                {/if}resource_id: '{$params.resourceId}',
                context_key: '{$params.contextKey}',
                packageName: '{$params.packageName}',
                className: '{$params.className}',
                displayField: '{$params.displayField}',
                options: "{$tv->_fields.elements}"
                {literal}
            }
        });
        new Ext.ux.form.SuperBoxSelect({ {/literal}
            transform: 'superboxselect-tv{$tv->id}',
            name: 'tv{$tv->id}[]',
            value: '{$value}',
            ctCls: 'superboxselect-tv',
            allowBlank: {if $params.allowBlank === 1 || $params.allowBlank === 'true'}true{else}false{/if},
            msgTarget: 'title',
            fieldLabel: 'Resources',
            width: 400,
            displayField: '{$params.displayField}',
            {literal}displayFieldTpl: '{{/literal}{$params.displayField}{literal}} ({id})',
            tpl: '<tpl for="."><div class="x-combo-list-item">{{/literal}{$params.displayField}{literal}} ({id})</div></tpl>',{/literal}
            valueField: 'id',
            {if ({$params.pageSize})}pageSize: {$params.pageSize},
            {/if}addNewDataOnBlur: false,
            anchor: '100%',
            minChars: 2,
            classField: 'cls',
            styleField: 'style',
            store: tv{$tv->id}resources, {literal}
            mode: 'remote',
            queryDelay: 0,
            triggerAction: 'all',
            listeners: { {/literal}{if $params.maxResources}
                {literal}
                afterrender: function (bs) { {/literal}
                    var caption = Ext.get('tv{$tv->id}-caption'); {literal}
                    var newlabel = _('superboxselect.maxResources_label').replace(/{maxResources}/, {/literal}'{$params.maxResources}');
                    caption.dom.innerHTML = caption.dom.innerHTML +
                            ' <span class="modx-tv-label-description">(' + newlabel +
                            ')</span>'; {literal}
                },
                beforeadditem: function (bs, v) { {/literal}
                    if (bs.getCount() > {$params.maxResources - 1}){literal} {
                        MODx.msg.alert(_('error'), _('superboxselect.maxResources_msg'));
                        return false;
                    }
                    return true;
                }{/literal},{/if}{literal}
                additem: function (bs, v) {
                    MODx.fireResourceFormChange();
                },
                removeitem: function (bs, v) {
                    MODx.fireResourceFormChange();
                }
            }
        });
    });
    {/literal}
    // ]]>
</script>