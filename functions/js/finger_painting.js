// JavaScript Document
window.addEventListener('load', eventWindowLoaded, false);    
function eventWindowLoaded() {
    canvasApp();
	}
function canvasSupport () {
    return Modernizr.canvas;
}
function canvasApp(){  
    if (!canvasSupport()) {
        return;
    }else{
        var theCanvas = document.getElementById('canvas');
        var context = theCanvas.getContext('2d');
        var resetButton = document.getElementById("reset_image");
        resetButton.addEventListener('click', resetPressed, false);
        drawScreen();
    }
    function drawScreen() {
        theCanvas.addEventListener('mousedown', mouse_pressed_down, false);
        theCanvas.addEventListener('mousemove', mouse_moved, false);
        theCanvas.addEventListener('mouseup', mouse_released, false);
        theCanvas.addEventListener('touchmove', touch_move_gesture, false);
        context.fillStyle = 'black';
        context.fillRect(0, 0, theCanvas.width, theCanvas.height);
        context.strokeStyle = '#000000'; 
        context.strokeRect(1,  1, theCanvas.width-2, theCanvas.height-2);
		context.stroke();
    }
    // For the mouse_moved event handler.
    var begin_drawing = false;
    function mouse_pressed_down (ev) {
        begin_drawing = true;
        context.fillStyle = 'black';
    }
	function mouse_moved (ev) {
        var x, y;    
        // Get the mouse position in the canvas
        x = ev.pageX;
        y = ev.pageY;
        if (begin_drawing) {
            context.beginPath();
            context.arc(x, y, 7, (Math.PI/180)*0, (Math.PI/180)*360, false);
            context.fill();
            context.closePath();
        }
    }
    function mouse_released (ev) {
        begin_drawing = false;
    }
    function touch_move_gesture (ev) {
        // For touchscreen browsers/readers that support touchmove
        var x, y;
        context.beginPath();
        context.fillStyle = 'black';
        if(ev.touches.length == 1){
            var touch = ev.touches[0];
            x = touch.pageX;
            y = touch.pageY;
            context.arc(x, y, 7, (Math.PI/180)*0, (Math.PI/180)*360, false);
            context.fill();
        }
    }
    function colorPressed(e) {
        var color_button_selected = e.target;
        var color_id = color_button_selected.getAttribute('id');
        colorChosen.innerHTML = color_id;
    }
    function resetPressed(e) {
        theCanvas.width = theCanvas.width; // Reset grid
        drawScreen();
    }
}