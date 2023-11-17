var btn = document.querySelector('#compraragora');
var form = document.querySelector('#form-control');
var frete = document.querySelector('#fretearea');
var avancabtn = document;querySelector("#avancar");
var fretebtn = document.querySelector("#btnfrete");


btn.addEventListener('click', function() {

    if(form.style.display === 'none') {
        form.style.display = 'block'
    } else {
        form.style.display === 'block'
        frete.style.display = 'none'
    }


});



