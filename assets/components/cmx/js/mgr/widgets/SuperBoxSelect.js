/**
 * User SuperBoxSelect
 *
 * @class MODx.combo.Users
 * @extends Ext.ux.form.SuperBoxSelect
 * @xtype modx-superbox-user
 */
<link rel="stylesheet" href="{$assets_url}/components/superboxselect/css/superboxselect.css" />
 
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