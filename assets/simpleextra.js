var SimpleExtra = {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}
}

// Page
SimpleExtra.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [
            {
                xtype: 'simpleextra-panel-home',
                renderTo: 'simpleextra-panel-home-div'
            }
        ]
    });
    SimpleExtra.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(SimpleExtra.page.Home, MODx.Component);
Ext.reg('simpleextra-page-home', SimpleExtra.page.Home);

// Panel
SimpleExtra.panel.Home = function(config) {
    config = config || {};
    Ext.applyIf(config, 
    {
        baseCls: 'modx-formpanel',
        cls: 'container',
        items: [
            {
                html: '<h2>Simple Extra</h2>',
                cls: 'modx-page-header'
            },
            {
                xtype: 'modx-tabs',
                border: true,
                items: [
                    {
                        title: 'Items',
                        layout: 'form',
                        items: [
                            {
                                html: '<p>Manage your items</p>',
                                bodyCssClass: 'panel-desc',
                                border: false
                            }
                        ]
                    }
                ]
            }
        ]
    });
    SimpleExtra.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(SimpleExtra.panel.Home, MODx.Panel);
Ext.reg('simpleextra-panel-home', SimpleExtra.panel.Home);

// load Page
Ext.onReady(function(){
    MODx.load({ xtype: 'simpleextra-page-home'});
});