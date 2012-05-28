/**
 * User SuperBoxSelect
 *
 * @class MODx.combo.Users
 * @extends Ext.ux.form.SuperBoxSelect
 * @xtype modx-superbox-user
 */
// <link rel="stylesheet" href="{$assets_url}/components/superboxselect/css/superboxselect.css" />
 
cmx.combo.Lists = function (config) {
    config = config || {};
    Ext.applyIf(config, {
    	xtype:'superboxselect'
        ,triggerAction: 'all'
	,mode: 'remote'
        ,valueField: "ListID"
        ,displayField: "Name"
	,store: new Ext.data.JsonStore({
		id:'ListID'
		,autoLoad: true
		,root:'results'
		,fields: ['ListID', 'Name']
		,url: cmx.config.connector_url
        ,baseParams: {
            action: 'mgr/campaign_form/getsubscriberlists'
        }
	})
    });
    cmx.combo.Lists.superclass.constructor.call(this, config);
};
Ext.extend(cmx.combo.Lists, Ext.ux.form.SuperBoxSelect);
Ext.reg('modx-superbox-lists', cmx.combo.Lists );

cmx.combo.Segments = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        xtype:'superboxselect'
        ,triggerAction: 'all'
    ,mode: 'remote'
        ,valueField: "SegmentID"
        ,displayField: "Title"
    ,store: new Ext.data.JsonStore({
        id:'SegmentID'
        ,autoLoad: true
        ,root:'results'
        ,fields: ['ListID', 'SegmentID', 'Title']
        ,url: cmx.config.connector_url
        ,baseParams: {
            action: 'mgr/campaign_form/getsubscribersegments'
        }
    })
    });
    cmx.combo.Segments.superclass.constructor.call(this, config);
};
Ext.extend(cmx.combo.Segments, Ext.ux.form.SuperBoxSelect);
Ext.reg('modx-superbox-segments', cmx.combo.Segments );

cmx.combo.PreviewRecipients = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        xtype:'superboxselect'
        ,triggerAction: 'all'
        ,mode: 'local'
        ,valueField: "EmailAddress"
        ,displayField: "EmailAddress"
        ,listeners: {
            newitem: function(bs,v, f){
                // v = v.slice(0,1).toUpperCase() + v.slice(1).toLowerCase();
                // var newObj = {
                // id: v,
                // name: v
                // };
                // bs.addItem(newObj); 
            }
        }
        ,allowAddNewData: true
        ,addNewDataOnBlur : true
        ,store: recipientsStore
        ,emptyText: 'Enter Preview Recipients'
        ,extraItemCls: 'x-tag'
    // ,store: new Ext.data.JsonStore({
    //     id:'SegmentID'
    //     ,autoLoad: true
    //     ,root:'results'
    //     ,fields: ['ListID', 'SegmentID', 'Title']
    //     ,url: cmx.config.connector_url
    //     ,baseParams: {
    //         action: 'mgr/campaign_form/getsubscribersegments'
    //     }
    // })
        
    });
    cmx.combo.PreviewRecipients.superclass.constructor.call(this, config);
};
Ext.extend(cmx.combo.PreviewRecipients, Ext.ux.form.SuperBoxSelect);
Ext.reg('modx-superbox-recipients', cmx.combo.PreviewRecipients);

var recipientsStore = new Ext.data.SimpleStore({
    fields: ['EmailAddress']
    ,data: [['justinkv@gmail.com'],['j@j.com'],['t@t.com']]
}); 