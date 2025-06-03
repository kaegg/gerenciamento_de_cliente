<template>
    <div class="container mt-5">
        <h2 class="mb-4">Clientes</h2>

        <!-- Filtros -->
        <div class="card mb-4">
            <div class="card-body">
                <form @submit.prevent="filtrarClientes">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-2">
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
                        <div class="col-md-1">
                            <BaseButton class="btn-primary" @click="filtrarClientes"
                                type="button">Buscar</BaseButton>
                        </div>
                        <div class="col-md-1">
                            <BaseButton class="btn-success" @click="cadastrarClientes" type="button">
                                Cadastrar</BaseButton>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabela -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Dt. Nascimento</th>
                        <th>Tp. Pessoa</th>
                        <th>CPF/CNPJ</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Endereço</th>
                        <th>Profissão</th>
                        <th>Status</th>
                        <th>Data Cadastro</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="client in clientesFiltrados" :key="client.id" @click="editarCliente(client)"
                        style="cursor: pointer">
                        <td>{{ client.id }}</td>
                        <td>{{ client.name }}</td>
                        <td>{{ formatarData(client.birth_date) }}</td>
                        <td>{{ client.person_type }}</td>
                        <td>{{ client.cpf_cnpj }}</td>
                        <td>{{ client.email }}</td>
                        <td>{{ client.phone }}</td>
                        <td>{{ formatarEndereco(client.address) }}</td>
                        <td>{{ client.profession?.profession_name || '-' }}</td>
                        <td>{{ client.active ? 'Ativo' : 'Inativo' }}</td>
                        <td>{{ formatarData(client.created_at) }}</td>
                    </tr>
                    <tr v-if="clientesFiltrados.length === 0">
                        <td colspan="11" class="text-center text-muted">Nenhum cliente encontrado.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <DialogRegister :visible="modalVisivel" :modo="modoModal" :cliente="clienteSelecionado" @close="fecharModal" @save="salvarCliente" />


</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import BaseButton from './BaseButton.vue';
import DialogRegister from './DialogRegister.vue'

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

function formatarData(data) {
    if (!data) return '-';

    const date = new Date(data);

    return date.toLocaleDateString('pt-BR');
}

function formatarEndereco(endereco) {
    if (!endereco) return '-';

    return `${endereco.address}, ${endereco.number} - ${endereco.neighborhood}, ${endereco.city}/${endereco.state}`;
}

function cadastrarClientes() {
    clienteSelecionado.value = null;
    modoModal.value = 'cadastro';
    modalVisivel.value = true;
}

function editarCliente(cliente) {
    clienteSelecionado.value = cliente;
    modoModal.value = 'edição';
    modalVisivel.value = true;
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

        clientesFiltrados.value = response.data.clients;
    } catch (error) {
        alert('Erro ao filtrar clientes:', error);
    }
}

async function salvarCliente(dadosCliente) {
    try {

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

        if(modoModal.value == "cadastro"){

            const response = await axios.post('http://localhost:8000/api/clients', data);

        }

        console.log('Resposta:', response.data);

        // fecharModal();
        // filtrarClientes();
    } catch (error) {
        alert('Erro ao filtrar clientes:', error);
    }
}
</script>
