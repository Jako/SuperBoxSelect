var SuperBoxSelectTV = function (config) {
    config = config || {};
    SuperBoxSelectTV.superclass.constructor.call(this, config);
};

Ext.extend(SuperBoxSelectTV, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, jquery: {}, form: {}
});
Ext.reg('superboxselecttv', SuperBoxSelectTV);

var SuperBoxSelect = new SuperBoxSelectTV();
