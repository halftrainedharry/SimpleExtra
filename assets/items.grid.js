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
        ddGroup: 'mygridDD',
        enableDragDrop: true,
        remoteSort: true,
        save_action: 'SimpleExtra\\Processors\\Item\\UpdateFromGrid',
        autosave: true,
        columns: [
            {
                header: 'ID',
                dataIndex: 'id',
                sortable: false
            },
            {
                header: 'Name',
                dataIndex: 'name',
                sortable: false,
                editor: { xtype: 'textfield' }
            },
            {
                header: 'Description',
                dataIndex: 'description',
                sortable: false,
                editor: { xtype: 'textfield' }
            }
        ],
        listeners: {
            'render': {
                scope: this,
                fn: function(grid) {
                    new Ext.dd.DropTarget(grid.container, {
                        ddGroup: 'mygridDD',
                        copy: false,
                        notifyDrop: function(dd, e, data) { //dd = thing being dragged, e = event, data = data from dragged source
                            if (dd.getDragData(e)) {
                                var targetNode = dd.getDragData(e).selections[0];
                                var sourceNode = data.selections[0];

                                grid.fireEvent('sort',{
                                    target: targetNode,
                                    source: sourceNode,
                                    event: e,
                                    dd: dd
                                });
                            }
                        }
                    });
                }
            }
        },
        tbar: [{
            text: 'Create Item',
            handler: this.createItem,
            scope: this
        },'->',{
            xtype: 'textfield',
            emptyText: 'Search...',
            listeners: {
                'change': { fn: this.search, scope: this}
            }
        }]
    });
    SimpleExtra.grid.Items.superclass.constructor.call(this, config);
    this.addEvents('sort');
    this.on('sort', this.onSort, this);
};
Ext.extend(SimpleExtra.grid.Items, MODx.grid.Grid, {
    onSort: function(o) {
        MODx.Ajax.request({
            url: MODx.config.connector_url,
            params: {
                action: 'SimpleExtra\\Processors\\Item\\Sort',
                source: o.source.id,
                target: o.target.id
            },
            listeners: {
                'success': { fn: function() { this.refresh(); }, scope: this},
                'failure': { fn: function() { this.refresh(); }, scope: this}
            }
        });
    },
    search: function(tf, nv, ov)
    {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    },
    createItem: function(btn, e){
        var win = MODx.load({
            xtype: 'simpleextra-window-item-create-update',
            title: 'Create Item',
            listeners: {
                'success': {fn: function() { this.refresh(); }, scope: this}
            }
        });
        win.show(e.target);
    },
    updateItem: function(btn, e){
        if (!this.menu.record || !this.menu.record.id){
            return false;
        }
        var win = MODx.load({
            xtype: 'simpleextra-window-item-create-update',
            title: 'Update Item',
            action: 'SimpleExtra\\Processors\\Item\\Update',
            listeners: {
                'success': {fn: function() { this.refresh(); }, scope: this}
            }
        });
        win.fp.getForm().setValues(this.menu.record);
        win.show(e.target);
    },
    getMenu: function() {
        var m = [];
        m.push({
            text: 'Update Item',
            handler: this.updateItem
        });
        m.push('-');
        m.push({
            text: 'Remove Item',
            handler: this.removeItem
        });
        this.addContextMenuItem(m);
    },
    removeItem: function(btn, e) {
        if (!this.menu.record){
            return false;
        }

        MODx.msg.confirm({
            title: 'Remove Item',
            text: 'Are you sure you want to remove this Item?',
            url: this.config.url,
            params: {
                action: 'SimpleExtra\\Processors\\Item\\Remove',
                id: this.menu.record.id
            },
            listeners: {
                'success': { fn: function() { this.refresh(); }, scope: this}
            }
        });
    }
});
Ext.reg('simpleextra-grid-items', SimpleExtra.grid.Items);

// Window
SimpleExtra.window.CreateUpdateItem = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        width: 500,
        closeAction: 'close',
        url: MODx.config.connector_url,
        action: 'SimpleExtra\\Processors\\Item\\Create',
        fields: [
            {
                xtype: 'textfield',
                fieldLabel: 'Name',
                name: 'name',
                anchor: '100%'
            },
            {
                xtype: 'textarea',
                fieldLabel: 'Description',
                name: 'description',
                anchor: '100%'
            },
            {
                xtype: 'hidden',
                name: 'id'
            }
        ]
    });
    SimpleExtra.window.CreateUpdateItem.superclass.constructor.call(this, config);
};
Ext.extend(SimpleExtra.window.CreateUpdateItem, MODx.Window);
Ext.reg('simpleextra-window-item-create-update', SimpleExtra.window.CreateUpdateItem);