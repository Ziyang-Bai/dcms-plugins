function onOpenLoginBox() {
   var overlayDiv = document.getElementById('lb_overlay');
   var boxDiv = document.getElementById('lb_box');
   overlayDiv.style.display = 'block';
   boxDiv.style.display = 'block';
   center(boxDiv);
}
function onCloseLoginBox() {
   var overlayDiv = document.getElementById('lb_overlay');
   var boxDiv = document.getElementById('lb_box');
   overlayDiv.style.display = 'none';
   boxDiv.style.display = 'none';
}
function center(element) {
   var my_width  = 0;
   var my_height = 0;
   var divWidth = 300;
   var divHeight = 0;
   
   if ( typeof( window.innerWidth ) == 'number' ){
      my_width  = window.innerWidth;
      my_height = window.innerHeight;
   }else if ( document.documentElement &&
   ( document.documentElement.clientWidth ||
   document.documentElement.clientHeight ) ){
      my_width  = document.documentElement.clientWidth;
      my_height = document.documentElement.clientHeight;
   }
   else if ( document.body &&
   ( document.body.clientWidth || document.body.clientHeight ) ){
      my_width  = document.body.clientWidth;
      my_height = document.body.clientHeight;
   }
   element.style.position = 'absolute';
   element.style.zIndex   = 99;
  
   var scrollY = 0;

   if ( document.documentElement && document.documentElement.scrollTop ){
      scrollY = document.documentElement.scrollTop;
   }else if ( document.body && document.body.scrollTop ){
      scrollY = document.body.scrollTop;
   }else if ( window.pageYOffset ){
      scrollY = window.pageYOffset;
   }else if ( window.scrollY ){
      scrollY = window.scrollY;
   }

   var setX = ( my_width  - divWidth  ) / 2;
   var setY = ( my_height - divHeight ) / 2 + scrollY;

   setX = ( setX < 0 ) ? 0 : setX;
   setY = ( setY < 0 ) ? 0 : setY;

   element.style.left = setX + "px";
   element.style.top  = setY + "px";
   element.style.display  = 'block';
   var overlayDiv = document.getElementById('lb_overlay');
   overlayDiv.style.width = my_width + "px";
   overlayDiv.style.height = my_height + "px";
   overlayDiv.style.top = scrollY + "px";
   overlayDiv.style.left = "0px";

}
function emoticon(text) {
	var txtarea = document.message.msg;
	text = ' ' + text + ' ';
	if (txtarea.createTextRange && txtarea.caretPos) {
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
		txtarea.focus();
	} else {
		txtarea.value  += text;
		txtarea.focus();
	}
}
function storeCaret(textEl) {
	if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}
function smiles(vis) {
if (vis == 'show')
{
document.getElementById("smiles_0").style.display = "none";
document.getElementById("smiles_1").style.display = "block";
}
else
{
document.getElementById("smiles_1").style.display = "none";
document.getElementById("smiles_0").style.display = "block";
}
}