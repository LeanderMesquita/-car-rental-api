<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="t, key in titles" :key="key">{{ t.title }}</th>
                    <th v-if="view || update || drop"></th>

                </tr>
            </thead>
            <tbody>
                <tr v-for="obj, k in infoFilter" :key="k">
                    <td v-for="value, kv in obj" :key="kv">
                        <span v-if="titles[kv].type == 'text'">{{ value }}</span>
                        <span v-if="titles[kv].type == 'image'"><img :src="'/storage/'+value" width="30" height="30" alt="img"></span>
                    </td> 
                    <td>
                        <button v-if="view.visible" type="button" class="btn btn-outline-primary btn-sm mx-1" :data-bs-toggle="view.dataToggle" :data-bs-target="view.dataTarget"><i class="fa-solid fa-eye"></i></button>
                        <button v-if="update" type="button" class="btn btn-outline-secondary btn-sm mx-1"><i class="fa-solid fa-pencil"></i></button>
                        <button v-if="drop" type="button" class="btn btn-outline-danger btn-sm mx-1"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ['info', 'titles', 'view', 'update', 'drop'],
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