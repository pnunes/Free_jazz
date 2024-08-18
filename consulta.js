function getHTTPObject() {
var xmlhttp;
/*@cc_on
@if (@_jscript_version >= 5)
try {
xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
try {
xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
} catch (E) {
xmlhttp = false;
}
}
@else
xmlhttp = false;
@end @*/
if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
try {
xmlhttp = new XMLHttpRequest();
} catch (e) {
xmlhttp = false;
}
}
return xmlhttp;
}
var http = getHTTPObject();

function funcaowebservicecep() 
{
http.open("GET", 'buscarendereco.php?cep='+document.getElementById("cep").value, true);
http.onreadystatechange = handleHttpResponse;
http.send(null);

var arr; //array com os dados retornados
function handleHttpResponse() 
{
if (http.readyState == 4) 
{
var response = http.responseText;
eval("var arr = "+response); //cria objeto com o resultado
document.getElementById("rua").value = arr.rua;
document.getElementById("bairro").value = arr.bairro;
document.getElementById("cidade").value = arr.cidade;
document.getElementById("uf").value = arr.uf;
}
}
}