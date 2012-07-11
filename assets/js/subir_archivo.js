/*
 *SIGII 2012
 *Archivo para guardar las funciones javascript de subida de imagenes
*/

/*
 * Funcion para verificar la extension del documento que se subira. 
 * Solo se aceptan archivos con formato .xls y .xlsx
 * Si se sube un documento de extension diferente despliega un mensaje de error.
 */
function comprueba_extension( archivo, tipo) { 
    //Arreglo de extensiones permitidas
    extensiones_permitidas = new Array(".gif",".png",".jpeg",".jpg"); 
    //Mensaje de error
    mierror = ""; 
    archivo=extractFilename(archivo);
    if (archivo) { 
        
        //Se obtiene la extensión de este nombre de archivo 
        extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();         
        //Se comprueba si la extensión está entre las permitidas 
        permitida = false; 
        for (var i = 0; i < extensiones_permitidas.length; i++) { 
            if (extensiones_permitidas[i] == extension) { 
                permitida = true; 
                break; 
            } 
        } 
        //Si no es permitida, se despliega el mensaje de error.
        if (!permitida) { 
            mierror = "Comprueba la extensión de las imágenes a subir. \nSólo se pueden subir imágenes con extensiones: " + extensiones_permitidas.join(); 
            //Si no se pudo subir, se despliega el mensaje de error.    
            document.getElementById("error"+tipo).innerHTML = "<a class='close' data-dismiss='alert' href='#'>×</a>" +mierror;
            document.getElementById("error"+tipo).className="alert alert-error";
            document.getElementById("error"+tipo).style.visibility= "visible";  
        }else{ 
        	//Si se permite, continuar.
            return 1; 
        } 
    } 
     
    return 0; 
}

/*
 *Funcion para extraer el nombre del archivo en caso de que el navegador agregue
 *en la ruta "C:\fakepath\"
 */
function extractFilename(path) {
  if (path.substr(0, 12) == "C:\\fakepath\\")
    return path.substr(12); // modern browser
  var x;
  x = path.lastIndexOf('/');
  if (x >= 0) // Unix-based path
    return path.substr(x+1);
  x = path.lastIndexOf('\\');
  if (x >= 0) // Windows-based path
    return path.substr(x+1);
  return path; // just the filename
}
