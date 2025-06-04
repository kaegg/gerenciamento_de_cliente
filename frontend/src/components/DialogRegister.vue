<template>
    <div v-if="visible" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Cliente ({{ props.modo }})</h5>
                    <button type="button" class="btn-close" @click="handleCancel" aria-label="Close"></button>
                </div>

                <form @submit.prevent="handleSubmit" class="modal-body">
                    <!-- Etapa 1: Dados Pessoais -->
                    <div v-if="etapaAtual === 1">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome *</label>
                            <input id="nome" v-model="form.nome" type="text" class="form-control" maxlength="255" />
                            <div v-if="erros.nome" class="text-danger">{{ erros.nome }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="dataNascimento" class="form-label">Data de Nascimento *</label>
                            <input id="dataNascimento" v-model="form.dataNascimento" type="date" class="form-control" />
                            <div v-if="erros.dataNascimento" class="text-danger">{{ erros.dataNascimento }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="tipoPessoa" class="form-label">Tipo Pessoa *</label>
                            <select id="tipoPessoa" v-model="form.tipoPessoa" class="form-select">
                                <option value="F">Física</option>
                                <option value="J">Jurídica</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="cpfCnpj" class="form-label">CPF/CNPJ *</label>
                            <input id="cpfCnpj" v-model="form.cpfCnpj" type="text" maxlength="18" @input="formataCpfCnpj" class="form-control" />
                            <div v-if="erros.cpfCnpj" class="text-danger">{{ erros.cpfCnpj }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail *</label>
                            <input id="email" v-model="form.email" type="email" class="form-control" maxlength="255" />
                            <div v-if="erros.email" class="text-danger">{{ erros.email }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone *</label>
                            <input id="telefone" v-model="form.telefone" type="tel" @input="formataTelefone" class="form-control" />
                            <div v-if="erros.telefone" class="text-danger">{{ erros.telefone }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select id="status" v-model="form.status" class="form-select" :disabled="props.modo === 'cadastro'">
                                <option value="true">Ativo</option>
                                <option value="false">Inativo</option>
                            </select>
                        </div>
                    </div>

                    <!-- Etapa 2: Endereço -->
                    <div v-if="etapaAtual === 2">
                        <div class="mb-3">
                            <label for="endereco" class="form-label">Endereço *</label>
                            <input id="endereco" v-model="form.endereco" type="text" class="form-control" maxlength="255" />
                            <div v-if="erros.endereco" class="text-danger">{{ erros.endereco }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="numero" class="form-label">Número *</label>
                            <input id="numero" v-model="form.numero" type="text" class="form-control" />
                            <div v-if="erros.numero" class="text-danger">{{ erros.numero }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="complemento" class="form-label">Complemento</label>
                            <input id="complemento" v-model="form.complemento" type="text" class="form-control" maxlength="255" />
                        </div>

                        <div class="mb-3">
                            <label for="bairro" class="form-label">Bairro *</label>
                            <input id="bairro" v-model="form.bairro" type="text" class="form-control" maxlength="255" />
                            <div v-if="erros.bairro" class="text-danger">{{ erros.bairro }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="cidade" class="form-label">Cidade *</label>
                            <input id="cidade" v-model="form.cidade" type="text" class="form-control" maxlength="255" />
                            <div v-if="erros.cidade" class="text-danger">{{ erros.cidade }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="uf" class="form-label">UF *</label>
                            <select id="uf" v-model="form.uf" class="form-select">
                                <option value="" disabled>Selecione</option>
                                <option v-for="estado in ufs" :key="estado" :value="estado">{{ estado }}</option>
                            </select>
                            <div v-if="erros.uf" class="text-danger">{{ erros.uf }}</div>
                        </div>
                    </div>

                    <!-- Etapa 3: Profissão -->
                    <div v-if="etapaAtual === 3">
                        <div class="mb-3">
                            <label for="nomeProfissao" class="form-label">Profissão *</label>
                            <select id="nomeProfissao" v-model="form.nomeProfissao" class="form-select">
                                <option value="">Selecione</option>
                                <option v-for="profissao in profissoes" :key="profissao" :value="profissao">{{ profissao }}</option>
                            </select>
                            <div v-if="erros.nomeProfissao" class="text-danger">{{ erros.nomeProfissao }}</div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" @click="handleCancel">Cancelar</button>
                        <button type="button" class="btn btn-outline-primary" v-if="etapaAtual > 1" @click="etapaAtual--">Voltar</button>
                        <button type="button" class="btn btn-outline-primary" v-if="etapaAtual < 3" @click="etapaAtual++">Avançar</button>
                        <button type="submit" class="btn btn-success" v-if="etapaAtual === 3">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { reactive, defineProps, defineEmits, watch, ref, onMounted } from 'vue';
    import axios from 'axios';

    const props = defineProps({
        visible: Boolean,
        modo   : String,
        cliente: Object
    });

    const emit       = defineEmits(['close', 'save']);
    const etapaAtual = ref(1);
    const ufs        = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];
    const profissoes = ref([]);
    const form       = reactive({});
    const erros      = reactive({});

    onMounted(async () => {
        try {
            const response = await axios.get('http://localhost:8000/api/professions');

            if (response.data.status) {

                profissoes.value = response.data.professions.map(profissao => profissao.profession_name);

            } else {
                
                alert('Não foi possível recuperar os dados de profissão');

            }
        } catch (error) {
            alert('Erro ao buscar profissões: ' + error);
        }
    });

    watch(() => props.visible, (visivel) => {
        if(visivel) {
            etapaAtual.value = 1;
        
            if (props.modo === 'edição' && props.cliente) {
                form.id             = props.cliente.id || null
                form.nome           = props.cliente.name || '';
                form.dataNascimento = props.cliente.birth_date || '';
                form.tipoPessoa     = props.cliente.person_type || 'F';
                form.cpfCnpj        = props.cliente.cpf_cnpj || '';
                form.email          = props.cliente.email || '';
                form.telefone       = props.cliente.phone || '';
                form.status         = props.cliente.active ? 'true' : 'false';
                form.endereco       = props.cliente.address?.address || '';
                form.numero         = props.cliente.address?.number || '';
                form.bairro         = props.cliente.address?.neighborhood || '';
                form.complemento    = props.cliente.address?.complement || '';
                form.cidade         = props.cliente.address?.city || '';
                form.uf             = props.cliente.address?.state || '';
                form.nomeProfissao  = props.cliente.profession?.profession_name || '';

                formataCpfCnpj();
                formataTelefone();
            } else {
                form.id             = null;
                form.nome           = '';
                form.dataNascimento = '';
                form.tipoPessoa     = 'F';
                form.cpfCnpj        = '';
                form.email          = '';
                form.telefone       = '';
                form.status         = 'true';
                form.endereco       = '';
                form.numero         = '';
                form.bairro         = '';
                form.complemento    = '';
                form.cidade         = '';
                form.uf             = '';
                form.nomeProfissao  = '';
            }
        }
    });

    function formataCpfCnpj() {
        let val = form.cpfCnpj.replace(/\D/g, '');

        if (form.tipoPessoa === 'F') {

            val = val.substring(0, 11).replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            
        } else {
            
            val = val.substring(0, 14).replace(/^(\d{2})(\d)/, '$1.$2').replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3').replace(/\.(\d{3})(\d)/, '.$1/$2').replace(/(\d{4})(\d)/, '$1-$2');

        }

        form.cpfCnpj = val;
    }

    function formataTelefone() {
        let val = form.telefone.replace(/\D/g, '');

        if (val.length > 11){
            
            val = val.substring(0, 11);

        }

        form.telefone = val.length <= 10 ? val.replace(/^(\d{2})(\d{4})(\d{0,4})$/, '($1) $2-$3') : val.replace(/^(\d{2})(\d{5})(\d{0,4})$/, '($1) $2-$3');
    }

    function limparFormulario() {
        Object.keys(form).forEach(key => form[key] = '');
        Object.keys(erros).forEach(key => erros[key] = '');
    }

    function validarEtapa() {
        Object.keys(erros).forEach(key => erros[key] = '');

        if (etapaAtual.value === 1) {

            if (!form.nome)                                                     erros.nome           = 'Campo obrigatório';
            if (!form.dataNascimento)                                           erros.dataNascimento = 'Campo obrigatório';
            if (!form.cpfCnpj || form.cpfCnpj.replace(/\D/g, '').length < 11)   erros.cpfCnpj        = 'CPF/CNPJ inválido';
            if (!form.email || !/^\S+@\S+\.\S+$/.test(form.email))              erros.email          = 'E-mail inválido';
            if (!form.telefone || form.telefone.replace(/\D/g, '').length < 10) erros.telefone       = 'Telefone inválido';

        } else if (etapaAtual.value === 2) {

            if (!form.endereco) erros.endereco = 'Campo obrigatório';
            if (!form.numero)   erros.numero   = 'Campo obrigatório';
            if (!form.bairro)   erros.bairro   = 'Campo obrigatório';
            if (!form.cidade)   erros.cidade   = 'Campo obrigatório';
            if (!form.uf)       erros.uf       = 'Campo obrigatório';
        
        } else if (etapaAtual.value === 3) {
        
            if (!form.nomeProfissao) erros.nomeProfissao = 'Campo obrigatório';
        
        }

        return Object.values(erros).every(err => !err);
    }

    function handleSubmit() {
        if (validarEtapa()){
            emit('save', { ...form });
        }
    }

    function handleCancel() {
        limparFormulario();
        emit('close');
    }
</script>

<style scoped>
    .text-danger {
        font-size: 0.9em;
    }
</style>
