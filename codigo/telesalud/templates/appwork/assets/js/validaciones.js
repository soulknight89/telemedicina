function onlyAlphabet (text) {
	return text.replace(/[^Ñña-zA-Z ]/g, '');
}

function onlyAlphaNumeric (text) {
	return text.replace(/[^Ñña-zA-Z0-9 ]/g, '');
}

function onlyAlphaNumericNonSpace (text) {
	return text.replace(/[^Ñña-zA-Z0-9]/g, '');
}

function validarTelefono (numero) {
	numero = numero.replace(/[^0-9]/g, '');
	if (!isNaN(numero) && numero < 1000000000 && numero > 0) {
		return numero;
	} else {
		alert('Numero no valido');
		return numero;
	}
}

function validarDinero (numero) {
	numero = numero.replace(/[^0-9.]/g, '');
	if (!isNaN(numero) && numero < 1000 && numero > -1) {
		return numero;
	} else {
		alert('Precio no valido');
		return '';
	}
}
