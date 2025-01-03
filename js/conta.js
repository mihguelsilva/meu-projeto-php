document.addEventListener('DOMContentLoaded', () => {
    let thCpfCnpj = document.querySelector('th#td-cpf-cnpj');
    let tdCpfCnpj = document.querySelector('td#cpf-cnpj');
    if (tdCpfCnpj.innerText.length == 11) {
	thCpfCnpj.innerText = 'CPF';
	let v = tdCpfCnpj.innerText
	newCpfCnpj = v.slice(0,3) + '.' + v.slice(3,6) + '.' + v.slice(6,9) + '-' + v.slice(9,11);
	tdCpfCnpj.innerText = newCpfCnpj;
    } else {
	thCpfCnpj.innerText = 'CNPJ';
    }
    let altTel = document.querySelectorAll('button.alterar-telefone');
    altTel.forEach((element, index) => {
	element.addEventListener('click', (e) => {
	    desabilitarBotaoEditar(document.querySelectorAll('button.alterar-telefone'));
	    let tagName = e.target.parentElement.tagName;
	    let parent = e.target.parentElement;
	    if (tagName == "TD") {
		setGetForm(parent)
	    } else if (tagName == 'BUTTON') {
		setGetForm(parent.parentElement);
	    }
	    function setGetForm(parent) {
		let id_tel = parent.getAttribute('id');
		let db_fld = parent.getAttribute('name');
		parent.innerHTML = '';
		let getForm = document.createElement('form');
		getForm.setAttribute('method', 'POST');
		getForm.setAttribute('class', 'was-validated');
		getForm.setAttribute('action', '/ops/usuario.php');
		let input_id = document.createElement('input');
		input_id.setAttribute('name', 'id');
		input_id.setAttribute('value', id_tel);
		input_id.setAttribute('readonly', true);
		input_id.setAttribute('style', 'display:none;');
		let input_name = document.createElement('input');
		input_name.setAttribute('name', 'type');
		input_name.setAttribute('value', db_fld);
		input_name.setAttribute('readonly', true);
		input_name.setAttribute('style', 'display:none;');
		let input_fld = document.createElement('input');
		input_fld.setAttribute('name', 'fld');
		input_fld.setAttribute('value', 'telefone');
		input_fld.setAttribute('readonly', true);
		input_fld.setAttribute('style', 'display:none;');
		let input_ctt = document.createElement('input');
		input_ctt.setAttribute('onkeyup', 'verificarTelefone(this)');
		input_ctt.setAttribute('name', 'ctt');
		input_ctt.setAttribute('class', 'form-control');
		if (db_fld == 'HOME' || db_fld == 'BUSINESS') {
		    input_ctt.setAttribute('maxlength', '11');
		} else if (db_fld == 'CELL') {
		    input_ctt.setAttribute('maxlength', '12');
		}
		let button = document.createElement('button');
		button.setAttribute('type', 'submit');
		button.setAttribute('class', 'btn btn-outline-primary');
		button.setAttribute('name', 'action');
		button.setAttribute('value', 'atualizar')
		button.append('Alterar');
		let cancelar = document.createElement('a');
		cancelar.setAttribute('href', '/page/conta.php');
		let buttonCancelar = document.createElement('button');
		buttonCancelar.setAttribute('class', 'btn btn-outline-danger');
		buttonCancelar.setAttribute('type', 'button');
		buttonCancelar.append('Calcelar');
		cancelar.append(buttonCancelar);
		getForm.append(input_id);
		getForm.append(input_name);
		getForm.append(input_fld);
		getForm.append(input_ctt);
		getForm.append(button);
		getForm.append(cancelar);
		parent.append(getForm);
	    }
	});
    });
    function desabilitarBotaoEditar(e) {
	e.forEach((element, index) => {
	    element.setAttribute('disabled', 'true');
	})
    }
    let buttonCC = document.querySelector('button#cpf-cnpj');
    let inputCC = document.querySelector('input#cpf-cnpj');
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
		} else if (data.match(/^(\d+){3}\.(\d+){3}$/)) {
		    inputCC.value = data + '.';
		} else if (data.match(/^(\d+){3}\.(\d+){3}\.(\d+){3}$/)) {
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
    
    let alterarAcesso = document.querySelector('button#alterar-acesso');
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
	    alterarAcesso.setAttribute('disabled', 'true');
	    divMensagem.removeAttribute('class');
	    divMensagem.setAttribute('class', 'invalid-feedback');
	    divMensagem.innerText = 'senhas não coincidem';
	} else if (valor1 == valor2 && valor1 != "" && valor2 != "") {
	    alterarAcesso.removeAttribute('disabled');
	    divMensagem.removeAttribute('class');
	    divMensagem.setAttribute('class', 'valid-feedback');
	    divMensagem.innerText = 'senhas coincidem';
	}
    }
    let endereco = document.querySelector('button#alterar');
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
	    alterar.removeAttribute('disabled');
	    if (data.length == 8) cepApi();
	} else {
	    divCep.removeAttribute('class');
	    divCep.setAttribute('class', 'invalid-feedback');
	    divCep.innerText = 'Você precisa preencher os 8 números do CEP!';
	    endereco.setAttribute('disabled', 'true');
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
});

function verificarTelefone(e) {
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
