<template>
    <div v-if="visible" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Cliente ({{ props.modo }})</h5>
                    <button type="button" class="btn-close" @click="handleCancel" aria-label="Close"></button>
                </div>

                <form @submit.prevent="handleSubmit" class="modal-body">
                    <div class="row">
                        <!-- Nome -->
                        <div class="mb-3 col-md-6">
                            <label for="nome" class="form-label">Nome *</label>
                            <input id="nome" v-model="form.nome" type="text" class="form-control" required />
                        </div>

                        <!-- Data de Nascimento -->
                        <div class="mb-3 col-md-6">
                            <label for="dataNascimento" class="form-label">Data de Nascimento *</label>
                            <input id="dataNascimento" v-model="form.dataNascimento" type="date" class="form-control"
                                required />
                        </div>

                        <!-- Tipo Pessoa -->
                        <div class="mb-3 col-md-6">
                            <label for="tipoPessoa" class="form-label">Tipo Pessoa *</label>
                            <select id="tipoPessoa" v-model="form.tipoPessoa" class="form-select" required>
                                <option value="F" selected>Física</option>
                                <option value="J">Jurídica</option>
                            </select>
                        </div>

                        <!-- CPF/CNPJ -->
                        <div class="mb-3 col-md-6">
                            <label for="cpfCnpj" class="form-label">CPF/CNPJ *</label>
                            <input id="cpfCnpj" v-model="form.cpfCnpj" type="text" maxlength="18" @input="formataCpfCnpj" class="form-control" required />
                        </div>

                        <!-- Email -->
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">E-mail *</label>
                            <input id="email" v-model="form.email" type="email" class="form-control" required />
                        </div>

                        <!-- Telefone -->
                        <div class="mb-3 col-md-6">
                            <label for="telefone" class="form-label">Telefone *</label>
                            <input id="telefone" v-model="form.telefone" type="tel"  @input="formataTelefone" class="form-control" required />
                        </div>

                        <!-- Status -->
                        <div class="mb-3 col-md-6">
                            <label for="status" class="form-label">Status *</label>
                            <select id="status"
                                v-model="form.status"
                                class="form-select"
                                :disabled="props.modo === 'cadastro'"
                                required
                            >
                                <option value="true">Ativo</option>
                                <option value="false">Inativo</option>
                            </select>
                        </div>

                        <!-- Nome Profissão -->
                        <div class="mb-3 col-md-6">
                            <label for="nomeProfissao" class="form-label">Nome da Profissão *</label>
                            <input id="nomeProfissao" v-model="form.nomeProfissao" type="text" class="form-control"
                                required />
                        </div>

                        <!-- Endereço -->
                        <div class="mb-3 col-md-6">
                            <label for="endereco" class="form-label">Endereço *</label>
                            <input id="endereco" v-model="form.endereco" type="text" class="form-control" required />
                        </div>

                        <!-- Número -->
                        <div class="mb-3 col-md-3">
                            <label for="numero" class="form-label">Número *</label>
                            <input id="numero" v-model="form.numero" type="text" class="form-control" required />
                        </div>

                        <!-- Complemento -->
                        <div class="mb-3 col-md-3">
                            <label for="complemento" class="form-label">Complemento</label>
                            <input id="complemento" v-model="form.complemento" type="text" class="form-control" />
                        </div>

                        <!-- Bairro -->
                        <div class="mb-3 col-md-6">
                            <label for="bairro" class="form-label">Bairro *</label>
                            <input id="bairro" v-model="form.bairro" type="text" class="form-control" required />
                        </div>

                        <!-- Cidade -->
                        <div class="mb-3 col-md-4">
                            <label for="cidade" class="form-label">Cidade *</label>
                            <input id="cidade" v-model="form.cidade" type="text" class="form-control" required />
                        </div>

                        <!-- UF -->
                        <div class="mb-3 col-md-2">
                            <label for="uf" class="form-label">UF *</label>
                            <select id="uf" v-model="form.uf" class="form-select" required>
                                <option value="" disabled>Selecione</option>
                                <option v-for="estado in ufs" :key="estado" :value="estado">{{ estado }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="handleCancel">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</template>

<script setup>
    import { reactive, defineEmits, defineProps, watch } from 'vue';

    const props = defineProps({
        visible: Boolean,
        modo   : {
            type   : String,
            default: 'cadastro',
        },
        cliente: {
            type   : Object,
            default: () => ({})
        }
    });

    const emit = defineEmits(['close', 'save']);

    const ufs = [
        'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'
    ]

    const form = reactive({});

    watch(() => props.visible, (visivel) => {
        if (visivel) {
            if (props.modo === 'edição' && props.cliente) {
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

    // watch(() => props.modo, (novoModo) => {
    //     if (novoModo === 'cadastro') {
    //         form.status = 'true';
    //     }
    // });

    // watch(() => props.visible, (visivel) => {
    //     if (visivel) {
    //         if (props.modo === 'edição' && props.cliente) {
    //             Object.assign(form, props.cliente);
    //         } else {
    //             form.status = 'true';
    //             form.tipoPessoa = 'F';
    //         }
    //     }
    // });

    function formataCpfCnpj() {
        let val = form.cpfCnpj.replace(/\D/g, '')

        if (form.tipoPessoa === 'F') {

            val = val.substring(0, 11)
            val = val.replace(/(\d{3})(\d)/, '$1.$2')
            val = val.replace(/(\d{3})(\d)/, '$1.$2')
            val = val.replace(/(\d{3})(\d{1,2})$/, '$1-$2')

        } else if (form.tipoPessoa === 'J') {

            val = val.substring(0, 14)
            val = val.replace(/^(\d{2})(\d)/, '$1.$2')
            val = val.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3')
            val = val.replace(/\.(\d{3})(\d)/, '.$1/$2')
            val = val.replace(/(\d{4})(\d)/, '$1-$2')

        }

        form.cpfCnpj = val
    }

    function formataTelefone() {
        let val = form.telefone.replace(/\D/g, '');

        if(val.length > 11) val = val.substring(0, 11);

        if(val.length <= 10){
            val = val.replace(/^(\d{2})(\d{4})(\d{0,4})$/, '($1) $2-$3');
        }else{
            val = val.replace(/^(\d{2})(\d{5})(\d{0,4})$/, '($1) $2-$3');
        }

        form.telefone = val;
    }


    function validateForm() {
        for (const key in form) {
            if (key !== 'complemento' && (!form[key] || form[key].toString().trim() === '')) {
                return false;
            }
        }

        return true;
    }

    function limparFormulario(){
        Object.keys(form).forEach(key => {
            form[key] = '';
        });
    }

    function handleSubmit() {
        if (!validateForm()) {
            alert('Por favor, preencha todos os campos obrigatórios.');
            return;
        }

        emit('save', { ...form });

        // limparFormulario();
    }

    function handleCancel(){
        limparFormulario();
        emit('close');
    }
</script>
