Ext.onReady(function() {
    MODx.load({ xtype: 'cmx-page-edit'});
});

cmx.page.Edit = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'cmx-panel-edit'
            ,renderTo: 'cmx-panel-edit-div'
        }]
        ,buttons: [{
            // process: 'submit',
            text: _('cmx.save_draft')
            ,id: 'cmx-button-save_draft'
            ,hidden: (mode == 'schedule') ? true : false
            ,handler: function () {
                Ext.MessageBox.confirm(
                    _('cmx.save_draft')
                    ,_('cmx.confirm_save_draft')
                    ,function(button) {
                        if (button == 'yes') {
                            Ext.getCmp('cmx-panel-edit').submit();
                        }
                    }
                );             
            }
        },{
            text: _('cmx.send_campaign')
            ,id: 'cmx-button-send_campaign'
            ,hidden: (mode == 'new') ? true : false
            ,handler: function() {
                // @TODO stub
            }
        },{
            text: _('cmx.edit_draft')
            ,hidden: (mode == 'new') ? true : false
            ,id: 'cmx-button-edit_draft'
            ,handler: function () {
                // @TODO stub
            }
        },{
            process: 'cancel'
            ,id: 'cmx-button-cancel'
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