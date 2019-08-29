/**
 * SuperBoxSelect Template Variable
 *
 * @package superboxselect
 * @subpackage superboxselecttv
 */

SuperBoxSelect.combo.SuperBoxSelectTV = function (config) {
    config = config || {};

    this.options = config.options;
    this.params = config.params;
    this.tvid = this.options.tvid;
    this.maxElements = this.options.maxElements;

    Ext.applyIf(config, {
        addNewDataOnBlur: false,
        allowBlank: this.options.allowBlank,
        anchor: '100%',
        classField: 'cls',
        ctCls: 'superboxselect-tv',
        displayField: 'title',
        displayFieldTpl: this.options.fieldTpl,
        fieldLabel: this.options.fieldLabel,
        listeners: {
            afterrender: {
                fn: this.afterrender,
                scope: this
            },
            beforeadditem: {
                fn: this.beforeadditem,
                scope: this
            },
            additem: {
                fn: this.additem,
                scope: this
            },
            removeitem: {
                fn: this.removeitem,
                scope: this
            }
        },
        minChars: 2,
        mode: 'remote',
        msgTarget: 'title',
        name: 'tv' + this.tvid + '[]',
        pageSize: this.options.pageSize,
        stackItems: this.options.stackItems,
        queryDelay: 0,
        store: this.options.store,
        styleField: 'style',
        tpl: '<tpl for="."><div class="x-combo-list-item">' + this.options.fieldTpl + '</div></tpl>',
        transform: 'superboxselect-tv-' + this.tvid,
        triggerAction: 'all',
        value: this.options.value,
        valueField: 'id',
        width: 400
    });
    SuperBoxSelect.combo.SuperBoxSelectTV.superclass.constructor.call(this, config);
};
SuperBoxSelect.combo.SuperBoxSelectTV = Ext.extend(SuperBoxSelect.combo.SuperBoxSelectTV, Ext.ux.form.SuperBoxSelect, {
    afterrender: function () {
        if (this.maxElements) {
            var caption = Ext.get('tv' + this.tvid + '-caption');
            var newlabel = _('superboxselect.maxElements_label').replace('{maxElements}', this.maxElements);
            caption.dom.innerHTML = caption.dom.innerHTML +
                ' <span class="modx-tv-label-description">(' + newlabel +
                ')</span>';
        }
        var _this = this;
        var item = document.querySelectorAll('#' + this.outerWrapEl.id + ' ul')[0];
        if (item) {
            item.setAttribute('data-xcomponentid', this.id);
            new Sortable(item, {
                onEnd: function (evt) {
                    if (evt.currentTarget) {
                        var cmpId = evt.currentTarget.getAttribute('data-xcomponentid');
                        var cmp = Ext.getCmp(cmpId);
                        if (cmp) {
                            _this.refreshSorting(cmp);
                            MODx.fireResourceFormChange();
                        } else {
                            console.log('Unable to reference xComponentContext.');
                        }
                    }
                }
            });
        } else {
            console.log('Unable to find select element');
        }
    },
    beforeadditem: function (bs) {
        if (this.maxElements) {
            if (bs.getCount() > this.maxElements - 1
            ) {
                MODx.msg.alert(_('error'), _('superboxselect.maxElements_msg'));
                return false;
            }
            return true;
        }
    },
    additem: function () {
        MODx.fireResourceFormChange();
    },
    removeitem: function () {
        MODx.fireResourceFormChange();
    },
    refreshSorting: function (cmp) {
        var viewList = cmp.items.items;
        var dataInputList = document.querySelectorAll('#' + cmp.outerWrapEl.dom.id + ' .x-superboxselect-input');
        var getElementIndex = function (item) {
            var nodeList = Array.prototype.slice.call(item.parentElement.children);
            return nodeList.indexOf(item);
        };
        var getElementByValue = function (val, list) {
            for (var i = 0; i < list.length; i += 1) {
                if (list[i].value === val) {
                    return list[i];
                }
            }
        };
        var sortElementsByListIndex = function (list, callback) {
            list.sort(compare);
            if (callback instanceof Function) {
                callback();
            }
        };
        var syncElementsByValue = function (list1, list2, callback) {
            var targetListRootElement = list2[0].parentElement;
            if (targetListRootElement) {
                for (var i = 0; i < list1.length; i += 1) {
                    var item = list1[i];
                    var targetItem = getElementByValue(String(item.value), list2);
                    var initialTargetElement = list2[i];
                    if (typeof targetItem !== 'undefined' && typeof initialTargetElement !== 'undefined') {
                        targetListRootElement.insertBefore(targetItem, initialTargetElement);
                    }
                }
            } else {
                console.debug('syncElementsByValue(), Unable to reference list root element.');
                return false;
            }
            if (callback instanceof Function) {
                callback();
            }
        };
        var compare = function (a, b) {
            if (typeof a.el.dom !== 'undefined' && typeof b.el.dom !== 'undefined') {
                var aIndex = getElementIndex(a.el.dom);
                var bIndex = getElementIndex(b.el.dom);
                if (aIndex < bIndex) {
                    return -1;
                }
                if (aIndex > bIndex) {
                    return 1;
                }
            }
            return 0;
        };
        sortElementsByListIndex(viewList);
        syncElementsByValue(viewList, dataInputList[0].children);
        cmp.value = cmp.getValue();
    },
    getElementComponentContext: function (el) {
        var parentClassList = Array.prototype.slice.call(el.classList);
        if (el.tagName !== 'body') {
            return null;
        }
        if (parentClassList.indexOf('x-superboxselect')) {
            return el;
        } else {
            getElementComponentContext(el.parentElement);
        }
    }
});
Ext.reg('superboxselect-combo-superboxselectv', SuperBoxSelect.combo.SuperBoxSelectTV);

SuperBoxSelect.combo.SuperBoxSelectTVSingle = function (config) {
    config = config || {};

    this.options = config.options;
    this.params = config.params;
    this.tvid = this.options.tvid;

    Ext.applyIf(config, {
        allowBlank: this.options.allowBlank,
        anchor: '100%',
        ctCls: 'superboxselect-tv',
        displayField: 'title',
        fieldLabel: this.options.fieldLabel,
        hiddenName: 'tv' + this.tvid,
        minChars: 2,
        mode: 'remote',
        msgTarget: 'title',
        name: 'tv' + this.tvid,
        pageSize: this.options.pageSize,
        queryDelay: 0,
        store: this.options.store,
        tpl: '<tpl for="."><div class="x-combo-list-item">' + this.options.fieldTpl + '</div></tpl>',
        transform: 'superboxselect-tv-' + this.tvid,
        triggerAction: 'all',
        value: this.options.value,
        valueField: 'id',
        width: 400
    });
    SuperBoxSelect.combo.SuperBoxSelectTVSingle.superclass.constructor.call(this, config);
};
SuperBoxSelect.combo.SuperBoxSelectTVSingle = Ext.extend(SuperBoxSelect.combo.SuperBoxSelectTVSingle, Ext.form.ComboBox);
Ext.reg('superboxselect-combo-superboxselectv-single', SuperBoxSelect.combo.SuperBoxSelectTVSingle);
