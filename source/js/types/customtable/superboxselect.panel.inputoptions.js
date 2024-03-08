/**
 * SuperBoxSelect Input Options Resources
 *
 * @package superboxselect
 * @subpackage inputoptions resources
 */

(SuperBoxSelect.panel.InputOptionsCustomTable = function (e) {
    (e = e || {}),
        (this.ident = "input-options-customtable-" + Ext.id()),
        (this.options = e.options),
        (this.params = e.params),
        Ext.applyIf(e, {
            layout: "fit",
            id: "type_customtable",
            cls: "alltypes",
            style: { height: "0", overflow: "hidden" },
            items: [
                {
                    xtype: "panel",
                    layout: "form",
                    labelAlign: "top",
                    items: [
                        {
                            layout: "column",
                            items: [
                                {
                                    columnWidth: 0.5,
                                    layout: "form",
                                    labelAlign: "top",
                                    items: [
                                        {
                                            xtype: "textfield",
                                            fieldLabel: _('superboxselect.className'),
                                            description: MODx.expandHelp ? "" : _('superboxselect.className_desc'),
                                            name: "inopt_className",
                                            id: this.ident + "inopt_inopt_className",
                                            value: this.params.className || "",
                                            anchor: "100%",
                                            listeners: { change: { fn: this.markDirty, scope: this } },
                                        },
                                        { xtype: MODx.expandHelp ? "label" : "hidden", forId: "inopt_className", html: _('superboxselect.className_desc'), cls: "desc-under" },
                                    ],
                                },
                                {
                                    columnWidth: 0.5,
                                    layout: "form",
                                    labelAlign: "top",
                                    items: [
                                        {
                                            xtype: "textfield",
                                            fieldLabel: _('superboxselect.selectedFields'),
                                            description: MODx.expandHelp ? "" : _('superboxselect.selectedFields_desc'),
                                            name: "inopt_selectedFields",
                                            id: this.ident + "inopt_selectedFields",
                                            value: this.params.selectedFields || "",
                                            anchor: "100%",
                                            listeners: { change: { fn: this.markDirty, scope: this } },
                                        },
                                        { xtype: MODx.expandHelp ? "label" : "hidden", forId: "inopt_selectedFields", html: _('superboxselect.selectedFields_desc') , cls: "desc-under" },
                                    ],
                                }
                            ],
                        },
                    ],
                },
            ],
        }),
        SuperBoxSelect.panel.InputOptionsCustomTable.superclass.constructor.call(this, e);
}),
Ext.extend(SuperBoxSelect.panel.InputOptionsCustomTable, MODx.Panel, {
    markDirty: function () {
        Ext.getCmp("modx-panel-tv").markDirty();
    },
}),
Ext.reg("superboxselect-panel-inputoptions-customtable", SuperBoxSelect.panel.InputOptionsCustomTable);