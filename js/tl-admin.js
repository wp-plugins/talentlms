/**
 * @author V. Prountzos
 */

//var editor = CodeMirror.fromTextArea(jQuery("#tl-edit-css").get(0), {
//    lineNumbers: true,
//    matchBrackets: true,
//    mode:  "css",
//});

jQuery( document ).ready(function() {
	var editor = CodeMirror.fromTextArea(document.getElementById("tl-edit-css"),{
        lineNumbers: true,
        matchBrackets: true,
        mode: "text/css"
	});
});  

