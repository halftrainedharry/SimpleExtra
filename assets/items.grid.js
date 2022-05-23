SimpleExtra.grid.Items = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        id: 'simpleextra-grid-items',
        url: MODx.config.connector_url,
        baseParams: {
            action: 'SimpleExtra\\Processors\\Item\\GetList'
        },
        fields: ['id', 'name', 'description'],
        autoHeight: true,
        paging: true,
        remoteSort: true,
        columns: [
            {
                header: 'ID',
                dataIndex: 'id',
                sortable: true
            },
            {
                header: 'Name',
                dataIndex: 'name',
                sortable: true
            },
            {
                header: 'Description',
                dataIndex: 'description',
                sortable: true
            }
        ],
        tbar: [{
            xtype: 'textfield',
            emptyText: 'Search...',
            listeners: {
                'change': { fn: this.search, scope: this}
            }
        }]
    });
    SimpleExtra.grid.Items.superclass.constructor.call(this, config);
};
Ext.extend(SimpleExtra.grid.Items, MODx.grid.Grid, {
    search: function(tf, nv, ov)
    {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
});
Ext.reg('simpleextra-grid-items', SimpleExtra.grid.Items);