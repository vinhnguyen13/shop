/*!
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos.org, 2015
 */

Ext.ns('MShop.panel.supplier.address');

MShop.panel.supplier.address.ItemUi = Ext.extend(MShop.panel.AbstractItemUi, {

    siteidProperty : 'supplier.address.siteid',

    initComponent : function() {

        MShop.panel.AbstractItemUi.prototype.setSiteCheck(this);

        this.items = [{
            xtype : 'tabpanel',
            activeTab : 0,
            border : false,
            itemId : 'MShop.panel.supplier.address.ItemUi',
            plugins : ['ux.itemregistry'],
            items : [{
                title : MShop.I18n.dt('admin', 'Basic'),
                xtype : 'panel',
                layout : 'fit',
                border : false,
                itemId : 'MShop.panel.supplier.address.ItemUi.BasicPanel',
                plugins : ['ux.itemregistry'],
                defaults : {
                    bodyCssClass : this.readOnlyClass
                },
                items : [{
                    title : MShop.I18n.dt('admin', 'Details'),
                    xtype : 'form',
                    ref : '../../mainForm',
                    autoScroll : true,
                    items : [{
                        xtype : 'fieldset',
                        labelAlign : 'top',
                        border : false,
                        defaults : {
                            readOnly : this.fieldsReadOnly,
                            anchor : '-25'
                        },
                        items : [{
                            xtype : 'textfield',
                            name : 'supplier.address.company',
                            fieldLabel : MShop.I18n.dt('admin', 'Company'),
                            emptyText : MShop.I18n.dt('admin', 'Company name'),
                            maxLength : 100
                        }, {
                            xtype : 'textfield',
                            name : 'supplier.address.vatid',
                            fieldLabel : MShop.I18n.dt('admin', 'Vat ID'),
                            emptyText : MShop.I18n.dt('admin', 'Vat ID, e.g. "GB999999999"'),
                            maxLength : 32
                        }, {
                            xtype : 'MShop.elements.salutation.combo',
                            name : 'supplier.address.salutation'
                        }, {
                            xtype : 'textfield',
                            name : 'supplier.address.title',
                            fieldLabel : MShop.I18n.dt('admin', 'Title'),
                            emptyText : MShop.I18n.dt('admin', 'Honorary title'),
                            maxLength : 64
                        }, {
                            xtype : 'textfield',
                            name : 'supplier.address.firstname',
                            fieldLabel : MShop.I18n.dt('admin', 'First name'),
                            emptyText : MShop.I18n.dt('admin', 'First name'),
                            maxLength : 64
                        }, {
                            xtype : 'textfield',
                            name : 'supplier.address.lastname',
                            fieldLabel : MShop.I18n.dt('admin', 'Last name'),
                            emptyText : MShop.I18n.dt('admin', 'Last name (required)'),
                            allowBlank : false,
                            maxLength : 64
                        }, {
                            xtype : 'textfield',
                            name : 'supplier.address.address1',
                            fieldLabel : MShop.I18n.dt('admin', 'Address 1'),
                            emptyText : MShop.I18n.dt('admin', 'Street (required)'),
                            allowBlank : false,
                            maxLength : 255
                        }, {
                            xtype : 'textfield',
                            name : 'supplier.address.address2',
                            fieldLabel : MShop.I18n.dt('admin', 'Address 2'),
                            emptyText : MShop.I18n.dt('admin', 'House number'),
                            maxLength : 255
                        }, {
                            xtype : 'textfield',
                            name : 'supplier.address.address3',
                            fieldLabel : MShop.I18n.dt('admin', 'Address 3'),
                            emptyText : MShop.I18n.dt('admin', 'Additional information, e.g. flat number'),
                            maxLength : 255
                        }, {
                            xtype : 'textfield',
                            name : 'supplier.address.postal',
                            fieldLabel : MShop.I18n.dt('admin', 'Postal code'),
                            emptyText : MShop.I18n.dt('admin', 'Postal code'),
                            maxLength : 16
                        }, {
                            xtype : 'textfield',
                            name : 'supplier.address.city',
                            fieldLabel : MShop.I18n.dt('admin', 'City'),
                            emptyText : MShop.I18n.dt('admin', 'City name (required)'),
                            allowBlank : false,
                            maxLength : 255
                        }, {
                            xtype : 'textfield',
                            name : 'supplier.address.state',
                            fieldLabel : MShop.I18n.dt('admin', 'State'),
                            emptyText : MShop.I18n.dt('admin', 'Country state, e.g. "NY"'),
                            maxLength : 255
                        }, {
                            xtype : 'textfield',
                            name : 'supplier.address.countryid',
                            fieldLabel : MShop.I18n.dt('admin', 'Country code'),
                            emptyText : MShop.I18n.dt('admin', 'Two letter country code, e.g. "US" (required)'),
                            regex : /[A-Za-z]{2}/,
                            allowBlank : false,
                            maxLength : 2
                        }, {
                            xtype : 'MShop.elements.language.combo',
                            name : 'supplier.address.languageid'
                        }, {
                            xtype : 'textfield',
                            name : 'supplier.address.telephone',
                            fieldLabel : MShop.I18n.dt('admin', 'Telephone'),
                            emptyText : MShop.I18n.dt('admin', 'Telephone number, e.g. +155512345'),
                            maxLength : 32
                        }, {
                            xtype : 'textfield',
                            name : 'supplier.address.telefax',
                            fieldLabel : MShop.I18n.dt('admin', 'Telefax'),
                            emptyText : MShop.I18n.dt('admin', 'Facsimile number, e.g. +155512345'),
                            maxLength : 32
                        }, {
                            xtype : 'textfield',
                            name : 'supplier.address.email',
                            fieldLabel : MShop.I18n.dt('admin', 'E-Mail'),
                            emptyText : MShop.I18n.dt('admin', 'E-Mail, e.g. me@example.com (required)'),
                            allowBlank : false,
                            maxLength : 255
                        }, {
                            xtype : 'textfield',
                            name : 'supplier.address.website',
                            fieldLabel : MShop.I18n.dt('admin', 'Website'),
                            emptyText : MShop.I18n.dt('admin', 'Web site, e.g. www.example.com'),
                            maxLength : 255
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('admin', 'Created'),
                            name : 'supplier.address.ctime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('admin', 'Last modified'),
                            name : 'supplier.address.mtime'
                        }, {
                            xtype : 'displayfield',
                            fieldLabel : MShop.I18n.dt('admin', 'Editor'),
                            name : 'supplier.address.editor'
                        }]
                    }]
                }]
            }]
        }];

        this.store.on('beforesave', this.onBeforeSave, this);

        MShop.panel.supplier.address.ItemUi.superclass.initComponent.call(this);
    },

    afterRender : function() {
        var label = this.record ? this.record.data['supplier.address.lastname'] : MShop.I18n.dt('admin', 'new');
        //#: Supplier address item panel title with supplier name ({0}) and site code ({1)}
        var string = MShop.I18n.dt('admin', 'Supplier address: {0} ({1})');
        this.setTitle(String.format(string, label, MShop.config.site["locale.site.label"]));

        MShop.panel.supplier.address.ItemUi.superclass.afterRender.apply(this, arguments);
    },


    onBeforeSave : function(store, data) {
        if(data.create && data.create[0]) {
            data.create[0].data['supplier.address.parentid'] = this.listUI.ParentItemUi.record.id;
        }
    }

});

Ext.reg('MShop.panel.supplier.address.itemui', MShop.panel.supplier.address.ItemUi);
