<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="t, key in titles" :key="key">{{ t.title }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="obj, k in infoFilter" :key="k">
                    <td v-for="value, kv in obj" :key="kv">
                        <span v-if="titles[kv].type == 'text'">{{ value }}</span>
                        <span v-if="titles[kv].type == 'image'"><img :src="'/storage/'+value" width="30" height="30" alt="img"></span>
                    </td> 
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ['info', 'titles'],
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