Ext.onReady(function() {
    MODx.load({ xtype: 'cmx-page-edit'});
});

cmx.page.Edit = function(config) {
    console.log(campaign);
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'cmx-panel-edit'
            ,record: campaign
            ,renderTo: 'cmx-panel-edit-div'
        }]
        ,buttons: [{
            text: _('cmx.save_draft')
            ,id: 'cmx-button-save_draft'
            ,hidden: (MODx.request.mode == 'schedule') ? true : false
            ,handler: function () {
                Ext.MessageBox.confirm(
                    _('cmx.save_draft')
                    ,_('cmx.confirm_save_draft')
                    ,function(button) {
                        if (button == 'yes') {
                            tinyMCE.triggerSave(true,true);
                            Ext.getCmp('cmx-panel-edit').submit();
                        }
                    }
                );             
            }
        },{
            text: _('cmx.send_campaign')
            ,id: 'cmx-button-send_campaign'
            ,hidden: (MODx.request.mode == 'new') ? true : false
            ,handler: function() {
                var id = Ext.getCmp('cmx-panel-edit').config.record.id;
                var confirmationEmail = Ext.getCmp('cmx-campaign-confirmation_email').getValue();
                var schedule = Ext.getCmp('cmx-campaign-schedule').getValue();

                MODx.msg.confirm({
                    title: _('cmx.send_campaign')
                    ,text: _('cmx.send_confirm_confirm')
                    ,url: Ext.getCmp('cmx-panel-edit').config.url
                    ,params: {
                        action: 'mgr/campaign_form/send_campaign'
                        ,id: id
                        ,confirmation_email: confirmationEmail
                        ,publish_at: schedule
                    }
                    ,listeners: {
                        'success': {fn:function(r) {
                            window.location.href = '?a='+MODx.action['cmx:index']+'&refresh=1';
                        }
                        ,scope:this}
                    }
                });
            }
        },{
            text: _('cmx.test_campaign')
            ,id: 'cmx-button-test_campaign'
            ,hidden: (MODx.request.mode == 'new') ? true : false
            ,handler: function() {
                var id = Ext.getCmp('cmx-panel-edit').config.record.id;
                var recipients = Ext.getCmp('cmx-preview_recipients').getValue();

                MODx.msg.confirm({
                    title: _('cmx.test_campaign')
                    ,text: _('cmx.test_campaign_confirm')
                    ,url: Ext.getCmp('cmx-panel-edit').config.url
                    ,params: {
                        action: 'mgr/campaign_form/send_test'
                        ,id: id
                        ,recipients: recipients
                    }
                    ,listeners: {
                        'success': {fn:function() { 
                            MODx.msg.status({
                                message: _('cmx.test_campaign_success')
                            });
                        },scope:this}
                    }
                });
            }
        },{
            text: _('cmx.edit_draft')
            ,hidden: (MODx.request.mode == 'new') ? true : false
            ,id: 'cmx-button-edit_draft'
            ,handler: function () {
                // @TODO stub
            }
        },{
            process: 'cancel'
            ,id: 'cmx-button-cancel'
            ,text: _('cmx.back')
            ,handler: function () {
                window.location.href = '?a='+MODx.action['cmx:index']+'&refresh=1';
            }
        }]
        

    }); 
    cmx.page.Edit.superclass.constructor.call(this,config);
};
Ext.extend(cmx.page.Edit,MODx.Component);
Ext.reg('cmx-page-edit',cmx.page.Edit);