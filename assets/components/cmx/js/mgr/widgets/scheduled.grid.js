
cmx.grid.Scheduled = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'cmx-grid-scheduled'
        ,url: cmx.config.connector_url
        ,baseParams: {
            action: 'mgr/scheduled/getlist'
            ,refresh: (MODx.request.refresh == '1') ? true : false
        }
        ,fields: ['CampaignID','Name','Subject','DateCreated','PreviewURL','DateScheduled']
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
            header: _('cmx.date_created')
            ,dataIndex: 'DateCreated'
            ,width: 86
        },{
            header: _('cmx.date_scheduled')
            ,dataIndex: 'DateScheduled'
        }]
        ,tbar: [{
            text: _('cmx.refresh')
            ,handler: function() {
                forceRefreshAll();
            }
            ,scope: this
        }]
    });
    cmx.grid.Scheduled.superclass.constructor.call(this,config);
};
Ext.extend(cmx.grid.Scheduled,MODx.grid.Grid,{
    windows: {}

    ,getMenu: function() {
        var m = [];
        m.push({
           text: _('cmx.view_web_preview')
           ,handler: this.viewWebVersion
        });
        m.push({
            text: _('cmx.unschedule_campaign')
            ,handler: this.unschedule
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
        window.open(r["PreviewURL"]);
        console.log(r);
    }
    ,unschedule: function(btn,e) {
        // if (!this.menu.record || !this.menu.record.id) return false;
        var r = this.menu.record;

        MODx.msg.confirm({
            title: _('cmx.unschedule_campaign')
            ,text: _('cmx.unschedule_campaign_confirm')
            ,url: this.url
            ,params: {
                action: 'mgr/scheduled/unschedule_campaign'
                ,id: r["CampaignID"]
            }
            ,listeners: {
                'success': {fn:function() {
                    MODx.msg.status({
                        message: _('cmx.unschedule_campaign_success')
                        ,delay: 3
                    });
                    forceRefresh(this);
                }
                ,scope:this}
            }
        });        
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
Ext.reg('cmx-grid-scheduled',cmx.grid.Scheduled);
