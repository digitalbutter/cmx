Ext.onReady(function() {
    MODx.load({ xtype: 'cmx-page-home'});
});

cmx.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'cmx-panel-home'
            ,renderTo: 'cmx-panel-home-div'
        }]
        ,buttons: [
        	{
        		text: "Create"
        		,handler: function(){
        			window.location.href = "index.php?&action=edit&mode=new&a=" + MODx.request.a;
        		}
        	}
        ]
    }); 
    cmx.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(cmx.page.Home,MODx.Component);
Ext.reg('cmx-page-home',cmx.page.Home);

function forceRefresh(cmp) {
    cmp.getStore().setBaseParam('refresh', true);
    cmp.refresh();
    cmp.getStore().setBaseParam('refresh', false);
}

function forceRefreshAll() {
    var tabs = Ext.getCmp('cmx-panel-home').items.items[1].items.items;
    for (var i=0;i<3;i++) {
        var grid = tabs[i].items.items[1];
        grid.getStore().setBaseParam('refresh', true);
        grid.refresh();
        grid.getStore().setBaseParam('refresh', false);
    }
}