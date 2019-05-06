/**
 * SuperBoxSelect Input Options Users
 *
 * @package superboxselect
 * @subpackage inputoptions users
 */

SuperBoxSelect.panel.InputOptionsUsers = function (config) {
    config = config || {};

    this.options = config.options;
    this.params = config.params;

    Ext.applyIf(config, {
        layout: 'fit',
        id: 'type_users',
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
                    columnWidth: .5,
                    layout: 'form',
                    labelAlign: 'top',
                    items: [{
                        xtype: 'textfield',
                        fieldLabel: _('superboxselect.allowedUsergroups'),
                        description: MODx.expandHelp ? '' : _('rsuperboxselect.allowedUsergroups_desc'),
                        name: 'inopt_allowedUsergroups',
                        id: 'inopt_allowedUsergroups',
                        value: this.params.allowedUsergroups || '',
                        anchor: '100%',
                        listeners: {
                            change: {
                                fn: this.markDirty,
                                scope: this
                            }
                        }
                    }, {
                        xtype: MODx.expandHelp ? 'label' : 'hidden',
                        forId: 'inopt_allowedUsergroups',
                        html: _('superboxselect.allowedUsergroups_desc'),
                        cls: 'desc-under'
                    }]
                }, {
                    columnWidth: .5,
                    layout: 'form',
                    labelAlign: 'top',
                    items: [{
                        xtype: 'textfield',
                        fieldLabel: _('superboxselect.deniedUsergroups'),
                        description: MODx.expandHelp ? '' : _('rsuperboxselect.deniedUsergroups_desc'),
                        name: 'inopt_deniedUsergroups',
                        id: 'inopt_deniedUsergroups',
                        value: this.params.deniedUsergroups || '',
                        anchor: '100%',
                        listeners: {
                            change: {
                                fn: this.markDirty,
                                scope: this
                            }
                        }
                    }, {
                        xtype: MODx.expandHelp ? 'label' : 'hidden',
                        forId: 'inopt_deniedUsergroups',
                        html: _('superboxselect.deniedUsergroups_desc'),
                        cls: 'desc-under'
                    }]
                }]
            }]
        }]
    });
    SuperBoxSelect.panel.InputOptionsUsers.superclass.constructor.call(this, config);
};
Ext.extend(SuperBoxSelect.panel.InputOptionsUsers, MODx.Panel, {
    markDirty: function () {
        Ext.getCmp('modx-panel-tv').markDirty();
    }
});
Ext.reg('superboxselect-panel-inputoptions-users', SuperBoxSelect.panel.InputOptionsUsers);
