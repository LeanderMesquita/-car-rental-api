<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <card-component title="Busque por marca">
                    <template v-slot:content>
                        <div class="row">
                            <div class="col mb-3">
                                <input-container-component title="Pesquise por ID" id="inputID" idHelper="idHelper" helper="Pesquise utilizando o número de indentificação (ID).">
                                    <input type="number" class="form-control" id="inputID" placeholder="ID da marca" aria-describedby="IDhelper">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component title="Pesquise pelo nome" id="nameInput" idHelper="nameHelper" helper="Pesquise utilizando o nome da marca.">
                                    <input type="text" class="form-control" placeholder="Nome da marca" id="nameInput" aria-describedby="nameHelper">
                                </input-container-component>
                            </div>
                        </div>
                    </template>
                    <template v-slot:footer>
                        <button type="submit" class="btn btn-primary btn-sm ">Search</button>
                    </template>
                </card-component>

                <card-component title="Tabela">
                    <template v-slot:content>
                        <table-component>
                            
                        </table-component>
                    </template>
                    <template v-slot:footer>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalMarca">
                        Adicionar
                        </button>
                    </template>
                </card-component>

                <modal-component id="modalMarca" title="Adicionar nova marca">
                    <template v-slot:content>
                        <div class="col mb-3">
                            <input-container-component title="Nome" id="createName" idHelper="createNameHelper" helper="Informe o nome da marca a ser cadastrada">
                                <input type="text" class="form-control" id="createName" placeholder="Nome da marca" aria-describedby="createNameHelper">
                            </input-container-component>
                        </div>
                        <div class="col mb-3">
                            <input-container-component title="Logo da marca" id="insertFile" idHelper="fileHelper" helper="Selecione uma imagem no formato .png">
                                <input type="file" class="form-control" id="insertFile" aria-describedby="fileHelper">
                            </input-container-component>
                        </div>
                    </template>
                </modal-component>
            </div>
        </div>
    </div>
</template>

<script>
import CardComponent from './utilities/CardComponent.vue'
import InputContainerComponent from './utilities/InputContainerComponent.vue'
import ModalComponent from './utilities/ModalComponent.vue'
import TableComponent from './utilities/TableComponent.vue'

    export default{
  components: { InputContainerComponent, TableComponent, CardComponent, ModalComponent },

    }
</script>
