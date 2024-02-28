<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <card-component title="Busque por marca">
                    <template v-slot:content>
                        <div class="row">
                            <div class="col mb-3">
                                <input-container-component title="Pesquise por ID" id="inputID" idHelper="idHelper" helper="Pesquise utilizando o número de indentificação (ID).">
                                    <input type="number" class="form-control" id="inputID" placeholder="ID da marca" aria-describedby="IDhelper" v-model="search.id">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component title="Pesquise pelo nome" id="nameInput" idHelper="nameHelper" helper="Pesquise utilizando o nome da marca.">
                                    <input type="text" class="form-control" placeholder="Nome da marca" id="nameInput" aria-describedby="nameHelper" v-model="search.nome">
                                </input-container-component>
                            </div>
                        </div>
                    </template>
                    <template v-slot:footer>
                        <button type="submit" class="btn btn-primary btn-sm " @click="seeker()">Search</button>
                    </template>
                </card-component>

                <card-component title="Tabela">
                    <template v-slot:content>
                        <table-component 
                        :info="marcas.data" 
                        :view="{ visible: true, dataToggle: 'modal', dataTarget:'#modalMarcaView'}"
                        :update="{ visible: true, dataToggle: 'modal', dataTarget:'#modalMarcaUpdate'}"
                        :drop="{ visible: true, dataToggle: 'modal', dataTarget:'#modalMarcaDrop'}"
                        :titles="{
                            id: {title: 'ID', type:'text'},
                            nome: {title: 'Nome', type:'text'},
                            imagem: {title: 'Imagem', type:'image'},
                            
                        }">
                        </table-component>
                    </template>
                    <template v-slot:footer>
                            <div class="col-10">
                                <paginate-component>
                                    <li :class="item.active ? 'page-item active' : 'page-item'" v-for="item, key in marcas.links" :key="key" @click="paginate(item)">
                                        <a class="page-link" v-html="item.label"></a>
                                    </li>
                                </paginate-component>
                            </div>
                            <div class="col">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalMarca">Adicionar</button>
                            </div>
                    </template>
                </card-component>

                <modal-component id="modalMarca" title="Adicionar nova marca">
                    <template v-slot:alert>
                        <alert-component type="success" :details="transactionDetails" title="Marca cadastrada com sucesso!" v-if="transactionStts == 'added'"></alert-component>
                        <alert-component type="danger" :details="transactionDetails" title="Erro ao cadastrar a marca" v-if="transactionStts == 'error'"></alert-component>
                    </template>
                    <template v-slot:content>
                        <div class="col mb-3">
                            <input-container-component title="Nome" id="createName" idHelper="createNameHelper" helper="Informe o nome da marca a ser cadastrada">
                                <input type="text" class="form-control" id="createName" placeholder="Nome da marca" aria-describedby="createNameHelper" v-model="marcaName">
                            </input-container-component>
                            
                        </div>
                        <div class="col mb-3">
                            <input-container-component title="Logo da marca" id="insertFile" idHelper="fileHelper" helper="Selecione uma imagem no formato .png">
                                <input type="file" class="form-control" id="insertFile" aria-describedby="fileHelper" @change="loadFile($event)">
                            </input-container-component>
                            
                        </div>
                    </template>
                    <template v-slot:footer>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary btn-sm " @click="save()">Adicionar</button>
                    </template>
                </modal-component>

                <modal-component id="modalMarcaView" title="Visualizar marca">
                    <template v-slot:alert></template>
                    <template v-slot:content>
                        <input-container-component title="ID">
                            <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                        </input-container-component>
                        <input-container-component title="Nome da Marca">
                            <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                        </input-container-component>
                        <input-container-component title="Imagem">
                            <img :src="'storage/'+$store.state.item.imagem" alt="" v-if="$store.state.item.imagem">
                        </input-container-component>
                    </template>
                    <template v-slot:footer>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Fechar</button>
                    </template>
                </modal-component>

                <modal-component id="modalMarcaUpdate" title="Atualizar marca">
                    <template v-slot:alert>
                        <alert-component type="success" title="Ação realizada." :details="$store.state.transation" v-if="$store.state.transation.status == 'success'"></alert-component>
                        <alert-component type="danger" title="Erro!" :details="$store.state.transation" v-if="$store.state.transation.status == 'error'"></alert-component>
                    </template>
                    <template v-slot:content>
                        <div class="col mb-3">
                            <input-container-component title="Nome" id="updateName" idHelper="updateNameHelper" helper="Informe o nome a ser atualizado">
                                <input type="text" class="form-control" id="updateName" placeholder="Nome da marca" aria-describedby="updateNameHelper" v-model="$store.state.item.nome">
                            </input-container-component>
                            
                        </div>
                        <div class="col mb-3">
                            <input-container-component title="Logo da marca" id="insertFile" idHelper="fileHelper" helper="Selecione uma nova imagem no formato .png">
                                <input type="file" class="form-control" id="insertFile" aria-describedby="fileHelper" @change="loadFile($event)">
                            </input-container-component>
                            
                        </div>
                    </template>
                    <template v-slot:footer>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary btn-sm " @click="update()">Adicionar</button>
                    </template>
                </modal-component>

                <modal-component id="modalMarcaDrop" title="Remover marca">
                    <template v-slot:alert>
                        <alert-component type="success" title="Ação realizada." :details="$store.state.transation" v-if="$store.state.transation.status == 'success'"></alert-component>
                        <alert-component type="danger" title="Erro!" :details="$store.state.transation" v-if="$store.state.transation.status == 'error'"></alert-component>
                    </template>
                    <template v-slot:content v-if="$store.state.transation.status != 'success'">
                        <input-container-component title="ID">
                            <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                        </input-container-component>
                        <input-container-component title="Nome da Marca">
                            <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                        </input-container-component>
                    </template>
                    <template v-slot:footer>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Fechar</button>
                        <button v-if="$store.state.transation.status != 'success'" type="button" class="btn btn-danger btn-sm" @click="drop()">Excluir</button>
                    </template>
                </modal-component>

                
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import CardComponent from './utilities/CardComponent.vue'
import InputContainerComponent from './utilities/InputContainerComponent.vue'
import ModalComponent from './utilities/ModalComponent.vue'
import TableComponent from './utilities/TableComponent.vue'
import AlertComponent from './utilities/AlertComponent.vue'
import PaginateComponent from './utilities/PaginateComponent.vue'

    export default{
        components: { InputContainerComponent, TableComponent, CardComponent, ModalComponent, AlertComponent},
        data(){
     
                return {
                baseURL: 'http://127.0.0.1:8000/api/auth/marca',
                paginateURL: '',
                URLfilter: '',
                marcaName: '',
                imageFile: [],
                transactionStts: '',
                transactionDetails: {},
                marcas: { data: []},
                search: { id:'', nome:''}
            }
        },
        computed: {
                token(){
                    let token = document.cookie.split(';').find(i => {
                        return i.includes('token=');
                    });
                    token = token.split('=')[1]
                    token = 'Bearer ' + token
                    
                    return token;
                }
            },
        methods: {
            update(){
                let formData = new FormData();
                formData.append('_method', 'patch')
                formData.append('nome', this.$store.state.item.nome)

                if(this.imageFile[0]){
                    formData.append('imagem', this.imageFile[0])
                }

                let url = this.baseURL + '/' + this.$store.state.item.id

                const config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }

                axios.post(url, formData, config)
                    .then(response => {
                        this.$store.state.transation.status = 'success'
                        this.$store.state.transation.message = response.data
                        insertFile.value = ''
                        this.showList()
                    })
                    .catch(errors => {
                        this.$store.state.transation.status = 'error'
                        this.$store.state.transation.message = errors.response.data.message
                        this.$store.state.transation.info = errors.response.data.errors
                    })
            },
            drop(){
                const confirmation = confirm('Tem certeza que deseja remover esse registro?')
                if(!confirmation) return false

                let url = this.baseURL + '/' + this.$store.state.item.id
              
                
                const formData = new FormData()
                formData.append('_method', 'delete')
                const config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }
                
                axios.post(url, formData, config)
                    .then(response => {
                        
                        this.$store.state.transation.status = 'success'
                        this.$store.state.transation.message = response.data
                        this.showList()
                    })
                    .catch(errors => {
                       
                        this.$store.state.transation.status = 'error'
                        this.$store.state.transation.message = errors.response.data
                    })
            },
            seeker(){
                let filter = ''
                for (let key in this.search){
                    if(this.search[key]){
                        if(filter != ''){
                            filter += ';'
                        }
                        filter += key + ':like:' + this.search[key]
                    }
                }
                if(filter != ''){
                    this.paginateURL = 'page=1'
                    this.URLfilter = '&filter='+filter
                }else{
                    this.URLfilter = ''   
                }
                this.showList()
            },
            paginate(item){
                if(item.url){
                    this.paginateURL = item.url.split('?')[1]
                    //this.baseURL = item.url;
                }
                this.showList();
            },
            showList(){
                
                const config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token,
                    }
                }

                let url = this.baseURL + '?' + this.paginateURL + this.URLfilter
                

                axios.get(url, config)
                    .then(response => {
                        this.marcas = response.data
                    })
                    .catch(errors =>{
                        console.log(errors)
                    })
            },
            loadFile(e){
                this.imageFile = e.target.files;
            },
            save(){
                const config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json',
                        'Authorization': this.token,
                    }
                }
                const formData = new FormData();
                formData.append('nome', this.marcaName)
                formData.append('imagem', this.imageFile[0])

                axios.post(this.baseURL, formData, config)
                    .then(response => {
                        this.transactionStts = 'added'
                        this.transactionDetails = {
                            message: "ID do registro: "+response.data.id
                        }
                        this.showList()
                    })
                    .catch(errors => {
                        this.transactionStts = 'error'
                        this.transactionDetails = {
                            message: errors.response.data.message,
                            info: errors.response.data.errors
                        }
                    })
            }
        },
        mounted(){
            this.showList()
        }

    }
</script>
