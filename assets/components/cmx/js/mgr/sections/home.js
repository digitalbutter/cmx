Ext.onReady(function() {
    Ext.getCmp('modx-layout').hideLeftbar(); 
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
    cmp.getStore().lastOptions.params.refresh = true;
    cmp.store.reload({
        callback:function(){cmp.getStore().lastOptions.params.refresh = false;}
    });
    
}

function forceRefreshAll() {
    var tabs = Ext.getCmp('cmx-panel-home').items.items[1].items.items;
    for (var i=0;i<tabs.length;i++) {
        var grid = tabs[i].items.items[1];
        grid.getStore().lastOptions.params.refresh = true;
        grid.store.reload({
            callback:function(){grid.getStore().lastOptions.params.refresh = false;}
        });
    }
}