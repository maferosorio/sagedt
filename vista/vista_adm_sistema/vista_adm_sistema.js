// JavaScript Document

Ext.onReady(function(){
        
        Ext.QuickTips.init();

		var toolbar1 = {
            height: 27,
            xtype: 'toolbar',
            items: [' ', {text: 'Boton 1'}, {text: 'Boton 2'} , {text: 'Boton n'}]
		};
		var toolbar2 = {
            height: 20,
            xtype: 'toolbar',
            items: [' ', {text: 'Boton 1'}, {text: 'Boton 2'} , {text: 'Boton 3'}, {text: 'Boton n'}]
		};
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
				fbar: toolbar2,
				tbar: toolbar1,
                items: [{
                    title: 'Opcion 1',
                    html: 'Contenido'
                }],
                margins: '0 0 0 0'
            },{
                region: 'south',
                html: 'barra inferior',
                margins: '5 5 5 5'
            }]
        });
    });