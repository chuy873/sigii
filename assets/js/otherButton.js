/*
 * Funcion javascript para generar otro elemento de entrada de subida de imagen.
 */

function createDivFachadas()
    {
	cont=document.getElementById("contFachadas").value;	
        var divTag = document.createElement("div");
        divTag.setAttribute("class","control-group");
        divTag.id = "div1";                        
        divTag.innerHTML = "<label class='control-label' for='fachada"+cont+"'>Im&aacute;gen "+
        "de fachada "+cont+"</label>  <div class='controls'> <input name='fachada"+cont+
        "' id='fachada"+cont+"' class='input-medium inputfachada' type='file'" +
        "  ><span class='help-inline'>"+
        "</span>  <div id='errorfachada"+cont+"'></div>   </div>";
        cont++;
        document.getElementById("contFachadas").value=cont;
        document.getElementById("fachadas").appendChild(divTag);
    }
 
function createDivDistribuciones()
    {
	cont2=document.getElementById("contDist").value;	
        var divTag = document.createElement("div");
        divTag.setAttribute("class","control-group");
        divTag.id = "div2";                        
        divTag.innerHTML = "<label class='control-label' for='distribucion"+cont2+"'>Im&aacute;gen "+
        "de distribucion "+cont2+"</label>  <div class='controls'> <input name='distribucion"+cont2+
        "' id='distribucion"+cont2+"' class='input-medium inputdistribucion' type='file'" +
        		"'><span class='help-inline'>"+
        "</span><div id='errordistribucion"+cont2+"'></div></div>";
        cont2++;
        document.getElementById("contDist").value=cont2;
        document.getElementById("distribuciones").appendChild(divTag);
    }
//onchange='comprueba_extension(this.value,'distribucion"+cont2+"')'
/*
 * Funcion para agregar otro precio en registro de modelo vertical
 */
var contPrecios=1; 
function createDivPrecio()
    {
		contPrecios++;
        var divTag = document.createElement("div");
        divTag.setAttribute("class","control-group");
        divTag.id = "div1";                        
        divTag.innerHTML = "<label class='control-label' for='precios"+contPrecios+"'>Precio " +
        		""+contPrecios+"</label>  <div class='controls'> $ <input name='precios"+contPrecios+
        "' id='precios"+contPrecios+"' class='input-medium' type='text'><span class='help-inline'>"+
        "</span></div>";
        document.getElementById("contPrecios").value=contPrecios;
        document.getElementById("precios").appendChild(divTag);
    }

/*
 * LLamadas a seleccionador de fechas de bootstrap
 */
var currentTime = new Date();
var month = currentTime.getMonth() + 1;
var day = currentTime.getDate();
var year = currentTime.getFullYear();

function setToday(id){
	document.getElementById(id).value=year+"-"+month+"-"+day;
}
$(function(){
	window.prettyPrint && prettyPrint();
	$('#dp1').datepicker({
		format: 'yyyy-mm-dd'
	});
});

$(function(){
	window.prettyPrint && prettyPrint();
	$('#dp2').datepicker({
		format: 'yyyy-mm-dd'
	});
});
