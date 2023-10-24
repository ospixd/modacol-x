
function controlTag(e) { //bloquear las teclas solo ingresar numero
    tecla = (document.all) ? e.keyCode : e.which; //capturamos lo que se recibe
    if (tecla==8) return true; //validamos si tecla corresponde a backspace 'borrar'
    else if (tecla==0||tecla==9) return true; //validamos si la tecla corresponde a tabular
    patron =/[0-9\s]/; //indica solo permite numeros del 0 al 9
    n = String.fromCharCode(tecla); //
    return patron.test(n); //verificar lo que se esta escribiendo
}

function testText(txtString){
    var stringText = new RegExp(/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/);
    if(stringText.test(txtString)){
        return true;
    }else{
        return false;
    }
}


function testEntero(intCant){
    var intCantidad = new RegExp(/^([0-9])*$/);
    if(intCantidad.test(intCant)){
        return true;
    }else{
        return false;
    }
}


function fntEmailValidate(email){
    var stringEmail = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})$/);
    if (stringEmail.test(email) == false){
        return false;
    }else{
        return true;
    }
}


function fntValidText(){
	let validText = document.querySelectorAll(".validText");
    validText.forEach(function(validText) {
        validText.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!testText(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
                this.classList.add('is-valid');
			}				
		});
	});
}

function fntValidNumber(){
	let validNumber = document.querySelectorAll(".validNumber");
    validNumber.forEach(function(validNumber) {
        validNumber.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!testEntero(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
                this.classList.add('is-valid');
			}				
		});
	});
}

function fntValidEmail(){
	let validEmail = document.querySelectorAll(".validEmail");
    validEmail.forEach(function(validEmail) {
        validEmail.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!fntEmailValidate(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
                this.classList.add('is-valid');
			}				
		});
	});
}

window.addEventListener('load', function() {
	fntValidText();
	fntValidEmail(); 
	fntValidNumber();
}, false);