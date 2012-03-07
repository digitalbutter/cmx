
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
        // m.push({
        //     text: _('cmx.item_update')
        //     ,handler: this.updateItem
        // });
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
    ,createItem: function(btn,e) {
        if (!this.windows.createItem) {
            this.windows.createItem = MODx.load({
                xtype: 'cmx-window-item-create'
                ,listeners: {
                    'success': {fn:function() { this.refresh(); },scope:this}
                }
            });
        }
        this.windows.createItem.fp.getForm().reset();
        this.windows.createItem.show(e.target);
    }
    ,updateItem: function(btn,e) {
        if (!this.menu.record || !this.menu.record.id) return false;
        var r = this.menu.record;

        if (!this.windows.updateItem) {
            this.windows.updateItem = MODx.load({
                xtype: 'cmx-window-item-update'
                ,record: r
                ,listeners: {
                    'success': {fn:function() { this.refresh(); },scope:this}
                }
            });
        }
        this.windows.updateItem.fp.getForm().reset();
        this.windows.updateItem.fp.getForm().setValues(r);
        this.windows.updateItem.show(e.target);
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




cmx.window.CreateItem = function(config) {
    config = config || {};
    this.ident = config.ident || 'mecitem'+Ext.id();
    Ext.applyIf(config,{
        title: _('cmx.item_create')
        ,id: this.ident
        ,height: 150
        ,width: 475
        ,url: cmx.config.connector_url
        ,action: 'mgr/sent/create'
        ,fields: [{
            xtype: 'textfield'
            ,fieldLabel: _('name')
            ,name: 'name'
            ,id: 'cmx-'+this.ident+'-name'
            ,width: 300
        },{
            xtype: 'textarea'
            ,fieldLabel: _('description')
            ,name: 'description'
            ,id: 'cmx-'+this.ident+'-description'
            ,width: 300
        }]
    });
    cmx.window.CreateItem.superclass.constructor.call(this,config);
};
Ext.extend(cmx.window.CreateItem,MODx.Window);
Ext.reg('cmx-window-item-create',cmx.window.CreateItem);


cmx.window.UpdateItem = function(config) {
    config = config || {};
    this.ident = config.ident || 'meuitem'+Ext.id();
    Ext.applyIf(config,{
        title: _('cmx.item_update')
        ,id: this.ident
        ,height: 150
        ,width: 475
        ,url: cmx.config.connector_url
        ,action: 'mgr/sent/update'
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
            ,id: 'cmx-'+this.ident+'-id'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('name')
            ,name: 'name'
            ,id: 'cmx-'+this.ident+'-name'
            ,width: 300
        },{
            xtype: 'textarea'
            ,fieldLabel: _('description')
            ,name: 'description'
            ,id: 'cmx-'+this.ident+'-description'
            ,width: 300
        }]
    });
    cmx.window.UpdateItem.superclass.constructor.call(this,config);
};
Ext.extend(cmx.window.UpdateItem,MODx.Window);
Ext.reg('cmx-window-item-update',cmx.window.UpdateItem);
