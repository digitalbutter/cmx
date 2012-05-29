cmx.window.SentCampaignInfo = function(config) {
    config = config || {};
    this.ident = config.record.CampaignID || 'campaign'+Ext.id();
    Ext.applyIf(config,{
        title: _('cmx.campaign_info')
        ,id: 'cmx-window-item-info-'+Ext.id()
        // ,layout: 'form'        
        ,autoHeight: false
        ,autoScroll: true
        ,height: 600
        ,allowDrop: false
        ,shadow: false
        ,width: 700
        ,url: cmx.config.connector_url
        // ,closeAction: 'hide'
        ,fields: [{
            xtype: 'modx-tabs'
            ,bodyStyle: 'padding: 10px 10px 10px 10px;'
            ,border: true
            ,layoutOnTabChange: true
            ,defaults: {
                border: false
                // ,autoHeight: true    
                ,bodyStyle: 'padding: 5px 8px 5px 5px;'
                ,layout: 'form'
                // ,deferredRender: true
                ,autoWidth: true
                ,height: 400
                // ,forceLayout: true
            }
            ,items: [{
                title: _('cmx.campaign_info')
                // ,html: results.content
                // ,padding: 10
                ,layout: 'form'
                // ,labelAlign: 'right'
                ,labelWidth: 50
                ,items: [{
                    xtype: 'statictextfield',
                    name: 'Recipients',
                    fieldLabel: _('cmx.recipients'),
                    width: 200
                },{
                    xtype: 'statictextfield'
                    ,name: 'TotalOpened'
                    ,fieldLabel: _('cmx.total_opened')
                },{
                    xtype: 'statictextfield'
                    ,name: 'Clicks'
                    ,fieldLabel: _('cmx.clicks')
                },{
                    xtype: 'statictextfield'
                    ,name: 'Unsubscribed'
                    ,fieldLabel: _('cmx.unsubscribed')
                },{
                    xtype: 'statictextfield'
                    ,name: 'Bounced'
                    ,fieldLabel: _('cmx.bounced')
                },{
                    xtype: 'statictextfield'
                    ,name: 'UniqueOpened'
                    ,fieldLabel: _('cmx.unique_opened')
                },{
                    xtype: 'statictextfield'
                    ,name: 'WebVersionURL'
                    ,fieldLabel: _('cmx.web_version_url')
                    ,width:300
                },{
                    xtype: 'statictextfield'
                    ,name: 'Forwards'
                    ,fieldLabel: _('cmx.forwards')
                },{
                    xtype: 'statictextfield'
                    ,name: 'Likes'
                    ,fieldLabel: _('cmx.likes')
                },{
                    xtype: 'statictextfield'
                    ,name: 'Mentions'
                    ,fieldLabel: _('cmx.mentions')
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

    this.on('render', function() {
        Ext.Ajax.request({
            url: cmx.config.connector_url
            ,params: {
                action: "mgr/sent/info"
                ,id: this.config.record.CampaignID
                ,win_id: this.id
            }
            ,method: 'POST'
            ,success: function(response, options) {
                console.log(response,options,this);
                var results = Ext.util.JSON.decode(response.responseText).results;
                Ext.getCmp(options.params.win_id).fp.getForm().setValues(results);
            }
        });
    },this);
};
Ext.extend(cmx.window.SentCampaignInfo,MODx.Window);

Ext.reg('cmx-window-item-info',cmx.window.SentCampaignInfo);