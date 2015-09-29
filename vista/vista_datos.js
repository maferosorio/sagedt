// JavaScript Document
Ext.onReady(function(){
        Ext.QuickTips.init();
	
	var datos_indicador = Ext.data.Record.create([
            'co_indicador',
			'nb_nombre_indicador',
            'tx_formula_indicador'
        ]);
		
        var store_indicador = new Ext.data.Store({
            data: [
					[1, "inspeccion programada", "% inspeccion programada"],
					[2, "inspeccion no programada", "% inspeccion no programada"]
				  ],
            reader: new Ext.data.ArrayReader({
                idInndex: 0
            }, datos_indicador)
        });
	
	var edit_nombre=new Ext.form.TextField({
  		 maxLength: 45
		});
		
	var grid_datos= new Ext.grid.EditorGridPanel({
	
	//renderTo: document.body,
	store:store_indicador,
	columns: [{header: 'N°', align: 'center',width: 80,sortable: true,dataIndex: 'co_indicador'}, 
			  {header: 'Nombre', align: 'center',width: 80,sortable: true,dataIndex: 'nb_nombre_indicador', editor:edit_nombre},
			  {header: 'Fórmula', align: 'center',width: 80,sortable: true,dataIndex: 'tx_formula_indicador' , editor:edit_nombre}
			 ]

	});
	
	var ventana= new Ext.Window({
		title:'Indicadores de gestión',
		layout:'fit',
		width: 400,
		height: 200,
		items: [grid_datos]
	});
	
	ventana.show();

});