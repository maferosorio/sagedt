Ext.onReady(function() 
{
		var store = new Ext.data.JsonStore({
		  root: 'archivo',  
		  url: '../controlador/mostrar_grid.php', //'controlador/mostrar_grid.php', 
		  fields: [{name:'co_archivo'},{name:'nb_archivo'}, {name:'co_turbocompresor'}]
		});
		store.load();

		var grid = new Ext.grid.GridPanel({
			store: store, 
			columns: [  {header: 'N°',align: 'center',width: 100,sortable: true,dataIndex: 'co_archivo'},
						{header: 'Archivo',align: 'center',width: 200,sortable: true,dataIndex: 'nb_archivo'},
						{header: 'Turbocompresor',align: 'center',width: 120,sortable: true,dataIndex: 'co_turbocompresor'}
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
