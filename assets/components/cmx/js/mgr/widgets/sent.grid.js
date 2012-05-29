
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


