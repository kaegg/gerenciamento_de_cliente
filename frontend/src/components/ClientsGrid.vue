<template>
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
        <tr v-for="client in clientes" :key="client.id" @click="$emit('editar', client)" style="cursor: pointer">
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
        <tr v-if="clientes.length === 0">
            <td colspan="11" class="text-center text-muted">Nenhum cliente encontrado.</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
    import { defineProps, defineEmits } from 'vue'

    const props = defineProps({
        clientes: {
            type: Array,
            required: true
        }
    });

    const emit = defineEmits(['editar']);

    function formatarData(data) {
        if (!data) return '-';

        const [ano, mes, dia] = data.split('T')[0].split('-');

        const date = new Date(ano, mes - 1, dia);

        return date.toLocaleDateString('pt-BR');
    }

    function formatarEndereco(endereco) {
        if (!endereco) return '-';

        return `${endereco.address}, ${endereco.number} - ${endereco.neighborhood}, ${endereco.city}/${endereco.state}`;
    }
</script>