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
        			window.location.href = "index.php?&action=edit&a=" + MODx.request.a;
        		}
        	}
        ]
    }); 
    cmx.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(cmx.page.Home,MODx.Component);
Ext.reg('cmx-page-home',cmx.page.Home);