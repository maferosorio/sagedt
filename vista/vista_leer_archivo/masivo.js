Ext.onReady(function(){
Ext.QuickTips.init();

var codigo;
		
		var store_turbocompresor = new Ext.data.JsonStore({
			url: 'controlador/control_leer_archivo/control_turbo1.php',
			successProperty: 'success',
			//totalProperty: 'results',
			root:'datos',
			fields: [
				{name:'co_turbocompresor'}
			],
			autoLoad: true
		});
		
		var base_datos_mas = new Ext.data.JsonStore({
			root: 'archivo',  
			url: 'controlador/control_leer_archivo/mostrar_grid_lectura.php', 
			totalProperty: 'total',
			remoteSort : true,
			baseParams:{
				start:0, 
				limit:20
			},
			fields: [
					  {name:'co_historico'},
					  {name:'co_turbocompresor'},
					  {name:'co_archivo'}, 
					  {name:'co_dato'}, 
					  {name:'tx_descripcion'}, 
					  {name:'nu_valor_dato'},
					  {name:'tx_unidad_medida'},
					  {name:'fe_fecha_inspeccion'}
				  ]
		});
		//base_datos_mas.load();

		var columnas_masivo = new Ext.grid.ColumnModel({
		columns: [
						{header: 'Turbocompresor',align: 'center',width: 100,sortable: true,dataIndex: 'co_turbocompresor'},
						{header: 'Archivo',align: 'center',width: 70,sortable: true,dataIndex: 'co_archivo'},
						{header: 'Etiqueta',align: 'center',width: 120,sortable: true,dataIndex: 'co_dato'},
						{header: 'Descripcion',align: 'center',width: 150,sortable: true,dataIndex: 'tx_descripcion'},
						{header: 'Valor',align: 'center',width: 80,sortable: true,dataIndex: 'nu_valor_dato'},
						{header: 'Unidad de medida',align: 'center',width: 80,sortable: true,dataIndex: 'tx_unidad_medida'},
						{header: 'Fecha de inspección',align: 'center',width: 120,sortable: true,dataIndex: 'fe_fecha_inspeccion'}
				 ]
		});


        var tbar_mas = new Ext.Toolbar({
            style: 'border:1px solid #99BBE8;'
        });
        

		var pagingBar2 = new Ext.PagingToolbar({
			pageSize: 20,
			store: base_datos_mas,
			displayInfo: true,
			displayMsg: 'Mostrando registros {0} - {1} de {2}',
			emptyMsg: "No hay registros que mostrar"
			//plugins: filters
		});
		
		
		var gridmasiva= new Ext.grid.GridPanel({
			id: 'gridmasiva',
			ds: base_datos_mas,
			cm: columnas_masivo,
			height: 465,
			width: 565,
			//border:false,
			bbar: pagingBar2,
			//border: true,
			sm: new Ext.grid.RowSelectionModel({
					singleSelect: true,
					listeners: {
						rowselect: function(sm, row, rec) {
							rowRec = row;
							
						},
						rowclick: function(sm, rowIdx, r) {	
								
						}
					}
				})
			
			});
			
		function validateFileExtension(fileName) {
			var exp = /^.*\.(XLS|xls)$/;
			return exp.test(fileName);
		};

        var panelRightTop_mas = new Ext.FormPanel({
            title: 'Subir Archivo',
            width: 320,
            height: 150,
            region: 'north',
            //renderTo: 'right-top',
            buttonAlign: 'center',
            defaults: {
				allowBlank: false  
			},
            bodyStyle:'padding:5px 5px 5px 5px',
            fileUpload: true,
            //frame: true,
            items: [{
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
						labelWidth: 85,
						emptyText: 'Seleccione'
					},{
						xtype: 'fileuploadfield',
						emptyText: '',
						fieldLabel: 'Archivo',
						buttonText: 'Seleccione',
						width: 200,
						name: 'archivo',
						id: 'archivo'
					}],
            buttons: [{
				text: 'Preliminar',
                id:'btnSubirD',
                handler: function() {
					codigo=false;
					if (!panelRightTop_mas.getForm().isValid()) {
					Ext.MessageBox.alert('Aviso','Por favor, seleccione un campo');         
					return;
					}
					if (!validateFileExtension(Ext.getDom('archivo').value)) {
						Ext.MessageBox.alert('Archivo No Válido','Por favor, introduzca un archivo con extensión .xls');
						return;
					}
                    panelRightTop_mas.getForm().submit({
                        url: 'controlador/control_leer_archivo/control_leer.php',
                        waitMsg: 'Subiendo...',
                        //params: {estructura:estruc},
                        success: function(form, o) {
                            obj = Ext.util.JSON.decode(o.response.responseText);
                            if (obj.failed == 0 && obj.uploaded != 0) {
								codigo= obj.codigo;
								
                                Ext.Msg.alert('Mensaje', 'Se cargaron los registros');
                            } else if (obj.uploaded == 0) {
                                Ext.Msg.alert('Mensaje', 'No se cargaron los registros');
                            } else {
                                Ext.Msg.alert('Mensaje',
                                    obj.uploaded + ' Archivo guardado <br/>' +
                                    obj.failed + ' Archivo no guardado');
                            }
                            
                           // panelRightTop_mas.getForm().reset();
                           base_datos_mas.load({
						   params: {  accion:'leer'},
                           callback: function(options, success, response) { 
									gridmasiva.getView().refresh();
									if(base_datos_mas.getCount()>0)
											{
											Ext.Msg.alert('Mensaje', 'Se cargaron los registros');
											  Ext.getCmp("btnDefinitivo").enable();
											 
											}
									else
											{
												Ext.Msg.alert('Mensaje', 'No se cargaron los registros');
											 // Ext.getCmp("btnSubirD").enable();
											   Ext.getCmp("btnDefinitivo").disable();
											}	
		
								}
							}); 
                          
					}
                    });

                }
            }, {
                text: 'Definitivo',
                id:'btnDefinitivo',
                disabled: true,
                handler: function() {
					base_datos_mas.load(
						   {params: { co_evento: codigo, accion:'carga_archivo'},
                           callback: function(options, success, response) { gridmasiva.getView().refresh();
									if(base_datos_mas.getCount()>0)
											{
											  Ext.getCmp("btnDefinitivo").enable();
											 
											}
									else
											{
											 // Ext.getCmp("btnSubirD").enable();
											   Ext.getCmp("btnDefinitivo").disable();
											}	
		
										
							}}); 
                    //panelRightTop_doc.getForm().reset();
                }
            },{
					text: 'Limpiar',
					handler: function(){
					panelRightTop_mas.getForm().reset();
				}
			}]
        });
		

/*
gridmasiva.getStore().reload({
  callback: function(){
    gridmasiva.getView().refresh();
  }
});

*/
 
        // Panel for the west
        var center_mas = new Ext.Panel({
			id: 'registros',
            region: 'center',
            split: true,
            width: 750,
            height: 480,
            //collapsible: true,
            margins:'3 0 3 3',
            cmargins:'3 3 3 3',
            items: [gridmasiva]
        });
        
        // Panel for the west
        var east_mas = new Ext.Panel({
            region: 'east',
            split: true,
            width: 320,
            //layout:'fit',
            //collapsible: true,
            margins:'3 0 3 3',
            items:[panelRightTop_mas]
        });

	var top = new Ext.Panel({
            title: 'Documentos',
            closable:true,
            width:900,
            height:500,
            //border:false,
            closeAction: 'hide',
            plain:true,
            layout: 'border',
			items: [center_mas, east_mas]
        });
top.render("form_turbo");
    
  
String.prototype.ellipse = function(maxLength){
    if(this.length > maxLength){
        return this.substr(0, maxLength-3) + '...';
    }
    return this;
};
});
