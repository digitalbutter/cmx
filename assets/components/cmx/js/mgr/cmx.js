var cmx = function(config) {
    config = config || {};
    cmx.superclass.constructor.call(this,config);
};
Ext.extend(cmx,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},view: {}
});
Ext.reg('cmx',cmx);

cmx = new cmx();