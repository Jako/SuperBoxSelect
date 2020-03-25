/**
 * SuperBoxSelect Input Options
 *
 * @package superboxselect
 * @subpackage inputoptions
 */

SuperBoxSelect.panel.InputOptions = function (config) {
    config = config || {};

    this.options = config.options;
    this.params = config.params;

    Ext.applyIf(config, {
        layout: 'form',
        autoHeight: true,
        cls: 'form-with-labels',
        labelAlign: 'top',
        border: false,
        items: [{
            layout: 'column',
            items: [{
                columnWidth: (SuperBoxSelect.config.advanced) ? .5 : 1,
                layout: 'form',
                labelAlign: 'top',
                items: [{
                    xtype: 'modx-combo',
                    fieldLabel: _('superboxselect.selectType'),
                    description: MODx.expandHelp ? '' : _('superboxselect.selectType_desc'),
                    name: 'inopt_selectType',
                    hiddenName: 'inopt_selectType',
                    id: 'inopt_selectType',
                    value: this.params.selectType || 'resources',
                    anchor: '100%',
                    url: SuperBoxSelect.config.connectorUrl,
                    baseParams: {
                        action: 'mgr/selecttypes/getlist',
                        tvId: MODx.request.id,
                        package: this.params.selectPackage || ''
                    },
                    listeners: {
                        select: {
                            fn: this.selectType,
                            scope: this
                        }
                    }
                }, {
                    xtype: MODx.expandHelp ? 'label' : 'hidden',
                    forId: 'inopt_selectType',
                    html: _('superboxselect.selectType_desc'),
                    cls: 'desc-under'
                }]
            }, {
                columnWidth: .5,
                layout: 'form',
                labelAlign: 'top',
                items: [{
                    xtype: 'textfield',
                    fieldLabel: _('superboxselect.selectPackage'),
                    description: MODx.expandHelp ? '' : _('superboxselect.selectPackage_desc'),
                    name: 'inopt_selectPackage',
                    id: 'inopt_selectPackage',
                    value: this.params.selectPackage || '',
                    anchor: '100%',
                    hidden: !SuperBoxSelect.config.advanced,
                    listeners: {
                        change: {
                            fn: this.markDirty,
                            scope: this
                        }
                    }
                }, {
                    xtype: MODx.expandHelp ? 'label' : 'hidden',
                    forId: 'inopt_selectPackage',
                    html: _('superboxselect.selectPackage_desc'),
                    cls: 'desc-under',
                    hidden: !SuperBoxSelect.config.advanced
                }]
            }]
        }, {
            layout: 'column',
            items: [{
                columnWidth: (SuperBoxSelect.config.advanced) ? .33 : .5,
                layout: 'form',
                labelAlign: 'top',
                items: [{
                    xtype: 'textfield',
                    fieldLabel: _('superboxselect.maxElements'),
                    description: MODx.expandHelp ? '' : _('superboxselect.maxElements_desc'),
                    name: 'inopt_maxElements',
                    id: 'inopt_maxElements',
                    value: this.params.maxElements || this.params.maxResources || '',
                    anchor: '100%',
                    listeners: {
                        change: {
                            fn: this.markDirty,
                            scope: this
                        }
                    }
                }, {
                    xtype: MODx.expandHelp ? 'label' : 'hidden',
                    forId: 'inopt_maxElements',
                    html: _('superboxselect.maxElements_desc'),
                    cls: 'desc-under'
                }]
            }, {
                columnWidth: .33,
                layout: 'form',
                labelAlign: 'top',
                items: [{
                    xtype: 'textfield',
                    fieldLabel: _('superboxselect.fieldTpl'),
                    description: MODx.expandHelp ? '' : _('superboxselect.fieldTpl_desc'),
                    name: 'inopt_fieldTpl',
                    id: 'inopt_fieldTpl',
                    value: this.params.fieldTpl || '',
                    anchor: '100%',
                    hidden: !SuperBoxSelect.config.advanced,
                    listeners: {
                        change: {
                            fn: this.markDirty,
                            scope: this
                        }
                    }
                }, {
                    xtype: MODx.expandHelp ? 'label' : 'hidden',
                    forId: 'inopt_fieldTpl',
                    html: _('superboxselect.fieldTpl_desc'),
                    cls: 'desc-under',
                    hidden: !SuperBoxSelect.config.advanced
                }]
            }, {
                columnWidth: (SuperBoxSelect.config.advanced) ? .34 : .5,
                layout: 'form',
                labelAlign: 'top',
                items: [{
                    xtype: 'combo-boolean',
                    fieldLabel: _('superboxselect.stackItems'),
                    description: MODx.expandHelp ? '' : _('superboxselect.stackItems_desc'),
                    name: 'inopt_stackItems',
                    hiddenName: 'inopt_stackItems',
                    id: 'inopt_stackItems',
                    value: this.params.stackItems === 1 || this.params.stackItems === 'true' ? 1 : 0,
                    anchor: '100%',
                    listeners: {
                        change: {
                            fn: this.markDirty,
                            scope: this
                        }
                    }
                }, {
                    xtype: MODx.expandHelp ? 'label' : 'hidden',
                    forId: 'inopt_stackItems',
                    html: _('superboxselect.stackItems_desc'),
                    cls: 'desc-under'
                }]
            }]
        }, {
            layout: 'column',
            items: [{
                columnWidth: .5,
                layout: 'form',
                labelAlign: 'top',
                items: [{
                    xtype: 'combo-boolean',
                    fieldLabel: _('required'),
                    description: MODx.expandHelp ? '' : _('required_desc'),
                    name: 'inopt_allowBlank',
                    hiddenName: 'inopt_allowBlank',
                    id: 'inopt_allowBlank',
                    value: this.params.allowBlank === 0 || this.params.allowBlank === 'false' ? 0 : 1,
                    anchor: '100%',
                    listeners: {
                        change: {
                            fn: this.markDirty,
                            scope: this
                        }
                    }
                }, {
                    xtype: MODx.expandHelp ? 'label' : 'hidden',
                    forId: 'inopt_allowBlank',
                    html: _('required_desc'),
                    cls: 'desc-under'
                }]
            }, {
                columnWidth: .5,
                layout: 'form',
                labelAlign: 'top',
                items: [{
                    xtype: 'numberfield',
                    fieldLabel: _('superboxselect.pageSize'),
                    description: MODx.expandHelp ? '' : _('superboxselect.pageSize_desc'),
                    name: 'inopt_pageSize',
                    id: 'inopt_pageSize',
                    value: this.params.pageSize || 10,
                    allowNegative: false,
                    allowDecimals: false,
                    anchor: '100%',
                    listeners: {
                        change: {
                            fn: this.markDirty,
                            scope: this
                        }
                    }
                }, {
                    xtype: MODx.expandHelp ? 'label' : 'hidden',
                    forId: 'inopt_pageSize',
                    html: _('superboxselect.pageSize_desc'),
                    cls: 'desc-under'
                }]
            }]
        }, {
            xtype: 'superboxselect-panel-inputoptions-types',
            params: this.params
        }, {
            cls: "treehillstudio_about",
            html: '<img width="133" height="40" src="' + SuperBoxSelect.config.assetsUrl + 'img/treehill-studio-small.png"' + ' srcset="' + SuperBoxSelect.config.assetsUrl + 'img/treehill-studio-small@2x.png 2x" alt="Treehill Studio">',
            listeners: {
                afterrender: function (component) {
                    component.getEl().select('img').on('click', function () {
                        var msg = '<span style="display: inline-block; text-align: center;">&copy; 2011-2016 by Benjamin Vauchel <a href="https://github.com/benjamin-vauchel" target="_blank">github.com/benjamin-vauchel</a><br>' +
                            '<img src="' + SuperBoxSelect.config.assetsUrl + 'img/treehill-studio.png" srcset="' + SuperBoxSelect.config.assetsUrl + 'img/treehill-studio@2x.png 2x" alt="Treehill Studio" style="margin-top: 10px"><br>' +
                            '&copy; 2016-2020 by <a href="https://treehillstudio.com" target="_blank">treehillstudio.com</a></span>';
                        Ext.Msg.show({
                            title: _('superboxselect') + ' ' + SuperBoxSelect.config.version,
                            msg: msg,
                            buttons: Ext.Msg.OK,
                            cls: 'treehillstudio_window',
                            width: 330
                        });
                    });
                }
            }
        }],
        listeners: {
            afterrender: {
                fn: this.inputOptionsAfterRender,
                scope: this
            }
        }
    });
    SuperBoxSelect.panel.InputOptions.superclass.constructor.call(this, config);
};
Ext.extend(SuperBoxSelect.panel.InputOptions, MODx.Panel, {
    selectType: function (c, v) {
        var oldsections = Ext.getCmp('modx-input-props').getEl().select('.alltypes');
        if (oldsections) {
            oldsections.each(function (el) {
                el.setStyle('height', '0');
            });
        }
        var section = Ext.getCmp('type_' + v.id);
        if (section) {
            section.getEl().setStyle('height', null);
        }
    },
    inputOptionsAfterRender: function () {
        var selecttype = Ext.getCmp('inopt_selectType').getValue();
        if (selecttype) {
            var section = Ext.getCmp('type_' + selecttype);
            if (section) {
                section.getEl().setStyle('height', null);
            }
        }
        var tvelements = Ext.getCmp('modx-tv-elements');
        if (tvelements) {
            tvelements.itemCt.applyStyles({
                height: '0',
                overflow: 'hidden'
            })
        }
    },
    markDirty: function () {
        Ext.getCmp('modx-panel-tv').markDirty();
    }
});
Ext.reg('superboxselect-panel-inputoptions', SuperBoxSelect.panel.InputOptions);
