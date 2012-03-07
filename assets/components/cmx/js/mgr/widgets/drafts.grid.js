
cmx.grid.Drafts = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'cmx-grid-drafts'
        ,url: cmx.config.connector_url
        ,baseParams: {
            action: 'mgr/drafts/getlist'
        }
        ,fields: ['CampaignID','Name','Subject','DateCreated','PreviewURL']
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
            header: _('cmx.date_created')
            ,dataIndex: 'DateCreated'
            ,width: 86
        },{
            header: _('cmx.preview_url')
            ,hidden: true
            //,renderer: function(val){ return '<input type="button" target="_blank" value="View" onclick="window.open(\''+val+'\');" id="'+val+'"/>'; }
            ,dataIndex: 'PreviewURL'
            ,width: 86
        }]
        ,tbar: [{
            text: _('cmx.force_refresh')
            ,handler: function() {
                forceRefreshAll();
            }
            ,scope: this
        }]
    });
    cmx.grid.Drafts.superclass.constructor.call(this,config);
};
Ext.extend(cmx.grid.Drafts,MODx.grid.Grid,{
    windows: {}

    ,getMenu: function() {
        var m = [];
        m.push({
           text: _('cmx.view_web_preview')
           ,handler: this.viewWebVersion
        });
        // no way to update drafts or scheduled items through API
        m.push({
            text: _('cmx.schedule_campaign_menuitem')
            ,handler: this.scheduleCampaign
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
    }
    ,scheduleCampaign: function(btn,e) {
        if (!this.menu.record || !this.menu.record['CampaignID']) return false;
        var r = this.menu.record;
        window.location.href = "index.php?&action=edit&mode=schedule&a=" + MODx.request.a + "&id="+this.menu.record['CampaignID'];


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
Ext.reg('cmx-grid-drafts',cmx.grid.Drafts);
