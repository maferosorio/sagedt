Ext.onReady(function() 
{
		var store = new Ext.data.JsonStore({
		  root: 'archivo',  
		  url: 'controlador/control_leer_archivo/mostrar_grid_lectura.php', 
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
		store.load();

		var grid = new Ext.grid.GridPanel({
			store: store, 
			columns: [  {header: 'Turbocompresor',align: 'center',width: 120,sortable: true,dataIndex: 'co_turbocompresor'},
						{header: 'N°',align: 'center',width: 100,sortable: true,dataIndex: 'co_archivo'},
						{header: 'Etiqueta',align: 'center',width: 120,sortable: true,dataIndex: 'co_dato'},
						{header: 'Descripcion',align: 'center',width: 120,sortable: true,dataIndex: 'tx_descripcion'},
						{header: 'valor',align: 'center',width: 120,sortable: true,dataIndex: 'nu_valor_dato'},
						{header: 'Unidad de medida',align: 'center',width: 120,sortable: true,dataIndex: 'tx_unidad_medida'},
						{header: 'Fecha de inspección',align: 'center',width: 120,sortable: true,dataIndex: 'fe_fecha_inspeccion'}
					]
		});
		

		var main = new Ext.Panel({
			
			layout		:	"fit",
			border		:   true,
			modal       :   false,
			frame 		:   true,
			height		:	700,
			items		:	[grid]
			
		});
		main.render(document.body);
		

});
