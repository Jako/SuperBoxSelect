/**
 * SuperBoxSelect Input Options Custom Table
 *
 * @package superboxselect
 * @subpackage inputoptions customtable
 */

SuperBoxSelect.panel.InputOptionsCustomTable = function (config) {
    config = config || {};

    this.ident = 'input-options-customtable-' + Ext.id();
    this.options = config.options;
    this.params = config.params;

    Ext.applyIf(config, {
        layout: 'fit',
        id: 'type_customtable',
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
                    columnWidth: .33,
                    layout: 'form',
                    labelAlign: 'top',
                    items: [{
                        xtype: 'textfield',
                        fieldLabel: _('superboxselect.packageName'),
                        description: MODx.expandHelp ? '' : _('superboxselect.packageName_desc'),
                        name: 'inopt_packageName',
                        id: this.ident + 'inopt_packageName',
                        value: this.params.packageName || '',
                        anchor: '100%',
                        listeners: {
                            change: {
                                fn: this.markDirty,
                                scope: this
                            }
                        }
                    }, {
                        xtype: MODx.expandHelp ? 'label' : 'hidden',
                        forId: 'inopt_packageName',
                        html: _('superboxselect.packageName_desc'),
                        cls: 'desc-under'
                    }]
                }, {
                    columnWidth: .33,
                    layout: 'form',
                    labelAlign: 'top',
                    items: [{
                        xtype: 'textfield',
                        fieldLabel: _('superboxselect.className'),
                        description: MODx.expandHelp ? '' : _('superboxselect.className_desc'),
                        name: 'inopt_className',
                        id: this.ident + 'inopt_className',
                        value: this.params.className || '',
                        anchor: '100%',
                        listeners: {
                            change: {
                                fn: this.markDirty,
                                scope: this
                            }
                        }
                    }, {
                        xtype: MODx.expandHelp ? 'label' : 'hidden',
                        forId: 'inopt_className',
                        html: _('superboxselect.className_desc'),
                        cls: 'desc-under'
                    }]
                }, {
                    columnWidth: .34,
                    layout: 'form',
                    labelAlign: 'top',
                    items: [{
                        xtype: 'textfield',
                        fieldLabel: _('superboxselect.selectedFields'),
                        description: MODx.expandHelp ? '' : _('superboxselect.selectedFields_desc'),
                        name: 'inopt_selectedFields',
                        id: this.ident + 'inopt_selectedFields',
                        value: this.params.selectedFields || '',
                        anchor: '100%',
                        listeners: {
                            change: {
                                fn: this.markDirty,
                                scope: this
                            }
                        }
                    }, {
                        xtype: MODx.expandHelp ? 'label' : 'hidden',
                        forId: 'inopt_selectedFields',
                        html: _('superboxselect.selectedFields_desc'),
                        cls: 'desc-under'
                    }]
                }]
            }]
        }]
    });
    SuperBoxSelect.panel.InputOptionsCustomTable.superclass.constructor.call(this, config);
};
Ext.extend(SuperBoxSelect.panel.InputOptionsCustomTable, MODx.Panel, {
    markDirty: function () {
        Ext.getCmp('modx-panel-tv').markDirty();
    }
});
Ext.reg('superboxselect-panel-inputoptions-customtable', SuperBoxSelect.panel.InputOptionsCustomTable);
