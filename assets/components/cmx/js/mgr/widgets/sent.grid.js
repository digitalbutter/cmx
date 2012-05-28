
cmx.grid.Sent = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'cmx-grid-sent'
        ,url: cmx.config.connector_url
        ,baseParams: {
            action: 'mgr/sent/getlist'
            ,refresh: (MODx.request.refresh == '1') ? true : false
        }
        ,fields: ['CampaignID','Name','Subject','SentDate','TotalRecipients','WebVersionURL']
        ,autoHeight: true
        ,paging: true
        ,remoteSort: true
        ,listeners: {
            'afterrender': {fn:function(r) { 
                this.getStore().setBaseParam('refresh', false);
             },scope:this}
        }
        ,columns: [{
            header: _('cmx.campaign_id')
            ,dataIndex: 'CampaignID'
            ,width: 86
        },{
            header: _('cmx.campaign_name')
            ,dataIndex: 'Name'
            ,width: 86
        },{
            header: _('cmx.campaign_subject')
            ,dataIndex: 'Subject'
            ,width: 86
        },{
            header: _('cmx.sent_date')
            ,dataIndex: 'SentDate'
            ,width: 86
        },{
            header: _('cmx.total_recipients')
            ,dataIndex: 'TotalRecipients'
            ,width: 86
        },{
            header: _('cmx.web_url')
            ,hidden: true
            ,align: 'center'
            ,renderer: function(val){ return '<input type="button" target="_blank" value="View" onclick="window.open(\''+val+'\');" id="'+val+'"/>'; }
            ,dataIndex: 'WebVersionURL'
            ,width: 86
        }]
        ,tbar: [{
            text: _('cmx.refresh')
            ,handler: function() {
                forceRefreshAll();
            }
            ,scope: this
        }]
    });
    cmx.grid.Sent.superclass.constructor.call(this,config);
};
Ext.extend(cmx.grid.Sent,MODx.grid.Grid,{
    windows: {}

    ,getMenu: function() {
        var m = [];
        m.push({
           text: _('cmx.view_web')
           ,handler: this.viewWebVersion
        });
        m.push('-');
        m.push({
            text: _('cmx.get_info')
            ,handler: this.getSentInfo
        });
        m.push('-');
        m.push({
            text: _('cmx.remove_campaign')
            ,handler: this.removeCampaign
        });
        this.addContextMenuItem(m);
    }

    ,viewWebVersion: function(btn,e) {
        var r = this.menu.record;
        window.open(r["WebVersionURL"]);
        // console.log(r);
    }
    ,getSentInfo: function(btn,e) {
        this.showCampaignInfo = MODx.load({
            xtype: 'cmx-window-item-info'
            ,record: this.menu.record
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
        //this.showOrderWindow.setValues(this.menu.record);
        this.showCampaignInfo.show(e.target);

    }
    
    ,removeCampaign: function(btn,e) {
        if (!this.menu.record) return false;
        
        MODx.msg.confirm({
            title: _('cmx.remove_campaign')
            ,text: _('cmx.remove_campaign_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/scheduled/remove'
                ,id: this.menu.record['CampaignID']
            }
            ,listeners: {
                'success': {fn:function(r) { 
                    MODx.msg.status({
                        message: _('cmx.remove_campaign_success')
                    });
                    forceRefresh(this);
                 },scope:this}
            }
        });
    }
});
Ext.reg('cmx-grid-sent',cmx.grid.Sent);


cmx.window.SentCampaignInfo = function(config) {
    config = config || {};
    this.ident = config.record.CampaignID || 'campaign'+Ext.id();
    Ext.applyIf(config,{
        title: _('cmx.campaign_info')
        ,id: 'cmx-window-sentcampaigninfo'
        ,layout: 'form'        
        ,autoHeight: false
        ,autoScroll: true
        ,height: 600
        ,allowDrop: false
        ,shadow: false
        ,width: 525
        ,url: cmx.config.connector_url
        // ,items: {html: '<div style="min-height:300px;padding:5px 0;" id="sent_info_content-'+config.record.CampaignID+'"></div>'}
        ,fields: [{
            xtype: 'modx-tabs'
            // ,deferredRender: true
            // ,anchor: '100%'
            ,bodyStyle: 'padding: 10px 10px 10px 10px;'
            ,border: true
            ,layoutOnTabChange: true
            ,defaults: {
                border: false
                // ,autoHeight: true    
                ,bodyStyle: 'padding: 5px 8px 5px 5px;'
                ,layout: 'form'
                ,deferredRender: true
                ,autoWidth: true
                ,height: 400
                // ,forceLayout: true
            }
            ,items: [{
                title: _('cmx.campaign_info')
                ,id: 'cmx-campaign_info'
                // ,html: results.content
                // ,padding: 10
                ,layout: 'form'
                // ,labelAlign: 'right'
                ,labelWidth: 50
                ,items: [{
                    xtype: 'statictextfield',
                    name: 'Recipients',
                    id: 'Recipients',
                    fieldLabel: _('cmx.recipients'),
                    width: 200
                },{
                    xtype: 'statictextfield'
                    ,name: 'TotalOpened'
                    ,fieldLabel: _('cmx.total_opened')
                    // ,width:200
                },{
                    xtype: 'statictextfield'
                    ,name: 'Clicks'
                    ,fieldLabel: _('cmx.clicks')
                    // ,width:200
                },{
                    xtype: 'statictextfield'
                    ,name: 'Unsubscribed'
                    ,fieldLabel: _('cmx.unsubscribed')
                    // ,width:200
                },{
                    xtype: 'statictextfield'
                    ,name: 'Bounced'
                    ,fieldLabel: _('cmx.bounced')
                    // ,width:200
                },{
                    xtype: 'statictextfield'
                    ,name: 'UniqueOpened'
                    ,fieldLabel: _('cmx.unique_opened')
                    // ,width:200
                },{
                    xtype: 'statictextfield'
                    ,name: 'WebVersionURL'
                    ,fieldLabel: _('cmx.web_version_url')
                    ,width:300
                },{
                    xtype: 'statictextfield'
                    ,name: 'Forwards'
                    ,fieldLabel: _('cmx.forwards')
                    // ,width:200
                },{
                    xtype: 'statictextfield'
                    ,name: 'Likes'
                    ,fieldLabel: _('cmx.likes')
                    // ,width:200
                },{
                    xtype: 'statictextfield'
                    ,name: 'Mentions'
                    ,fieldLabel: _('cmx.mentions')
                    // ,width:200
                }]
            },{
                title: _('cmx.bounce_tab')
                ,items:[{
                    xtype: 'cmx-grid-bounces'
                    ,record: config.record
                }]
            }]
        }]
    });

    cmx.window.SentCampaignInfo.superclass.constructor.call(this,config);

    this.on('afterrender', function() {
        Ext.Ajax.request({
            url: cmx.config.connector_url
            ,params: {
                action: "mgr/sent/info"
                ,id: this.config.record.CampaignID
            }
            ,method: 'POST'
            ,success: function(response, options) {
                var results = Ext.util.JSON.decode(response.responseText).results;
                Ext.getCmp('cmx-window-sentcampaigninfo').fp.getForm().setValues(results);
            }
        });
    },this);
};
Ext.extend(cmx.window.SentCampaignInfo,MODx.Window);

Ext.reg('cmx-window-item-info',cmx.window.SentCampaignInfo);


