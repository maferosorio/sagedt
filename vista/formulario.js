Ext.onReady(function(){
Ext.QuickTips.init();

	var store_turbocompresor = new Ext.data.JsonStore({
		url: 'controlador/control_turbo.php',
        successProperty: 'success',
        //totalProperty: 'results',
        root:'datos',
        fields: [
            {name:'co_turbocompresor'}
        ],
        autoLoad: true
	});
	

var fp = new Ext.FormPanel({
		url: 'controlador/subir_archivos.php',
		id:'form',
        fileUpload: true,
        frame: true,
		method: 'POST',
		bodyStyle: 'padding: 10px;',
		//draggable:true,
        defaults: {
      			   allowBlank: false,
        		  },
		items:[{
					xtype:'combo',
					fieldLabel: 'Turbocompresor',
					mode: 'remote',
					store: store_turbocompresor,
					name: 'equipo',
					id:'equipo',
					displayField:'co_turbocompresor',
					triggerAction: 'all',
					width:85,
					height:100,
					forceSelection: true,
					labelWidth: 70,
					emptyText: 'Seleccione'
					
				},{
					xtype: 'fileuploadfield',
					id: 'archivo',
					emptyText: 'Seleccione un archivo .csv',
					fieldLabel: 'Archivo',
					name: 'archivo',
					buttonText: 'Buscar',
					width: 220,
				 }],
					buttons:[{ 
						text: 'Guardar',
						handler: function (){
							guardar_archivo(Ext.getCmp('form'))
								}
							},{
							text: 'Resetear',
							handler: function(){
							fp.getForm().reset();
						}
					}]
	});
	
	var ventana_form_archivo = new Ext.Window({
			id: 'ventana_archivo',
			draggable: false,
			resizable: false,
			maximizable: false,
			modal: true,
			minimizable: false,
			closable: false,
			layout: "anchor",
			title: "Datos Operacionales",
			width: 400,
			height: 145,
			items: [fp]
			//tbar:	[boton_agregar,'-', boton_eliminar]
	});
	ventana_form_archivo.show();
});
