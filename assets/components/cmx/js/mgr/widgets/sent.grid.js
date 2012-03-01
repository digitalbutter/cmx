
cmx.grid.Sent = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'cmx-grid-sent'
        ,url: cmx.config.connector_url
        ,baseParams: {
            action: 'mgr/sent/getlist'
        }
        ,fields: ['CampaignID','Name','Subject','SentDate','TotalRecipients','WebVersionURL']
        ,autoHeight: true
        ,paging: true
        ,remoteSort: true
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
            text: _('cmx.force_refresh')
            ,handler: function() {
                this.getStore().setBaseParam('refresh', true);
                this.refresh();
                this.getStore().setBaseParam('refresh', false);
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
            text: _('cmx.delete_campaign')
            ,handler: this.deleteCampaign
        });
        this.addContextMenuItem(m);
    }

    ,viewWebVersion: function(btn,e) {
        var r = this.menu.record;
        window.open(r["WebVersionURL"]);
        console.log(r);
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
    
    ,deleteCampaign: function(btn,e) {
        if (!this.menu.record) return false;
        
        MODx.msg.confirm({
            title: _('cmx.item_remove')
            ,text: _('cmx.item_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/sent/remove'
                ,id: this.menu.record.CampaignID
            }
            ,listeners: {
                'success': {fn:function(r) { this.refresh(); },scope:this}
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
        ,id: this.ident
        ,height: 300
        ,minHeight: 300
        ,width: 650
        ,url: cmx.config.connector_url
        ,closeAction: 'destroy'
        ,items: {html: '<div style="min-height:300px;padding:5px 0;" id="sent_info_content-'+config.record.CampaignID+'"></div>'}
    });

    cmx.window.SentCampaignInfo.superclass.constructor.call(this,config);

    this.on('afterrender', function() {
        console.log('show hit');
        this.getSentCampaignInfo(this.config.record);
    },this);
};
Ext.extend(cmx.window.SentCampaignInfo,MODx.Window);

Ext.extend(cmx.window.SentCampaignInfo,MODx.Window,{
    getSentCampaignInfo: function(record) {
        Ext.Ajax.request({
            url: cmx.config.connector_url
            ,params: {
                action: "mgr/sent/info"
                ,id: record.CampaignID
            }
            ,method: 'POST'
            ,success: function(response, options) {

                var results = Ext.util.JSON.decode(response.responseText).results;
                // console.log(results);
                // console.log(options);


                var tabs = new Ext.TabPanel({
                    renderTo: 'sent_info_content-'+record.CampaignID
                    ,activeTab: 0
                    ,autoShow: true
                    ,height: 300
                    ,plain: true
                    ,margins: '5 5 5 5'
                    ,autoScroll: true
                    ,resizeable: true
                    ,items: [{
                            title: _('cmx.campaign_info')
                            ,html: results.content
                            ,padding: 10
                        }
                    ]
                });
            }
        });
    }
});
Ext.reg('cmx-window-item-info',cmx.window.SentCampaignInfo);