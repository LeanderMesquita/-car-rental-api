<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header">Busque por marca</div>

                    <div class="card-body">
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
                    </div>
                    <div  class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-sm ">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import InputContainerComponent from './utilities/InputContainerComponent.vue'
    export default{
  components: { InputContainerComponent },

    }
</script>
