document.addEventListener('DOMContentLoaded', () => {
    let cep = document.querySelector('input#cep');
    let rua = document.querySelector('input#rua');
    let bairro = document.querySelector('input#bairro');
    let cidade = document.querySelector('input#cidade');
    let estado = document.querySelector('input#estado');
    cep.addEventListener('keyup', (e) => {
	let data = e.target.value;
	if (data.match(/^(\d+){1,8}$/)) {
	    if (data.length == 8) cepApi();
	}
	function cepApi() {
	    fetch('https://viacep.com.br/ws/' + data + '/json/')
		.then(response => response.json())
		.then(json => {
		    rua.value = json.logradouro
		    bairro.value = json.bairro
		    cidade.value = json.localidade
		    estado.value = json.uf
		})
		.catch(err => console.log(err))
	}
    })
    let inputCC = document.querySelector('input#cpf-cnpj');
    let buttonCC = document.querySelector('button#cpf-cnpj');
    let cpfCnpj = document.querySelectorAll('li.cpf-cnpj');
    cpfCnpj.forEach((element, index) => {
	element.addEventListener('click', (e) => {
	    let data = e.target.innerText;
	    buttonCC.innerHTML = data;
	    inputCC.setAttribute('placeholder', 'Insira seu ' + data);
	    if (data == 'CPF') {
		inputCC.setAttribute('maxlength', '14');
	    } else {
		inputCC.setAttribute('maxlength', '18');
	    }
	});
    });
    inputCC.addEventListener('keyup', (e) => {
	let check = buttonCC.innerHTML;
	console.log(check);
	let data = e.target.value;
	if (check == "CPF") {
	    if (data.match(/^(\d+){11}$/)) {
		console.log('Corrige aqui');
		let newData = data.slice(0,3) + '.' + data.slice(3, 6) + '.' + data.slice(6,9) + '-' +data.slice(9,11);
		inputCC.value = newData;
	    } else {
		if (data.match(/^(\d+){3}$/)) {
		    console.log("Adicione um ponto");
		    inputCC.value = data + '.';
		}
		if (data.match(/^(\d+){3}\.(\d+){3}$/)) {
		    inputCC.value = data + '.';
		}
		if (data.match(/^(\d+){3}\.(\d+){3}\.(\d+){3}$/)) {
		    inputCC.value = data + '-';
		}
	    }
	} else {
	    if (data.match(/^(\d+){14}$/)) {
		let newData = data.slice(0,2) + '.' + data.slice(2,5) + '.' + data.slice(5,8) + '.' + data.slice(8,12) + "/" + data.slice(12,14);
		inputCC.value = newData;
	    } else {
		if (data.match(/^(\d+){2}$/)) {
		    inputCC.value = data + '.';
		} else if (data.match(/^(\d+){2}\.(\d+){3}$/)) {
		    inputCC.value = data + '.';
		} else if (data.match(/^(\d+){2}\.(\d+){3}\.(\d+){3}$/)) {
		    inputCC.value = data + '/';
		} else if (data.match(/^(\d+){2}\.(\d+){3}\.(\d+){3}\/(\d+){4}$/)) {
		    inputCC.value = data + '-';
		}
	    }
	}

    });
})
