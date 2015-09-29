// JavaScript Document
	
function validateFileExtension(fileName) {
		var exp = /^.*\.(csv|CSV)$/;
		return exp.test(fileName);
};

function guardar_archivo(fp){				
		if (!fp.getForm().isValid()) {
		Ext.MessageBox.alert('Aviso','Por favor, seleccione un campo');
		return;
		}
		if (!validateFileExtension(Ext.getDom('archivo').value)) {
		Ext.MessageBox.alert('Archivo No Válido','Por favor, introduzca un archivo con extensión .csv');
		return;
		}
		fp.getForm().submit({
				success: function(fp, action){
					 console.log('action:',action);
					 Ext.MessageBox.show({
					   title: 'Subir Archivo',
					   msg: action.result.archivo.mensaje,
					   buttons: Ext.MessageBox.OK,
					   fn: function(btn, text){
							var redirect = "vista/index.html"; 
							window.location = redirect;												   
					   },
					   icon: Ext.MessageBox.INFO
				   });

					/*Ext.Msg.alert('Aviso', 'Archivo procesado "'+action.result.file+'" ');
					fp.reset();*/
				},
				failure: function(fp, action){
					//Ext.Msg.alert('Error', 'Falla en la Comunicacion con el Servidor: '+action.response.status+' '+action.response.statusText);
					Ext.Msg.alert('Error', ''+action.result.error + '');
					fp.reset();
				}

			})
		}	
		
