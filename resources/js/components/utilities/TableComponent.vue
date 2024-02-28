<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="t, key in titles" :key="key">{{ t.title }}</th>
                    <th v-if="view.visible || update.visible || drop.visible"></th>

                </tr>
            </thead>
            <tbody>
                <tr v-for="obj, k in infoFilter" :key="k">
                    <td v-for="value, kv in obj" :key="kv">
                        <span v-if="titles[kv].type == 'text'">{{ value }}</span>
                        <span v-if="titles[kv].type == 'image'"><img :src="'/storage/'+value" width="30" height="30" alt="img"></span>
                    </td> 
                    <td>
                        <button v-if="view.visible" type="button" class="btn btn-outline-primary btn-sm mx-1" 
                            :data-bs-toggle="view.dataToggle" 
                            :data-bs-target="view.dataTarget" 
                            @click="setStore(obj)">
                            <i class="fa-solid fa-eye"></i>
                        </button>

                        <button v-if="update.visible" type="button" class="btn btn-outline-secondary btn-sm mx-1"  
                            :data-bs-toggle="update.dataToggle"
                            :data-bs-target="update.dataTarget"
                            @click="setStore(obj)"><i class="fa-solid fa-pencil"></i>
                        </button>

                        <button v-if="drop.visible" type="button" class="btn btn-outline-danger btn-sm mx-1"
                            :data-bs-toggle="drop.dataToggle"
                            :data-bs-target="drop.dataTarget"
                            @click="setStore(obj)"><i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ['info', 'titles', 'view', 'update', 'drop'],
    methods: {
        setStore(obj){
            this.$store.state.transation.status = ''
            this.$store.state.transation.message = ''
            this.$store.state.item = obj
        }
    },
    computed: {
       infoFilter() {
            let fields = Object.keys(this.titles)
            let filtredInfo = []

            this.info.map((element)=>{
                let filtredElement = {}

                fields.forEach(field => {
                    filtredElement[field] = element[field]
                })
                filtredInfo.push(filtredElement)
            })

            return filtredInfo;
       } 
    }
    
}
</script>