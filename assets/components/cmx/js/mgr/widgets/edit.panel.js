/**
 * Loads the Template panel
 * 
 * @class MODx.panel.CampaignForm
 * @extends MODx.FormPanel
 * @param {Object} config An object of configuration properties
 * @xtype modx-panel-template
 */

cmx.panel.CampaignForm = function(config) {
    config = config || {record:{}};
    config.record = config.record || {};
    Ext.applyIf(config,{
        url: cmx.config.connector_url
        ,baseParams: {
            action: 'mgr/campaign_form/save'
            ,id: (MODx.request.id !== undefined) ? MODx.request.id : 0
        }
        ,id: 'cmx-panel-edit'
        ,cls: 'container form-with-labels'
        ,bodyStyle: ''
        ,listeners: {
            'setup': {fn:this.setup,scope:this}
            ,'success': {fn:this.success,scope:this}
        }
        ,items: [{
            html: '<h2>'+_('cmx.new_campaign')+'</h2>'
            ,id: 'modx-template-header'
            ,cls: 'modx-page-header'
            ,border: false
        },MODx.getPageStructure([{
            title: _('cmx.campaign')
            ,itemId: 'form-campaign'
            ,defaults: { border: false ,msgTarget: 'side' }
            ,layout: 'form'
            ,id: 'cmx-form-campaign'
            ,labelWidth: 150
            ,items: [{
                html: '<p>'+_('cmx.campaign_intro')+'</p>'
                ,id: 'modx-template-msg'
                ,bodyCssClass: 'panel-desc'
            },{
                layout: 'column'
                ,border: false
                ,defaults: {
                    layout: 'form'
                    ,labelAlign: 'top'
                    ,anchor: '100%'
                    ,border: false
                    ,cls:'main-wrapper'
                    ,labelSeparator: ''
                }
                ,items: [{
                    columnWidth: 1
                    ,items: [{
                        xtype: 'textfield',
                        cls: 'new-item',
                        name: 'name',
                        fieldLabel: _('cmx.campaign_name_label'),
                        width: 500,
                        allowBlank: false,
                        value: config.record.Name || ''

                    }
                    ,{
                        xtype: 'textfield',
                        cls: 'new-item',
                        name: 'subject',
                        fieldLabel: _('cmx.campaign_subject_label'),
                        width: 500,
                        allowBlank: false,
                        value: config.record.Subject || ''
                    }
                    ,{
                        xtype: 'textfield',
                        cls: 'new-item',
                        name: 'from_name',
                        fieldLabel: _('cmx.campaign_from_name_label'),
                        width: 500,
                        allowBlank: false,
                        value: config.record.FromName || ''
                    }
                    ,{
                        xtype: 'textfield',
                        cls: 'new-item',
                        name: 'from_email',
                        fieldLabel: _('cmx.campaign_from_email_label'),
                        width: 500,
                        allowBlank: false,
                        value: config.record.FromEmail || ''
                    }
                    ,{
                        xtype: 'textfield',
                        cls: 'new-item',
                        name: 'replyto',
                        fieldLabel: _('cmx.campaign_replyto_label'),
                        width: 500,
                        allowBlank: false,
                        value: config.record.ReplyTo || ''
                    }
                    ,{
                        fieldLabel: _('cmx.lists_label')
                        ,cls: 'new-item'
                        ,id: 'cmx-superbox-lists'
                        ,name: 'lists[]'
                        ,xtype: 'modx-superbox-lists'
                        ,resizable: true
                        ,width: 500
                        ,allowBlank: true
                        ,value: config.record.ListIDs || ''
                    }
                    ,{
                        fieldLabel: _('cmx.segments_label')
                        ,cls: 'new-item'
                        ,id: 'cmx-superbox-segments'
                        ,name: 'segments[]'
                        ,xtype: 'modx-superbox-segments'
                        ,resizable: true
                        ,width: 500
                        ,allowBlank: true
                        ,value: config.record.SegmentIDs || ''
                    }]
                }]
            }]
        },{
            title: _('cmx.campaign_content')
            ,itemId: 'form-content'
            ,id: 'cmx-form-content'
            ,defaults: { autoHeight: true }
            ,layout: 'form'
            ,items: [{
                html: '<p>'+_('cmx.campaign_content_intro')+'</p>'
                ,bodyCssClass: 'panel-desc'
                ,border: false
            },{
                xtype: 'panel'
                ,border: false
                ,layout: 'form'
                ,cls:'main-wrapper'
                ,labelAlign: 'top'
                ,items: [{
                    xtype: 'textarea'
                    ,cls: 'new-item'
                    ,fieldLabel: _('template_code')                     
                    ,name: 'content'
                    ,fieldLabel: _('cmx.campaign_content_label')
                    ,id: 'modx-template-content'
                    ,anchor: '100%'
                    ,height: 400
                    ,value: config.record.Content || ''
                    ,listeners: {
                        'afterrender': {fn:function() {
                            MODx.loadRTE('modx-template-content');
                        },scope:this}
                    }
                }]
            }]
        },{
            title: _('cmx.schedule_preview')
            ,itemId: 'form-schedule'
            ,id: 'cmx-form-schedule'
            ,disabled: (MODx.request.mode == 'new') ? true : false
            ,layout: 'form'
            ,defaults: { autoHeight: true }
            ,items: [{
                html: '<p>'+_('cmx.form_schedule_label')+'</p>'
                ,bodyCssClass: 'panel-desc'
                ,border: false
            },{
                xtype: 'panel'
                ,border: false
                ,layout: 'form'
                ,cls:'main-wrapper'
                ,labelAlign: 'top'
                ,items: [{
                    xtype: 'textfield'
                    ,fieldLabel: _('cmx.confirmation_email_label')
                    ,name: 'confirmation_email'
                    ,id: 'cmx-campaign-confirmation_email'
                    ,allowBlank: true
                    ,width: 500
                    // ,value: config.record.content || ''
                },{
                    xtype: 'xdatetime'
                    ,fieldLabel: _('cmx.schedule_campaign')
                    // ,description: '<b>[[*publishedon]]</b><br />'+_('resource_publishedon_help')
                    ,name: 'campaign_send_at'
                    ,id: 'cmx-campaign-schedule'
                    ,allowBlank: true
                    ,dateFormat: 'Y-m-d'
                    ,timeFormat: 'g:i a'
                    ,dateWidth: 120
                    ,timeWidth: 120
                    // ,value: config.record.publishedon
                }]
            }
            ,{
                html: '<p>'+_('cmx.form_preview_recipients_label')+'</p>'
                ,bodyCssClass: 'panel-desc'
                ,border: false 
            },{
                xtype: 'panel'
                ,border: false
                ,layout: 'form'
                ,cls:'main-wrapper'
                ,labelAlign: 'top'
                ,items: [{
                    fieldLabel: _('cmx.preview_recipients_label')
                    // ,cls: 'new-item'
                    ,id: 'cmx-preview_recipients'
                    ,name: 'recipients'
                    ,xtype: 'textfield'
                    // ,resizable: true
                    ,width: 500
                }] 
            }]
        }],{
            id: 'modx-tabs'
        })]

        ,useLoadingMask: true
    });
    cmx.panel.CampaignForm.superclass.constructor.call(this,config);

    var isStatic = Ext.getCmp('modx-template-static');
    if (isStatic) { isStatic.on('check',this.toggleStaticFile); }
};
Ext.extend(cmx.panel.CampaignForm,MODx.FormPanel,{
    initialized: false
    ,setup: function() {
        if (this.initialized) { this.clearDirty(); return true; }
        console.log(this.config.record);
        this.getForm().setValues(this.config.record);

        if (Ext.getCmp('cmx-panel-edit').baseParams['id'] != 0) {
            this.config.record.id = Ext.getCmp('cmx-panel-edit').baseParams['id'];
            var form_elements = [];
            form_elements = lookForElements(this,form_elements);

            for(var j = 0, lenj = form_elements.length; j < lenj; j ++){
                form_elements[j].setDisabled(true);
            }
            Ext.getCmp('modx-tabs').setActiveTab('form-schedule');
        }
        // if (!Ext.isEmpty(this.config.record.templatename)) {
        //     Ext.getCmp('modx-template-header').getEl().update('<h2>'+_('template')+': '+this.config.record.templatename+'</h2>');
        // }
        // if (!Ext.isEmpty(this.config.record.properties)) {
        //     var d = this.config.record.properties;
        //     var g = Ext.getCmp('modx-grid-element-properties');
        //     if (g) {
        //         g.defaultProperties = d;
        //         g.getStore().loadData(d);
        //     }
        // }
        this.fireEvent('ready',this.config.record);
        this.initialized = true;
        MODx.fireEvent('ready');
        return true;
    }
    ,success: function(r) {
        console.log('edit panel success');
        Ext.getCmp('cmx-form-schedule').setDisabled(false);
        Ext.getCmp('modx-tabs').setActiveTab('form-schedule');
        Ext.getCmp('cmx-button-save_draft').hide();
        Ext.getCmp('cmx-button-send_campaign').show();
        Ext.getCmp('cmx-button-test_campaign').show();
        Ext.getCmp('cmx-button-edit_draft').show();

        var form_elements = [];
        form_elements = lookForElements(this,form_elements);

        for(var j = 0, lenj = form_elements.length; j < lenj; j ++){
            form_elements[j].setDisabled(true);
        }

        this.config.record.id = r.result.object.response;

    }
    // ,afterrender: function() {
    //     console.log('ready');
    //     MODx.loadRTE('modx-template-content');
    // }
});
Ext.reg('cmx-panel-edit',cmx.panel.CampaignForm);

function lookForElements(cmp, result){
    for(var i = 0, leni = cmp.items.items.length; i < leni; i++){
        var item = cmp.items.items[i];
        
        if(item.initialConfig.cls && item.initialConfig.cls == 'new-item'){
            result.push(item);
        }

        if(item.items && item.items.items && item.items.items.length > 0){
            result = lookForElements(item, result);
        }
    }
    return result;
}

