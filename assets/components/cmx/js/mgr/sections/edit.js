Ext.onReady(function() {
    MODx.load({ xtype: 'cmx-page-edit'});
});

cmx.page.Edit = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'cmx-panel-edit'
            ,renderTo: 'cmx-panel-home-div'
        }]
        ,buttons: [{
            process: 'submit',
            text: _('save'),
            handler: function () {
                var panel = Ext.getCmp('cmx-panel-edit');
                
                Ext.getCmp('cmx-panel-edit').submit();
                
            }
        },{
            process: 'cancel'
            ,text: _('cmx.back')
            ,handler: function () {
                window.location.href = '?a='+MODx.action['cmx:index'];
            }
        }]
        

    }); 
    cmx.page.Edit.superclass.constructor.call(this,config);
};
Ext.extend(cmx.page.Edit,MODx.Component);
Ext.reg('cmx-page-edit',cmx.page.Edit);