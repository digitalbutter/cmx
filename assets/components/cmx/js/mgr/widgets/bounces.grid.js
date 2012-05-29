cmx.grid.Bounces = function(config) {
    console.log(config);
    config = config || {};
    Ext.applyIf(config,{
        url: cmx.config.connector_url
        ,baseParams: {
            action: 'mgr/sent/bounces'
            ,campaign_id: config.record.CampaignID
            ,sent_date: config.record.SentDate
            ,count: config.record.Bounces
        }
        ,fields: ['EmailAddress','ListID','BounceType','Date','Reason']
        ,autoHeight: true
        ,paging: true
        ,remoteSort: true
        ,columns: [{
            header: 'EmailAddress'
            ,dataIndex: 'EmailAddress'
            ,width: 86
        },{
            header: 'ListID'
            ,dataIndex: 'ListID'
            ,width: 86
        },{
            header: 'BounceType'
            ,dataIndex: 'BounceType'
            ,width: 86
        },{
            header: 'Date'
            ,dataIndex: 'Date'
            ,width: 86
        },{
            header: 'Reason'
            ,dataIndex: 'Reason'
            ,width: 86
        }]
    });
    cmx.grid.Bounces.superclass.constructor.call(this,config);
};

Ext.extend(cmx.grid.Bounces,MODx.grid.Grid);
Ext.reg('cmx-grid-bounces',cmx.grid.Bounces);
