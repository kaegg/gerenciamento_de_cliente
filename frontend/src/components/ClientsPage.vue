<template>
    <div class="container mt-5">
        <h2 class="mb-4">Clientes</h2>
        <!-- Filtros -->
        <div class="card mb-4">
            <div class="card-body">
                <form @submit.prevent="filtrarClientes">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-1">
                            <label for="statusSelect" class="form-label">Status</label>
                            <select id="statusSelect" v-model="filtros.status" class="form-select">
                                <option value="">Todos</option>
                                <option value="ativo">Ativo</option>
                                <option value="inativo">Inativo</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="nomeCliente" class="form-label">Nome (contém)</label>
                            <input type="text" id="nomeCliente" v-model="filtros.nome" class="form-control"placeholder="Digite o nome" />
                        </div>
                        <div class="col-md-2">
                            <label for="dataInicio" class="form-label">Data Início</label>
                            <input type="date" id="dataInicio" v-model="filtros.dataInicio" class="form-control" />
                        </div>
                        <div class="col-md-2">
                            <label for="dataFim" class="form-label">Data Fim</label>
                            <input type="date" id="dataFim" v-model="filtros.dataFim" class="form-control" />
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-outline-primary" @click="filtrarClientes" type="button">Buscar</button>
                            <button class="btn btn-outline-success mx-2" @click="cadastrarClientes" type="button">Cadastrar</button>
                            <button class="btn btn-outline-warning" @click="limparFormulario" type="button">Limpar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <ClientsGrid :clientes="clientesFiltrados" @editar="editarCliente" />
    </div>

    <DialogRegister :visible="modalVisivel" :modo="modoModal" :cliente="clienteSelecionado" @close="fecharModal" @save="salvarCliente" />

</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import axios              from 'axios';
    import ClientsGrid        from './ClientsGrid.vue';
    import DialogRegister     from './DialogRegister.vue';

    const modalVisivel       = ref(false);
    const modoModal          = ref('cadastro');
    const clienteSelecionado = ref(null);
    const clientesFiltrados  = ref([]);

    const filtros = ref({
        status    : '',
        dataInicio: '',
        dataFim   : '',
        nome      : ''
    });

    function cadastrarClientes() {
        clienteSelecionado.value = null;
        modoModal.value          = 'cadastro';
        modalVisivel.value       = true;
    }

    function editarCliente(cliente) {
        clienteSelecionado.value = cliente;
        modoModal.value          = 'edição';
        modalVisivel.value       = true;
    }

    function fecharModal() {
        modalVisivel.value       = false;
        clienteSelecionado.value = null;
    }

    async function filtrarClientes(){
        try {
            const params = {
                created_at_begins: filtros.value.dataInicio || '',
                created_at_end   : filtros.value.dataFim    || '',
                active           : filtros.value.status === 'ativo'   ? 1 :
                                   filtros.value.status === 'inativo' ? 0 : '',
                name             : filtros.value.nome       || ''
            };

            const response = await axios.get('http://localhost:8000/api/clients', { params });

            if(response.data.clients.length == 0){

                alert("Não foi possível encontrar clientes com o filtro informado.");

            }else{
                
                clientesFiltrados.value = response.data.clients;

            }
        } catch (error) {
            alert('Erro ao filtrar clientes: ' + error);
        }
    }

    async function salvarCliente(dadosCliente) {
        const data = {
            "name"           : dadosCliente.nome,
            "birth_date"     : dadosCliente.dataNascimento,
            "person_type"    : dadosCliente.tipoPessoa,
            "cpf_cnpj"       : dadosCliente.cpfCnpj,
            "email"          : dadosCliente.email,
            "phone"          : dadosCliente.telefone,
            "address"        : dadosCliente.endereco,
            "number"         : dadosCliente.numero,
            "neighborhood"   : dadosCliente.bairro,
            "complement"     : dadosCliente.complemento,
            "city"           : dadosCliente.cidade,
            "state"          : dadosCliente.uf,
            "profession_name": dadosCliente.nomeProfissao,
            "active"         : String(dadosCliente.status).toLowerCase() === "true"
        }

        if (modoModal.value == "cadastro") {

            await axios.post('http://localhost:8000/api/clients', data)
            .then((resp) => {
                alert(resp.data.message);
                fecharModal();
                filtrarClientes();
            }).catch((error) => {
                tratarErroReq(error, 'cadastrar');
            });

        } else {

            const id = dadosCliente.id;

            await axios.put(`http://localhost:8000/api/clients/${id}`, data)
            .then((resp) => {
                alert(resp.data.message);
                fecharModal();
                filtrarClientes();
            }).catch((error) => {
                tratarErroReq(error, 'atualizar');
            });

        }
    }

    function tratarErroReq(error, acao) {
        if (error.response) {
            const resposta = error.response.data;

            if (resposta.errors) {
                let mensagens = [];

                for (const campo in resposta.errors) {
                    mensagens.push(...resposta.errors[campo]);
                }

                alert(`Ocorreu um erro ao ${acao} o cliente. Detalhes:\n` + mensagens.join('\n'));
            } else if (resposta.message) {
                alert(`Erro ao ${acao} o cliente: ${resposta.message}`);
            }
        } else {
            alert(`Ocorreu um erro ao ${acao} o cliente. Tente novamente.`);
        }
    }

    function limparFormulario(){
        try {

            clientesFiltrados.value  = [];
            filtros.value.status     = '';
            filtros.value.dataInicio = '';
            filtros.value.dataFim    = '';
            filtros.value.nome       = '';

        } catch (error) {
            alert("Ocorreu um erro ao limpar o formulário");
        }
    }
</script>
