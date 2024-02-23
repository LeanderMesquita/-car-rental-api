<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="t, key in titles" :key="key">{{ t }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="e in info" :key="e.id">
                    <th scope="row">{{ e.id }}</th>
                    <td>{{ e.nome }}</td>
                    <td><img :src="'/storage/'+e.imagem" alt="" width="45px" height="45px"></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ['info', 'titles']
    
}
</script>