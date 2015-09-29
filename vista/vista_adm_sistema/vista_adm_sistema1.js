// JavaScript Document

Ext.onReady(function(){
        
		
		Ext.QuickTips.init();
		
		var datos = Ext.data.Record.create([
            'co_dato',
            'tx_dexcripcion',
            'nu_valor_alarma',
            'nu_valor_paro',
            'nu_status',
        ]);
		
        var store = new Ext.data.Store({
            data: [
                [TNH, "velocidad", 300,450,"Activo"],
                [TNH, "velocidad", 300,450,"Activo"],
				[TNH, "velocidad", 300,450,"Activo"],
            	],
            reader: new Ext.data.ArrayReader({
                idInndex: 0
            }, datos)
        });
		/*
		var Columnas= new Ext.grid.ColumnModel([
			{header: 'Etiqueta', align: 'center',width: 100,sortable: true,dataIndex: 'co_dato'},
			{header: 'Descripcion', align: 'center',width: 100,sortable: true,dataIndex: 'tx_descripcion'},
			{header: 'Valor de alarma', align: 'center',width: 100,sortable: true,dataIndex: 'nu_valor_alarma'},
			{header: 'Valor de paro', align: 'center',width: 100,sortable: true,dataIndex: 'nu_valor_paro'},
			{header: 'Estatus', align: 'center',width: 100,sortable: true,dataIndex: 'nu_status'}
		]);
		
		
		var grid= new  Ext.grid.GridPanel({
			loadMask: true,
        	layout:'fit',   
        	store: store,
			cm: Columnas
		});
		
		var ventana= new  Ext.Panel({
			layout:'fit',   
        	items: [grid]
		});*/
		

		var toolbar1 = {
            height: 27,
            xtype: 'toolbar',
            items: [' ', {text: 'Boton 1'}, {text: 'Boton 2'} , {text: 'Boton n'}]
		};
		var toolbar2 = {
            height: 25,
            xtype: 'toolbar',
            items: [' ', {text: 'Boton 1'}, {text: 'Boton 2'} , {text: 'Boton 3'}, {text: 'Boton n'}]
		};
		
	/*   var tab1={
                region: 'center',
                //xtype: 'panel',
                activeTab: 0,
				fbar: toolbar2,
				tbar: toolbar1,
				title: 'Opcion 1',
                items:[ventana]
               // margins: '0 0 0 0'
            };
	  var tab2={
                region: 'center',
                //xtype: 'tabpanel',
                activeTab: 0,
				title: 'Opcion 2',
				fbar: toolbar2,
				tbar: toolbar1,
               // items:[grid2]
               // margins: '0 0 0 0'
            };
			*/
		
        var viewport = new Ext.Viewport({
            layout: "border",
            defaults: {
                bodyStyle: 'padding:5px;',
            		  },
            items: [{
                region: "north",
                html: 'Encabezado',
                margins: '5 5 5 5',
				height: 70
           		}, {
                region: 'west',
                split: true,
				xtype: 'panel',
                collapsible: true,
                collapseMode: 'mini',
                title: 'Menu',
                width: 250,
                minSize: 200,
                
                margins: '0 0 0 5',
				items:[{
                    xtype: 'container',
					
                    title: 'Menu',
                    layout: 'accordion',
                    defaults: {
                        border: false,
                        autoScroll: true
                    		},
                    items: [{
                        title: 'Datos',
                       // autoLoad: 'html/1.txt'
                    },{
                        title: 'Tendencias',
                        //autoLoad: 'html/3.txt'
                    },{
                        title: 'Reportes',
                      //  autoLoad: 'html/4.txt'
 					},{
                        title: 'Administracion',
                      //  autoLoad: 'html/4.txt'
 					}
					
					],
             }]//,   margins: '0 0 0 0'
			
            },{
                region: 'center',
                xtype: 'tabpanel',
                activeTab: 0,
				tbar: toolbar1,
				fbar: toobar2,
				items: [{xtype:'grid',
						store:store,
						colModel: new Ext.grid.ColumnModel({
						columns: [
								{header: 'Etiqueta', align: 'center',width: 80,sortable: true,dataIndex: 'co_dato'},
								{header: 'Descripcion', align: 'center',width: 80,sortable: true,dataIndex: 'tx_descripcion'},
								{header: 'Valor de alarma', xtype:'numberfield', align: 'center',width: 80,sortable: true,dataIndex: 'nu_valor_alarma'}, {header: 'Valor de paro', xtype:'numberfield', align: 'center',width: 80,sortable: true,dataIndex: 'nu_valor_paro'},
								{header: 'Estatus', align: 'center',width: 80,sortable: true,dataIndex: 'nu_status'}
								]
						})
				}],
				margins: '0 0 0 0'
				},{
                region: 'south',
                html: 'barra inferior',
                margins: '5 5 5 5'
            }]
        });
    });