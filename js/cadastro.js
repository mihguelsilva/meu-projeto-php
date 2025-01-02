let b;
document.addEventListener('DOMContentLoaded', () => {
    let registrar = document.querySelector('button#registrar');
    let cep = document.querySelector('input#cep');
    let rua = document.querySelector('input#rua');
    let bairro = document.querySelector('input#bairro');
    let cidade = document.querySelector('input#cidade');
    let estado = document.querySelector('input#estado');
    let divCep = document.querySelector('div#mensagem-cep');
    cep.addEventListener('keyup', (e) => {
	let data = e.target.value;
	if (data.match(/^(\d+){8}$/)) {
	    divCep.removeAttribute('class');
	    divCep.setAttribute('class', 'valid-feedback');
	    divCep.innerText = 'CEP preenchido corretamente!';
	    registrar.removeAttribute('disabled');
	    if (data.length == 8) cepApi();
	} else {
	    divCep.removeAttribute('class');
	    divCep.setAttribute('class', 'invalid-feedback');
	    divCep.innerText = 'Você precisa preencher os 8 números do CEP!';
	    registrar.setAttribute('disabled', 'true');
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
    });
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
    let numero = document.querySelector('input#numero');
    let divNumero = document.querySelector('div#mensagem-numero');
    numero.addEventListener('keyup', (e) => {
	let v = e.target.value;
	if (v.match(/^\d+$/)) {
	    divNumero.removeAttribute('class');
	    divNumero.setAttribute('class', 'valid-feedback');
	    divNumero.innerText = 'Campo preenchido corretamente';
	    registrar.removeAttribute('disabled');
	} else {
	    divNumero.removeAttribute('class');
	    divNumero.setAttribute('class', 'invalid-feedback');
	    divNumero.innerText = 'Preencha apenas com números!';
	    registrar.setAttribute('disabled', 'true')
	}
    })
    let buttonTelefone = document.querySelectorAll('button.telefone');
    buttonTelefone.forEach((element, index) => {
	b = 0;
	element.addEventListener('click', (e) => {
	    b++;
	    let nome = e.target.getAttribute('id');
	    let num;
	    (nome == 'residencial' || nome == 'comercial') ? num = '08133333333' : num = '081999999999';
	    criarCampoTelefone(b, num, nome, e.target);
	});
    });
    function criarCampoTelefone(inc, numero, nome, elemento) {
	let checkInput = document.querySelectorAll('input.definir-telefone-' + nome);
	if(checkInput.length == 3) {
	    Swal.fire({
		title: 'Erro!',
		text: 'Você só pode registrar 3 telefones ' + nome + '!',
		icon: 'error',
		confirmButtonText: 'Fechar'
	    });
	} else {
	    let div = document.createElement('div');
	    div.setAttribute('class', 'input-group mt-3');
	    div.setAttribute('id', nome+inc);
	    let button = document.createElement('button');
	    button.setAttribute('type', 'button');
	    button.setAttribute('id', nome+inc);
	    button.setAttribute('class', 'btn btn-danger');
	    button.setAttribute('onclick', 'removerTelefone(this)')
	    button.append('X');
	    let telRes = document.createElement('input');
	    telRes.setAttribute('id', nome+inc);
	    telRes.setAttribute('class', 'form-control p-1 input-telefone definir-telefone-' + nome);
	    telRes.setAttribute('name', nome+'[]');
	    if(nome == 'residencial' || nome == 'comercial') {
		telRes.setAttribute('maxlength', '11');
	    } else {
		telRes.setAttribute('maxlength', '12');
	    }
	    telRes.setAttribute('onkeyup', 'verificar(this)');
	    telRes.setAttribute('placeholder', numero);
	    div.append(telRes);
	    div.append(button);
	    elemento.after(div);
	}
    }
    let senha = document.querySelector('input#senha');
    let rSenha = document.querySelector('input#repetir-senha');
    let divMensagem = document.querySelector('div#mensagem');
    senha.addEventListener('keyup', (e) => {
	let v = e.target.value;
	verificarSenha(v, rSenha.value)
    });
    rSenha.addEventListener('keyup', (e) => {
	let v = e.target.value;
	verificarSenha(v, senha.value)
    });
    function verificarSenha(valor1, valor2) {
	if (valor1 != valor2 || valor1 == "" || valor2 == "") {
	    registrar.setAttribute('disabled', 'true');
	    divMensagem.removeAttribute('class');
	    divMensagem.setAttribute('class', 'invalid-feedback');
	    divMensagem.innerText = 'senhas não coincidem';
	} else if (valor1 == valor2 && valor1 != "" && valor2 != "") {
	    registrar.removeAttribute('disabled');
	    divMensagem.removeAttribute('class');
	    divMensagem.setAttribute('class', 'valid-feedback');
	    divMensagem.innerText = 'senhas coincidem';
	}
    }
    let nomeUsuario = document.querySelector('input#nome');
    let usuario = document.querySelector('input#usuario');
    nomeUsuario.addEventListener('keyup', (e) => {
	let v = e.target.value;
	let vArray = v.split(' ');
	let vPrimeiro = vArray[0].toLowerCase();
	let vUltimo = vArray.pop().toLowerCase();
	let username = vPrimeiro + '.' + vUltimo;
	usuario.setAttribute('value', username);
    })
});
function removerTelefone(e) {
    let id = e.getAttribute('id');
    let divTel = document.querySelector('div#' + id);
    let inputTel = document.querySelector('input#' + id);
    inputTel.remove();
    e.remove();
    divTel.remove();
    b = b - 1;
}

function verificar(e) {
    let v = e.value;
    if(!v.match(/^\d+$/)) {
	Swal.fire({
	    title: 'Erro!',
	    text: 'O campo só pode ser preenchido com números!',
	    icon: 'error',
	    confirmButtonText: 'Fechar'
	});
	e.value = '';
    };
}
