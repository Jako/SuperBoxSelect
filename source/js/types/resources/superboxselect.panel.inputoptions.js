/**
 * SuperBoxSelect Input Options Resources
 *
 * @package superboxselect
 * @subpackage inputoptions resources
 */

SuperBoxSelect.panel.InputOptionsResources = function (config) {
    config = config || {};

    this.options = config.options;
    this.params = config.params;

    Ext.applyIf(config, {
        layout: 'fit',
        id: 'type_resources',
        cls: 'alltypes',
        style: {
            height: '0',
            overflow: 'hidden'
        },
        items: [{
            xtype: 'panel',
            layout: 'form',
            labelAlign: 'top',
            items: [{
                layout: 'column',
                items: [{
                    columnWidth: .25,
                    layout: 'form',
                    labelAlign: 'top',
                    items: [{
                        xtype: 'textfield',
                        fieldLabel: _('resourcelist_parents'),
                        description: MODx.expandHelp ? '' : _('resourcelist_parents_desc'),
                        name: 'inopt_parents',
                        id: 'inopt_parents',
                        value: this.params.parents || '',
                        anchor: '100%',
                        listeners: {
                            change: {
                                fn: this.markDirty,
                                scope: this
                            }
                        }
                    }, {
                        xtype: MODx.expandHelp ? 'label' : 'hidden',
                        forId: 'inopt_parents',
                        html: _('resourcelist_parents_desc'),
                        cls: 'desc-under'
                    }]
                }, {
                    columnWidth: .25,
                    layout: 'form',
                    labelAlign: 'top',
                    items: [{
                        xtype: 'textfield',
                        fieldLabel: _('resourcelist_depth'),
                        description: MODx.expandHelp ? '' : _('resourcelist_depth_desc'),
                        name: 'inopt_depth',
                        id: 'inopt_depth',
                        value: this.params.depth || 10,
                        anchor: '100%',
                        listeners: {
                            change: {
                                fn: this.markDirty,
                                scope: this
                            }
                        }
                    }, {
                        xtype: MODx.expandHelp ? 'label' : 'hidden',
                        forId: 'inopt_depth',
                        html: _('resourcelist_depth_desc'),
                        cls: 'desc-under'
                    }]
                }, {
                    columnWidth: .25,
                    layout: 'form',
                    labelAlign: 'top',
                    items: [{
                        xtype: 'textfield',
                        fieldLabel: _('superboxselect.valueField'),
                        description: MODx.expandHelp ? '' : _('superboxselect.valueField_desc'),
                        name: 'inopt_valueField',
                        id: 'inopt_valueField',
                        value: this.params.valueField || 10,
                        anchor: '100%',
                        listeners: {
                            change: {
                                fn: this.markDirty,
                                scope: this
                            }
                        }
                    }, {
                        xtype: MODx.expandHelp ? 'label' : 'hidden',
                        forId: 'inopt_valueField',
                        html: _('superboxselect.valueField_desc'),
                        cls: 'desc-under'
                    }]
                }, {
                    columnWidth: .25,
                    layout: 'form',
                    labelAlign: 'top',
                    items: [{
                        xtype: 'combo-boolean',
                        fieldLabel: _('resourcelist_limitrelatedcontext'),
                        description: MODx.expandHelp ? '' : _('resourcelist_limitrelatedcontext_desc'),
                        name: 'inopt_limitRelatedContext',
                        hiddenName: 'inopt_limitRelatedContext',
                        id: 'inopt_limitRelatedContext',
                        value: this.params.limitRelatedContext === 1 || this.params.limitRelatedContext === 'true' ? 1 : 0,
                        anchor: '100%',
                        listeners: {
                            change: {
                                fn: this.markDirty,
                                scope: this
                            }
                        }
                    }, {
                        xtype: MODx.expandHelp ? 'label' : 'hidden',
                        forId: 'inopt_limitRelatedContext',
                        html: _('resourcelist_limitrelatedcontext_desc'),
                        cls: 'desc-under'
                    }]
                }]
            }, {
                xtype: 'textarea',
                fieldLabel: _('resourcelist_where'),
                description: MODx.expandHelp ? '' : _('resourcelist_where_desc'),
                name: 'inopt_where',
                id: 'inopt_where',
                value: this.params.where || '',
                anchor: '100%',
                listeners: {
                    change: {
                        fn: this.markDirty,
                        scope: this
                    }
                }
            }, {
                xtype: MODx.expandHelp ? 'label' : 'hidden',
                forId: 'inopt_where',
                html: _('resourcelist_where_desc'),
                cls: 'desc-under'
            }]
        }]
    });
    SuperBoxSelect.panel.InputOptionsResources.superclass.constructor.call(this, config);
};
Ext.extend(SuperBoxSelect.panel.InputOptionsResources, MODx.Panel, {
    markDirty: function () {
        Ext.getCmp('modx-panel-tv').markDirty();
    }
});
Ext.reg('superboxselect-panel-inputoptions-resources', SuperBoxSelect.panel.InputOptionsResources);
