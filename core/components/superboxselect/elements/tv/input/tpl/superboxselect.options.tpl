<div id="tv-input-properties-form{$tv|default}"></div>
<script type="text/javascript">
    // <![CDATA[
    {literal}
    var params = {
        {/literal}{foreach from=$params key=k item=v name='p'}
        '{$k}': '{$v|escape:"javascript"}'{if NOT $smarty.foreach.p.last}, {/if}
        {/foreach}{literal}
    };
    var oc = {
        'change': {
            fn: function () {
                Ext.getCmp('modx-panel-tv').markDirty();
            },
            scope: this
        }
    };
    MODx.load({
        xtype: 'panel',
        layout: 'form',
        autoHeight: true,
        cls: 'form-with-labels',
        labelAlign: 'top',
        border: false,
        items: [
            {
                xtype: 'box',
                tag: 'div',
                html: '<p>' + _('superboxselect.generalOptions') + '</p>',
                style: 'background-color:#F0F0F0; color: #53595F; padding: 15px;',
            }, {
                xtype: 'textarea',
                fieldLabel: _('resourcelist_where'),
                description: MODx.expandHelp ? '' : _('resourcelist_where_desc'),
                name: 'inopt_where',
                id: 'inopt_where{/literal}{$tv|default}{literal}',
                value: params['where'] || '',
                //anchor: '100%',
                style: 'width:100%;box-sizing: border-box;',
                listeners: oc
            }, {
                xtype: MODx.expandHelp ? 'label' : 'hidden',
                forId: 'inopt_where{/literal}{$tv|default}{literal}',
                html: _('resourcelist_where_desc'),
                cls: 'desc-under'
            }, {
                xtype: 'numberfield',
                fieldLabel: _('superboxselect.pageSize'),
                description: MODx.expandHelp ? '' : _('superboxselect.pageSize_desc'),
                name: 'inopt_pageSize',
                id: 'inopt_pageSize{/literal}{$tv|default}{literal}',
                value: params['pageSize'] || 10,
                allowNegative: false,
                allowDecimals: false,
                style: 'width:100%;box-sizing: border-box;min-height:30px;',
                listeners: oc
            }, {
                xtype: MODx.expandHelp ? 'label' : 'hidden',
                forId: 'inopt_pageSize{/literal}{$tv|default}{literal}',
                html: _('superboxselect.pageSize_desc'),
                cls: 'desc-under'
            }, {
                xtype: 'combo-boolean',
                fieldLabel: _('required'),
                description: MODx.expandHelp ? '' : _('required_desc'),
                name: 'inopt_allowBlank',
                hiddenName: 'inopt_allowBlank',
                id: 'inopt_allowBlank{/literal}{$tv|default}{literal}',
                value: params['allowBlank'] == 0 || params['allowBlank'] == 'false' ? 0 : 1,
                style: 'width:100%;box-sizing: border-box;min-height:30px;',
                listeners: oc
            }, {
                xtype: MODx.expandHelp ? 'label' : 'hidden',
                forId: 'inopt_allowBlank{/literal}{$tv|default}{literal}',
                html: _('required_desc'),
                cls: 'desc-under'
            }, {
                xtype: 'box',
                tag: 'div',
                html: '<p>' + _('superboxselect.resourceOptions') + '</p>',
                style: 'background-color:#F0F0F0; color: #53595F; padding: 15px;margin-top:15px;',
            }, {
                xtype: 'textfield',
                fieldLabel: _('resourcelist_parents'),
                description: MODx.expandHelp ? '' : _('resourcelist_parents_desc'),
                name: 'inopt_parents',
                id: 'inopt_parents{/literal}{$tv|default}{literal}',
                value: params['parents'] || '',
                style: 'width:100%;box-sizing: border-box;min-height:30px;',
                listeners: oc
            }, {
                xtype: MODx.expandHelp ? 'label' : 'hidden',
                forId: 'inopt_parents{/literal}{$tv|default}{literal}',
                html: _('resourcelist_parents_desc'),
                cls: 'desc-under'
            }, {
                xtype: 'textfield',
                fieldLabel: _('superboxselect.maxResources'),
                description: MODx.expandHelp ? '' : _('superboxselect.maxResources_desc'),
                name: 'inopt_maxResources',
                id: 'inopt_maxResources{/literal}{$tv|default}{literal}',
                value: params['maxResources'] || '',
                style: 'width:100%;box-sizing: border-box;min-height:30px;',
                listeners: oc
            }, {
                xtype: MODx.expandHelp ? 'label' : 'hidden',
                forId: 'inopt_maxResources{/literal}{$tv|default}{literal}',
                html: _('superboxselect.maxResources_desc'),
                cls: 'desc-under'
            }, {
                xtype: 'textfield',
                fieldLabel: _('resourcelist_depth'),
                description: MODx.expandHelp ? '' : _('resourcelist_depth_desc'),
                name: 'inopt_depth',
                id: 'inopt_depth{/literal}{$tv|default}{literal}',
                value: params['depth'] || 10,
                style: 'width:100%;box-sizing: border-box;min-height:30px;',
                listeners: oc
            }, {
                xtype: MODx.expandHelp ? 'label' : 'hidden',
                forId: 'inopt_depth{/literal}{$tv|default}{literal}',
                html: _('resourcelist_depth_desc'),
                cls: 'desc-under'
            }, {
                xtype: 'combo-boolean',
                fieldLabel: _('resourcelist_limitrelatedcontext'),
                description: MODx.expandHelp ? '' : _('resourcelist_limitrelatedcontext_desc'),
                name: 'inopt_limitRelatedContext',
                hiddenName: 'inopt_limitRelatedContext',
                id: 'inopt_limitRelatedContext{/literal}{$tv|default}{literal}',
                value: params['limitRelatedContext'] == 1 || params['limitRelatedContext'] == 'true' ? 1 : 0,
                style: 'width:100%;box-sizing: border-box;min-height:30px;',
                listeners: oc
            }, {
                xtype: MODx.expandHelp ? 'label' : 'hidden',
                forId: 'inopt_limitRelatedContext{/literal}{$tv|default}{literal}',
                html: _('resourcelist_limitrelatedcontext_desc'),
                cls: 'desc-under'
            }, {
                xtype: 'box',
                tag: 'div',
                html: '<p>' + _('superboxselect.customProcessor') + '</p>',
                style: 'background-color:#F0F0F0; color: #53595F; padding: 15px;margin-top:15px;',
            }, {
                xtype: 'textfield',
                fieldLabel: _('superboxselect.packageName'),
                description: MODx.expandHelp ? '' : _('superboxselect.packageName_desc'),
                name: 'inopt_packageName',
                id: 'inopt_packageName{/literal}{$tv|default}{literal}',
                value: params['packageName'] || '',
                style: 'width:100%;box-sizing: border-box;min-height:30px;',
                listeners: oc
            }, {
                xtype: MODx.expandHelp ? 'label' : 'hidden',
                forId: 'inopt_packageName{/literal}{$tv|default}{literal}',
                html: _('superboxselect.packageName_desc'),
                cls: 'desc-under'
            }, {
                xtype: 'textfield',
                fieldLabel: _('superboxselect.processorAction'),
                description: MODx.expandHelp ? '' : _('superboxselect.processorAction_desc'),
                name: 'inopt_processorAction',
                id: 'inopt_processorAction{/literal}{$tv|default}{literal}',
                value: params['processorAction'] || '',
                style: 'width:100%;box-sizing: border-box;min-height:30px;',
                listeners: oc
            }, {
                xtype: MODx.expandHelp ? 'label' : 'hidden',
                forId: 'inopt_processorAction{/literal}{$tv|default}{literal}',
                html: _('superboxselect.processorAction_desc'),
                cls: 'desc-under'
            }, {
                xtype: 'textfield',
                fieldLabel: _('superboxselect.className'),
                description: MODx.expandHelp ? '' : _('superboxselect.className_desc'),
                name: 'inopt_className',
                id: 'inopt_className{/literal}{$tv|default}{literal}',
                value: params['className'] || '',
                style: 'width:100%;box-sizing: border-box;min-height:30px;',
                listeners: oc
            }, {
                xtype: MODx.expandHelp ? 'label' : 'hidden',
                forId: 'inopt_className{/literal}{$tv|default}{literal}',
                html: _('superboxselect.className_desc'),
                cls: 'desc-under'
            }, {
                xtype: 'textfield',
                fieldLabel: _('superboxselect.displayField'),
                description: MODx.expandHelp ? '' : _('superboxselect.displayField_desc'),
                name: 'inopt_displayField',
                id: 'inopt_displayField{/literal}{$tv|default}{literal}',
                value: params['displayField'] || '',
                style: 'width:100%;box-sizing: border-box;min-height:30px;',
                listeners: oc
            }, {
                xtype: MODx.expandHelp ? 'label' : 'hidden',
                forId: 'inopt_displayField{/literal}{$tv|default}{literal}',
                html: _('superboxselect.displayField_desc'),
                cls: 'desc-under'
            }],
        renderTo: 'tv-input-properties-form{/literal}{$tv|default}{literal}'
    });

    // ]]>
</script>
{/literal}
