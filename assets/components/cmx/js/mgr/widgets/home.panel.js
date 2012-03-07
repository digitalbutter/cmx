cmx.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,id: 'cmx-panel-home'
        ,items: [{
            html: '<h2>'+_('cmx')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,bodyStyle: 'padding: 10px'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,activeItem: 0
            ,hideMode: 'offsets'
            ,items: [{
                title: _('cmx.sent_campaigns')
                ,items: [{
                    html: '<p>'+_('cmx.sent_campaigns_intro')+'</p><br />'
                    ,border: false
                },{
                    xtype: 'cmx-grid-sent'
                    ,preventRender: true
                }]
            }
            ,{
                title: _('cmx.draft_campaigns')
                ,items: [{
                    html: '<p>'+_('cmx.draft_campaigns_intro')+'</p><br />'
                    ,border: false
                },{
                    xtype: 'cmx-grid-drafts'
                    ,preventRender: true
                }]
            }
            ,{
                title: _('cmx.scheduled_campaigns')
                ,items: [{
                    html: '<p>'+_('cmx.scheduled_campaigns_intro')+'</p><br />'
                    ,border: false
                },{
                    xtype: 'cmx-grid-scheduled'
                    ,preventRender: true
                }]
            }]
        }]
    });
    cmx.panel.Home.superclass.constructor.call(this,config);
};

Ext.extend(cmx.panel.Home,MODx.Panel);
Ext.reg('cmx-panel-home',cmx.panel.Home);
