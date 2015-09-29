// JavaScript Document
Ext.onReady(function(){
Ext.QuickTips.init();
// -------------------------------- AQUI DEFINO EL STORE QUE ES EL QUE LLENARA EL GRID CON LOS DATOS DE TURBOCOMPRESOR --------------- 

    var store_turbocompresor = new Ext.data.JsonStore({
        url: 'php/cargar_turbo.php',
        successProperty: 'success',
        //totalProperty: 'results',
        root:'datos',
        baseParams: {
            accion: 'mostrar'
            /*start:0,
            limit:4*/
        },
        fields: [
            {name:'co_turbocompresor'},
            {name:'nb_fabricante'},
            {name:'tx_modelo'},
            {name:'nu_capacidad_nominal'},
            {name:'nu_estado'}
        ]
    });
		store_turbocompresor.load();
 
 // -------------------------------- COLUMNAS DEL GRID CON LOS DATOS DE TURBOCOMPRESOR --------------- 

 var col_turbocompresor = new Ext.grid.ColumnModel([
            {header: 'N°',align: 'center',width: 80,sortable: true,dataIndex: 'co_turbocompresor'},
            {header: 'Fabricante',align: 'center',width: 120, sortable: true, dataIndex: 'nb_fabricante'},
            {header: 'Modelo',align: 'center',width: 120,sortable: true,dataIndex: 'tx_modelo'},
            {header: 'Capacidad', xtype: 'numbercolumn', format:0, align: 'center',width: 100,sortable: true,dataIndex: 'nu_capacidad_nominal'},
            {header: 'Estado',align: 'center',width: 100,sortable: true,dataIndex: 'nu_estado'}
			]);
    
 // -------------------------------- DEFINICION DEL GRID DE DATOS DE TURBOCOMPRESOR --------------- 			
 var grid_turbocompresor = new Ext.grid.GridPanel({
        loadMask: true,
        height: 250,
		weight: 'auto',
        store: store_turbocompresor,
        cm: col_turbocompresor,
		selModel: new Ext.grid.RowSelectionModel({
                singleSelect: true,
                listeners: {
                    rowselect: function(selModel, index, record) {
					   boton_eliminar.enable();  //Activar boton eliminar cuando se seleccione un registro
                    }
                }
        })
        
 	});
 
 // -------------------------------- DEFINICION DE STORE DE COMBOBOX DEL FORMULARIO DE TURBOCOMPRESOR --------------- 	
   var store_estado = new Ext.data.SimpleStore({
    fields: ['nu_estado', 'estado'],
    data : [['0', 'Activo'],['1','Inactivo']]
	});
 // --------------------------------DEFINICION VTYPE PARA CAMPO MODELO---------------------------------------------
    var value= /^[a-zA-Z0-9_ ' ']+$/;        
	Ext.apply(Ext.form.VTypes, {
		alphanum : function(v){
            return value.test(v);
    	},
		alphanumMask : /[a-z0-9_ ' ']/i,
		alphanumText : 'El campo solo debe contener numeros y letras'
	});
 // --------------------------------DEFINICION VTYPE PARA CAMPO CAPACIDAD---------------------------------------------
	var value2= /^[0-9_]+$/;
	Ext.apply(Ext.form.VTypes, {
		num : function(v){
            return value2.test(v);
    	},
		numMask : /[0-9_]/i,
		numText : 'El campo solo debe contener numeros'
	});
 // -------------------------------- DEFINICION DEL CAMPOS DE FORMULARIO ---------------
  var campo_fabricante= new Ext.form.TextField({
	  fieldLabel : 'Fabricante',
	  allowBlank : false,
	  anchor: '90%',
	  inputType : 'text',
	  id : 'nb_fabricante',
	  name: 'nb_fabricante',
	  vtype: 'alphanum',
	  blankText:'El campo es requerido'
	  });
	  
  var campo_modelo= new Ext.form.TextField({
	  fieldLabel : 'Modelo',
	  allowBlank : false,
	  anchor: '90%',
	  id : 'tx_modelo',
	  name: 'tx_modelo',
	  vtype: 'alphanum',
	  blankText:'El campo es requerido'
	  });
	  
  var campo_capacidad= new Ext.form.TextField({
	  fieldLabel : 'Capacidad (HP)',
	  allowBlank : false,
	  anchor: '90%',
	  id : 'nu_capacidad',
	  name: 'nu_capacidad',
	  vtype: 'num',
	  blankText:'El campo es requerido'
	  });
  // -------------------------------- DEFINICION DEL COMBOBOX SOBRE EL ESTADO DEL TURBOCOMPRESOR ---------------
  var combo_estado = new Ext.form.ComboBox({
		store: store_estado,
		displayField: 'estado',
		valueField: 'nu_estado',
		editable: false,
		allowBlank : false,
		mode: 'local',
		name: 'nu_estado',
		id:'nu_estado',
		forceSelection: true,
		triggerAction: 'all',
		fieldLabel: 'Estado',
		emptyText: 'Seleccione',
		selectOnFocus: true,
		anchor:'50%',

		});
	 // -------------------------------- DEFINICION DEL FORMULARIO DEL TURBOCOMPRESOR ---------------
	var form_turbocompresor=new Ext.FormPanel({
		frame: true,
		/*title: 'Datos de Turbocompresor',
		bodyStyle: 'padding:5px',
		width: 420,
		height:200,
		id: 'form_turbo',*/
		labelWidth:60,
		url: 'php/insertar_turbo.php',
		items: [campo_fabricante, campo_modelo,  campo_capacidad, combo_estado]
	});
		//form_turbocompresor.render(document.body);
		
	// -------------------------------- PESTANA FORMULARIO DEL TURBOCOMPRESOR ---------------	
	/*var tab_formulario = {
        height: 600,
        weight: 700,
        frame: true,                             
        title: 'Datos de Turbocompresor',
        buttonAlign: 'center',
        items:[form_turbocompresor,grid_turbocompresor]
    };*/
	
	/*var tab_panelgrid = {
        height: 530,
        frame: true,                             
        title: 'Datos Iniciales',
        buttonAlign: 'center',
        items:[grid_turbocompresor]
    };
    
    var tab_panel = new Ext.TabPanel({
        activeTab: 0,
        frame: true,
        defaults:{autoHeight: true},
        items: [tab_panelgrid]
    });*/
	
	//-------------------------------------------------VENTANA DE FORMULARIO DE TURBOCOMPRESOR----------------------------------------------
     var ventana_formulario = new Ext.Window({
        bodyStyle: 'padding:5px',
        width: 450,
        height: 250,
        draggable: false,
        modal: true,
        title: 'Agregar Nuevo Turbocompresor',
        resizable: false,
        maximizable: false,
        minimizable: false,
        closable: false,
        items: [form_turbocompresor],
		buttonAlign: 'center',
		buttons:[{
				text: 'Guardar',  //boton guardar
				handler: function(){
					if (!form_turbocompresor.getForm().isValid()) {
						Ext.MessageBox.alert('Aviso','Todos los campos deben ser llenados');
						return;
						}
					form_turbocompresor.getForm().submit({
						success: function(form, action){
							console.log("action: ", action);
							Ext.Msg.alert('Exito', 'Datos Guardados Exitosamente');
							form_turbocompresor.getForm().reset();
							ventana_formulario.hide();
							store_turbocompresor.reload();
							
						},				
						failure: function(form, action){
							console.log("action: ", action);
							if (action.failureType == Ext.form.Action.CLIENT_INVALID) {
								Ext.Msg.alert("Error, no se pudo guardar", "Alguno(s) campos son invalidos, por favor verifique");
							} 
							else {
								Ext.Msg.alert('Error, no se pudo guardar', 'Falla en la Comunicacion con el Servidor: '+action.response.status+' '+action.response.statusText);
								
							} 
						}
					})				
				}
				},{
				text: 'Cancelar', // boton cancelar
				handler: function(){
					ventana_formulario.hide();
					}
				},{ 
				text: 'Resetear', //boton resetear
				handler: function(){
					form_turbocompresor.getForm().reset();
				}
				}]
    });
    
   //ventana_formulario.show();
    /*
    var Panel_Interno = new Ext.Panel({
        items: [grid_turbocompresor]
    });
    
     var Vista = new Ext.Viewport({
        layout: 'fit',
        items: [ Panel_Interno ]
    });*/
	//-----------------------------------------------------BOTON AGREGAR VENTANA GRID-----------------------------------------------------------------
	var boton_agregar= new Ext.Button({
		xtype:'button',
		text: 'Agregar',
		icon: 'recursos/imagenes/add.png',
		handler: function(){
			ventana_formulario.show();
			}
	});
	//-----------------------------------------------------BOTON ELIMINAR VENTANA GRID-----------------------------------------------------------------
	var boton_eliminar= new Ext.Button({
		text:'Eliminar',
		disabled: true,
		id: 'boton_eliminar',
		icon: 'recursos/imagenes/delete.png',
		handler: function(){
			fila = grid_turbocompresor.getSelectionModel();
			celda = fila.getSelected();
			if(fila.hasSelection()){
				Ext.Msg.show({
				title: 'Confirmación',
				buttons: Ext.MessageBox.YESNO,
				msg: '¿Desea eliminar el registro ' + celda.data.co_turbocompresor + '?',
				fn: function(btn){
					if (btn == 'yes'){
						Ext.Ajax.request({
							url: 'php/eliminar_turbo.php',
							params: {
								co_turbocompresor: celda.data.co_turbocompresor
								},
							success: function(resp,opt) {
								grid_turbocompresor.getStore().remove(celda);
								Ext.Msg.alert('Aviso', 'Datos eliminados');
								},
							failure: function(resp,opt) {
								Ext.Msg.alert('Aviso', 'No se pudo eliminar');
								}
							});
						}	
					}
				});
			}
		}
	});
    //-----------------------------------------------------VENTANA GRID-----------------------------------------------------------------
    var ventana_grid = new Ext.Window({
    id: 'ventana_grid',
    draggable: false,
    resizable: false,
    maximizable: false,
    modal: true,
    minimizable: false,
    closable: false,
    layout: "anchor",
    title: "Turbocompresor",
    items: [grid_turbocompresor],
	tbar:	[boton_agregar,'-', boton_eliminar]
	});
    
   /* 
    var contenedor = new Ext.Viewport({
	layout: 'fit',
	items: [ ventana1 ]
});
    */
    ventana_grid.show();
	});
